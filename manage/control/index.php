<?php
// +----------------------------------------------------------------------
// | Name: 默认页
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class indexControl extends SystemControl{
    public function __construct(){
        
        parent::__construct();


    }
    public function indexDo(){
        //   header("Content-Security-Policy: upgrade-insecure-requests");
       //var_Dump(3123132);exit;
        //var_Dump(444444);exit;
		$lang = Language::getLangContent();
        //输出管理员信息
      
        $admin_info=$this->getAdminInfo();
        //输出菜单  var_Dump(555);exit;
        $result = $this->getNav();
        //var_Dump($result);exit;
       
        list($top_nav, $left_nav, $map_nav, $quicklink) = $result;

		include T('index');

    }

    /**
     * 退出
     */
    public function logoutDo(){
        setXwCookie('sys_key','',-1,'',null);
        @header("Location: index.php");
        exit;
    }
    /**
     * 修改密码
     */
    public function modifypwDo(){
		Language::read('admin');
        $lang = Language::getLangContent();
        if (chksubmit()){
            if (trim($_POST['new_pw']) !== trim($_POST['new_pw2'])){
                //showMessage('两次输入的密码不一致，请重新输入');
                showMessage(Language::get('index_modifypw_repeat_error'));
            }
            $admininfo = $this->getAdminInfo();
            //查询管理员信息
            $admin_model = M('admin');
            $admininfo = $admin_model->getOneAdmin($admininfo['id']);
            if (!is_array($admininfo) || count($admininfo)<= 0){
                showMessage(Language::get('index_modifypw_admin_error'));
            }
            //旧密码是否正确
            if ($admininfo['admin_password'] != md5(trim($_POST['old_pw']))){
                showMessage(Language::get('index_modifypw_oldpw_error'));
            }
            $new_pw = md5(trim($_POST['new_pw']));
            $update = array();
            $update['admin_password'] = $new_pw;
            $update['admin_id'] = $admininfo['admin_id'];
            $result = $admin_model->updateAdmin($update);
            if ($result){
                showDialog(Language::get('index_modifypw_success'), urlAdmin('index', 'logout'), 'succ');
            }else{
                showMessage(Language::get('index_modifypw_fail'));
                showDialog(Language::get('index_modifypw_fail'), '', '', 'CUR_DIALOG.click();');
            }
        }else{

			include T('admin.modifypw');

        }
    }

    public function save_avatarDo() {
        $admininfo = $this->getAdminInfo();
        $admin_model = M('admin');
        $admininfo = $admin_model->getOneAdmin($admininfo['id']);
        if ($_GET['avatar'] == '') {
            echo false;die;
        }
        @unlink(HX_UPLOAD . '/' . ATTACH_ADMIN_AVATAR . '/' . cookie('admin_avatar'));
        $update['admin_avatar'] = $_GET['avatar'];
        $update['admin_id'] = $admininfo['admin_id'];
        $result = $admin_model->updateAdmin($update);
        if ($result) {
            setXwCookie('admin_avatar',$_GET['avatar'],86400 * 365,'',null);
        }
        echo $result;die;
    }
}
