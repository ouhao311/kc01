<?php
// +----------------------------------------------------------------------
// | Name: 登录页面
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.hanett.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class loginControl extends PcControl{
	
    public function __construct(){
        parent::__construct();
		if(!empty($_SESSION['member_id'])) {
			@header('location: index.php?url=index');die;
		}
    }
    // 登陆部分
    public function indexDo(){

        $title="用户登陆";
		
		$banner_list=getAdinfoList(2);
        include T('login');
    }

	
	// 登陆部分
    public function loginDo(){

		$title="用户登陆";
		
		$banner_list=getAdinfoList(2);
		
	    include T('login');
    }
	
	// 登陆ajax部分
     public function loginajaxDo(){
        $obj_member=M('member');
        $login_info=array();
        $login_info['user_name']=$_POST['username'];
        $login_info['password']=$_POST['password'];
        if(empty($_POST['username'])||empty($_POST['password'])){
            $msg=array('result'=>false, 'message'=>array('error'=>'账户和密码不能为空'));
            exit(json_encode($msg));exit();
        }
        $member_info=$obj_member->login($login_info);
       // var_dump($member_info);exit;
        //登录成功返回用户信息，失败返回提示信息
        if($member_info['id']){
            //登录时创建会话SESSION
            $obj_member->createSession($member_info);
			$msg=array('result'=>true, 'isorgan'=>$member_info['isorgan'],'message'=>array('error'=>'登陆成功！'));
            exit(json_encode($msg));exit();
            //成功后跳转首页
//            header('location: index.php?url=index');
        }else{
			$msg=array('result'=>false, 'message'=>array('error'=>$member_info['error']));
            exit(json_encode($msg));exit(); 
        }

	}
}