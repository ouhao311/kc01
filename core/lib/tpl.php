<?php
// +----------------------------------------------------------------------
// | Name: 模板类
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class Tpl{


	private function __construct(){}


	/**
	 * 设置布局
	 *
	 * @param string $layout
	 * @return bool
	 */
	public static function setLayout($layout){
		self::$layout_file = $layout;
		return true;
	}
/**
* 生成缓存
* @param
* @return
*/

public static function template_compile($from, $to) {


	$content = self::template_parse(F($from));


	F($to, $content);
}
/**
* 解析模板
* @param
* @return
*/
public static function template_parse($str) {

	$str = preg_replace("/\<\!\-\-\[(.+?)\]\-\-\>/", "", $str);
	$str = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $str);
	$str = preg_replace("/\{template\s+([^\}]+)\}/", "<?php include T(\\1);?>", $str);
	$str = preg_replace("/\{php\s+(.+)\}/", "<?php \\1?>", $str);
	$str = preg_replace("/\{if\s+(.+?)\}/", "<?php if(\\1) { ?>", $str);
	$str = preg_replace("/\{else\}/", "<?php } else { ?>", $str);
	$str = preg_replace("/\{elseif\s+(.+?)\}/", "<?php } else if(\\1) { ?>", $str);
	$str = preg_replace("/\{\/if\}/", "<?php } ?>\r\n", $str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}/", "<?php if(is_array(\\1)) { foreach(\\1 as \\2) { ?>", $str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/", "<?php if(is_array(\\1)) { foreach(\\1 as \\2 => \\3) { ?>", $str);
	$str = preg_replace("/\{\/loop\}/", "<?php } } ?>", $str);
	$str = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str);
	$str = preg_replace("/<\?php([^\?]+)\?>/es", "self::template_addquote('<?php\\1?>')", $str);
	$str = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\+\-\x7f-\xff]*)\}/", "<?php echo \\1;?>", $str);
	$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "self::template_addquote('<?php echo \\1;?>')", $str);
	$str = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $str);
	$str = preg_replace("/\'([A-Za-z]+)\[\'([A-Za-z\.]+)\'\](.?)\'/s", "'\\1[\\2]\\3'", $str);
	$str = preg_replace("/(\r?\n)\\1+/", "\\1", $str);
	$str = str_replace("\t", '', $str);
	$str = "<?php defined('SSZCMS') or exit('Access Denied');?>".$str;

	return $str;
}

public static function template_addquote($var) {
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}





	/**
	 * 显示页面Trace信息
	 *
	 * @return array
	 */
    public static function showTrace(){
    	$trace = array();
    	//当前页面
		$trace[Language::get('hx_debug_current_page')] =  $_SERVER['REQUEST_URI'].'<br>';
    	//请求时间
        $trace[Language::get('hx_debug_request_time')] =  date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']).'<br>';
        //系统运行时间
        $query_time = number_format((microtime(true)-StartTime),3).'s';
        $trace[Language::get('hx_debug_execution_time')] = $query_time.'<br>';
		//内存
		$trace[Language::get('hx_debug_memory_consumption')] = number_format(memory_get_usage()/1024/1024,2).'MB'.'<br>';
		//请求方法
        $trace[Language::get('hx_debug_request_method')] = $_SERVER['REQUEST_METHOD'].'<br>';
        //通信协议
        $trace[Language::get('hx_debug_communication_protocol')] = $_SERVER['SERVER_PROTOCOL'].'<br>';
        //用户代理
        $trace[Language::get('hx_debug_user_agent')] = $_SERVER['HTTP_USER_AGENT'].'<br>';
        //会话ID
        $trace[Language::get('hx_debug_session_id')] = session_id().'<br>';
        //执行日志
        $log    =   Log::read();
        $trace[Language::get('hx_debug_logging')]  = count($log)?count($log).Language::get('hx_debug_logging_1').'<br/>'.implode('<br/>',$log):Language::get('hx_debug_logging_2');
        $trace[Language::get('hx_debug_logging')] = $trace[Language::get('hx_debug_logging')].'<br>';
        //文件加载
		$files =  get_included_files();
		$trace[Language::get('hx_debug_load_files')] = count($files).str_replace("\n",'<br/>',substr(substr(print_r($files,true),7),0,-2)).'<br>';
        return $trace;
    }
	public static function flexigridXML($flexigridXML){

	$page = $flexigridXML['now_page'];
	$total = $flexigridXML['total_num'];
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: text/xml");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<rows>";
$xml .= "<page>$page</page>";
$xml .= "<total>$total</total>";
if(empty($flexigridXML['list'])){
	$xml .= "<row id=''>";
	$xml .= "<cell></cell>";
	$xml .= "</row>";
	}else{
	foreach ($flexigridXML['list'] as $k => $v){
		$xml .= "<row id='".$k."'>";
       foreach ($v as $kk => $vv){
			$xml .= "<cell><![CDATA[".$v[$kk]."]]></cell>";
			}
	$xml .= "</row>";
	}
}
$xml .= "</rows>";
echo $xml;
		}
	public static function flexigridfXML($flexigridXML){
	$page = $flexigridXML['now_page'];
	$total = $flexigridXML['total_num'];

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: text/xml");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<rows>";
$xml .= "<page>$page</page>";
$xml .= "<total>$total</total>";
foreach ($flexigridXML['list'] as $k => $v){
	$xml .= "<row id='".$k."'>";
	$xml .= "<cell><![CDATA[".$v['operation']."]]></cell>";
	$xml .= "<cell><![CDATA[".$v['channel_name']."]]></cell>";
	$xml .= "<cell><![CDATA[".$v['channel_style']."]]></cell>";
	$xml .= "<cell><![CDATA[".$v['gc_name']."]]></cell>";
	$xml .= "<cell><![CDATA[".$v['channel_show']."]]></cell>";
	$xml .= "</row>";
	}

$xml .= "</rows>";
echo $xml;
		}

public static function flexigridXMLfloor($flexigridXML){
	$page = $flexigridXML['now_page'];
	$total = $flexigridXML['total_num'];

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: text/xml");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<rows>";
$xml .= "<page>$page</page>";
$xml .= "<total>$total</total>";
foreach ($flexigridXML['list'] as $k => $v){
	$xml .= "<row id='".$k."'>";
	$xml .= "<cell><![CDATA[".$v['operation']."]]></cell>";
	$xml .= "<cell><![CDATA[".$v['web_name']."]]></cell>";
	$xml .= "<cell><![CDATA[".$v['web_page']."]]></cell>";
	$xml .= "<cell><![CDATA[".$v['update_time']."]]></cell>";
	$xml .= "<cell><![CDATA[".$v['web_show']."]]></cell>";
	$xml .= "</row>";
	}

$xml .= "</rows>";
echo $xml;
		}

	public static function flexigroupbuyXML($flexigridXML){
	$page = $flexigridXML['now_page'];
	$total = $flexigridXML['total_num'];
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: text/xml");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<rows>";
$xml .= "<page>$page</page>";
$xml .= "<total>$total</total>";
if(empty($flexigridXML['list'])){
	$xml .= "<row id=''>";
	$xml .= "<cell></cell>";
	$xml .= "</row>";
	}else{
	foreach ($flexigridXML['list'] as $k => $v){
		$xml .= "<row id='".$k."'>";
		$xml .= "<cell><![CDATA[".'--'."]]></cell>";
       foreach ($v as $kk => $vv){
			$xml .= "<cell><![CDATA[".$v[$kk]."]]></cell>";
			}
	$xml .= "</row>";
	}
}
$xml .= "</rows>";
echo $xml;
		}



}
