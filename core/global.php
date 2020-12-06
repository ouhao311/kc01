<?php
// +----------------------------------------------------------------------
// | Name: SSZCMS 入口文件
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
error_reporting(E_ALL & ~E_NOTICE);
//注册常量
define('SSZCMS',true);
define('DS','/');
define('HX_CORE',str_replace('\\','/',dirname(__FILE__)));
define('HX_ROOT',HX_CORE.'/../');
define('HX_DATA',HX_ROOT.'data');
define("HX_UPLOAD", HX_ROOT . "data/upload");
define("HX_EXT", HX_ROOT . "data/ext");
define('DIR_ADMIN','manage');
define('DIR_UPLOAD','data/upload');
define('DIR_TPL', 'default');
define('DIR_TPL_MOBILE', 'mobile');
define('DIR_PC', 'pc');
define('DIR_WAP', 'wap');
define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST']);
define('EXT_URL', 'http://'.$_SERVER['HTTP_HOST'].DS.'data/ext');
define('ADMIN_URL', SITE_URL.DS.DIR_ADMIN);
define('BASE_SITE_URL', SITE_URL);
define('UPLOAD_SITE_URL',SITE_URL.DS.DIR_UPLOAD);

define('MEMBER_SITE_URL', SITE_URL.DS.'member');
define('LOGIN_SITE_URL',MEMBER_SITE_URL);
define('MOBILE_SITE_URL', SITE_URL.DS.'wap');


define('StartTime',microtime(true));
define('TIMESTAMP',time());

define('ATTACH_PATH','system');
define('ATTACH_COMMON','system/common');
define('ATTACH_AVATAR','avatar');
define('ATTACH_EDITOR','system/editor');
define('ATTACH_LOGIN','system/login');
define('ATTACH_ADMIN_AVATAR','admin/avatar');
define('ATTACH_PRINT','system/print');
define('ATTACH_ARTICLE','article');
define('ATTACH_ADV','adv');
define('ATTACH_CLASS','class');
define('ATTACH_GOODS','goods/thumb');
define('ATTACH_QRCODE','goods/qrcode');

/**
 * 商品图片
 */
define('GOODS_IMAGES_WIDTH', '60,240,640,1280');
define('GOODS_IMAGES_HEIGHT', '60,240,640,1280');
define('GOODS_IMAGES_EXT', '_60,_240,_640,_1280');

function isMobile()
    {  
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;

        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
                return true;
        }
            // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
     }




//初始化

if (!@include(HX_DATA.'/config/config.ini.php')) exit('config.ini.php isn\'t exists!');
global $cfg;


define('URL_MODEL',$cfg['url_model']);
define(SUBDOMAIN_SUFFIX, $cfg['subdomain_suffix']);

define('CHARSET',$cfg['db'][1]['dbcharset']);
define('DBDRIVER',$cfg['dbdriver']);
define('SESSION_EXPIRE',$cfg['session_expire']);
define('LANG_TYPE',$cfg['lang_type']);
define('COOKIE_PRE',$cfg['cookie_pre']);

define('DBPRE',$cfg['tablepre']);
define('DBNAME',$cfg['db'][1]['dbname']);

$_GET['url'] = is_string($_GET['url']) ? strtolower($_GET['url']) : (is_string($_POST['url']) ? strtolower($_POST['url']) : null);
$_GET['do'] = is_string($_GET['do']) ? strtolower($_GET['do']) : (is_string($_POST['do']) ? strtolower($_POST['do']) : null);

if (empty($_GET['url'])){
    require_once(HX_CORE.'/lib/route.php');
    //var_Dump($cfg);exit;
    new Route($cfg);
}
//统一ACTION
//(isMobile());exit;
//var_Dump($_GET);exit;
if(isMobile())
{
    
    $mid=$_SESSION['member_id'];
    
   //var_dump( $_GET['url']);exit;
   $_GET['url'] = preg_match('/^[\w]+$/i',$_GET['url']) ? $_GET['url'] : 'online'; 
}else{
    $_GET['url'] = preg_match('/^[\w]+$/i',$_GET['url']) ? $_GET['url'] : 'index';
}

$_GET['do'] = preg_match('/^[\w]+$/i',$_GET['do']) ? $_GET['do'] : 'index';

//对GET POST接收内容进行过滤,$ignore内的下标不被过滤
$ignore = array('article_content');

if (!class_exists('Security')) require(HX_CORE.'/lib/security.php');
$_GET = !empty($_GET) ? Security::getAddslashesForInput($_GET,$ignore) : array();
$_POST = !empty($_POST) ? Security::getAddslashesForInput($_POST,$ignore) : array();
$_REQUEST = !empty($_REQUEST) ? Security::getAddslashesForInput($_REQUEST,$ignore) : array();
$_SERVER = !empty($_SERVER) ? Security::getAddSlashes($_SERVER) : array();


if ($_POST || $_GET || $_COOKIE)
{
    extract($_POST,EXTR_SKIP);
	extract($_GET,EXTR_SKIP);
	extract($_COOKIE,EXTR_SKIP);
}



//启用ZIP压缩
if ($cfg['gzip'] == 1 && function_exists('ob_gzhandler') && $_GET['inajax'] != 1){
	ob_start('ob_gzhandler');
}else {
	ob_start();
}

require_once(HX_CORE.'/lib/queue.php');
require_once(HX_CORE.'/fun/common.php');
require_once(HX_CORE.'/fun/function.php');
require_once(HX_CORE.'/lib/base.php');
require_once(HX_CORE.'/fun/pdo.php');





if(function_exists('spl_autoload_register')) {
	spl_autoload_register(array('Base', 'autoload'));
} else {
	function __autoload($class) {
	    //var_Dump($class);exit;
		return Base::autoload($class);
	}
}
