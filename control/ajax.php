<?php
// +----------------------------------------------------------------------
// | Name: ajax
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class ajaxControl extends PcControl{
    public function __construct(){
        parent::__construct();

    }

   /**
     * 区域
     */
    public function areaDo(){

		$type = isset($_GET["type"]) ? intval($_GET["type"]) : 1;
		$parent_id = isset($_GET["parent_id"]) ? intval($_GET["parent_id"]) : 0;


		$info = Db::getAll("SELECT * FROM ".DBPRE."area where area_parent_id=".intval($_GET['parent_id'])." and area_deep=".$type."   ORDER by area_sort asc ");

			exit(json_encode($info));


    }

	 /**
     * 手机验证码
     */
    public function sendCodeDo(){
		//错误码-2发送时间不到1分钟，-1手机号错误，0是失败1是成功，

		//exit('{"err":"0","msg":"手机号码格式不正确!!!!！"}');


		$mobile = $_GET["mobile"];

		if(!$mobile) exit('{"err":"0","msg":"手机号码不能为空！"}');

		if($_SESSION['codetime_'.$mobile]){

			$lasttime=time()-$_SESSION['codetime_'.$mobile];

			if($lasttime<60){
				exit('{"err":"0","msg":"发送频率过快请您稍等片刻！"}');
			}

		} 
		$send=new Sms();

		$rs=$send->mysend_sms235($mobile);
		
		if($rs=='-1'){
			exit('{"err":"0","msg":"手机号码格式不正确！"}');
		}elseif($rs=='1'){
			exit('{"err":"1","msg":"发送成功！"}');
		}else{
			exit('{"err":"0","msg":"'.$rs.'"}');
		}

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
	 * AJAX验证码验证
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
