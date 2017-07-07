<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Member extends Curd {
	public function __construct() {
		parent::__construct();
		$this->conf['index'] = [
			'tableName' => 'member A',
			'join' => [
				['member_group B','A.group_id = B.id','left']
			],
			'fields' => [
				'A'=> ['*'],
				'B'=> ['group_name'=>'name'],
			]
		];

		$this->conf['edit'] = [
			'endFunc' => function (&$data) {
				$data['group'] = D("member_group")->get_list();
				$data['formData']['password'] = '';
			}
		];

		$this->conf['save'] = [
			'startFunc' => function(&$post) {
				if($post['password']) {
					$post['password'] = md5(md5($post['password'])."DI389K23K21K403L2GS2");
				} else {
					unset($post['password']);
				}

			}
		];
	}
}
