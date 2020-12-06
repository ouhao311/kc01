<?php
// +----------------------------------------------------------------------
// | Name: 注册
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.hanett.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied'); 
class registerControl extends PcControl{
    public function __construct(){
        parent::__construct();
		if(!empty($_SESSION['member_id'])) {
			@header('location: index.php?url=index');die;
		}

    }
    public function indexDo(){ 
		$xwhash= getXwhash(); 
		//seo
		$title='用户注册';  
		
		$banner_list=getAdinfoList(2);
		
		include T('register');

    }

	public function preDo(){ 
		$xwhash= getXwhash(); 
		//seo
		$title='用户注册'; 
		$banner_list=getAdinfoList(2);
		include T('register'); 
    }

	public function preSaveDo(){

		$data = array();
		$data['username'] = trim($_POST['username']);
		$data['password'] = trim($_POST['regPassword']);
		$data['password_confirm'] = trim($_POST['confirmPassword']);
		$data['truename'] = trim($_POST['truename']); 
		$data['department'] = trim($_POST['department']); 
		$data['mobile']   = trim($_POST['mobile']);
		$ref_url   = trim($_POST['ref_url']); 
		$data['status']   = 1;
		
		if(empty($_POST['username'])||empty($_POST['regPassword'])){
            $msg=array('result'=>false, 'message'=>array('error'=>'用户名和密码不能为空'));
            exit(json_encode($msg));exit();
        } 
		
		//验证码
		/* $ckcode=checkCode($data['mobile'],trim($_POST['code']));
		if(!$ckcode){
		 exit('{"status":"0","msg":"验证码错误或已过期"}');
		} */
 
		$model_member=M("member");
		$member_info =$model_member->register($data);


		if (!isset($member_info['error'])){//注册成功

			//$model_member->createSession($member_info,true);
			//process::addprocess('reg');

			if(empty($ref_url)){
				$ref_url=url('member','index');
			}
			$msg=array('result'=>true, 'message'=>array('error'=>'注册成功，请等待审核！','ref_url'=>$ref_url));
            exit(json_encode($msg));exit();
		}else {
			$msg=array('result'=>false, 'message'=>array('error'=>$member_info['error']));
            exit(json_encode($msg));exit();
		}
 

    }
  
	   /**
     * ajax操作
     */
    public function ajaxDo(){
        switch ($_GET['branch']){
			  // 检查用户名
            case 'check_username':

				$username=trim($_GET['username']);


				if(getUNname($username)) {

				    echo 'false';exit;
				 }


				$condition["username"]=$username;
                $info =  M("member")->getMemberInfo($condition);

                if (empty($info)){
                    echo 'true';exit;
                }else {
                    echo 'false';exit;
                }

                break;

            // 检查手机号
            case 'check_mobile':

               $mobile=trim($_GET['mobile']);


				$condition["mobile"]=$mobile;
                $info =  M("member")->getMemberInfo($condition);

                if (empty($info)){
                    echo 'true';exit;
                }else {
                    echo 'false';exit;
                }

				break;

				case 'check_contitle':

				$contitle=trim($_GET['contitle']);




				$condition["title"]=$contitle;
                $info =  M("logistic_com")->where($condition)->find();

                if (empty($info)){
                    echo 'true';exit;
                }else {
                    echo 'false';exit;
                }

                break;
        }
    }


}
