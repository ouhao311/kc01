<?php
// +----------------------------------------------------------------------
// | Name: 消息设置
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class messageControl extends SystemControl{
    private $links = array(
        array('url'=>'url=message&do=email','lang'=>'email_set'),
        array('url'=>'url=message&do=email_tpl','lang'=>'email_tpl')
    );
    public function __construct(){
        parent::__construct();
        Language::read('manage,setting');
    }

    public function indexDo() {
        $this->emailDo();
    }

    /**
     * 邮件设置
     */
    public function emailDo(){
		$lang = Language::getLangContent();
        $model_setting = M('setting');
        if (chksubmit()){
            $update_array = array();
            $update_array['email_host']     = $_POST['email_host'];
            $update_array['email_port']     = $_POST['email_port'];
            $update_array['email_addr']     = $_POST['email_addr'];
            $update_array['email_id']       = $_POST['email_id'];
            $update_array['email_pass']     = $_POST['email_pass'];

            $result = $model_setting->updateSetting($update_array);
            if ($result === true){
                $this->log(L('hx_edit,email_set'),1);
                showMessage(L('hx_common_save_succ'));
            }else {
                $this->log(L('hx_edit,email_set'),0);
                showMessage(L('hx_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();

        $top_link=$this->sublink($this->links,'email');
		include T('message.email');
    }

    /**
     * 邮件模板列表
     */
    public function email_tplDo(){
		$lang = Language::getLangContent();
        $model_templates = M('mail_templates');
        $templates_list = $model_templates->getTplList();

       $top_link=$this->sublink($this->links,'email_tpl');
	   include T('message.email_tpl');
    }

    /**
     * 编辑邮件模板
     */
    public function email_tpl_editDo(){
		$lang = Language::getLangContent();
        $model_templates = M('mail_templates');
        if (chksubmit()){
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["code"], "require"=>"true", "message"=>L('mailtemplates_edit_no_null')),
                array("input"=>$_POST["title"], "require"=>"true", "message"=>L('mailtemplates_edit_title_null')),
                array("input"=>$_POST["content"], "require"=>"true", "message"=>L('mailtemplates_edit_content_null')),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $update_array = array();
                $update_array['code'] = $_POST["code"];
                $update_array['title'] = $_POST["title"];
                $update_array['content'] = $_POST["content"];
                $result = $model_templates->editTpl($update_array,array('code'=>$_POST['code']));
                if ($result === true){
                    $this->log(L('hx_edit,email_tpl'),1);
                    showMessage(L('mailtemplates_edit_succ'),'index.php?url=message&do=email_tpl');
                }else {
                    $this->log(L('hx_edit,email_tpl'),0);
                    showMessage(L('mailtemplates_edit_fail'));
                }
            }
        }
        if (empty($_GET['code'])){
            showMessage(L('mailtemplates_edit_code_null'));
        }
        $templates_array = $model_templates->getTplInfo(array('code'=>$_GET['code']));

       $top_link=$this->sublink($this->links,'email_tpl');
		include T('message.email_tpl.edit');

    }

   /**
	 * 测试邮件发送
	 *
	 * @param
	 * @return
	 */
	public function email_testingDo(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();

		$email_host = trim($_POST['email_host']);
		$email_port = trim($_POST['email_port']);
		$email_addr = trim($_POST['email_addr']);
		$email_id = trim($_POST['email_id']);
		$email_pass = trim($_POST['email_pass']);

		$email_test = trim($_POST['email_test']);
		$subject	= $lang['test_email'];
		$site_url	= SHOP_SITE_URL;

        $site_title = C('site_name');
        $message = '<p>'.$lang['this_is_to']."<a href='".$site_url."' target='_blank'>".$site_title.'</a>'.$lang['test_email_send_ok'].'</p>';
// 		if ($email_type == '1'){
			$obj_email = new Email();
			$obj_email->set('email_server',$email_host);
			$obj_email->set('email_port',$email_port);
			$obj_email->set('email_user',$email_id);
			$obj_email->set('email_password',$email_pass);
			$obj_email->set('email_from',$email_addr);
            $obj_email->set('site_name',$site_title);
			$result = $obj_email->send($email_test,$subject,$message);
// 		}else {
// 			$result = @mail($email_test,$subject,$message);
// 		}
       if ($result === false){
            $message = $lang['test_email_send_fail'];
            if (strtoupper(CHARSET) == 'GBK'){
                $message = Language::getUTF8($message);
            }
            showMessage($message,'','json');
        }else {
            $message = $lang['test_email_send_ok'];
            if (strtoupper(CHARSET) == 'GBK'){
                $message = Language::getUTF8($message);
            }
            showMessage($message,'','json');
        }
    }
}
