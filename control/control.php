<?php
// +----------------------------------------------------------------------
// | Name: 父类
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.hanett.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class PcControl{

    protected function __construct() {
		Language::read('common');

		//转码  防止GBK下用ajax调用时传汉字数据出现乱码
        if (($_GET['branch']!='' || $_GET['do']=='ajax') && strtoupper(CHARSET) == 'GBK'){
            $_GET = Language::getGBK($_GET);
        }
        if(!C('site_status')) halt(C('closed_reason'));
        // 自动登录
      
        $this->auto_login();

    }





    /**
     * 输出JSON
     *
     * @param string $errorMessage 错误信息 为空则表示成功
     */
    protected function jsonOutput($errorMessage = false)
    {
        $data = array();

        if ($errorMessage === false) {
            $data['result'] = true;
        } else {
            $data['result'] = false;
            $data['message'] = $errorMessage;
        }

        $jsonFlag = C('debug') && version_compare(PHP_VERSION, '5.4.0') >= 0
            ? JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            : 0;

        echo json_encode($data, $jsonFlag);
        exit;
    }


	 /**
     * 验证会员是否登录
     *
     */
    protected function checkLogin(){
        if ($_SESSION['is_login'] !== '1'){
//var_Dump(21321);exit;
            $ref_url = request_uri();
            if ($_GET['inajax']){
                echo '{"status":"0"}';
                exit;
            }else {
                
                @header("location: " . urlLogin('login', 'index', array('ref_url' => $ref_url)));
            }
            exit;
        }
    }

    /**
     * 自动登录
     */
    protected function auto_login() {
        $data = cookie('auto_login');
        if (empty($data)) {
            return false;
        }
        $model_member = M('member');
        if ($_SESSION['is_login']) {
            $model_member->auto_login();
        }
        $member_id = intval(decrypt($data, MD5_KEY));
        if ($member_id <= 0) {
            return false;
        }
        $member_info = $model_member->getMemberInfoByID($member_id);
        $model_member->createSession($member_info);
    }

}



/********************************** 会员control父类 **********************************************/
class BaseMemberControl extends PcControl {

    //会员信息
    protected $Member_info = array();


    public function __construct(){
       // var_Dump(4444);exit;
        Language::read('common,member_layout,member');
        if(!C('site_status')) halt(C('closed_reason'));
        global $nav_list,$menu,$current_menu,$left_menu,$member_quicklink;

        if ($_GET['url'] !== 'login') {
             //var_dump(1231231);exit;
            if(empty($_SESSION['member_id'])) {
                @header('location: index.php?url=login');die;
            }

        }
    }



}

