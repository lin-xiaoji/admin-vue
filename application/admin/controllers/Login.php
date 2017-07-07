<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Common {
	public function __construct() {
		parent::__construct();


	}

	function login() {
		$post = $this->input->post();
		$username=$post['username'];
		$password=md5(md5($post['password'])."DI389K23K21K403L2GS2");

		$item = $this->db
				->from('member')
				->where(['username'=>$username,'password'=>$password])
				->get()
				->row_array();
		if($item) {
			$data['id'] = $item['id'];
			$data['username'] = $item['username'];
			$data['token'] = md5($item['id'].$item['username'].$item['password']);
			$this->success($data);
		} else {
			$this->error('帐号或密码错误');
		}
	}

}
