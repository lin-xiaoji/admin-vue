<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Curd {
	public function __construct() {
		parent::__construct();

	}

	function menu() {
		$login_id = $this->get('login_id');

		$member = $this->db
			->from('member A')
			->join('member_group B','A.group_id = B.id','left')
			->where('a.id',$login_id)
			->get()->row_array();
		$privilege = $member['privilege'];

		$menu = $this->db
			->from('menu')
			->select('id,name,parent_id,view,icon')
			->where_in('id',explode(',',$privilege))
			->order_by('sort asc,id asc')
			->get()->result_array();


		$nav = array_find($menu,['parent_id'=>0]);
		foreach ($nav as &$item) {
			$item['sub'] = array_find($menu,['parent_id'=>$item['id']]);
		}
		foreach ($nav as  &$item) {
			foreach ($item['sub'] as &$subItem) {
				$subItem['sub'] = array_find($menu,['parent_id'=>$subItem['id']]);
			}
		}
		$this->success($nav);
	}




}
