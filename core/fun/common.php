<?php
// +----------------------------------------------------------------------
// | Name: 公共函数
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');


/**
 * 取得系统配置信息
 * @param string $key 取得下标值
 * @return mixed
 */
function C($key){
        if (strpos($key,'.')){
                $key = explode('.',$key);
                if (isset($key[2])){
                        return $GLOBALS['setting_config'][$key[0]][$key[1]][$key[2]];
                }else{
                        return $GLOBALS['setting_config'][$key[0]][$key[1]];
                }
        }else{
                return $GLOBALS['setting_config'][$key];
        }
}

/**
 * 数据库模型实例化入口
 * @param string $model 模型名称
 * @return obj 对象形式的返回结果
 */
function M($model = null, $base_path = null){
	static $_cache = array();

	$cache_key = $model.'.'.$base_path;
	if (!is_null($model) && isset($_cache[$cache_key])) return $_cache[$cache_key];
	$base_path = $base_path == null ? HX_CORE : $base_path;
	$file_name = $base_path.'/model/'.$model.'.model.php';
	$class_name = $model.'Model';
		//var_dump(file_exists($file_name));exit;
	if (!file_exists($file_name)){
		return $_cache[$cache_key] =  new Model($model);
	}else{
		require_once($file_name);
		if (!class_exists($class_name)){
			$error = 'Model Error:  Class '.$class_name.' is not exists!';
			throw_exception($error);
		}else{
		    //var_dump($class_name);exit;
			return $_cache[$cache_key] = new $class_name();
		}
	}
}

/**
 * 文件数据读取和保存 字符串、数组
 *
 * @param string $filename 文件名称（含目录）
 * @param mixed $value 待写入文件的内容null为删除
 * @param string $path 写入cache的目录
 * @return mixed
 */
// 快速文件数据读取和保存 针对简单类型数据 字符串、数组
function F($filename, $value='') {

    if ('' !== $value) {
        if (is_null($value)) {
            // 删除文件
			return is_file($filename) ? unlink($filename) : false;
        } else {
            // 写入文件
            $dir = dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mk_dir($dir);

            return file_put_contents($filename, $value);
        }
    }

    // 获取缓存数据
    if (is_file($filename)) {
        $value = file_get_contents($filename);
    } else {
        $value = false;
    }
    return $value;
}



/**
 * 读/写 缓存方法
 *
 * H('key') 取得缓存
 * H('setting',true) 生成缓存并返回缓存结果
 * H('key',null) 清空缓存
 * H('setting',true,'file') 生成配置信息的文件缓存
 * H('setting',true,'memcache') 生成商城配置信息到memcache
 * @param string $key 缓存名称
 * @param string $value 缓存内容
 * @param string $type	缓存类型，允许值为 file,memcache,xcache,apc,eaccelerator，可以为空，默认为file缓存
 * @param int/null $expire 缓存周期
 * @param mixed $args 扩展参数
 * @return mixed
 */
function H($key, $value='', $cache_type='', $expire=null, $args=null){
	static $cache = array();
	
	$cache_type = $cache_type ? $cache_type : 'file';
	$obj_cache = Cache::getInstance($cache_type,$args);
//var_Dump($key,333,$obj_cache);
    if ($value !== '') {
        if (is_null($value)) { // 删除缓存
            $result = $obj_cache->rm($key);
            if ($result)
                unset($cache[$cache_type . '_' . $key]);
            return $result;
        }else { // 缓存数据

        	if ($value === true) $obj_cache->rm($key);//先删除缓存
			//写
            $list = M('cache')->call($key);
            $obj_cache->set($key, $list, null, $expire);
            $cache[$cache_type . '_' . $key] = $list;
        }
        return $value === true ? $list : true;
    }

    if (isset($cache[$cache_type . '_' . $key]))
        return $cache[$cache_type . '_' . $key];


    $value = $obj_cache->get($key);	// 取得缓存
    
//var_Dump($value);exit;
	if($value===false){
			//重新缓存

            $list = M('cache')->call($key);

            $obj_cache->set($key, $list, null, $expire);
            $value=$list;
	}
//	var_Dump($cache[$cache_type . '_' . $key],333,$value);exit;
    $cache[$cache_type . '_' . $key] = $value;
    return $value;
}




/**
 * 读取缓存信息（只适用于内存缓存）
 *
 * @param string $key 要取得缓存 键
 * @param string $prefix 键值前缀
 * @param bool $unserialize 是否需要反序列化
 * @return array/bool
 */
function rcache($key = null, $prefix = '', $unserialize = true){
	if (empty($key) || C('cache.type') == 'file' ) return false;
	$obj_cache = Cache::getInstance(C('cache.type'));
    $data = $obj_cache->get($key, $prefix);
    return $unserialize ? unserialize($data) : $data;
}

/**
 * 写入缓存（只适用于内存缓存）
 *
 * @param string $key 缓存键值
 * @param array $data 缓存数据
 * @param string $prefix 键值前缀
 * @param int $ttl 缓存周期
 * @param string $perfix 存入的键值前缀
 * @param bool $serialize 是否序列化后保存
 * @return bool 返回值
 */
function wcache($key = null, $data = array(), $prefix = '',  $ttl = 0,  $serialize = true){




	if (empty($key) || C('cache.type') == 'file') return false;
	$obj_cache = Cache::getInstance(C('cache.type'));
	if ($ttl !== 0){
		$ttl = C('session_expire');
	}
    $obj_cache->set($key, $serialize ? serialize($data) : $data, $prefix, $ttl);
    return true;
}




/**
 * 快速调用语言包
 * @param string $key
 * @return string
 */
function L($key = ''){
	if (class_exists('Language')){
		if (strpos($key,',') !== false){
			$tmp = explode(',',$key);
			$str = Language::get($tmp[0]).Language::get($tmp[1]);
			return isset($tmp[2])? $str.Language::get($tmp[2]) : $str;
		}else{
			return Language::get($key);
		}
	}else{
		return null;
	}
}




/**
 * 调用模板
 * @param string $html
 * @param string $path 目录
 * @param bool $layout 1找父路径下模板
 * @return string
 */
function T($html='index',$layout=0,$path=''){
	
	if(isMobile()){
		if (!defined('TPL_NAME')) define('TPL_NAME','mobile');
	}else{
		if (!defined('TPL_NAME')) define('TPL_NAME','default');
	}
	
	if (!defined('BASE_TPL_PATH')) define('BASE_TPL_PATH',BASE_PATH.DS.'templates'.DS.TPL_NAME);

	if($path) $path=$path.DS;
	if($layout){
        $from=BASE_PATH.DS.'templates'.DS.TPL_NAME.DS.$path.$html.'.html';
	}else{
		$from=BASE_TPL_PATH.DS.$path.$html.'.html';
	}

	if(defined('MODULE_NAME')) $path=MODULE_NAME.DS.$path;
	if(isMobile()){
		$to=HX_ROOT.'data'.DS.'cache'.DS.'tpl'.DS.'mobile'.DS.$path.$html.'.php';
	}else{
		$to=HX_ROOT.'data'.DS.'cache'.DS.'tpl'.DS.APP_ID.DS.$path.$html.'.php';
	}

	if (file_exists($from)){
    //缓存文件
    if(!is_file($to) || filemtime($from) > filemtime($to) || (filesize($to) == 0 && filesize($from) > 0)) {
		Tpl::template_compile($from, $to);
	}

	return  $to;

	}else{
		$error = 'Tpl ERROR:'.$from.' is not exists';
		throw_exception($error);
	}

}





/**
 * 产生验证码
 *
 * @param string $xwhash 哈希数
 * @return string
 */
function makeSeccode($xwhash){
	$seccode = random(6, 1);
	$seccodeunits = '';

	$s = sprintf('%04s', base_convert($seccode, 10, 23));
	$seccodeunits = 'ABCEFGHJKMPRTVXY2346789';
	if($seccodeunits) {
		$seccode = '';
		for($i = 0; $i < 4; $i++) {
			$unit = ord($s{$i});
			$seccode .= ($unit >= 48 && $unit <= 57) ? $seccodeunits[$unit - 48] : $seccodeunits[$unit - 87];
		}
	}
	setXwCookie('seccode'.$xwhash, encrypts(strtoupper($seccode)."\t".(time())."\t".$xwhash,MD5_KEY),3600);
	return $seccode;
}
function getFlexigridArray($in_array, $fields_array, $data, $format_array)
{
	$out_array = $in_array;
	if ($out_array["operation"]) {
		$out_array["operation"] = "--";
	}




	if ($fields_array && is_array($fields_array)) {
		foreach ($fields_array as $key => $value ) {
			$k = "";

			if (is_int($key)) {
				$k = $value;
			}
			else {
				$k = $key;
			}
			if (is_array($data) && array_key_exists($k, $data)) {
				$out_array[$k] = $data[$k];
				if ($format_array && in_array($k, $format_array)) {
					$out_array[$k] = ncpriceformatb($data[$k]);
				}
			}
			else {
				$out_array[$k] = "--";
			}
		}
	}

	return $out_array;
}

/**
 * 验证验证码
 *
 * @param string $xwhash 哈希数
 * @param string $value 待验证值
 * @return boolean
 */
function checkSeccode($xwhash,$value){
	list($checkvalue, $checktime, $checkidhash) = explode("\t", decrypt(cookie('seccode'.$xwhash),MD5_KEY));
	$return = $checkvalue == strtoupper($value) && $checkidhash == $xwhash;


	if (!$return) setXwCookie('seccode'.$xwhash,'',-3600);
	return $return;
}

/**
 * 设置cookie
 *
 * @param string $name cookie 的名称
 * @param string $value cookie 的值
 * @param int $expire cookie 有效周期
 * @param string $path cookie 的服务器路径 默认为 /
 * @param string $domain cookie 的域名
 * @param string $secure 是否通过安全的 HTTPS 连接来传输 cookie,默认为false
 */
function setXwCookie($name, $value, $expire='3600', $path='', $domain='', $secure=false){
	if (empty($path)) $path = '/';
	if (empty($domain)) $domain = SUBDOMAIN_SUFFIX ? SUBDOMAIN_SUFFIX : '';
	$name = defined('COOKIE_PRE') ? COOKIE_PRE.$name : strtoupper(substr(md5(MD5_KEY),0,4)).'_'.$name;
	$expire = intval($expire)?intval($expire):(intval(SESSION_EXPIRE)?intval(SESSION_EXPIRE):3600);
	$result = setcookie($name, $value, time()+$expire, $path, $domain, $secure);
	$_COOKIE[$name] = $value;
}

/**
 * 取得COOKIE的值
 *
 * @param string $name
 * @return unknown
 */
function cookie($name= ''){
	$name = defined('COOKIE_PRE') ? COOKIE_PRE.$name : strtoupper(substr(md5(MD5_KEY),0,4)).'_'.$name;
	return $_COOKIE[$name];
}

/**
 * 当访问的url或do不存在时调用此函数并退出脚本
 *
 * @param string $url
 * @param string $do
 * @return void
 */
function requestNotFound($url = null, $do = null) {
    showMessage('您访问的页面不存在！', SITE_URL, 'exception', 'error', 1, 3000);
    exit;
}

/**
 * 输出信息
 *
 * @param string $msg 输出信息
 * @param string/array $url 跳转地址 当$url为数组时，结构为 array('msg'=>'跳转连接文字','url'=>'跳转连接');
 * @param string $show_type 输出格式 默认为html
 * @param string $msg_type 信息类型 succ 为成功，error为失败/错误
 * @param string $is_show  是否显示跳转链接，默认是为1，显示
 * @param int $time 跳转时间，默认为2秒
 * @return string 字符串类型的返回结果
 */
function showMessage($msg,$url='',$show_type='html',$msg_type='succ',$is_show=1,$time=2000){

	/**
	 * 如果默认为空，则跳转至上一步链接
	 */
	$url = ($url!='' ? $url : getReferer());

	$msg_type = in_array($msg_type,array('succ','error')) ? $msg_type : 'error';

	/**
	 * 输出类型
	 */
	switch ($show_type){
		case 'json':
			$return = '{';
			$return .= '"msg":"'.$msg.'",';
			$return .= '"url":"'.$url.'"';
			$return .= '}';
			echo $return;
			break;
		case 'exception':
			echo '<!DOCTYPE html>';
			echo '<html>';
			echo '<head>';
			echo '<meta http-equiv="Content-Type" content="text/html; charset='.CHARSET.'" />';
			echo '<title></title>';
			echo '<style type="text/css">';
			echo 'body { font-family: "Verdana";padding: 0; margin: 0;}';
			echo 'h2 { font-size: 12px; line-height: 30px; border-bottom: 1px dashed #CCC; padding-bottom: 8px;width:800px; margin: 20px 0 0 150px;}';
			echo 'dl { float: left; display: inline; clear: both; padding: 0; margin: 10px 20px 20px 150px;}';
			echo 'dt { font-size: 14px; font-weight: bold; line-height: 40px; color: #333; padding: 0; margin: 0; border-width: 0px;}';
			echo 'dd { font-size: 12px; line-height: 40px; color: #333; padding: 0px; margin:0;}';
			echo '</style>';
			echo '</head>';
			echo '<body>';
			echo '<h2>'.L('error_info').'</h2>';
			echo '<dl>';
			echo '<dd>'.$msg.'</dd>';
			echo '<dt><p /></dt>';
			echo '<dd>'.L('error_notice_operate').'</dd>';
			echo '<dd><p /><p /><p /><p /></dd>';
			echo '<dd><p /><p /><p /><p /></dd>';
			echo '</dl>';
			echo '</body>';
			echo '</html>';
			exit;
			break;
		case 'javascript':
			echo "<script>";
			echo "alert('". $msg ."');";
			echo "location.href='". $url ."'";
			echo "</script>";
			exit;
			break;
		case 'tenpay':
			echo "<html><head>";
			echo "<meta name=\"TENCENT_ONLINE_PAYMENT\" content=\"China TENCENT\">";
			echo "<script language=\"javascript\">";
			echo "window.location.href='" . $url . "';";
			echo "</script>";
			echo "</head><body></body></html>";
			exit;
			break;
		default:
		    /**
		     * 不显示右侧工具条
		     */

		    $hidden_nctoolbar=1;
			if (is_array($url)){
				foreach ($url as $k => $v){
					$url[$k]['url'] = $v['url']?$v['url']:getReferer();
				}
			}

			/**
			 * html输出形式
			 * 指定为指定项目目录下的error模板文件
			 */
            $html_title=L('hx_html_title');
			include T('msg',t);

	}
	exit;
}

/**
 * 消息提示，主要适用于普通页面AJAX提交的情况
 *
 * @param string $message 消息内容
 * @param string $url 提示完后的URL去向
 * @param stting $alert_type 提示类型 error/succ/notice 分别为错误/成功/警示
 * @param string $extrajs 扩展JS
 * @param int $time 停留时间
 */
function showDialog($message = '', $url = '', $alert_type = 'error', $extrajs = '', $time = 2){
	if (empty($_GET['inajax'])){
		if ($url == 'reload') $url = '';
		showMessage($message.$extrajs,$url,'html',$alert_type,1,$time*1000);
	}
	$message = str_replace("'", "\\'", strip_tags($message));

	$paramjs = null;
	if ($url == 'reload'){
		$paramjs = 'window.location.reload()';
	}elseif ($url != ''){
		$paramjs = 'window.location.href =\''.$url.'\'';
	}
	if ($paramjs){
		$paramjs = 'function (){'.$paramjs.'}';
	}else{
		$paramjs = 'null';
	}
	$modes = array('error' => 'alert', 'succ' => 'succ', 'notice' => 'notice','js'=>'js');
	$cover = $alert_type == 'error' ? 1 : 0;
	$extra .= 'showDialog(\''.$message.'\', \''.$modes[$alert_type].'\', null, '.($paramjs ? $paramjs : 'null').', '.$cover.', null, null, null, null, '.(is_numeric($time) ? $time : 'null').', null);';
	$extra = $extra ? '<script type="text/javascript" reload="1">'.$extra.'</script>' : '';
	if ($extrajs != '' && substr(trim($extrajs),0,7) != '<script'){
		$extrajs = '<script type="text/javascript" reload="1">'.$extrajs.'</script>';
	}
	$extra .= $extrajs;
	ob_end_clean();
	@header("Expires: -1");
	@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
	@header("Pragma: no-cache");
	@header("Content-type: text/xml; charset=".CHARSET);

	$string =  '<?xml version="1.0" encoding="'.CHARSET.'"?>'."\r\n";
	$string .= '<root><![CDATA['.$message.$extra.']]></root>';
	echo $string;exit;
}


/**
 * 不显示信息直接跳转
 *
 * @param string $url
 */
function redirect($url = ''){
	if (empty($url)){
		if(!empty($_REQUEST['ref_url'])){
			$url = $_REQUEST['ref_url'];
		}else{
			$url = getReferer();
		}
	}
	header('Location: '.$url);exit();
}

/**
 * 取上一步来源地址
 *
 * @param
 * @return string 字符串类型的返回结果
 */
function getReferer(){
	return empty($_SERVER['HTTP_REFERER'])?'':$_SERVER['HTTP_REFERER'];
}

/**
 * 取验证码hash值
 *
 * @param
 * @return string 字符串类型的返回结果
 */
function getXwhash($url = '', $do = ''){
    $url = $url ? $url : $_GET['url'];

    $do = $do ? $do : $_GET['do'];
    if (C('captcha_status_login')){
        return substr(md5(SITE_URL.$url.$do),0,8);
    } else {
        return '';
    }
}

/**
 * 加密函数
 *
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function encrypts($txt, $key = ''){
	if (empty($txt)) return $txt;
	if (empty($key)) $key = md5(MD5_KEY);
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
	$ikey ="YUTOU2018chen.SSZCMS";
	$nh1 = rand(0,64);
	$nh2 = rand(0,64);
	$nh3 = rand(0,64);
	$ch1 = $chars{$nh1};
	$ch2 = $chars{$nh2};
	$ch3 = $chars{$nh3};
	$nhnum = $nh1 + $nh2 + $nh3;
	$knum = 0;$i = 0;
	while(isset($key{$i})) $knum +=ord($key{$i++});
	$mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum%8,$knum%8 + 16);
	$txt = base64_encode(time().'_'.$txt);
	$txt = str_replace(array('+','/','='),array('-','_','.'),$txt);
	$tmp = '';
	$j=0;$k = 0;
	$tlen = strlen($txt);
	$klen = strlen($mdKey);
	for ($i=0; $i<$tlen; $i++) {
		$k = $k == $klen ? 0 : $k;
		$j = ($nhnum+strpos($chars,$txt{$i})+ord($mdKey{$k++}))%64;
		$tmp .= $chars{$j};
	}
	$tmplen = strlen($tmp);
	$tmp = substr_replace($tmp,$ch3,$nh2 % ++$tmplen,0);
	$tmp = substr_replace($tmp,$ch2,$nh1 % ++$tmplen,0);
	$tmp = substr_replace($tmp,$ch1,$knum % ++$tmplen,0);
	return $tmp;
}

/**
 * 解密函数
 *
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function decrypt($txt, $key = '', $ttl = 0){
	if (empty($txt)) return $txt;
	if (empty($key)) $key = md5(MD5_KEY);

	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
	$ikey ="YUTOU2018chen.SSZCMS";
	$knum = 0;$i = 0;
	$tlen = @strlen($txt);
	while(isset($key{$i})) $knum +=ord($key{$i++});
	$ch1 = @$txt{$knum % $tlen};
	$nh1 = strpos($chars,$ch1);
	$txt = @substr_replace($txt,'',$knum % $tlen--,1);
	$ch2 = @$txt{$nh1 % $tlen};
	$nh2 = @strpos($chars,$ch2);
	$txt = @substr_replace($txt,'',$nh1 % $tlen--,1);
	$ch3 = @$txt{$nh2 % $tlen};
	$nh3 = @strpos($chars,$ch3);
	$txt = @substr_replace($txt,'',$nh2 % $tlen--,1);
	$nhnum = $nh1 + $nh2 + $nh3;
	$mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum % 8,$knum % 8 + 16);
	$tmp = '';
	$j=0; $k = 0;
	$tlen = @strlen($txt);
	$klen = @strlen($mdKey);
	for ($i=0; $i<$tlen; $i++) {
		$k = $k == $klen ? 0 : $k;
		$j = strpos($chars,$txt{$i})-$nhnum - ord($mdKey{$k++});
		while ($j<0) $j+=64;
		$tmp .= $chars{$j};
	}
	$tmp = str_replace(array('-','_','.'),array('+','/','='),$tmp);
	$tmp = trim(base64_decode($tmp));

	if (preg_match("/\d{10}_/s",substr($tmp,0,11))){
		if ($ttl > 0 && (time() - substr($tmp,0,11) > $ttl)){
			$tmp = null;
		}else{
			$tmp = substr($tmp,11);
		}
	}
	return $tmp;
}

/**
 * 取得IP
 * @return string 字符串类型的返回结果
 */
function getIp(){
	if (@$_SERVER['HTTP_CLIENT_IP'] && $_SERVER['HTTP_CLIENT_IP']!='unknown') {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (@$_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR']!='unknown') {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return preg_match('/^\d[\d.]+\d$/', $ip) ? $ip : '';
}



/**
 * 读取目录列表
 * 不包括 . .. 文件 三部分
 * @param string $path 路径
 * @return array 数组格式的返回结果
 */
function readDirList($path){
	if (is_dir($path)) {
		$handle = @opendir($path);
		$dir_list = array();
		if ($handle){
			while (false !== ($dir = readdir($handle))){
				if ($dir != '.' && $dir != '..' && is_dir($path.DS.$dir)){
					$dir_list[] = $dir;
				}
			}
			return $dir_list;
		}else {
			return false;
		}
	}else {
		return false;
	}
}

/**
 * 转换特殊字符
 * @param string $string 要转换的字符串
 * @return string 字符串类型的返回结果
 */
function replaceSpecialChar($string){
	$str = str_replace("\r\n", "", $string);
	$str = str_replace("\t", "    ", $string);
	$str = str_replace("\n", "", $string);
	return $string;
}

/**
 * 编辑器内容
 *
 * @param int $id 编辑器id名称，与name同名
 * @param string $value 编辑器内容
 * @param string $width 宽 带px
 * @param string $height 高 带px
 * @param string $style 样式内容
 * @param string $upload_state 上传状态，默认是开启
 */
 
function showEditor($id, $value='', $width='700px', $height='300px', $style='visibility:hidden;',$upload_state="true", $media_open=false, $type='all'){
	switch($type) {
    case 'basic':
        $items = "['source', '|', 'fullscreen', 'undo', 'redo', 'cut', 'copy', 'paste', '|', 'about']";
        break;
    case 'simple':
        $items = "['source', '|', 'fullscreen', 'undo', 'redo', 'cut', 'copy', 'paste', '|',
            'fontname', 'fontsize', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
            'removeformat', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
            'insertunorderedlist', '|', 'emoticons', 'image', 'link', '|', 'about']";
        break;
    default:
        $items = "['fullscreen', 'source', 'undo', 'redo', '|','bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'simpleupload','insertimage','link','unlink','justifyleft','justifyright','justifycenter','justifyjustify','fontsize','forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']";
        break;
    }
	echo '<script id="'. $id .'" name="'. $id .'" type="text/plain" >'.$value.'</script>'; 
	echo '<script type=text/javascript>';  
	echo 'var editor = UE.getEditor("'. $id .'", {
		initialFrameHeight:300, 
		scaleEnabled:true,
		toolbars: [ '.$items.' ]
	});'; 
	echo '</script>';
	 
	return true;
}
 
 
function showEditor1($id, $value='', $width='700px', $height='300px', $style='visibility:hidden;',$upload_state="true", $media_open=false, $type='all'){
	//是否开启多媒体
	$media = '';
	if ($media_open){
		$media = ", 'flash', 'media'";
	}
    switch($type) {
    case 'basic':
        $items = "['source', '|', 'fullscreen', 'undo', 'redo', 'cut', 'copy', 'paste', '|', 'about']";
        break;
    case 'simple':
        $items = "['source', '|', 'fullscreen', 'undo', 'redo', 'cut', 'copy', 'paste', '|',
            'fontname', 'fontsize', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
            'removeformat', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
            'insertunorderedlist', '|', 'emoticons', 'image', 'link', '|', 'about']";
        break;
    default:
        $items = "['source', '|', 'fullscreen', 'undo', 'redo', 'print', 'cut', 'copy', 'paste',
            'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
            'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
            'superscript', '|', 'selectall', 'clearhtml','quickformat','|',
            'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
            'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image'".$media.", 'table', 'hr', 'emoticons', 'link', 'unlink', '|', 'about']";
        break;
    }
	//图片、Flash、视频、文件的本地上传都可开启。默认只有图片，要启用其它的需要修改resource\kindeditor\php下的upload_json.php的相关参数
	echo '<textarea id="'. $id .'" name="'. $id .'" style="width:'. $width .';height:'. $height .';'. $style .'">'.$value.'</textarea>';
	echo '
<script src="'. EXT_URL .'/kindeditor/kindeditor-min.js" charset="utf-8"></script>
<script src="'. EXT_URL .'/kindeditor/lang/zh_CN.js" charset="utf-8"></script>
<script>
	var KE;
  KindEditor.ready(function(K) {
        KE = K.create("textarea[name=\''.$id.'\']", {
						items : '.$items.',
						cssPath : "' . EXT_URL . '/kindeditor/themes/default/default.css",
						allowImageUpload : '.$upload_state.',
						allowFlashUpload : false,
						allowMediaUpload : false,
						allowFileManager : false,
						syncType:"form",
						afterCreate : function() {
							var self = this;
							self.sync();
						},
						afterChange : function() {
							var self = this;
							self.sync();
						},
						afterBlur : function() {
							var self = this;
							self.sync();
						}
        });
			KE.appendHtml = function(id,val) {
				this.html(this.html() + val);
				if (this.isCreated) {
					var cmd = this.cmd;
					cmd.range.selectNodeContents(cmd.doc.body).collapse(false);
					cmd.select();
				}
				return this;
			}
	});
</script>
	';
	return true;
}

/**
 * 获取目录大小
 * @param string $path 目录
 * @param int $size 目录大小
 * @return int 整型类型的返回结果
 */
function getDirSize($path, $size=0){
	$dir = @dir($path);
	if (!empty($dir->path) && !empty($dir->handle)){
		while($filename = $dir->read()){
			if($filename != '.' && $filename != '..'){
				if (is_dir($path.DS.$filename)){
					$size += getDirSize($path.DS.$filename);
				}else {
					$size += filesize($path.DS.$filename);
				}
			}
		}
	}
	return $size ? $size : 0 ;
}

/**
 * 删除缓存目录下的文件或子目录文件
 * @param string $dir 目录名或文件名
 * @return boolean
 */
function delCacheFile($dir){
	//防止删除cache以外的文件
	if (strpos($dir,'..') !== false) return false;
	$path = HX_DATA.DS.'cache'.DS.$dir;

	if (is_dir($path)){
		$file_list = array();
		readFileList($path,$file_list);
		if (!empty($file_list)){
			foreach ($file_list as $v){
				if (basename($v) != 'index.html')@unlink($v);
			}
		}
	}else{
		if (basename($path) != 'index.html') @unlink($path);
	}
	return true;
}

/**
 * 获取文件列表(所有子目录文件)
 *
 * @param string $path 目录
 * @param array $file_list 存放所有子文件的数组
 * @param array $ignore_dir 需要忽略的目录或文件
 * @return array 数据格式的返回结果
 */
function readFileList($path,&$file_list,$ignore_dir=array()){
	$path = rtrim($path,'/');
	if (is_dir($path)) {
		$handle = @opendir($path);
		if ($handle){
			while (false !== ($dir = readdir($handle))){
				if ($dir != '.' && $dir != '..'){
					if (!in_array($dir,$ignore_dir)){
						if (is_file($path.DS.$dir)){
							$file_list[] = $path.DS.$dir;
						}elseif(is_dir($path.DS.$dir)){
							readFileList($path.DS.$dir,$file_list,$ignore_dir);
						}
					}
				}
			}
			@closedir($handle);
//			return $file_list;
		}else {
			return false;
		}
	}else {
		return false;
	}
}

/**
* 价格格式化
* @param int	$price
* @return string	$price_format
*/
function PriceFormat($price) {
	$price_format	= number_format($price,2,'.','');
	return $price_format;
}

/**
* 价格格式化
*
* @param int	$price
* @return string	$price_format
*/
function PriceFormatForList($price) {
    if ($price >= 10000) {
       return number_format(floor($price/100)/100,2,'.','').L('ten_thousand');
    } else {
     return L('currency').$price;
    }
}

/**
 * 二级域名解析
 * @return int 域名id
 */
function subdomain(){
	$domain_id = 0;
	/**
	 * 获得系统配置,二级域名功能是否开启
	 */
	if (C('enabled_subdomain')=='1'){//开启了二级域名
		$line = @explode(SUBDOMAIN_SUFFIX,$_SERVER['HTTP_HOST']);
		$line = trim($line[0],'.');
		if(empty($line) || strtolower($line) == 'www') return 0;

		$model_domain = M('domain');
		$domain_info = $model_domain->getDomainInfo(array('url_domain'=>$line));
		//二级域名存在
		if ($domain_info['domain_id'] > 0){
			$store_id = $domain_info['domain_id'];
			$_GET['domain_id'] = $domain_info['domain_id'];
		}
	}
	return $domain_id;
}

/**
 * 通知邮件/通知消息 内容转换函数
 * @param string $message 内容模板
 * @param array $param 内容参数数组
 * @return string 通知内容
 */
function ReplaceText($message,$param){
	if(!is_array($param))return false;
	foreach ($param as $k=>$v){
		$message	= str_replace('{$'.$k.'}',$v,$message);
	}
	return $message;
}

/**
 * 字符串切割函数，一个字母算一个位置,一个字算2个位置
 * @param string $string 待切割的字符串
 * @param int $length 切割长度
 * @param string $dot 尾缀
 */
function str_cut($string, $length, $dot = '')
{
	$string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$maxi = $length - strlen($dot);
	$strcut = '';
	if(strtolower(CHARSET) == 'utf-8')
	{
		$n = $tn = $noc = 0;
		while($n < $strlen)
		{
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $maxi) break;
		}
		if($noc > $maxi) $n -= $tn;
		$strcut = substr($string, 0, $n);
	}
	else
	{
		$dotlen = strlen($dot);
		$maxi = $length - $dotlen;
		for($i = 0; $i < $maxi; $i++)
		{
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	$strcut = str_replace(array('&', '"', "'", '<', '>'), array('&amp;', '&quot;', '&#039;', '&lt;', '&gt;'), $strcut);
	return $strcut.$dot;
}

/**
 * unicode转为utf8
 * @param string $str 待转的字符串
 * @return string
 */
function unicodeToUtf8($str, $order = "little")
{
	$utf8string ="";
	$n=strlen($str);
	for ($i=0;$i<$n ;$i++ )
	{
		if ($order=="little")
		{
			$val = str_pad(dechex(ord($str[$i+1])), 2, 0, STR_PAD_LEFT) .
			str_pad(dechex(ord($str[$i])),      2, 0, STR_PAD_LEFT);
		}
		else
		{
			$val = str_pad(dechex(ord($str[$i])),      2, 0, STR_PAD_LEFT) .
			str_pad(dechex(ord($str[$i+1])), 2, 0, STR_PAD_LEFT);
		}
		$val = intval($val,16); // 由于上次的.连接，导致$val变为字符串，这里得转回来。
		$i++; // 两个字节表示一个unicode字符。
		$c = "";
		if($val < 0x7F)
		{ // 0000-007F
			$c .= chr($val);
		}
		elseif($val < 0x800)
		{ // 0080-07F0
			$c .= chr(0xC0 | ($val / 64));
			$c .= chr(0x80 | ($val % 64));
		}
		else
		{ // 0800-FFFF
			$c .= chr(0xE0 | (($val / 64) / 64));
			$c .= chr(0x80 | (($val / 64) % 64));
			$c .= chr(0x80 | ($val % 64));
		}
		$utf8string .= $c;
	}
	/* 去除bom标记 才能使内置的iconv函数正确转换 */
	if (ord(substr($utf8string,0,1)) == 0xEF && ord(substr($utf8string,1,2)) == 0xBB && ord(substr($utf8string,2,1)) == 0xBF)
	{
		$utf8string = substr($utf8string,3);
	}
	return $utf8string;
}

/*
 * 重写$_SERVER['REQUREST_URI']
 */
function request_uri()
{
    if (isset($_SERVER['REQUEST_URI']))
    {
        $uri = $_SERVER['REQUEST_URI'];
    }
    else
    {
        if (isset($_SERVER['argv']))
        {
            $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
        }
        else
        {
            $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
        }
    }
    return $uri;
}

/*
 * 自定义memory_get_usage()
 * @return 内存使用额度，如果该方法无效，返回0
 */
if(!function_exists('memory_get_usage')){
	function memory_get_usage(){
		return 0;
	}
}

// 记录和统计时间（微秒）
function addUpTime($start,$end='',$dec=3) {
    static $_info = array();
    if(!empty($end)) { // 统计时间
        if(!isset($_info[$end])) {
            $_info[$end]   =  microtime(TRUE);
        }
        return number_format(($_info[$end]-$_info[$start]),$dec);
    }else{ // 记录时间
        $_info[$start]  =  microtime(TRUE);
    }
}



/**
 * 加载文件
 * 使用require_once函数，只适用于加载框架内类库文件
 * 如果文件名中包含"_"使用"#"代替
 * @example import('cache'); //require_once(BASE_PATH.'/lib/cache.php');
 * @example import('lib.cache');	//require_once(BASE_PATH.'/lib/cache.php');
 * @example import('fun.core');	//require_once(BASE_PATH.'/fun/core.php');
 * @example import('.control.adv')	//require_once(BASE_PATH.'/control/adv.php');
 *
 * @param 要加载的文件 $libname
 * @param 文件扩展名 $file_ext
 */
function import($libname,$file_ext='.php'){
	//替换为目录符号/
	if (strstr($libname,'.')){
		$path = str_replace('.','/',$libname);
	}else{
		$path = 'lib/'.$libname;
	}
	// 基准目录，如果是顶级目录
	if(substr($libname,0,1) == '.'){
		$base_dir = HX_CORE.'/';
		$path = ltrim(str_replace('lib/','',$path),'/');
	}else{
		$base_dir = HX_CORE.'/';
	}
	//如果文件名中含有.使用#代替
	if (strstr($path,'#')){
		$path = str_replace('#','.',$path);
	}
	//返回安全路径
	if(preg_match('/^[\w\d\/_.]+$/i', $path)){
		$file = realpath($base_dir.$path.$file_ext);
	}else{
		$file = false;
	}
	if (!$file){
		exit($path.$file_ext.' isn\'t exists!');
	}else{
		require_once($file);
	}

}

/**
 * 取得随机数
 *
 * @param int $length 生成随机数的长度
 * @param int $numeric 是否只产生数字随机数 1是0否
 * @return string
 */
function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}



/**
 * 检测FORM是否提交
 * @param  $check_token 是否验证token
 * @param  $check_captcha 是否验证验证码
 * @param  $return_type 'alert','num'
 * @return boolean
 */
function chksubmit($check_token = false, $check_captcha = false, $return_type = 'alert'){
	$submit = isset($_POST['form_submit']) ? $_POST['form_submit'] : $_GET['form_submit'];

	if ($submit != 'ok') return false;
	if ($check_token && !Security::checkToken()){
		if ($return_type == 'alert'){
			showDialog('Token error!');
		}else{
			return -11;
		}
	}

	if ($check_captcha){

		if (!checkSeccode($_POST['xwhash'],$_POST['captcha'])){
		    setXwCookie('seccode'.$_POST['xwhash'],'',-3600);
			if ($return_type == 'alert'){
				showDialog('验证码错误!');
			}else{
				return -12;
			}
		}
		setXwCookie('seccode'.$_POST['xwhash'],'',-3600);
	}
	return true;
}



/**
 * 输出validate的验证信息
 *
 * @param array/string $error
 */
function showValidateError($error){
	if (!empty($_GET['inajax'])){
		foreach (explode('<br/>',$error) as $v) {
			if (trim($v != '')){
				showDialog($v,'','error','',3);
			}
		}
	}else{
		showDialog($error,'','error','',3);
	}
}

/**
 * 延时加载分页功能，判断是否有更多连接和limitstart值和经过验证修改的$delay_eachnum值
 * @param int $delay_eachnum 延时分页每页显示的条数
 * @param int $delay_page 延时分页当前页数
 * @param int $count 总记录数
 * @param bool $ispage 是否在分页模式中实现延时分页(前台显示的两种不同效果)
 * @param int $page_nowpage 分页当前页数
 * @param int $page_eachnum 分页每页显示条数
 * @param int $page_limitstart 分页初始limit值
 * @return array array('hasmore'=>'是否显示更多连接','limitstart'=>'加载的limit开始值','delay_eachnum'=>'经过验证修改的$delay_eachnum值');
 */
function lazypage($delay_eachnum,$delay_page,$count,$ispage=false,$page_nowpage=1,$page_eachnum=1,$page_limitstart=1){
	//是否有多余
	$hasmore = true;
	$limitstart = 0;
	if ($ispage == true){
		if ($delay_eachnum < $page_eachnum){//当延时加载每页条数小于分页的每页条数时候实现延时加载，否则按照普通分页程序流程处理
			$page_totlepage = ceil($count/$page_eachnum);
			//计算limit的开始值
			$limitstart = $page_limitstart + ($delay_page-1)*$delay_eachnum;
			if ($page_totlepage > $page_nowpage){//当前不为最后一页
				if ($delay_page >= $page_eachnum/$delay_eachnum){
					$hasmore = false;
				}
				//判断如果分页的每页条数与延时加载每页的条数不能整除的处理
				if ($hasmore == false && $page_eachnum%$delay_eachnum >0){
					$delay_eachnum = $page_eachnum%$delay_eachnum;
				}
			}else {//当前最后一页
				$showcount = ($page_totlepage-1)*$page_eachnum+$delay_eachnum*$delay_page;//已经显示的记录总数
				if ($count <= $showcount){
					$hasmore = false;
				}
			}
		}else {
			$hasmore = false;
		}
	}else {
		if ($count <= $delay_page*$delay_eachnum){
			$hasmore = false;
		}
		//计算limit的开始值
		$limitstart = ($delay_page-1)*$delay_eachnum;
	}

	return array('hasmore'=>$hasmore,'limitstart'=>$limitstart,'delay_eachnum'=>$delay_eachnum);
}

/**
 * 封装分页操作到函数，方便调用
 * @param string $cmd 命令类型
 * @param mixed $arg 参数
 * @return mixed
 */
function pagecmd($cmd ='', $arg = ''){
	if (!class_exists('page'))	import('page');
	static $page;
	if ($page == null){
		$page = new Page();
	}

	switch (strtolower($cmd)) {
		case 'seteachnum':		$page->setEachNum($arg);break;
		case 'settotalnum': 	$page->setTotalNum($arg);break;
		case 'setstyle': 		$page->setStyle($arg);break;
		case 'show': 			return $page->show($arg);break;
		case 'obj':				return $page;break;
		case 'gettotalnum':		return $page->getTotalNum();break;
		case 'gettotalpage':	return $page->getTotalPage();break;
		case "getnowpage":      return $page->getNowPage();break;
		default:				break;
	}
}

/**
 * 内容写入文件
 *
 * @param string $filepath 待写入内容的文件路径
 * @param string/array $data 待写入的内容
 * @param  string $mode 写入模式，如果是追加，可传入“append”
 * @return bool
 */
function write_file($filepath, $data, $mode = null)
{
    if (!is_array($data) && !is_scalar($data)) {
        return false;
    }

    $dir = dirname($filepath);
    // 目录不存在则创建
    if (!is_dir($dir))
    mk_dir($dir);

    $data = var_export($data, true);
    $data = "<?php defined('SSZCMS') or exit('Access Denied'); return ".$data.";";
    $mode = $mode == 'append' ? FILE_APPEND : null;
    if (false === file_put_contents($filepath,($data),$mode)){
        return false;
    }else{
        return true;
    }
}

/**
 * 循环创建目录
 *
 * @param string $dir 待创建的目录
 * @param  $mode 权限
 * @return boolean
 */
function mk_dir($dir, $mode = '0777') {
    if (is_dir($dir) || @mkdir($dir, $mode))
        return true;
    if (!mk_dir(dirname($dir), $mode))
        return false;
    return @mkdir($dir, $mode);
}




/**
 * 抛出异常
 *
 * @param string $error 异常信息
 */
function throw_exception($error){
	if (!defined('IGNORE_EXCEPTION')){
		showMessage($error, '', 'exception');
	}else{
		exit();
	}
}

/**
 * 输出错误信息
 *
 * @param string $error 错误信息
 */
function halt($error){
	showMessage($error,'','exception');
}

/**
 * 去除代码中的空白和注释
 * @param string $content 待压缩的内容
 * @return string
 */
function compress_code($content) {
    $stripStr = '';
    //分析php源码
    $tokens = token_get_all($content);
    $last_space = false;
    for ($i = 0, $j = count($tokens); $i < $j; $i++) {
        if (is_string($tokens[$i])) {
            $last_space = false;
            $stripStr .= $tokens[$i];
        } else {
            switch ($tokens[$i][0]) {
                case T_COMMENT:	//过滤各种PHP注释
                case T_DOC_COMMENT:
                    break;
                case T_WHITESPACE:	//过滤空格
                    if (!$last_space) {
                        $stripStr .= ' ';
                        $last_space = true;
                    }
                    break;
                default:
                    $last_space = false;
                    $stripStr .= $tokens[$i][1];
            }
        }
    }
    return $stripStr;
}

/**
 * 取得对象实例
 *
 * @param object $class
 * @param string $method
 * @param array $args
 * @return object
 */
function get_obj_instance($class, $method='', $args = array()){
	static $_cache = array();
	$key = $class.$method.(empty($args) ? null : md5(serialize($args)));
	if (isset($_cache[$key])){
		return $_cache[$key];
	}else{
		if (class_exists($class)){
			$obj = new $class;
			if (method_exists($obj,$method)){
				if (empty($args)){
					$_cache[$key] = $obj->$method();
				}else{
					$_cache[$key] = call_user_func_array(array(&$obj, $method), $args);
				}
			}else{
				$_cache[$key] = $obj;
			}
			return $_cache[$key];
		}else{
			throw_exception('Class '.$class.' isn\'t exists!');
		}
	}
}

/**
 * 返回以原数组某个值为下标的新数据
 * @param array $array
 * @param string $key
 * @param int $type 1一维数组2二维数组
 * @return array
 */
function array_under_reset($array, $key, $type=1){
	if (is_array($array)){
		$tmp = array();
		foreach ($array as $v) {
			if ($type === 1){
				$tmp[$v[$key]] = $v;
			}elseif($type === 2){
				$tmp[$v[$key]][] = $v;
			}
		}
		return $tmp;
	}else{
		return $array;
	}
}




/**
 * 加载完成业务方法的文件
 * @param string $filename
 * @param string $file_ext
 */
function loadfunc($filename, $file_ext = '.php'){
	if(preg_match('/^[\w\d\/_.]+$/i', $filename.$file_ext)){
		$file = realpath(BASE_PATH.'/fun/'.$filename.$file_ext);
	}else{
		$file = false;
	}
	if (!$file){
		exit($filename.$file_ext.' isn\'t exists!');
	}else{
		require_once($file);
	}
}

/**
 * 实例化类
 * @param string $model_name 模型名称
 * @return obj 对象形式的返回结果
 */
function hx_class($classname = null){
	static $_cache = array();
	if (!is_null($classname) && isset($_cache[$classname])) return $_cache[$classname];
	$file_name = BASE_PATH.'/lib/'.$classname.'.class.php';
	$newname = $classname.'Class';
	if (file_exists($file_name)){
		require_once($file_name);
		if (class_exists($newname)){
			return $_cache[$classname] = new $newname();
		}
	}
	throw_exception('Class Error:  Class '.$classname.' is not exists!');
}

/**
 * 拼接动态URL，参数需要小写
 *
 * 调用示例
 *
 * 若指向网站首页，可以传空:
 * url() => 表示url和do均为index，返回当前站点网址
 *
 * url('search,'index','array('cate_id'=>2)); 实际指向 index.php?url=search&op=index&cate_id=2
 * 传递数组参数时，若act（或op）值为index,则可以省略
 * 上面示例等同于
 * url('search','',array('url'=>'search','cate_id'=>2));
 *
 * @param string $url control文件名
 * @param string $op op方法名
 * @param array $args URL其它参数
 * @param boolean $model 默认取当前系统配置
 * @param string $site_url 生成链接的网址，默认取当前网址
 * @return string
 */
function url($url = '', $do = '', $args = array(), $model = false, $site_url = ''){
    //伪静态文件扩展名
    $ext = '.html';
    //入口文件名
    $file = 'index.php';
//    $site_url = empty($site_url) ? SHOP_SITE_URL : $site_url;
    $url = trim($url);
    $do = trim($do);
    $args = !is_array($args) ? array() : $args;
    //定义变量存放返回url
    $url_string = '';
    if (empty($url) && empty($do) && empty($args)) {
        return $site_url;
    }
    $url = !empty($url) ? $url : 'index';
    $do = !empty($do) ? $do : 'index';

    $model = $model ? URL_MODEL : $model;

    if ($model) {
        //伪静态模式
        $url_perfix = "{$url}-{$do}";
        if (!empty($args)){
            $url_perfix .= '-';
        }
        $url_string = $url_perfix.http_build_query($args,'','-').$ext;
        $url_string = str_replace('=','-',$url_string);
    }else {
        //默认路由模式
        $url_perfix = "url={$url}&do={$do}";
        if (!empty($args)){
            $url_perfix .= '&';
        }
        $url_string = $file.'?'.$url_perfix.http_build_query($args);
    }
    //将自动生成的伪静态URL使用短URL代替
    $reg_match_from = array(
	    '/^login-index\.html$/'

        );
    $reg_match_to = array(
	    'login.html'

    );
    $url_string = preg_replace($reg_match_from,$reg_match_to,$url_string);
    return rtrim($site_url,'/').'/'.$url_string;
}
function wapurl($url = '', $do = '', $args = array(), $model = false, $site_url = ''){
    //伪静态文件扩展名
    $ext = '.html';
    //入口文件名
    $file = 'index.php';
//    $site_url = empty($site_url) ? SHOP_SITE_URL : $site_url;
    $url = trim($url);
    $do = trim($do);
    $args = !is_array($args) ? array() : $args;
    //定义变量存放返回url
    $url_string = '';
    if (empty($url) && empty($do) && empty($args)) {
        return $site_url;
    }
    $url = !empty($url) ? $url : 'index';
    $do = !empty($do) ? $do : 'index';

    $model = $model ? URL_MODEL : $model;

    if ($model) {
        //伪静态模式
        $url_perfix = "{$url}-{$do}";
        if (!empty($args)){
            $url_perfix .= '-';
        }
        $url_string = $url_perfix.http_build_query($args,'','-').$ext;
        $url_string = str_replace('=','-',$url_string);
    }else {
        //默认路由模式
        $url_perfix = "url={$url}&do={$do}";
        if (!empty($args)){
            $url_perfix .= '&';
        }
        $url_string = $file.'?'.$url_perfix.http_build_query($args);
    }
    //将自动生成的伪静态URL使用短URL代替
    $reg_match_from = array(
	    '/^login-index\.html$/'

        );
    $reg_match_to = array(
	    'login.html'

    );
    $url_string = preg_replace($reg_match_from,$reg_match_to,$url_string);
    return rtrim($site_url,'/').'/wap/'.$url_string;
}

/**
 * 后台使用的URL链接函数，强制使用动态传参数模式
 *
 * @param string $url control文件名
 * @param string $do op方法名
 * @param array $args URL其它参数
 * @return string
 */
function urlAdmin($url = '', $do = '', $args = array()){
    return url($url, $do, $args, false, ADMIN_URL);
}
function urlAdminM($url = '', $do = '', $args = array()){
    return url($url, $do, $args, false, APP_SITE_URL);
}


/**
 * 将字符部分加密并输出
 * @param unknown $str
 * @param unknown $start 从第几个位置开始加密(从1开始)
 * @param unknown $length 连续加密多少位
 * @return string
 */
function encryptShow($str,$start,$length) {
    $end = $start - 1 + $length;
    $array = str_split($str);
    foreach ($array as $k => $v) {
    	if ($k >= $start-1 && $k < $end) {
    	    $array[$k] = '*';
    	}
    }
    return implode('',$array);
}

/**
 * 规范数据返回函数
 * @param unknown $state
 * @param unknown $msg
 * @param unknown $data
 * @return multitype:unknown
 */
function callback($state = true, $msg = '', $data = array()) {
    return array('state' => $state, 'msg' => $msg, 'data' => $data);
}

/**
 * 取得商品默认大小图片
 *
 * @param string $key	图片大小 small tiny
 * @return string
 */
function defaultGoodsImage($key){
    $file = str_ireplace('.', '_' . $key . '.', C('default_goods_image'));
	return ATTACH_COMMON.DS.$file;
}

/**
 * 获取运单图片地址
 */
function getprintImageUrl($image_name = '') {
    $image_path = DS . ATTACH_PRINT . DS . $image_name;
    if(is_file(HX_UPLOAD . $image_path)) {
        return UPLOAD_SITE_URL . $image_path;
    } else {
        return UPLOAD_SITE_URL.'/'.defaultGoodsImage('240');
    }
}


/**
 * 获取运单图片地址
 */
function getMbSpecialImageUrl($image_name = '') {
    $name_array = explode('_', $image_name);
    if(count($name_array) == 2) {
        $image_path = DS . ATTACH_MOBILE . DS . 'special' . DS . $name_array[0] . DS . $image_name;
    } else {
        $image_path = DS . ATTACH_MOBILE . DS . 'special' . DS . $image_name;
    }
    if(is_file(HX_UPLOAD . $image_path)) {
        return UPLOAD_SITE_URL . $image_path;
    } else {
        return UPLOAD_SITE_URL.'/'.defaultGoodsImage('240');
    }
}

function cny($ns) {
    static $cnums=array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"),
        $cnyunits=array("圆","角","分"),
        $grees=array("拾","佰","仟","万","拾","佰","仟","亿");
    list($ns1,$ns2)=explode(".",$ns,2);
    $ns2=array_filter(array($ns2[1],$ns2[0]));
    $ret=array_merge($ns2,array(implode("",_cny_map_unit(str_split($ns1),$grees)),""));
    $ret=implode("",array_reverse(_cny_map_unit($ret,$cnyunits)));
    return str_replace(array_keys($cnums),$cnums,$ret);
}

function cnn($ns) {
    static $cnums=array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"),
        $cnyunits=array("","",""),
        $grees=array("拾","佰","仟","万","拾","佰","仟","亿");
    list($ns1,$ns2)=explode(".",$ns,2);
    $ns2=array_filter(array($ns2[1],$ns2[0]));
    $ret=array_merge($ns2,array(implode("",_cny_map_unit(str_split($ns1),$grees)),""));
    $ret=implode("",array_reverse(_cny_map_unit($ret,$cnyunits)));
    return str_replace(array_keys($cnums),$cnums,$ret);
}

function _cny_map_unit($list,$units) {
    $ul=count($units);
    $xs=array();
    foreach (array_reverse($list) as $x) {
        $l=count($xs);
        if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]);
        else $n=is_numeric($xs[0][0])?$x:'';
        array_unshift($xs,$n);
    }
    return $xs;
}




