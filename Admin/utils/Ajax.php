<?php

namespace Admin\utils;

/**
 *
 * @author guan
 *        
 */
class Ajax {
	const SUCCESS = '1';
	const ERROR = '-1';
	const FAILED = '0';
	public static function ajaxReturn($info, $status, $data = array()){
		return new \Arsenals\Core\Views\Ajax(array('info'=>$info, 'status'=>$status, 'data'=>$data));	
	}
}
