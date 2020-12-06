<?php
// +----------------------------------------------------------------------
// | Name: 后台管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2016 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
define('APP_ID','pc');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
require __DIR__ . '/core/global.php';
//端口输出
if(isMobile()){
	define('TPL_NAME', DIR_TPL_MOBILE);
	define('PC_URL', SITE_URL.DS.DIR_PC);
	define('PC_TEMPLATES_URL',PC_URL.DS.'templates'.DS.DIR_TPL);
	define('BASE_TPL_PATH',BASE_PATH.DS.'templates'.DS.DIR_TPL_MOBILE);
}else{
	define('TPL_NAME', DIR_TPL);
	define('PC_URL', SITE_URL.DS.DIR_PC);
	define('PC_TEMPLATES_URL',PC_URL.DS.'templates'.DS.DIR_TPL);
	define('BASE_TPL_PATH',BASE_PATH.DS.'templates'.DS.DIR_TPL);
}

if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');
//var_Dump(312313);exit;
Base::run();
