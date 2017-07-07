<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('API_IN', TRUE);
/**
 * 前端接口入口
 */
class Api extends MY_Controller {

	public function _remap() {
		$res = [];
		if ($this->input->is_post()) {
			$data  = ($this->input->post('data'));
			if ($data) {
				$data = json_decode(htmlspecialchars_decode($data),TRUE);
				if ($data) {
					if (count($data) < 20)
					foreach ($data as $_data) {
						$res[] = $this->call($_data);
					}
				}
			}
		}
		echo json_encode($res);
		exit;
	}

	private function call($data) {
		$method = isset($data['method']) ? $data['method'] : '';
		unset($data['method']);
		$res['code'] = 'FAIL';
		$res['method'] = $method;
		$res['data']  = [];
		if ( $method && preg_match('~^[a-z|\_|\.]+$~',$method)) {
			$method = array_filter(explode('.', $method));
			$a = array_pop($method);
			$m = array_pop($method);
			$file = __DIR__.'/openapi/'.join('/', $method).'/'.$m.'.php';
			if (file_exists($file)) {
				require_once $file;
				$call = new $m($this);
				if (isset($call->hasLogin) && $call->hasLogin === TRUE) {
					if ( ! $this->loginUser['id']) {
						$res['action'] = 'login';
						return $res;
					}
				}
				$call->ci = $this;
				try {
					$res['code'] = 'SUCCESS';
					$calldata = $call->$a($data);
					if (isset($calldata['form_error'])) {
						$res['code'] = 'FAIL';
						$res['form_error'] = $calldata['form_error'];
						unset($calldata['form_error']);
					}
					if (isset($calldata['code'])) {
						$res = $calldata;
					} else {
						$res['data'] = $calldata;
					}
				} catch(Exception $e) {
					$res['code'] = 'FAIL';
				}
			}
		}
		return $res;
	}
}
