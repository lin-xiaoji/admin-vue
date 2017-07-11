<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();

	}


}

class Common extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->view->assign('method',$this->router->fetch_method());
	}

	/**
	 * 接收get参数,增加为空时的默认值
	 * @param null $index
	 * @param null $default
	 * @return null
	 */
	function get($index=null,$default=null) {
		$value = $this->input->get($index);
		$value = $value ? $value : $default;
		return $value;
	}

	/**
	 * 接收post参数,增加为空时的默认值
	 * @param null $index
	 * @param null $default
	 * @return null
	 */
	function post($index=null,$default=null) {
		$value = $this->input->post($index);
		$value = $value ? $value : $default;
		return $value;
	}


	function success($data=[]){
		$ret['code'] = 200;
		$ret['data'] = $data;
		$out = json_encode($ret,JSON_UNESCAPED_SLASHES);
		echo $out;
		die;
	}

	function error($msg){
		if (is_numeric($msg)) {
			$code = $msg;
			$this->config->load('error_code');
			$error_code = $this->config->item('error_code');
			$ret['code'] = $code;
			$ret['msg'] = $error_code[$code];
		} else {
			$ret['code'] = 500;
			$ret['msg'] = $msg;
		}
		echo json_encode($ret);
		die;
	}

}

/**
 * 数据库基本增删查改
 */
class Curd extends Common  {
	protected $conf = [];
	protected $tableName = '';

	public function __construct() {
		parent::__construct();
		$this->tableName = $this->router->class;

	}


	/**
	 * 列表页
	 * @param array $conf
	 */
	function get_list($conf=[]) {
		$get = $this->input->get();
		$page = $get['page'];
		$conf = $conf ? $conf : $this->conf['index'];

		$data = [];

		//开始钩子函数
		if($conf['startFunc']) {
			$conf['startFunc']($data);
		}

		//额外数据|二维数组
		if($conf['extra_data']) {
			$extra_data = $this->extra_data($conf['extra_data']);
			$data = array_merge($data,$extra_data);
		}


		//自定义表名
		if($conf['tableName']) {
			$this->tableName = $conf['tableName'];
		}

		$query= $this->db->from($this->tableName);

		//join | 二维数组无键值数组
		if($conf['join']) {
			foreach ($conf['join'] as $item) {
				$query->join($item[0],$item[1],$item[2]);
			}
		}


		//搜索条件 | 一维无键值数组
		if($conf['search']) {
			$search = $conf['search'];
			foreach ($search as $value) {
				$fieldArr = explode('.',$value);

				$field = end($fieldArr);
				$arr = explode('-',$field);

				if (count($fieldArr) > 1) {
					$searchField = $fieldArr[0].'.'.$arr[0];
				} else {
					$searchField = $arr[0];
				}

				$searchType = $arr[1];
				if(!$searchType) $searchType = '=';
				if($get[$field] or $get[$field] === '0') {
					if($searchType == 'like') $get[$value] = '%'.$get[$value].'%';
					if($arr[2] == 'time') {//转换时间为时间截
						$get[$value] = strtotime($get[$value]);
					}
					if($arr[2] == 'date') {//转换日期为时间截
						if($searchType == '<' or $searchType == '<=' ) {
							$get[$value] = strtotime($get[$value]) + 86400; //结束日期需加一天时间
						} else {
							$get[$value] = strtotime($get[$value]);
						}
					}
					$query->where([$searchField." ".$searchType=>$get[$field]]);
				}
			}
		}




		//where  | 一维有键值数组
		if($conf['where']) {
			foreach ($conf['where'] as $key=>$val) {
				if (is_array($val)) {
					$query->where_in($key,$val);
				} else {
					$query->where($key,$val);
				}
			}
		}
		//or_where  | 一维有键值数组
		if($conf['or_where']) {
			$query->or_where($conf['or_where']);
		}








		/**
		 * 'fields'=>[
						'B'=>['id','name'],
						'A'=>['a','b'],
					  ],
		 */
		if(isset($conf['fields']) && $conf['fields']) {
			$field = [];
			foreach ($conf['fields'] as $k=>$fs) {
				foreach ($fs as $_fk=>$f) {
					if (!is_numeric($_fk)) {
						$f .= ' AS '.$_fk;
					}
					if ($k) {
						$field[] = $k.'.'.$f;
					} else {
						$field[] = $f;
					}
				}
			}
			$field = join(',', $field);
			$query->select($field);
		} else {
			//field
			$field = '*';
			if($conf['field']) {
				if(substr($conf['field'],0,1) == ',') {
					$field .= $conf['field'];
				} else {
					$field = $conf['field'];
				}
			}
			$query->select($field);
		}


		//order
		if($conf['order']) {
			$query->order_by($conf['order']);
		}

		//group
		if($conf['group']) {
			$query->group_by($conf['group']);
		}




		//pageSize
		$pageSize = $conf['pageSize'];
		if(empty($pageSize)) $pageSize = 10;
		if($page<=0) $page = 1;

		//是否显示总条数
		$totalQuery = clone $query;
		$total = $totalQuery->count_all_results(null,false);
		$data['total'] = $total;

		if($pageSize != 'all') {
			$query->limit($pageSize,($page-1)*$pageSize);
		}

		$list = $query->get()->result_array();

//		echo $query->last_query()."<br >";
//		print_r($data);







		//循环处理的钩子
		if($conf['itemFunc']) {
			$listTmp = [];
			foreach ($list as $item) {
				$conf['itemFunc']($item);
				$listTmp[] = $item;
			}
			$list = $listTmp;
		}

		$data['list'] = $list;



		//结束钩子函数
		if($conf['endFunc']) {
			$conf['endFunc']($data);
		}
		$this->success($data);
	}


	function index() {
		$this->get_list($this->conf['index']);
	}


	/**
	 * 添加和修改数据的公共处理方法
	 * @return string
	 */
	function edit() {
		@$conf = $this->conf['edit'];
		//自定义表名
		if($conf['tableName']) {
			$this->tableName = $conf['tableName'];
		}

		//保存
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->save();
			exit;
		}


		//表单信息--------------------
		$id = $this->get('id');
		$data = [];
		//开始钩子函数
		if($conf['startFunc']) {
			$conf['startFunc']($data);
		}


		if($id) {
			$query= $this->db->from($this->tableName);
			$query->where(['id'=>$id]);
			//join | 二维数组
			if($conf['join']) {
				foreach ($conf['join'] as $item) {
					$query->join($item[0],$item[1],$item[2]);
				}
			}
			$data['formData'] = $query->get()->row_array();
		}


		//结束钩子函数
		if($conf['endFunc']) {
			$conf['endFunc']($data);
		}

		$this->success($data);
	}




	function save() {
		$post = $this->input->post();
		//开始钩子函数
		if($this->conf['save']['startFunc']) {
			$this->conf['save']['startFunc']($post);
		}

		//去掉关联表的字段 *二维数组*
		//  [ ['news_content','content','news_id'] ] 分别代表 表名，相关字段，关联主表id的字段
		$data = [];
		if($this->conf['save']['relate']) {
			foreach ($this->conf['save']['relate'] as $arr) {
				$outField = explode(',',$arr[1]);
				foreach ($outField as $item) {
					$data[$arr[0]][$item] = $post[$item];
					unset($post[$item]);
				}
			}
		}

		//保存数据
		$id = $post['id'];
		if ($id) {
			D($this->tableName)->save($post,['id'=>$id]);
		} else {
			$id = D($this->tableName)->add($post);
		}


		//保存关联表的数据
		//二维数组[['关联表','相关字段','与主表id关联的字段']]
		if($this->conf['save']['relate']) {
			foreach ($this->conf['save']['relate'] as $arr) {
				if($post['id']) {
					$exist = D($arr[0])->get_row([$arr[2]=>$post['id']]);
					if($exist) { //关联表中对应的数据不存在，直接添加
						D($arr[0])->save($data[$arr[0]],[$arr[2]=>$post['id']]);
					} else {
						$data[$arr[0]][$arr[2]] = $post['id'];
						D($arr[0])->add($data[$arr[0]]);
					}
				} else {
					$data[$arr[0]][$arr[2]] = $id;
					D($arr[0])->add($data[$arr[0]]);
				}
			}
		}



		//结束钩子函数
		if($this->conf['save']['endFunc']) {
			$this->conf['save']['endFunc']($id);
		}


		$this->success();
	}


	//快速修改某个表的特定字段
	function setValue() {
		$set = $this->input->post("set");
		//刷新时间
		$key = key($set[1]);
		if($set[1][$key] == 'time()') {
			$set[1][$key] = time();
		}

		if(D($set[0])->save($set[1],$set[2])) {
			$this->success();
		}else {
			$this->error('操作失败');
		}
	}

	/**
	 * 删除
	 * @return string
	 */
	function del(){
		$id = $this->input->get('id');
		//开始钩子函数
		if($this->conf['del']['startFunc']) {
			$this->conf['del']['startFunc']($id);
		}
		if(D($this->tableName)->del(['id' => $id])){
			//删除成功后的结束钩子函数
			if($this->conf['del']['endFunc']) {
				$this->conf['del']['endFunc']($id);
			}
			$this->success();
		}else {
			$this->error('删除失败');
		}
	}

}


class CheckLogin extends Curd {
	protected $login_id;
	public function __construct() {
		parent::__construct();
		$login_id = $this->get('login_id');
		$token = $this->get('token');
		$item = D("member")->find($login_id);
		if($token != md5($item['id'].$item['username'].$item['password'])) {
			$this->error('token无效');
		} else {
			$this->login_id = $login_id;
		}

	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */