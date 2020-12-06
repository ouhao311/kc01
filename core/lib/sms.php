<?php
// +----------------------------------------------------------------------
// | Name:手机短信
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
require_once "SignatureHelper.php";
use Aliyun\DySDKLite\SignatureHelper;
require_once 'ChuanglanSmsApi.php';
class Sms
{
	
	//235短信平台
	public function mysend_sms235($mobile){
		$clapi  = new ChuanglanSmsApi(); 
		//生成验证码
        if (!is_telephone($mobile)) {
            return '-1';
        }
		$smscode = mt_rand(1000, 9999);
        $_SESSION['codetime_' . $mobile] = time(); 
		$content='【253云通讯】您好，您的短信验证码是：'.$smscode.'。请不要把验证码泄露给其他人。'; 
		$result = $clapi->sendSMS($mobile, $content); 
		if(!is_null(json_decode($result))){
			$output=json_decode($result,true);
			if(isset($output['code'])  && $output['code']=='0'){
				//if(1){
				$data = array();
				$data["member_id"] = 0;
				$data["member_name"] = 0;
				$data["mobile"] = $mobile;
				$data["code"] = $smscode;
				$data["addtime"] = time();
				$data["ip"] = getIp();
				$data["type"] = 1;
				//插入数据库
				M("code")->insert($data);
				return '1'; 
			}else{
				return $output['errorMsg'];
			}
		}else{
			return $result; 
		}   
	}
	
	//阿里大鱼短信
    /**
     * 发送手机验证码
     * @param unknown $mobile 手机号
     */
    public function sendCode($mobile = '')
    {
        //生成验证码
        if (!is_telephone($mobile)) {
            return '-1';
        }
        $smscode = mt_rand(1000, 9999);
        $_SESSION['codetime_' . $mobile] = time();
        $temId = 'SMS_135310045';
        // 验证码模板
        $temp = array("code" => $smscode);
        $result = $this->send($mobile, $temp, $temId);
        //var_dump($result) ;
        $rs = $this->object_array($result);
        if ($rs["Code"] == "OK") {
            //if(1){
            $data = array();
            $data["member_id"] = 0;
            $data["member_name"] = 0;
            $data["mobile"] = $mobile;
            $data["code"] = $smscode;
            $data["addtime"] = time();
            $data["ip"] = getIp();
            $data["type"] = 1;
            //插入数据库
            M("code")->insert($data);
            return '1';
        } else {
            return '0';
        }
    }
    /**
     * 发送手机短信
     * @param unknown $mobile 手机号
     * @param unknown $temp 短信内容
     */
    public function send($mobile = '', $temp = array(), $temId = 'SMS_135310045')
    {
        $params = array();
        // *** 需用户填写部分 ***
        // fixme 必填: 请参阅 http://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAI7kwcm2BfqG5V";
        $accessKeySecret = "FTxzcjQl7CIBNYmlg27JQyQtEiLgFU";
        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $mobile;
        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: http://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "智慧鸟科技后台管理系统";
        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: http://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $temId;
        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $temp;
        // fixme 可选: 设置发送短信流水号
        // $params['OutId'] = "12345";
        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        // $params['SmsUpExtendCode'] = "1234567";
        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();
        // 此处可能会抛出异常，注意catch
        $content = $helper->request($accessKeyId, $accessKeySecret, "dysmsapi.aliyuncs.com", array_merge($params, array("RegionId" => "cn-hangzhou", "Action" => "SendSms", "Version" => "2017-05-25")));
        return $content;
    }
    function object_array($array)
    {
        if (is_object($array)) {
            $array = (array) $array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }
	
	
	
}

 
