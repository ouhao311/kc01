<?php
// +----------------------------------------------------------------------
// | Name: 上传设置
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class uploadControl extends SystemControl{

    private $links = array(
        array('url'=>'url=upload&do=param','lang'=>'upload_param')
       
    );
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
                array("input"=>$_POST["image_max_filesize"], "require"=>"true", "validator"=>"Number", "message"=>L('upload_image_filesize_is_number')),
                array("input"=>trim($_POST["image_allow_ext"]), "require"=>"true", "message"=>L('image_allow_ext_not_null'))
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $model_setting = M('setting');
                $result = $model_setting->updateSetting(array(
                    'image_max_filesize'=>intval($_POST['image_max_filesize']),
                    'image_allow_ext'=>$_POST['image_allow_ext'])
                );
                if ($result){
                    $this->log(L('hx_edit,upload_param'),1);
                    showMessage(L('hx_common_save_succ'));
                }else {
                    $this->log(L('hx_edit,upload_param'),0);
                    showMessage(L('hx_common_save_fail'));
                }
            }
        }

        //获取默认图片设置属性
        $model_setting = M('setting');
        $list_setting = $model_setting->getListSetting();
        //输出子菜单
		$top_link=$this->sublink($this->links,'param');
		include T('upload.param');

    }

 
}
