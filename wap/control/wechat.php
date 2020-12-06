<?php
// +----------------------------------------------------------------------
// | Name:微信相关
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class wechatControl extends mobileControl{
	
    public function __construct(){
        parent::__construct();
		define('APPID',"");
		define("SECRET","");
		define("WEIXIN","");//原始微信号 
		define("baseUrl","http://jiujin.chiniukeji.cn/wap/");//通用网址
    }
	
    public function indexDo(){

        $redirect_uri = urlencode(baseUrl.'index.php?url=wechat&do=getUserInfo');
		$url ="http://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
		header("Location:".$url);
		
    }
	
	//获取用户Code 
	public function getCodeDo(){
		
		$redirect_uri = urlencode(baseUrl.'index.php?url=wechat&do=getUserInfo');
		$url ="http://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
		header("Location:".$url);
	}
	
	//获取用户详细信息
	public function getUserInfoDo(){
		
		$model=M('member'); 
		$code = $_GET["code"]; 
		//第一步:取得openid
		$oauth2Url = "http://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".SECRET."&code=$code&grant_type=authorization_code";
		$oauth2 = getJson($oauth2Url);
		$openid = $oauth2['openid'];
		setcookie("openid",$openid);
		//print_r($openid); 
		
		//第二步:根据全局access_token和openid查询用户信息
		$tokenurl="http://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".SECRET.""; 
		$token2 = getJson($tokenurl);
		$access_token = $token2["access_token"];  
		$get_user_info_url = "http://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
		$userinfo = getJson($get_user_info_url);
		
		$condition['openid']=$openid;
		$info = $model->where($condition)->find();
		if(empty($info)){
			$data['truename']      = trim($userinfo['nickname']);
			$data['avatar']      = trim($userinfo['headimgurl']);
			$data['sex']      = trim($userinfo['sex']);
			$data['password']      = getPwd(trim('123456'));
			$data['login_num']      = 1;
			$data['addtime']      = time();
			$data['edittime']      = time();
			$data['login_time']      = time();
			$data['login_ip']       = getIp(); 
			$data['openid']      = $openid; 
			$data['weixin_info'] = json_decode($userinfo);
			$data['subscribe_time']      = trim($userinfo['subscribe_time']);
			$data['country']      = trim($userinfo['country']);
			$data['province']      = trim($userinfo['province']);
			$data['city']      = trim($userinfo['city']);
			$data['subscribe']      = trim($userinfo['subscribe']);
			$result = M('member')->insert($data);
		}else{
			$login_num=$info['login_num']+1;
			$data['truename']      = trim($userinfo['nickname']);
			$data['avatar']      = trim($userinfo['headimgurl']);
			$data['sex']      = trim($userinfo['sex']); 
			$data['login_num']      = $login_num; 
			$data['edittime']      = time();
			$data['login_time']      = time();
			$data['login_ip']       = getIp();  
			$data['weixin_info'] = json_decode($userinfo);
			$data['subscribe_time']      = trim($userinfo['subscribe_time']);
			$data['country']      = trim($userinfo['country']);
			$data['province']      = trim($userinfo['province']);
			$data['city']      = trim($userinfo['city']);
			$data['subscribe']      = trim($userinfo['subscribe']);
			$result = $model->where($condition)->update($data);
		}
		//打印用户信息
		//print_r($userinfo); 
		if ($result&&$userinfo){
			header("Location:index.php?url=index");
		}else{
			header("Location:index.php?url=wechat");
		}
	}
	
	//获取access_token
	function get_access_token(){
		$tokenurl="http://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".SECRET.""; 
		$token2 = getJson($tokenurl);
		$access_token = $token2["access_token"];
		return $access_token;
	}
	
	//通过accesstoken获取用户粉丝列表
	function get_fans_list($access_token,$next_openid=""){
		$url = "http://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$next_openid";
		$result = getJson($url);
		return $result;
	}
	
	//通过accesstoken获取用户基本信息
	function get_user_info($access_token,$openid){
		$url = "http://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN ";
		$result = getJson($url);
		return $result;
	}
	
	//获取用户详细信息
	public function getfanslistDo(){
			
		set_time_limit(0);
		$model=M('fans_list'); 
		$access_token = $this->get_access_token();
		$result=$this->get_fans_list($access_token);
		$openids=$result['data']['openid'];
		foreach($openids as $key=>$item){
			$userinfo=$this->get_user_info($access_token,$item);
			$condition['openid']=$item;
			$info = $model->where($condition)->find();
			if(empty($info)){
				$data['nickname']      = trim($userinfo['nickname']);
				$data['headimgurl']      = trim($userinfo['headimgurl']);
				$data['sex']      = trim($userinfo['sex']);  
				$data['addtime']      = time();
				$data['openid']      = $item;  
				$data['subscribe_time']      = trim($userinfo['subscribe_time']);
				$data['country']      = trim($userinfo['country']);
				$data['province']      = trim($userinfo['province']);
				$data['city']      = trim($userinfo['city']);
				$data['subscribe']      = trim($userinfo['subscribe']);
				$data['language']      = trim($userinfo['language']);
				$data['remark']      = trim($userinfo['remark']);
				$data['groupid']      = trim($userinfo['groupid']);
				$result =$model->insert($data);
			}else{
				$data['nickname']      = trim($userinfo['nickname']);
				$data['headimgurl']      = trim($userinfo['headimgurl']);
				$data['sex']      = trim($userinfo['sex']);    
				$data['subscribe_time']      = trim($userinfo['subscribe_time']);
				$data['country']      = trim($userinfo['country']);
				$data['province']      = trim($userinfo['province']);
				$data['city']      = trim($userinfo['city']);
				$data['subscribe']      = trim($userinfo['subscribe']);
				$data['language']      = trim($userinfo['language']);
				$data['remark']      = trim($userinfo['remark']);
				$data['groupid']      = trim($userinfo['groupid']);
				$result = $model->where($condition)->update($data);
			}
			//print_r($userinfo);
			echo '更新第'.$key.'个粉丝信息';
		}
		
	}
	
}