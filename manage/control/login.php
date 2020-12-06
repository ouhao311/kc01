<?php
// +----------------------------------------------------------------------
// | Name: 登录
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class LoginControl extends SystemControl {

    /**
     * 不进行父类的登录验证，所以增加构造方法重写了父类的构造方法
     */
    public function __construct(){
            //   header("Content-Security-Policy: upgrade-insecure-requests");
		Language::read('common,manage');
        $result = chksubmit(true,true,'num');
        if ($result){
            if ($result === -11){
                showMessage('非法请求');
            }elseif ($result === -12){
                showMessage(L('login_index_checkcode_wrong'));
            }
            if (process::islock('admin')) {
                showMessage('您的操作过于频繁，请稍后再试');
            }
            $obj_validate = new Validate();
			if(C("captcha_status_login")){
			$obj_validate->validateparam = array(
				array("input"=>$_POST["user_name"], "require"=>"true", "message"=>L('login_index_username_null')),
				array("input"=>$_POST["password"],  "require"=>"true", "message"=>L('login_index_password_null')),
				array("input"=>$_POST["captcha"],   "require"=>"true", "message"=>L('login_index_checkcode_null')),
							);
				
			}else{
			$obj_validate->validateparam = array(
				array("input"=>$_POST["user_name"], "require"=>"true", "message"=>L('login_index_username_null')),
				array("input"=>$_POST["password"],  "require"=>"true", "message"=>L('login_index_password_null')),
				
								);				
			}
            
            $error = $obj_validate->validate();
            if ($error != '') {
                showMessage(L('error').$error);
            } else {
                $model_admin = M('admin');
                $array  = array();
                $array['admin_name']    = $_POST['user_name'];
                $array['admin_password']= md5(trim($_POST['password']));
                $admin_info = $model_admin->infoAdmin($array);
                if(is_array($admin_info) and !empty($admin_info)) {
                    if ($admin_info['admin_gid'] > 0) {
                        $gamdin_info = M('gadmin')->getGadminInfoById($admin_info['admin_gid']);
                        $group_name = $gamdin_info['gname'];
                    } else {
                        $group_name = '超级管理员';
                    }
                    $array = array();
                    $array['name']  = $admin_info['admin_name'];
                    $array['id']    = $admin_info['admin_id'];
					$array['truename']  = $admin_info['admin_username'];
                    $array['time']  = $admin_info['admin_login_time'];
                    $array['ip']    = getIp();
					$array['czlb']    = $admin_info['czlb'];
                    $array['gid']   = $admin_info['admin_gid'];
                    $array['gname'] = $group_name;
                    $array['sp']    = $admin_info['admin_is_super'];
                    $array['qlink'] = $admin_info['admin_quick_link'];
                    $this->systemSetKey($array, $admin_info['admin_avatar'], true);
                    $update_info    = array(
                        'admin_id'=>$admin_info['admin_id'],
                        'admin_login_num'=>($admin_info['admin_login_num']+1),
                        'admin_login_time'=>TIMESTAMP
                    );
                    $model_admin->updateAdmin($update_info);
                    $this->log(L('hx_login'),1);
                    process::clear('admin');
                    @header('Location: index.php');exit;
                } else {
                    process::addprocess('admin');
                    showMessage(L('login_index_username_password_wrong'),'index.php?act=login&op=login');
                }
            }
        }




		$html_title=L('login_index_need_login');

		include T('login');

    }
    public function loginDo(){}
    public function indexDo(){}
}
