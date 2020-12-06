<?php
// +----------------------------------------------------------------------
// | Name: 上传设置
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class memberControl extends SystemControl{


    public function __construct(){
        parent::__construct();
        Language::read('setting');


    }

    public function indexDo() {
        $this->paramDo();
    }

    /**
     * 上传参数设置
     *
     */
    public function paramDo(){
		$lang = Language::getLangContent();
        if (chksubmit()){
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
              //  array("input"=>$_POST["sys_kcjg"], "require"=>"true", "validator"=>"Number", "message"=>'库存警告必须为数字'),
              //  array("input"=>trim($_POST["sys_kcjg_mail"]), "validator"=>"email", "message"=>'请您填写有效的电子邮箱')
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $model_setting = M('setting');
                $result = $model_setting->updateSetting(array(
                    'sys_kcjg'=>intval($_POST['sys_kcjg']),
                    'sys_kcjg_mail'=>$_POST['sys_kcjg_mail'])
                );
                if ($result){
					H('setting',true);
                    $this->log(L('hx_edit').'产品设置',1);
                    showMessage(L('hx_common_save_succ'));
                }else {
                    $this->log(L('hx_edit').'产品设置',0);
                    showMessage(L('hx_common_save_fail'));
                }
            }
        }

        //获取默认图片设置属性
        $model_setting = M('setting');
        $list_setting = $model_setting->getListSetting();
		include T('setting.member');

    }


}
