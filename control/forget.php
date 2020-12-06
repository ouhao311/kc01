<?php
// +----------------------------------------------------------------------
// | Name: 找回密码
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class forgetControl extends PcControl{ 

	public function __construct(){
        parent::__construct();
    } 
	
	// 首页部分
    public function indexDo(){

		$title="找回密码";
		
		session_unset();

        session_destroy();
		
		$banner_list=getAdinfoList(2);
        include T('forget');
		 
    } 
	
	public function preSaveDo(){
		$lang = Language::getLangContent(); 
		$code = trim($_POST['code']);
		$username = trim($_POST['username']);
		if(empty($username)){
			$msg=array('result'=>false, 'message'=>array('error'=>'请输入要找回的用户名'));
            exit(json_encode($msg));exit();
		}
		/* if(empty($code)){
			$msg=array('result'=>false, 'message'=>array('error'=>'请先获取短信验证码！'));
            exit(json_encode($msg));exit();
		} */
		//验证码
		/* $ckcode=checkCode(trim($_POST['username']),trim($_POST['code']));
		if(!$ckcode){
			$msg=array('result'=>false, 'message'=>array('error'=>'验证码错误或已过期'));
            exit(json_encode($msg));exit();
		}  */
		$data = array();
		$data['username'] = trim($_POST['username']);
		$memberinfo=M('member')->where(array('username'=>$username,'isdel'=>0))->find();
		if(empty($memberinfo)){
			$msg=array('result'=>false, 'message'=>array('error'=>'您还不是会员请先注册！'));
            exit(json_encode($msg));exit();
		}
		
		$password = trim($_POST['regPassword']);
		$qpassword = trim($_POST['qpassword']);
		if($password!=$qpassword){
			$msg=array('result'=>false, 'message'=>array('error'=>'两次密码不一致！'));
            exit(json_encode($msg));exit();
		}
		$res=M('member')->where(array('username'=>$username,'isdel'=>0))->update(array('password'=>getPwd($password))); 
		$ref_url=url('login','index');
		if ($res){//修改密码成功
			$msg=array('result'=>true, 'message'=>array('error'=>'恭喜您，密码找回成功！','ref_url'=>$ref_url));
            exit(json_encode($msg));exit();
		}else {
			$msg=array('result'=>false, 'message'=>array('error'=>'修改失败'));
            exit(json_encode($msg));exit();
		}
 

    }
	
	
	
}