<?php
// +----------------------------------------------------------------------
// | Name: 公共函数
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');


//三水整理属性函数
 
function channels(){
	$channel_list=M('article_class')->where(array('isdel'=>0,'status'=>1,'pid'=>0,'cate'=>1))->order('rank asc')->select();
//	var_Dump($channel_list);exit;
	if(!empty($channel_list)){
		foreach($channel_list as $key=>$list){
			$son_channel=M('article_class')->where(array('isdel'=>0,'status'=>1,'pid'=>$list['id']))->order('rank asc')->select();
			$channel_list[$key]['son_channel']=$son_channel;
		}
	}
	return $channel_list;
}

//获取资讯栏目导航合集
function channel(){
	$channel_list=M('article_class')->where(array('isdel'=>0,'status'=>1,'pid'=>0,'cate'=>2))->order('rank asc')->select();
	if(!empty($channel_list)){
		foreach($channel_list as $key=>$list){
			$son_channel=M('article_class')->where(array('isdel'=>0,'status'=>1,'pid'=>$list['id']))->order('rank asc')->select();
			$channel_list[$key]['son_channel']=$son_channel;
		}
	}
	return $channel_list;
}




if (!function_exists('isMobile')) 
{
    /**
     * 判断当前访问的用户是  PC端  还是 手机端  返回true 为手机端  false 为PC 端
     * 是否移动端访问
     *
     * @return boolean
     */
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
}

if (!function_exists('isWeixin')) 
{
    /**
     * 是否微信端访问
     *
     * @return boolean
     */
    function isWeixin() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } return false;
    }
}

//截取字符串,带中文,多余的省略号代替
function subtext($text, $length)
{
    if(mb_strlen($text, 'utf8') > $length) {
        return mb_substr($text, 0, $length, 'utf8').'...';
    } else {
        return $text;
    } 
}

//获取广告位信息
function getAdinfoList($pid,$num='99'){ 
	$result_ads=array();
	//var_dump($pid);exit;
	//$ad_position = M('ad_position')->where(array('id'=>$pid,'status'=>1))->find(); 
		$ad_position = M('ad_position')->where(array('status'=>1))->select();
	//var_dump($ad_position);exit;
	if(!empty($ad_position)){
	   
	      
		$data['status'] = 1;
		$result_ads = M('ad_info')->where($data)->order('rank asc')->limit($num)->select();
		if(!empty($result_ads)&&isMobile()){
			foreach($result_ads as $key=>$item){
				if(!empty($item['wappic'])){
					$result_ads[$key]['pic']=$item['wappic'];
				}
			}
		}  
	    
	 
	}
	//var_dump($result_ads);exit;
	return $result_ads;
}

//获取友情链接
function getLinksList($links_class){ 
	$links_list=array();
	$links_list = M('links_list')->where(array('status'=>1,'links_class'=>$links_class))->order('rank asc')->limit(99)->select();  
	return $links_list;
}

//审核状态
function getReview($name='',$val=''){
	$result = M('attribute')->where('status=1 and code="'.$name.'" and value="'.$val.'"')->find();
	if($val==1){
		$msg = "<span class='yes'><i class='fa fa-check-circle'></i> ".$result['title']." </span>"; 
	}else{
		$msg = "<span class='no'><i class='fa fa-ban'></i> ".$result['title']." </span>"; 
	}  
	return $msg;
}


//单选框 属性 
function getNotRadio($name='',$val=''){
	$result = M('attribute')->where('status=1 and code="'.$name.'"')->order('rank asc')->select();
	foreach ($result as $k => $v) {
		if($v["value"]==$val){
			$msg .="<input type='".radio."' lay-skin='primary' title='".$v["title"]."' checked name='".$name."' value='".$v["value"]."' lay-filter='".$name."'/>";
		}else{
			$msg .="<input type='".radio."' lay-skin='primary' title='".$v["title"]."' name='".$name."' value='".$v["value"]."' lay-filter='".$name."'/>";
		}
	}
	return $msg;
}


//下拉框 属性
function getNotSelectoff($name,$val=''){
	$info= M('office_list')->where('status=1 and value="'.$name.'"')->find();
	$result = M('office_list')->where('status=1')->order('rank asc')->select();
	$msg .='<select name="'.$name.'" id="'.$name.'" lay-verify="'.$name.'" lay-filter="'.$name.'" lay-search>';
	$msg .='<option value="">请选择'.$info['title'].'</option>'; 
	foreach ($result as $k => $v) {
		if($v["id"]==$val){
			$msg .="<option value='".$v["id"]."' selected >".$v["title"]."</option>";
		}else{
			$msg .="<option value='".$v["id"]."'>".$v["title"]."</option>";
		}
	}
	$msg .='</select>';
	return $msg;
}


//下拉框 属性
function getMemberSelects($name='',$val=''){
  
	$info= M('member')->where('isorgan=1  and id="'.$val.'"')->find();
	$result = M('member')->where('isorgan=1 and isreview=1')->order('id asc')->select();
	  //var_Dump($result);exit;
	$msg .='<select name="'.'manage'.$name.'" id="'.$name.'" lay-verify="'.$name.'" lay-filter="'.$name.'" lay-search>';
	$msg .='<option value="">请选择'.'管理人员'.'</option>'; 

	foreach ($result as $k => $v) {
		if($v["id"]==$val){
			$msg .="<option value='".$v["id"]."' selected >".$v["truename"]."</option>";
		}else{
			$msg .="<option value='".$v["id"]."'>".$v["truename"]."</option>";
		}
	}
	$msg .='</select>';
	return $msg;
}
//下拉框 属性
function getMemberSelect($name='',$val=''){
	$info= M('member')->where('isorgan=1 and id="'.$val.'"')->find();
	$result = M('member')->where('isorgan=1')->order('id asc')->select();
	$msg .='<select name="'.$name.'" id="'.$name.'" lay-verify="'.$name.'" lay-filter="'.$name.'" lay-search>';
	$msg .='<option value="">请选择'.'管理人员'.'</option>'; 
	foreach ($result as $k => $v) {
		if($v["id"]==$val){
			$msg .="<option value='".$v["id"]."' selected >".$v["truename"]."</option>";
		}else{
			$msg .="<option value='".$v["id"]."'>".$v["truename"]."</option>";
		}
	}
	$msg .='</select>';
	return $msg;
}
//下拉框 属性
function getNotSelect($name='',$val=''){
	$info= M('attribute')->where('status=1 and value="'.$name.'"')->find();
	$result = M('attribute')->where('status=1 and code="'.$name.'"')->order('rank asc')->select();
	$msg .='<select name="'.$name.'" id="'.$name.'" lay-verify="'.$name.'" lay-filter="'.$name.'" lay-search>';
	$msg .='<option value="">请选择'.$info['title'].'</option>'; 
	foreach ($result as $k => $v) {
		if($v["value"]==$val){
			$msg .="<option value='".$v["value"]."' selected >".$v["title"]."</option>";
		}else{
			$msg .="<option value='".$v["value"]."'>".$v["title"]."</option>";
		}
	}
	$msg .='</select>';
	return $msg;
}
function getNotSelectq($name='',$val=''){
	$info= M('attribute')->where('status=1 and value="'.$name.'"')->find();
	$result = M('attribute')->where('status=1 and code="'.$name.'"')->order('rank asc')->select();
	$msg .='<select name="'.$name.'" id="'.$name.'" lay-verify="'.$name.'" lay-filter="'.$name.'" class="input" lay-search> ';
	$msg .='<option value="">请选择'.$info['title'].'</option>'; 
	foreach ($result as $k => $v) {
		if($v["value"]==$val){
			$msg .="<option value='".$v["value"]."' selected >".$v["title"]."</option>";
		}else{
			$msg .="<option value='".$v["value"]."'>".$v["title"]."</option>";
		}
	}
	$msg .='</select>';
	return $msg;
}

//发送邮件
function sendMail($to_email, $paras) {
    $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    if (!preg_match($pattern, $to_email)) {
        return "".$to_email."邮箱格式有误";
    }
    $title = $paras['title']; 
    $body = $paras['body'];
    $from = C("email_id");
    require_once(HX_CORE.'/../data/ext/phpmailer/class.phpmailer.php');  	
    $mail = new PHPMailer(); //PHPMailer对象
    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();  // 设定使用SMTP服务
    $mail->SMTPDebug = 0;                     // 关闭SMTP调试功能
    $mail->SMTPAuth = true;                  // 启用 SMTP 验证功能
    $mail->SMTPSecure = '';                 // 使用安全协议
    $mail->Host = C("email_host");  // SMTP 服务器
    $mail->Port = C("email_port");  // SMTP服务器的端口号
    $mail->Username = C("email_addr");  // SMTP服务器用户名
    $mail->Password = C("email_pass");  // SMTP服务器密码
    $mail->Subject = $title; //邮件标题
    $mail->SetFrom(C("email_addr"), $from);
    $mail->MsgHTML($body);
    $mail->AddAddress($to_email, $from);
    $result = $mail->Send() ? '200' : $mail->ErrorInfo;
    return $result;
}


//ajax错误返回信息  统一json输出 
function output_data($datas, $extend_data = array(), $error = false,$message='请求成功') {
    $data = array();
    $data['code'] = 200;
    if($error) {
        $data['code'] = 400;
    }

    if(!empty($extend_data)) {
        $data = array_merge($data, $extend_data);
    }

    $data['datas'] = $datas;
	$data['message'] = $message;

    $jsonFlag = 0 && C('debug') && version_compare(PHP_VERSION, '5.4.0') >= 0
        ? JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        : 0;

    if ($jsonFlag) {
        header('Content-type: text/plain; charset=utf-8');
    }
	
	header('Content-type: application/json');
    if (!empty($_GET['callback'])) {
        echo $_GET['callback'].'('.json_encode($data, $jsonFlag).')';die;
    } else {
        header("Access-Control-Allow-Origin:*");
        header('Content-type: application/json');
        echo json_encode($data, $jsonFlag);die;
    }
}

function output_error($message, $extend_data = array()) {
    $datas = array('error' => $message);
    output_data($datas, $extend_data, true,$message);
}

//三水整理属性函数

//获取底部菜单
function footermenu(){
	$menu_lists =array();
	$condition['pid']=0;
	$condition['status']=1;
	$menu_lists = M('menu_list')->where($condition)->order('rank asc')->select();
	return $menu_lists;
}

//前端分类无限级获取id合集
function puttreestatus($pid=0,$model='article_class',$selected=0){
	$rs = gettreestatus($pid,$model);
	if(!empty($pid)){
		$str=$pid; 
	}else{
		$str='';
	}
	foreach($rs as $key=>$val){
		if(!empty($str)){
			$str .= ','.$val['id'];
		}else{
			$str .= $val['id'];
		}
	} 
	return $str;
} 
function gettreestatus($pid=0,$model,$result=array(),$spac=0){
	$spac = $spac+2;
	$row = Db::getAll("SELECT * FROM ".DBPRE."".$model." where pid=$pid and status=1 and isdel=0 ORDER by rank asc ");
	if(!empty($row)){
		foreach($row as $v){
			$result[] = $v;
			gettreestatus($v['id'],$result,$spac);
		}
	} 
	return $result;
}

//后端分类无限级获取id合集
function puttrees($pid=0,$model='article_class',$selected=0){
	$rs = gettrees($pid,$model);
	if(!empty($pid)){
		$str=$pid; 
	}else{
		$str='';
	}
	foreach($rs as $key=>$val){
		if(!empty($str)){
			$str .= ','.$val['id'];
		}else{
			$str .= $val['id'];
		}
	} 
	return $str;
} 
function gettrees($pid=0,$model,$result=array(),$spac=0){
	$spac = $spac+2;
	$row = Db::getAll("SELECT * FROM ".DBPRE."".$model." where pid=$pid and isdel=0 ORDER by rank asc ");
	if(!empty($row)){
		foreach($row as $v){
			$result[] = $v;
			gettrees($v['id'],$result,$spac);
		}
	} 
	return $result;
}

//微信获取信息转换JSON使用
function getJson($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return json_decode($output, true);
}

/** 
 * 创建(导入)Excel数据表格  
 * @param  string  $filenameurl  导入的Excel表格数据表的路径 
 */  
function excelToArray($filenameurl,$dates=array('E')){   
	require_once(HX_CORE.'/../data/ext/PHPExcel/PHPExcel/IOFactory.php');  	
	
	//加载excel文件   
	$filename = HX_ROOT.$filenameurl;  
	$objPHPExcelReader = PHPExcel_IOFactory::load($filename);    
  
	$sheet = $objPHPExcelReader->getSheet(0);        // 读取第一个工作表(编号从 0 开始)  
	$highestRow = $sheet->getHighestRow();           // 取得总行数  
	$highestColumn = $sheet->getHighestColumn();     // 取得总列数  
  
	$arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');  
	// 一次读取一列  
	$res_arr = array();  
	for ($row = 2; $row <= $highestRow; $row++) {  
		$row_arr = array();  
		for ($column = 0; $arr[$column] != 'W'; $column++) {  //控制暂停列数
			
			$val = $sheet->getCellByColumnAndRow($column, $row)->getValue();
			if(!empty($dates)){
				foreach($dates as $date){
					if($arr[$column]==$date){
						$val = excelTime($val);
					}
				}
			}
			$row_arr[] = $val;  
		}  
		  
		$res_arr[] = $row_arr;  
	}  
	  
	return $res_arr;  
} 
//读取excel中的时间转换问题
function excelTime($date, $time = false) {
	//如果是数字则转化，如果是有 - 或者 /，视作文本格式不作处理
	$type1 = strpos($date, '/');
	$type2 = strpos($date, '-');
	if($type1 || $type2){
		$return_date = $date;
	}else{
		$return_date=date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($date));
	}
	return $return_date;
}


//由身份证号得到身份信息
function getidcardinfo($sfzh){


$info["birthYear"]=substr($sfzh, 6, 4);
$info["birthMonth"]=substr($sfzh, 10, 2);
$info["birthDay"]=substr($sfzh, 12, 2);
$info["csrq"]=$info["birthYear"]."-".$info["birthMonth"]."-".$info["birthDay"] ;
$info["csrq2"]=$info["birthYear"]."年".$info["birthMonth"]."月".$info["birthDay"] ."日";

     $date=strtotime(substr($sfzh,6,8));
//获得出生年月日的时间戳
        $today=strtotime('today');
//获得今日的时间戳
        $diff=floor(($today-$date)/86400/365);
//得到两个日期相差的大体年数

//strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
        $age=strtotime(substr($sfzh,6,8).' +'.$diff.'years')>$today?($diff+1):$diff;

//$info["age"]=date('Y')-$info["birthYear"];
$info["age"]=$age;

$info["xb"] = substr($sfzh,16, 1) % 2 ? '1' : '0';
$info["xbname"] = substr($sfzh,16, 1) % 2 ? '男' : '女';

	return $info;
}

//获取权限
function isGmenu($power,$a,$b,$c){
	
	$power=$power[$a];
	$power=$power[$b];
	$power=$power[$c];
	
	return $power;
}

//获表会员信息微信小程序专用
function getTableInfowxapp($openid='',$table='member'){

	$param = array();
	$param['table'] = $table;
	$param['field'] = 'weixin_unionid';
	$param['value'] = $openid; 
	$result = Db::getRow($param);
	return $result; 
}


//充值金额与积分兑换
function getMoneyRatio($money){
	$bili=C("ratio")/100;
	return $money*$bili;
}

//金额格式化
function getMoneyGsh($money){
	if($money>=1000&&$money<10000){
		return $money/1000 .'K';
	}else if($money>=10000){
		return $money/10000 .'W';
	}else{
		return $money;
	}
}

//xml转json
function xmlToArray($simpleXmlElement){
	$simpleXmlElement=(array)$simpleXmlElement;
	foreach($simpleXmlElement as $k=>$v){
		if($v instanceof SimpleXMLElement ||is_array($v)){
			$simpleXmlElement[$k]=xmlToArray($v);
		}
	}
	return $simpleXmlElement;
} 
function xml2json($xml){
	$url = $xml; 
	$contentxml = simplexml_load_file($url);
	$xml_array=xmlToArray($contentxml);
	$xml_array=$xml_array['row'];
	 
	return $xml_array;
	 
}
//自定义xml转json 
function xml2jsonzdy($xml){
	$url = $xml; 
	$contentxml = simplexml_load_file($url);
	$xml_array=xmlToArray($contentxml);
	 
	return $xml_array;
	 
}




// 日志添加
function worklog($type='',$typeid='',$content=''){

	$param['type'] = $type;
	$param['typeid'] = $typeid;
	$param['content'] = $content;
	$param['take_per'] = '管理员';
	$param['addtime'] = time();
	$result = M('work_log')->insert($param);
	
}

function getAttribute($code=''){

	 if (!$code) return ""; 

		$result = M("attribute")->where("status=1 and code='$code'")->order('rank asc')->select();
		
		//print_r($result);
		
		return $result;
}
 

//下拉框 没有默认值
function getAttShow($code='',$type=1,$val='',$on=''){

	 if (!$code) return "";

	$result = getAttribute($code);

	// print_r($result);


	 $msg="<SELECT name='".$code."' id='".$code."' $on >";
	 $msg.="<OPTION   value='' >请选择</OPTION>";
			foreach ($result as $k => $rs) {
				$select="";
				if($rs["value"]==$val){
					$select="selected";
				}
				$msg.="<OPTION    value='".$rs["value"]."' $select >".$rs["title"]."</OPTION>";
			}

		$msg.="</SELECT>";

		return $msg;
}

//下拉框，有默认值，为第一个
function getAttShowx($code='',$type=1,$val='',$on=''){

	 if (!$code) return "";

	$result = getAttribute($code);

	 $msg="<SELECT name='".$code."' id='".$code."' $on >";
			foreach ($result as $k => $rs) {
				$select="";
				if($rs["value"]==$val){
					$select="selected";
				}
				$msg.="<OPTION    value='".$rs["value"]."' $select >".$rs["title"]."</OPTION>";
			}

		$msg.="</SELECT>";

		return $msg;
}

// 多选框 非属性
function getNotCheckbox($table='',$name='',$val=''){

	$result = M($table)->where('status=1')->select();

	if(!empty($val)){

		$vals=explode(',',$val);
		foreach ($result as $k => $v) {

			if(in_array($v["id"],$vals)){
				$msg .="<input type='".checkbox."' lay-skin='primary' title='".$v["title"]."' checked name='".$name."[]' value='".$v["id"]."'/>";
			}else{
				$msg .="<input type='".checkbox."' lay-skin='primary' title='".$v["title"]."' name='".$name."[]' value='".$v["id"]."'/>";
			}
		}
	}else{

		foreach ($result as $k => $v) {
			$msg .="<input type='".checkbox."' lay-skin='primary' title='".$v["title"]."' name='".$name."[]' value='".$v["id"]."'/>";
		}

	}
	return $msg;
}

// 多选框 属性
function getAttCheckbox($code='',$type=1,$val=''){

	if (!$code) return "";

	$result = getAttribute($code);

	if(!empty($val)){
		$vals=explode(',',$val);
		foreach ($result as $k => $rs) {

			if(in_array($rs["value"],$vals)){

				$msg .="<input type='".checkbox."' lay-skin='primary' title='".$rs["title"]."' checked name='".$code."[]'value='".$rs["value"]."'/>";
			}else{
				$msg .="<input type='".checkbox."' lay-skin='primary' title='".$rs["title"]."' name='".$code."[]'value='".$rs["value"]."'/>";
			}
		}
	}else{

		foreach ($result as $k => $rs) {

				$msg .="<input type='".checkbox."' lay-skin='primary' title='".$rs["title"]."' name='".$code."[]'value='".$rs["value"]."'/>";
		}

	}
		return $msg;
}


//select下拉
function getselect($table='',$name='',$id='',$type=0,$on=''){

	 if (!$table) return "";

	 $msg="<SELECT name='".$name."' lay-filter='".$name."' id='".$name."' $on >";
	 if($type) $msg.="<OPTION   value='' >请选择</OPTION>";

			$result = M($table)->order("id desc")->select();
			foreach ($result as $k => $rs) {
				$select="";
				if($rs["id"]==$id){
					$select="selected";
				}
				$msg.="<OPTION    value='".$rs["id"]."' $select >".$rs["title"]."</OPTION>";
			}

		$msg.="</SELECT>";

		return $msg;
}

//属性管理select下拉
function getselectsx($table='',$name='',$id='',$type=0,$on=''){

	 if (!$table) return "";

	 $msg="<SELECT name='".$name."' id='".$name."' $on >";
	 if($type) $msg.="<OPTION   value='' >请选择</OPTION>";

			$result = M($table)->order("id desc")->limit('10000')->select();

			foreach ($result as $k => $rs) {
				$select="";
				if($rs["id"]==$id){
					$select="selected";
				}
				$msg.="<OPTION    value='".$rs["id"]."' $select >".$rs["title"]."</OPTION>";
			}

		$msg.="</SELECT>";

		return $msg;
}

//有父id限制条件的select下拉
function getselectksgl($table='',$name='',$id='',$proid=''){

	 if (!$table) return "";

	 $msg="<SELECT name='".$name."' id='".$name."'>";

			$result = M($table)->order("id desc")->where('pid='.$proid)->limit('10000')->select();

			foreach ($result as $k => $rs) {
				$select="";
				if($rs["id"]==$id){
					$select="selected";
				}
				$msg.="<OPTION    value='".$rs["id"]."' $select >".$rs["title"]."</OPTION>";
			}

		$msg.="</SELECT>";

		return $msg;
}


// 根据value值获取title值
function getSinglePas($table='attribute',$code='',$value='',$title=''){

	if (!$code) return "";
	$param = array();
	$param['code'] = $code;
	$param['value'] = $value;
	$result = M($table)->where($param)->select();

	return $result['0'][$title];
}

// value有多个时，根据逗号切开
function getSinglePasmore($table='attribute',$code='',$value='',$title=''){

	if (!$code) return "";
	$param = array();
	$param['code'] = $code;

	$valueone = explode(',',$value);

	$string = "";

	foreach ($valueone as $k => $v) {

		$param['value'] = $v;

		$result = M($table)->where($param)->select();

		$string.= ' <a class="">'.$result['0'][$title]."</a> ";

	}
	return $string;
}

// value有多个时，根据逗号切开  非属性
function getvaluemore($table='',$value='', $title='title'){

	$valueone = explode(',',$value);

	$string = "";

	foreach ($valueone as $k => $v) {

		$param['id']  = $v;

		$result = M($table)->where($param)->select();

		$string.= ' <a class="">'.$result['0'][$title]."</a> ";

	}
	
	return $string;
}

/**
 * 获取图片地址
 */
function getImageUrl($image_name = '',$width = '240') {
    $image_path = $image_name;
    if($image_path) {
        return $image_path;
    } else {
        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($width);
    }
}

function getImageUrlAdmin($image_name = '',$width = '240') {
    $image_path = $image_name;
    if($image_path) {
        return UPLOAD_SITE_URL.'/'.ATTACH_ADMIN_AVATAR.'/'.$image_path;
    } else {
        return ADMIN_TEMPLATES_URL.'//images/login/admin.png';
    }
}



/**
 * 获取地址
 */
function getUrl($name) {

       // return rtrim($name, "Control");
       return substr($name, 0, -7);
}


/**
 * 返回密码
 */
function getPwd($password) {
		global $cfg;

	   return md5(md5($password).$cfg['salt']);
} 


//父级id返回整个子集
function getParentIds($table="article_class",$id=0){
	$data['pid'] = $id;
	$data['status'] = 1;
	$result = M($table)->where($data)->order('rank asc')->select();
	$ids=$id;
	foreach($result as $r){
		$ids.=','.$r['id'];
	}
	return $ids;
}

/**
 * 检查验证码
 */
function checkCode($mobile='',$code='') {

		if(!$mobile || !$code)  return false;

		$rs = M('code')->where("mobile='".$mobile."' and code='".$code."'")->field("addtime")->order('addtime desc')->find();

		if(!$rs['addtime']) return false;


		$times=time()-$rs["addtime"];


		if($times>300){//大于5分钟
			return false;
		}


	   return true;
}


/**
	is_telephone($telephone='')  $telephone 手机号
	功能：验证是否是手机号
*/
function is_telephone($telephone='')
{
	$telephone=trim($telephone);

	if(!$telephone)
	{
		return false;
	}

	return preg_match('/^1[3456789]{1}\d{9}$/i',$telephone);
}


//手机号中间四位用星号*代替显示
function getPhoneStar($phone){
	$phone = preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2', $phone);
	return $phone;
}

//过滤保留用户名
function getUNname($username){
	$unusername=array('admin','123456','manage','agent','fhjgw','jgw','金刚网','凤凰金刚网');

	if(in_array($username,$unusername)){

		return true;
	}


	return false;
}


//返回模板列表
function getMoban(){
	return array('about'=>'关于我们','contact'=>'联系我们','job'=>'招聘模块','faq'=>'常见问题模块','page'=>'单页模块');
}



//返回数组
function getval($table='',$code='id',$key='title',$condition='1'){

	$val  = array();

	$result = M($table)->field('id,'.$key)->where($condition)->order("rank desc, id asc")->select();

	foreach ($result as $k => $rs) {

	  $val[$rs[$code]]=$rs[$key];

	}


	return $val;

}


//返回列表数组
function getlistval($table='',$code='id',$key='title',$condition='1'){

	$val  = array();

	$result = M($table)->field('id,'.$key)->where($condition)->order("edittime desc, id asc")->select();

	foreach ($result as $k => $rs) {

	  $val[$rs[$code]]=$rs[$key];

	}


	return $val;

}


//清除过滤html标签
function clearHtmlText($str)
{
	$search = array(" ","　","\n","\r","\t");
	$replace = array("","","","","");
	$str = preg_replace( "@<script(.*?)</script>@is", "", $str );
	$str = preg_replace( "@<iframe(.*?)</iframe>@is", "", $str );
	$str = preg_replace( "@<style(.*?)</style>@is", "", $str );
	$str = preg_replace( "@<(.*?)>@is", "", $str );
	$str= htmlspecialchars_decode($str);
	$str= preg_replace("/<(.*?)>/","",$str);
	$str = str_replace("　"," ",$str);
	$str = htmlspecialchars($str);
	$str = strip_tags($str);
	$str = str_replace($search, $replace, $str);
	return stripslashes($str);
}



//获公司信息Id
function getComId(){

	return "1";

}

//获公司信息
function getComInfo($id=0){

	
	$param = array();
	$param['table'] = 'company';
	$param['field'] = 'id';
	$param['value'] = intval($id);
	$result = Db::getRow($param);
	return $result;

}

function getTableInfo($id=0,$table='article'){

	$param = array();
	$param['table'] = $table;
	$param['field'] = 'id';
	$param['value'] = intval($id); 
	$result = Db::getRow($param);
	return $result;

}

function getTableInfoName($id=0,$table='article',$name){

	
	$param = array();
	$param['table'] = $table;
	$param['field'] = 'id';
	$param['value'] = intval($id);
	$result = Db::getRow($param);
	return $result[$name];

}

function getAdminTableInfoName($id=0,$table='admin',$name){

	
	$param = array();
	$param['table'] = $table;
	$param['field'] = 'admin_id';
	$param['value'] = intval($id);
	$result = Db::getRow($param);
	return $result[$name];

}


//获表单条信息
function getTableInfohanett($id=0,$table='article'){

	$param = array();
	$param['table'] = $table;
	$param['field'] = 'id';
	$param['value'] = intval($id); 
	$result = Db::getRow($param);
	return $result;

}



//获表单条信息某个字段值
function getTableInfohanettName($id=0,$table='article',$name){

	
	$param = array();
	$param['table'] = $table;
	$param['field'] = 'id';
	$param['value'] = intval($id);
	$result = Db::getRow($param);
	return $result[$name];

}


//获取部门信息
function getDeptName($id=0,$info=0){

	
	$param = array();
	$param['table'] = 'bumen';
	$param['field'] = 'id';
	$param['value'] = intval($id);
	$result = Db::getRow($param);

	if($info){
		return $result;
	}else{
		return $result["bmming"];
	}
}

//标签分词
function getParticiple($word){
	$words = explode(",", $word); 
	return $words;
}
 

/**
 * 计算几分钟前、几小时前、几天前、几月前、几年前。
 * $agoTime string Unix时间
 * @author tangxinzhuan
 * @version 2018-07-11
 */
function time_tran($agoTime)
{
    $agoTime = (int)$agoTime;
    
    // 计算出当前日期时间到之前的日期时间的毫秒数，以便进行下一步的计算
    $time = time() - $agoTime;
    
    if ($time >= 31104000) { // N年前
        $num = (int)($time / 31104000);
        return $num.'年前';
    }
    if ($time >= 2592000) { // N月前
        $num = (int)($time / 2592000);
        return $num.'月前';
    }
    if ($time >= 86400) { // N天前
        $num = (int)($time / 86400);
        return $num.'天前';
    }
    if ($time >= 3600) { // N小时前
        $num = (int)($time / 3600);
        return $num.'小时前';
    }
    if ($time > 60) { // N分钟前
        $num = (int)($time / 60);
        return $num.'分钟前';
    }
    return '1分钟前';
}



//多图上传插件 1:上传节点id 2:显示列表id 3:图片自动name 4:图片字段name值 5：是否多图
function getMorePic($upload_img='upload_img',$upload_img_list='upload_img_list',$inputname='images',$inputval='resimages',$duotu=true){
	$jiedian='<style>';
	$jiedian.='';
	$jiedian.='    #layui-layer-content{';
    $jiedian.='    overflow: scroll !important;';
    $jiedian.='    padding: 20px !important;';
    $jiedian.='}';
	$jiedian.='</style>';
	
	if($duotu==true){
		$jiedian.='<div class="layui-upload-drag"  id="'.$upload_img.'" ><i class="layui-icon"></i><p>点击上传，或将图片拖拽到此处</p></div>';
		$jiedian.='<div id="'.$upload_img_list.'" class="upload_img_list">';
		if(!empty($inputval)){
			$moreimages=explode(",",$inputval);
			foreach($moreimages as $moreimage){
				$randid=rand(1000000, 9999999);
				$jiedian.='<dd class="item_img" id="'.$randid.'">';
				$jiedian.='<div class="operate">';
				$jiedian.='<i  onclick=toleft("'.$upload_img_list.'") class="toleft layui-icon"></i>';
				$jiedian.='<i  onclick=toright("'.$upload_img_list.'") class="toright layui-icon"></i>';
				$jiedian.='<i  onclick="UPLOAD_IMG_DEL('.$randid.')" class="close layui-icon"></i>';
				$jiedian.='</div>';
				$jiedian.='<img src="'.$moreimage.'" class="img cover" onclick="previewImg(this)"> ';
				$jiedian.='<input type="hidden" name="'.$inputname.'[]" value="'.$moreimage.'" /></dd>';
			}
		} 
		$jiedian.='</div>';
	}else{
		$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div class="layui-upload-drag" capture="camera" id="'.$upload_img.'" ><i class="layui-icon"></i><p>点击上传，或将图片拖拽到此处</p></div></div>';
		$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div id="'.$upload_img_list.'" class="upload_img_list">';
		if(!empty($inputval)){
			$moreimages=explode(",",$inputval);
			foreach($moreimages as $moreimage){
				$randid=rand(1000000, 9999999);
				$jiedian.='<dd class="item_img" id="'.$randid.'">';
				$jiedian.='<div class="operate">'; 
				$jiedian.='<i  onclick="UPLOAD_IMG_DEL('.$randid.')" class="close layui-icon"></i>';
				$jiedian.='</div>';
				$jiedian.='<img src="'.$moreimage.'" class="img cover"  onclick="previewImg(this)" > ';
				$jiedian.='<input type="hidden" name="'.$inputname.'" value="'.$moreimage.'" /></dd>';
			}
		} 
		$jiedian.='</div></div>';
	}
	
	$jiedian.='<link rel="stylesheet" type="text/css" href="'.EXT_URL.'/layui_morepic/style.css" /> ';
	$jiedian.='<script type="text/javascript" src="'.EXT_URL.'/layui_morepic/upload.js"></script>';
	$jiedian.='<script>';
		$jiedian.='var upurl="'.EXT_URL.'/layui_morepic/upload.php";';
		$jiedian.="layui_upimg('".$upload_img."','".$upload_img_list."','".$inputname."',upurl,".$duotu.");";
	$jiedian.='</script>'; 
	
	return $jiedian;
}

function getMorePicsingle($upload_img='upload_img',$upload_img_list='upload_img_list',$inputname='images',$inputval='resimages',$duotu=true){
	$jiedian='';
	
	$jiedian.='<div class=" layui-col-xs4 layui-col-sm4 layui-col-md4"><div class="layui-upload-drag" id="'.$upload_img.'" ><i class="layui-icon"></i><p>点击上传，或将图片拖拽到此处</p></div></div>';
	$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div id="'.$upload_img_list.'" class="upload_img_list">';
	if(!empty($inputval)){
		$moreimages=explode(",",$inputval);
		foreach($moreimages as $moreimage){
			$randid=rand(1000000, 9999999);
			$jiedian.='<div class="item_img" style="width:160px;position: relative;border:1px solid #ccc;" id="'.$randid.'">';
			$jiedian.='<div class="operate">'; 
			$jiedian.='<i  onclick="UPLOAD_IMG_DEL('.$randid.')" class="close layui-icon"></i>';
			$jiedian.='</div>';
			$jiedian.='<img src="'.$moreimage.'" class="img"  width="140"> ';
			$jiedian.='<input type="hidden" name="'.$inputname.'" value="'.$moreimage.'" /></div>';
		}
	} 
	$jiedian.='</div></div>'; 
	
	$jiedian.='<link rel="stylesheet" type="text/css" href="'.EXT_URL.'/layui_morepic/style.css" /> ';
	$jiedian.='<script type="text/javascript" src="'.EXT_URL.'/layui_morepic/upload.js"></script>';
	$jiedian.='<script>';
		$jiedian.='var upurl="'.EXT_URL.'/layui_morepic/upload.php";';
		$jiedian.="layui_upimg('".$upload_img."','".$upload_img_list."','".$inputname."',upurl,".$duotu.");";
	$jiedian.='</script>'; 
	
	return $jiedian;
}


//附件上传插件 1:上传节点id 2:显示列表id 3:图片自动name 4:图片字段name值 5:文件后缀名称 6:文件后缀值 7:文件大小 8:文件缀值
function getMoreattachment($upload_img='upload_img',$upload_img_list='upload_img_list',$inputname='images',$inputval='resimages',$modelname='model',$modelval='zip',$sizename='size',$sizeval='0'){
	$jiedian='';
	$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div class="layui-upload-drag" id="'.$upload_img.'" ><i class="layui-icon"></i><p>点击上传，或将文件拖拽到此处</p></div></div>';
	$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div id="'.$upload_img_list.'" class="aupload_img_list">';
	if(!empty($inputval)){
		$randid=rand(1000000, 9999999);
		$jiedian.='<dd class="item_img" id="'.$randid.'">';
		$jiedian.='<div class="operate">'; 
		$jiedian.='<i  onclick="UPLOAD_IMG_DEL('.$randid.')" class="close layui-icon"></i>';
		$jiedian.='</div>';
		$jiedian.='<img src="'.EXT_URL.'/layui_attachment/attachment.jpg" class="img" > ';
		$jiedian.='<input type="hidden" name="'.$inputname.'" value="'.$inputval.'" lay-verify="required|'.$upload_img.'"/>';
		$jiedian.='<input type="hidden" name="'.$modelname.'" value="'.$modelval.'" />';
		$jiedian.='<input type="hidden" name="'.$sizename.'" value="'.$sizeval.'" /></dd>';
	} 
	$jiedian.='</div></div>';
	$jiedian.='<link rel="stylesheet" type="text/css" href="'.EXT_URL.'/layui_attachment/astyle.css" /> ';
	$jiedian.='<script type="text/javascript" src="'.EXT_URL.'/layui_attachment/aupload.js"></script>';
	$jiedian.='<script>';
		$jiedian.='var upurl="'.EXT_URL.'/layui_attachment/aupload.php";';
		$jiedian.="layui_upattachment('".$upload_img."','".$upload_img_list."','".$inputname."',upurl,'".EXT_URL."/layui_attachment/attachment.jpg','".$modelname."','".$sizename."');";
	$jiedian.='</script>'; 
	
	return $jiedian;
}




//视频上传插件 1:上传节点id 2:显示列表id 3:视频自动name 4:视频字段name值 5:文件后缀名称 6:文件后缀值 7:文件大小 8:文件缀值
function getMorevideo($upload_img='upload_img',$upload_img_list='upload_img_list',$inputname='images',$inputval='resimages',$modelname='model',$modelval='zip',$sizename='size',$sizeval='0'){
	$jiedian='';
	$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div class="layui-upload-drag" id="'.$upload_img.'" ><i class="layui-icon"></i><p>点击上传，或将视频文件拖拽到此处</p></div></div>';
	$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div id="'.$upload_img_list.'" class="aupload_img_list">';
	if(!empty($inputval)){
		$randid=rand(1000000, 9999999);
		$jiedian.='<dd class="item_img" id="'.$randid.'">';
		$jiedian.='<div class="operate">'; 
		$jiedian.='<i  onclick="UPLOAD_IMG_DEL('.$randid.')" class="close layui-icon"></i>';
		$jiedian.='</div>';
		$jiedian.='<img src="'.EXT_URL.'/layui_video/video.jpg" class="img" > ';
		
		$jiedian.='<input type="hidden" name="'.$inputname.'" value="'.$inputval.'" />';
		$jiedian.='<input type="hidden" name="'.$modelname.'" value="'.$modelval.'" />';
		$jiedian.='<input type="hidden" name="'.$sizename.'" value="'.$sizeval.'" /></dd>';
	} 
	$jiedian.='</div></div>';
	$jiedian.='<link rel="stylesheet" type="text/css" href="'.EXT_URL.'/layui_video/vstyle.css" /> ';
	$jiedian.='<script type="text/javascript" src="'.EXT_URL.'/layui_video/vupload.js"></script>';
	$jiedian.='<script>';
		$jiedian.='var upurl="'.EXT_URL.'/layui_video/vupload.php";';
		$jiedian.="layui_upvideo('".$upload_img."','".$upload_img_list."','".$inputname."',upurl,'".EXT_URL."/layui_video/video.jpg','".$modelname."','".$sizename."');";
	$jiedian.='</script>'; 
	
	return $jiedian;
}



//音频上传插件 1:上传节点id 2:显示列表id 3:视频自动name 4:视频字段name值 5:文件后缀名称 6:文件后缀值 7:文件大小 8:文件缀值
function getMoreaudio($upload_img='upload_img',$upload_img_list='upload_img_list',$inputname='images',$inputval='resimages',$modelname='model',$modelval='zip',$sizename='size',$sizeval='0'){
	$jiedian='';
	$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div class="layui-upload-drag" id="'.$upload_img.'" ><i class="layui-icon"></i><p>点击上传，或将音频文件拖拽到此处</p></div></div>';
	$jiedian.='<div class=" layui-col-xs6 layui-col-sm6 layui-col-md6"><div id="'.$upload_img_list.'" class="aupload_img_list">';
	if(!empty($inputval)){
		$randid=rand(1000000, 9999999);
		$jiedian.='<dd class="item_img" id="'.$randid.'">';
		$jiedian.='<div class="operate">'; 
		$jiedian.='<i  onclick="UPLOAD_AUDIO_DEL('.$randid.')" class="close layui-icon"></i>';
		$jiedian.='</div>';
		$jiedian.='<img src="'.EXT_URL.'/layui_audio/audio.jpg" class="img" > ';
		$jiedian.='<input type="hidden" name="'.$inputname.'" value="'.$inputval.'" />';
		$jiedian.='<input type="hidden" name="'.$modelname.'" value="'.$modelval.'" />';
		$jiedian.='<input type="hidden" name="'.$sizename.'" value="'.$sizeval.'" /></dd>';
	} 
	$jiedian.='</div></div>';
	$jiedian.='<link rel="stylesheet" type="text/css" href="'.EXT_URL.'/layui_audio/vstyle.css" /> ';
	$jiedian.='<script type="text/javascript" src="'.EXT_URL.'/layui_audio/aupload.js"></script>';
	$jiedian.='<script>';
		$jiedian.='var upurl="'.EXT_URL.'/layui_audio/aupload.php";';
		$jiedian.="layui_upaudio('".$upload_img."','".$upload_img_list."','".$inputname."',upurl,'".EXT_URL."/layui_audio/audio.jpg','".$modelname."','".$sizename."');";
	$jiedian.='</script>'; 
	
	return $jiedian;
}




//获取列表 1、表名 2、父id 3、数量 4、层级 
function getRandListCenshu($table,$pid,$limit,$censhu){
	
	$conditioncom['pid']=$pid;
	$conditioncom['status']=1;
	$conditioncom['censhu']=$censhu;
	$page_list = M($table)->where($conditioncom)->limit("0,".$limit)->select();
	return $page_list;
}



//获取列表 1、表名 2、父id 3、数量
function getRandList($table,$pid,$limit){
	
	$conditioncom['pid']=$pid;
	$conditioncom['status']=1;
	$page_list = M($table)->where($conditioncom)->limit("0,".$limit)->select();
	return $page_list;
}



//获取列表 1、表名 2、父id 3、数量 4、排序方式
function getRandListOrder($table,$pid,$limit,$order='edittime desc'){
	 
	$page_list = M($table)->where('pid in ('.$pid.') and status=1')->field('*')->limit("0,".$limit)->order($order)->select();
	return $page_list;
}


// 获取搜索记录 1、类型id （1 产品，2 作品，3 培训，4 动态，5 案例 ） 2、数量
function getSearchRecord($typeid=1,$num=4){
	$conditioncom['typeid']=$typeid; 
	$search_list = M('search')->where($conditioncom)->limit("0,".$num)->order('nums desc')->select();
	return $search_list;
}




//获取物流公司信息
function getAreaName($id=0){

	
	$param = array();
	$param['table'] = 'area';
	$param['field'] = 'area_id';
	$param['value'] = intval($id);
	$result = Db::getRow($param);
	return $result[$area_name];

}
//获取树状
function getTree($list,$parentid=0,$level=1,$html='&nbsp├ &nbsp'){
            static $tree = array();
            foreach($list as $v){
                if($v['parentid'] == $parentid){
                    $v['level'] = $level;
                    $v['bmname'] = $v['bmming'];
                    $v['bmming'] = str_repeat($html,$level).$v['bmming'];
                    $tree[] = $v;
                    $tree = getTree($list,$v['id'],$level+1);

                }
            }
                    return $tree;
        }
//根据子类id获取父类顶级id
        function getNavPid($id){
    $nav = M('bumen')->find($id);
    if($nav['parentid'] != 0){
        return getNavPid($nav['parentid']);
        }
    return $nav['id'];
}
//获取父类id下的所有子类
    function getSubs($dat,$id=0,$level=1){
    $subs=array();
    foreach($dat as $item){
        if($item['parentid']==$id){
            $item['level']=$level;
            $subs[]=$item;
            $subs=array_merge($subs,getSubs($dat,$item['id'],$level+1));

        }

    }
    return $subs;
}
//获取当前子类id的所有父类id
   function getParents($dat,$id){
    $tre=array();
    foreach($dat as $item){
        if($item['id']==$id){
            if($item['parentid']>0)
                $tre=array_merge($tre,getParents($dat,$item['parentid']));
            $tre[]=$item;
            break;
        }
    }
    return $tre;
}
//返回地区
//val   1,id 2,title
function getArea($id=0,$title=""){


	$msg="";


	$msg.='<script type="text/javascript"> $(document).ready(function() {  ';
	if(!$id){
		$msg.='$.ajax({
					type: "get",
					url: "'.ADMIN_URL.'/index.php?url=ajax&do=area", // type=1表示查询省份
					data: {"parent_id": "0", "type": "1"},
					dataType: "json",
					success: function(data) {
						$("#area_sheng'.$title.'").html("<option value=\'\'>请选择</option>");
						$.each(data, function(i, item) {
						$("#area_sheng'.$title.'").append("<option value=\'" + item.area_id + "\'>"+item.area_name+"</option>");
							  });
						  }
					  });';
	}
		$msg.='	  $("#area_sheng'.$title.'").change(function() {
						  $.ajax({
							  type: "get",
							  url: "'.ADMIN_URL.'/index.php?url=ajax&do=area", // type =2表示查询市
							  data: {"parent_id": $(this).val(), "type": "2"},
							  dataType: "json",
							  success: function(data) {
								  $("#area_shi'.$title.'").html("<option value=\'\'>请选择</option>");
								  $.each(data, function(i, item) {
									  $("#area_shi'.$title.'").append("<option value=\'" + item.area_id + "\'>"+item.area_name+"</option>");

								  });
								  $("#area_qu'.$title.'").empty();
								  $("#area_qu'.$title.'").html("<option value=\'\'>请选择</option>");
							  }
						  });
					  });

					  $("#area_shi'.$title.'").change(function() {
						  $.ajax({
							  type: "get",
							  url: "'.ADMIN_URL.'/index.php?url=ajax&do=area", // type =3表示查询区
							  data: {"parent_id": $(this).val(), "type": "3"},
							  dataType: "json",
							  success: function(data) {
								  $("#area_qu'.$title.'").html("<option value=\'\'>请选择</option>");
								  $.each(data, function(i, item) {
									  $("#area_qu'.$title.'").append("<option value=\'" + item.area_id + "\'>"+item.area_name+ "</option>");
								  });
							  }
						  });
					  });
				  });
			  </script>';
	 if(!$id){
$msg.='<select id="area_sheng'.$title.'" name="area_sheng'.$title.'"><option value="">请选择</option></select> 省 <select id="area_shi'.$title.'" name="area_shi'.$title.'"><option value="">请选择</option></select> 市 <select id="area_qu'.$title.'" name="area_qu'.$title.'"><option value="">请选择</option></select> 地区 ';
			  }else{


				$condition["area_id"]=$id;
				$result=M('area')->where($condition)->field("area_parent_id")->find();



				$shi=$result['area_parent_id'];

				$con["area_id"]=$shi;
				$res=M('area')->where($con)->field("area_parent_id")->find();
				$sheng=$res['area_parent_id'];



				$msg.='<select id="area_sheng'.$title.'" name="area_sheng'.$title.'"><option value="">请选择</option>';

				$shenginfo = Db::getAll("SELECT * FROM ".DBPRE."area where area_parent_id=0 and area_deep=1   ORDER by area_sort asc ");
				foreach ((array)$shenginfo as $k => $v) {
					$sed="";
						if($sheng==$v["area_id"]){
							$sed="selected";
							}
					$msg.='<option value="'.$v["area_id"].'" '.$sed.'>'.$v["area_name"].'</option>';

				}
				$msg.='</select> 省 ';

				$msg.='<select id="area_shi'.$title.'" name="area_shi'.$title.'"><option value="">请选择</option>';

				$shiinfo = Db::getAll("SELECT * FROM ".DBPRE."area where area_parent_id=".$sheng." and area_deep=2   ORDER by area_sort asc ");
				foreach ((array)$shiinfo as $kk => $vv) {
					$sed="";
						if($shi==$vv["area_id"]){
							$sed="selected";
						}
					$msg.='<option value="'.$vv["area_id"].'" '.$sed.'>'.$vv["area_name"].'</option>';

				}

				$msg.='</select> 市 ';


				$msg.='<select id="area_qu'.$title.'" name="area_qu'.$title.'"><option value="">请选择</option>';

				$quinfo = Db::getAll("SELECT * FROM ".DBPRE."area where area_parent_id=".$shi." and area_deep=3   ORDER by area_sort asc ");
				foreach ((array)$quinfo as $kkk => $vvv) {
					$sed="";
						if($id==$vvv["area_id"]){
							$sed="selected";
						}
					$msg.='<option value="'.$vvv["area_id"].'" '.$sed.'>'.$vvv["area_name"].'</option>';

				}

				$msg.='</select> 地区 ';




			  }

			  return $msg;



	  }


?>