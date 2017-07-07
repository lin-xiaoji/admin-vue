<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 公共辅助函数
 *
 * Created by xiaoji.lin.
 *
 */


//获取公共model，来操作数据库
function D($table){
    $CI =& get_instance();
    $CI->common_model->table = $table;

    return $CI->common_model;
}


//数组根据键值查找函数
function array_find($source, $condition) {
	return array_values(array_filter($source, function ($value) use($condition) {
		$re = true;
		foreach ($condition as $k => $v) {
			if (!isset($value[$k]) || $value[$k] != $v) {
				$re = false;
				break;
			}
		}
		return $re;
	}));
}