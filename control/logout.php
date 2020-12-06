<?php
// +----------------------------------------------------------------------
// | Name: 登出
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class logoutControl extends PcControl{ 

	public function __construct(){
        parent::__construct();
    } 
	
	// 首页部分
    public function indexDo(){

		$title="用户登出";
		
		session_unset();

        session_destroy();
 
        @header('location: index.php?url=login');die;
		 
    } 
	
	
}