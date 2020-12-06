<?php
// +----------------------------------------------------------------------
// | Name: ajax
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class ajaxControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('dashboard');
    }

    

    /**
     * 关于我们
     */
    public function sfzhDo(){

			$condition['sfzh'] = trim($_GET['sfzh']);
			//$condition['id'] = array('neq',intval($_GET['id']));
			$info = M()->table('rybdk')->where($condition)->find();				    
			if (!empty($info)){			
	
				//exit('{"code":"0"}');
				exit("false");
			}else {
				//$rs=getidcardinfo(trim($_GET['sfzh']));

				//exit('{"code":"1","idcard":"'.$idcard.'","xb":"'.$rs["xbname"].'","csrq":"'.$rs["csrq"].'","csrq2":"'.$rs["csrq2"].'","age":"'.$rs["age"].'"}');
				exit('true');
			}
    }

}
