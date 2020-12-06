<?php
// +----------------------------------------------------------------------
// | Name: 网站设置
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class settingControl extends SystemControl{
    private $links = array(
        array('url'=>'url=setting&do=base','lang'=>'web_set'),
		array('url'=>'url=setting&do=email','lang'=>'web_email')
       
    );
    public function __construct(){
        parent::__construct();
        Language::read('setting');

    }

    public function indexDo() {
        $this->baseDo();
    }

    /**
     * 基本信息
     */
    public function baseDo(){

        $model_setting = M('setting');
        if (chksubmit()){
            $list_setting = $model_setting->getListSetting();
            $update_array = array();
            $update_array['time_zone'] = $this->setTimeZone($_POST['time_zone']);
            $update_array['site_name'] = trim($_POST['site_name']);
			$update_array['site_keywords'] = trim($_POST['site_keywords']);
			$update_array['site_description'] = trim($_POST['site_description']);
			$update_array['site_welcome'] = trim($_POST['site_welcome']);
			$update_array['site_tel'] = trim($_POST['site_tel']);
			$update_array['site_phone'] = trim($_POST['site_phone']);
			$update_array['site_kfewm'] = trim($_POST['site_kfewm']);
			$update_array['ratio'] = trim($_POST['ratio']);
			$update_array['site_address'] = trim($_POST['site_address']);
			$update_array['site_email'] = trim($_POST['site_email']);
			$update_array['site_fax'] = trim($_POST['site_fax']);
			$update_array['site_company'] = trim($_POST['site_company']);
			$update_array['site_coordinate'] = trim($_POST['site_coordinate']);
			$update_array['site_qq'] = trim($_POST['site_qq']);
			$update_array['site_url'] = trim($_POST['site_url']);
			$update_array['integral'] = trim($_POST['integral']);
			$update_array['site_copyright'] =htmlspecialchars_decode($_POST['site_copyright'], ENT_QUOTES);

            $update_array['statistics_code'] = htmlspecialchars_decode($_POST['statistics_code'], ENT_QUOTES);
            $update_array['icp_number'] = htmlspecialchars_decode($_POST['icp_number'], ENT_QUOTES);
            $update_array['site_status'] = $_POST['site_status'];
			
			$update_array['captcha_status_login'] = $_POST['captcha_status_login'];

            $update_array['closed_reason'] = $_POST['closed_reason'];
            $result = $model_setting->updateSetting($update_array);
            if ($result === true){
                $this->log(L('hx_edit,web_set'),1);
                showMessage(L('hx_common_save_succ'));
            }else {
                $this->log(L('hx_edit,web_set'),0);
                showMessage(L('hx_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();
        foreach ($this->getTimeZone() as $k=>$v) {
            if ($v == $list_setting['time_zone']){
                $list_setting['time_zone'] = $k;break;
            }
        }

        $top_link=$this->sublink($this->links,'base');

		include T('setting.base');

    } 
	
	  /**
     * 发件邮箱配置
     */
    public function emailDo(){

        $model_setting = M('setting');
        if (chksubmit()){
            $list_setting = $model_setting->getListSetting(); 
			$update_array = array(); 
			$update_array['email_type'] = trim($_POST['email_type']);
			$update_array['email_host'] = trim($_POST['email_host']);
			$update_array['email_port'] = trim($_POST['email_port']);
			$update_array['email_addr'] = trim($_POST['email_addr']);
			$update_array['email_id'] = trim($_POST['email_id']);
			$update_array['email_pass'] = trim($_POST['email_pass']);

            $result = $model_setting->updateSetting($update_array);
            if ($result === true){
                $this->log(L('hx_edit,web_set'),1);
                showMessage(L('hx_common_save_succ'));
            }else {
                $this->log(L('hx_edit,web_set'),0);
                showMessage(L('hx_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();


        $top_link=$this->sublink($this->links,'email');

		include T('setting.email');

    }		


    /**
     * 设置时区
     *
     * @param int $time_zone 时区键值
     */
    private function setTimeZone($time_zone){
        $zonelist = $this->getTimeZone();
        return empty($zonelist[$time_zone]) ? 'Asia/Shanghai' : $zonelist[$time_zone];
    }

    private function getTimeZone(){
        return array(
        '-12' => 'Pacific/Kwajalein',
        '-11' => 'Pacific/Samoa',
        '-10' => 'US/Hawaii',
        '-9' => 'US/Alaska',
        '-8' => 'America/Tijuana',
        '-7' => 'US/Arizona',
        '-6' => 'America/Mexico_City',
        '-5' => 'America/Bogota',
        '-4' => 'America/Caracas',
        '-3.5' => 'Canada/Newfoundland',
        '-3' => 'America/Buenos_Aires',
        '-2' => 'Atlantic/St_Helena',
        '-1' => 'Atlantic/Azores',
        '0' => 'Europe/Dublin',
        '1' => 'Europe/Amsterdam',
        '2' => 'Africa/Cairo',
        '3' => 'Asia/Baghdad',
        '3.5' => 'Asia/Tehran',
        '4' => 'Asia/Baku',
        '4.5' => 'Asia/Kabul',
        '5' => 'Asia/Karachi',
        '5.5' => 'Asia/Calcutta',
        '5.75' => 'Asia/Katmandu',
        '6' => 'Asia/Almaty',
        '6.5' => 'Asia/Rangoon',
        '7' => 'Asia/Bangkok',
        '8' => 'Asia/Shanghai',
        '9' => 'Asia/Tokyo',
        '9.5' => 'Australia/Adelaide',
        '10' => 'Australia/Canberra',
        '11' => 'Asia/Magadan',
        '12' => 'Pacific/Auckland'
        );
    }

  
}
