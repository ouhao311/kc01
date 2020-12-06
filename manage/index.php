<?php
// +----------------------------------------------------------------------
// | Name: 后台管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
define('APP_ID','manage');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
require __DIR__ . '/../core/global.php';

define('TPL_NAME', DIR_TPL);
define('ADMIN_URL', SITE_URL.DS.DIR_ADMIN);
define('ADMIN_TEMPLATES_URL',ADMIN_URL.DS.'templates'.DS.DIR_TPL);
define('BASE_TPL_PATH',BASE_PATH.DS.'templates'.DS.DIR_TPL);
define('ADMIN_EXT_URL',ADMIN_URL.DS.'ext');


if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');

Base::run();
