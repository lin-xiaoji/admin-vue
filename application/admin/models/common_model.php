<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 公共model,数据库基本的增删查改方法
 * Created by xiaoji.lin
 *
 */

class Common_model extends CI_Model {

    function __construct(){
        $this->table = "";
    }

    //获取完整查询的数据
    function get_data($config) {
        $query = $this->db
            ->select($config['field'])
            ->from($this->table);
        foreach ($config['where'] as $key=>$item) {
            if(strpos($key,' in')) {
                $query->where_in(current(explode(' ',$key)),$item);
                unset($config['where'][$key]);
            }
        }
        foreach ($config['join'] as $item) {
            $query->join($item[0],$item[1],$item[2]);
        }
        $result = $query
            ->where($config['where'])
            ->order_by($config['order'])
            ->limit($config['limit'])
            ->get()
            ->result_array();

        return $result;
    }

    //获取某张表的列表数据
    function get_list($where=[],$field='*',$order=null,$limit=[]){
        $query = $this->db
            ->select($field)
            ->from($this->table);

        foreach ($where as $key=>$item) {
            if(strpos($key,' in')) {
                $query->where_in(current(explode(' ',$key)),$item);
                unset($where[$key]);
            }
			if(strpos($key,' or')) {
				$query->or_where(current(explode(' ',$key)),$item);
				unset($where[$key]);
			}
        }
		$query->where($where);
        if($order) $query->order_by($order);
        if($limit) {
        	if (is_array($limit)) {
				$query->limit($limit[0],$limit[1]);
			}else {
				$query->limit($limit);
			}
		}
        $result = $query->get()->result_array();

        return $result;
    }


    function get_page($where=[],$field='*',$order=null,$pageSize=10) {
		$CI = & get_instance();
		$page = $CI->input->get('page');

		if($page<=0) $page = 1;
		$limit =[$pageSize,($page-1)*$pageSize];
		$result = $this->get_list($where,$field,$order,$limit);

		//不计算总记录数
		if(count($result) == $pageSize) {
			$pages = 1000;
		} else {
			$pages = $page;
		}
		$CI->view->assign('pages', $pages);

		return $result;
	}

    //获取一行数据
    function get_row($where=[],$field='*',$order=''){
        $result=$this->get_list($where,$field,$order,1);
        return $result[0];
    }

	//获取一行数据的某个字段
	function get_field($where=[],$field=''){
		$result=$this->get_list($where,$field,null,1);
		return $result[0][$field];
	}

    //快速根据id得到某张表的某个值或某些值
    function get_value($id,$field = '',$idName='id'){
        $result = $this->get_row([$idName=>$id],$field);

        if(count($result) == 1) {
            return $result[$field];
        } else {
            return $result;
        }
    }

    //根据id查找信息
    function find($id){
        $result= $this->get_row(['id'=>$id]);
        return $result;
    }

    //查找记录条数
    function count($where){
        $result= $this->db->where($where)->count_all_results($this->table,true);
        return $result;
    }


    //添加新数据
    function add($data){

		$this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    //替换插入
    function replace($data){
        $this->db->replace($this->table,$data);
        return $this->db->insert_id();
    }

    //修改数据
    function save($data,$where=[]){
        if(!empty($where)){
            return $this->db->where($where)->update($this->table, $data);
        }else{
            return false;
        }
    }

    //删除数据
    function del($where=[]){
        if(!empty($where)){
            return $this->db->where($where)->delete($this->table);
        }else{
            return false;
        }
    }

}