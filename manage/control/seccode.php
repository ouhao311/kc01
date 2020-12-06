<?php
// +----------------------------------------------------------------------
// | Name: 验证码
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class seccodeControl{

	public function __construct(){
	}
	/**
	 * 产生验证码
	 *
	 */
	public function makecodeDo(){
		$refererhost = parse_url($_SERVER['HTTP_REFERER']);
		$refererhost['host'] .= !empty($refererhost['port']) ? (':'.$refererhost['port']) : '';

		$seccode = makeSeccode($_GET['xwhash']);

		@header("Expires: -1");
		@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
		@header("Pragma: no-cache");

		$code = new seccode();
		$code->code = $seccode;
		$code->width = 90;
		$code->height = 26;
		$code->background = 1;
		$code->adulterate = 1;
		$code->scatter = '';
		$code->color = 1;
		$code->size = 0;
		$code->shadow = 1;
		$code->animator = 0;
		$code->datapath =  HX_DATA.'/ext/seccode/';
		$code->display();
	}

	/**
	 * AJAX验证
	 *
	 */
	public function checkDo(){
		if (checkSeccode($_GET['xwhash'],$_GET['captcha'])){
			exit('true');
		}else{
			exit('false');
		}
	}
}

?>
