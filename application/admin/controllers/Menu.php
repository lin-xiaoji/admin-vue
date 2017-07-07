<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Curd {
	protected $menu = [];
	public function __construct() {
		parent::__construct();

		$this->conf['edit'] = [
			'endFunc'=> function(&$data) {
				$this->getMenu(0);
				$data['parent'] = $this->menu;
			}
		];
		$this->conf['save'] = [
			'startFunc'=> function(&$post) {
				$level = D("menu")->get_field(['id'=>$post['parent_id']],'level');
				$post['level'] = intval($level) + 1;
			}
		];
	}

	function index() {
		$this->getMenu(0);
		$data['list'] = $this->menu;

		$this->success($data);
	}

	//递归得到所有栏目数据
	function getMenu($parent_id) {
		$list = D('menu')->get_list(['parent_id'=>$parent_id]);
		foreach ($list as $item) {
			array_push($this->menu,$item);
			$this->getMenu($item['id']);
		}
		return $list;
	}



}
