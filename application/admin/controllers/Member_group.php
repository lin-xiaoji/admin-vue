<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_group extends Curd {
	public function __construct() {
		parent::__construct();


	}

	function privilege() {
		$id = $this->input->get('id');
		$item = D('member_group')->find($id);
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			$data['id'] = $id;
			$data['privilege'] = explode(',', $item['privilege']);

			$this->success($data);
		} else {
			$privilege = $this->input->post('privilege');
			$privilege = implode(',',$privilege);
			D('member_group')->save(['privilege'=>$privilege],['id'=>$id]);

			$this->success();
		}
	}



}
