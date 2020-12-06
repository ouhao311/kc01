<?php
// +----------------------------------------------------------------------
// | Name: 系统框架
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
define('BASE_PATH',str_replace('\\','/',dirname(dirname(dirname(__FILE__)))));
define('MODULES_BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
require __DIR__ . '/../../../core/global.php';

define('APP_SITE_URL', ADMIN_URL.'/modules/system');
define('TPL_NAME','default');
define('ADMIN_TEMPLATES_URL',ADMIN_URL.'/templates/'.TPL_NAME);
define('ADMIN_RESOURCE_URL',ADMIN_URL.'/ext');
define('SHOP_TEMPLATES_URL',SITE_URL.'/templates/'.TPL_NAME);
define('BASE_TPL_PATH',MODULES_BASE_PATH.'/templates/'.TPL_NAME);



define('APP_ID', 'manage');
define('MODULE_NAME', 'system');

if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');
$system='system';

Base::runadmin($system);