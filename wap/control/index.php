<?php
// +----------------------------------------------------------------------
// | Name: 首页
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class indexControl extends mobileControl{
	
    public function __construct(){
        parent::__construct();
    }
	
    public function indexDo(){

        $lang = Language::getLangContent();
		$title=C("site_name");
		$keywords=C("site_keywords");
		$description=C("site_description");
		
    }
	
}