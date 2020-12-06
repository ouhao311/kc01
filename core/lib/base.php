<?php
// +----------------------------------------------------------------------
// | Name: 初始化类，不允许继承
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
final class Base{

	const CPURL = '';

	/**
	 * init
	 */
	public static function init() {
	    //配置信息
	    global $setting_config;
	    self::parse_conf($setting_config);

	    define('MD5_KEY',md5(C('md5_key')));

	    if(function_exists('date_default_timezone_set')){
	        if (is_numeric(C('time_zone'))){
	            @date_default_timezone_set('Asia/Shanghai');
	        }else{
	            @date_default_timezone_set((C('time_zone')));
	        }
	    }


	    //session start
	    self::start_session();

	    //加载基础语言包
	    Language::read('common');



	}

	/**
	 * run
	 */
	public static function run(){
		@header("Content-type: text/html; charset=".CHARSET);
	    self::cp();
	    self::init();
	   
		self::control();
	}
	public static function runadmin($admin){
	    self::cp();
	    self::init();
	    //var_Dump($admin);exit;
		self::controladmin($admin);
	}
	/**
	 * 初始化配置文件
	 */
	private static function parse_conf(&$setting_config){
		$hx_config = $GLOBALS['cfg'];
		if(is_array($hx_config['db']['slave']) && !empty($hx_config['db']['slave'])){
			$dbslave = $hx_config['db']['slave'];
			$sid     = array_rand($dbslave);
			$hx_config['db']['slave'] = $dbslave[$sid];
		}else{
			$hx_config['db']['slave'] = $hx_config['db'][1];
		}
		$hx_config['db']['master'] = $hx_config['db'][1];
		$setting_config = $hx_config;
		$setting = ($setting = H('setting')) ? $setting : H('setting',true);
		$setting['SSZCMS_version'] = 'V3.0';
		$setting_config = array_merge_recursive($setting,$hx_config);
	}

	/**
	 * 控制器调度
	 *
	 */
	private static function control(){

        $mid=$_SESSION['member_id'];
       $myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
        if(!empty($member)&&$member['identity']>=1)
        {
            if($_GET['url']=="online")
            {
              $_GET['url']="member";  
            }
        }
//var_dump($member);exit;
		$act_file = realpath(BASE_PATH.'/control/'.$_GET['url'].'.php');

		$class_name = $_GET['url'].'Control';
//var_Dump($_SESSION['member_id']);exit;
		if (!@include($act_file)){
		   // var_Dump(313123);exit;
		    if (C('debug')) {
		        throw_exception("Base Error: access file isn't exists!(".$act_file.")");
		    } else {
		        showMessage('暂无相关数据','','html','error',1,0);
		    }
		}
		  
		if (class_exists($class_name)){
			$main = new $class_name();
			$function = $_GET['do'].'Do';
		
			if (method_exists($main,$function)){
			   
				$main->$function();
			}elseif (method_exists($main,'indexDo')){
			    
				$main->indexDo();
			}else {
			    
				$error = "Base Error: function $function not in $class_name!";
				throw_exception($error);
			}
		}else {
			$error = "Base Error: class $class_name isn't exists!";
			throw_exception($error);
		}
	}

	private static function controladmin($admin){
    //var_Dump(BASE_PATH.'/modules/'.$admin.'/control/'.$_GET['url'].'.php');exit;
	$act_file = realpath(BASE_PATH.'/modules/'.$admin.'/control/'.$_GET['url'].'.php');


		$class_name = $_GET['url'].'Control';
	
		//var_Dump($act_file,BASE_PATH.'/modules/'.$admin.'/control/'.$_GET['url'].'.php');exit;
		if (!@include($act_file)){
		    if (C('debug')) {
		        throw_exception("Base Error: access file isn't exists!----".$_GET['url']);
		    } else {
		        showMessage('暂无相关数据333','','html','error',1,0);
		    }
		}
		if (class_exists($class_name)){
			$main = new $class_name();
			$function = $_GET['do'].'Do';
			if (method_exists($main,$function)){
				$main->$function();
			}elseif (method_exists($main,'indexDo')){
				$main->indexDo();
			}else {
				$error = "Base Error: function $function not in $class_name!";
				throw_exception($error);
			}
		}else {
			$error = "Base Error: class $class_name isn't exists!";
			throw_exception($error);
		}
	}


	/**
	 * 开启session
	 *
	 */
	private static function start_session(){
		if (SUBDOMAIN_SUFFIX){
			$subdomain_suffix = SUBDOMAIN_SUFFIX;
		}else{
			if (preg_match("/^[0-9.]+$/",$_SERVER['HTTP_HOST'])){
				$subdomain_suffix = $_SERVER['HTTP_HOST'];
			}else{
				$split_url = explode('.',$_SERVER['HTTP_HOST']);
				if($split_url[2] != '') unset($split_url[0]);
				$subdomain_suffix = implode('.',$split_url);
			}
		}
		//session.name强制定制成PHPSESSID,不允许更改
		@ini_set('session.name','PHPSESSID');
		$subdomain_suffix = str_replace('http://','',$subdomain_suffix);
		if ($subdomain_suffix !== 'localhost') {
		    @ini_set('session.cookie_domain', $subdomain_suffix);
		}

		//默认以文件形式存储session信息
		session_save_path(HX_DATA.'/session');
		session_start();
	}
/**
* 魔法调用类
*/
	public static function autoload($class){
		$class = strtolower($class);
		if (ucwords(substr($class,0,5)) == 'Cache' && $class != 'cache'){
			if (!@include_once(HX_CORE.'/lib/'.substr($class,0,5).'.'.substr($class,5).'.php')){
				exit("Class Error: {$class}.isn't exists!");
			}
		}elseif ($class == 'db'){
			if (!@include_once(HX_CORE.'/db/'.strtolower(DBDRIVER).'.php')){
				exit("Class Error: {$class}.isn't exists!");
			}
		}else{
			if (!@include_once(HX_CORE.'/lib/'.$class.'.php')){
				exit("Class Error: {$class}.isn't exists!");
			}
		}
	}

	/**
	 * 合法性验证
	 *
	 */
	private static function cp(){
		if (self::CPURL == '') return;
		if ($_SERVER['HTTP_HOST'] == 'localhost') return;
		if ($_SERVER['HTTP_HOST'] == '127.0.0.1') return;
		if (strpos(self::CPURL,'||') !== false){
			$a = explode('||',self::CPURL);
			foreach ($a as $v) {
				$d = strtolower(stristr($_SERVER['HTTP_HOST'],$v));
				if ($d == strtolower($v)){
					return;
				}else{
					continue;
				}
			}
			exit('Access Denied');
		}else{
			$d = strtolower(stristr($_SERVER['HTTP_HOST'],self::CPURL));
			if ($d != strtolower(self::CPURL)){
				exit('Access Denied');
			}
		}
	}
}