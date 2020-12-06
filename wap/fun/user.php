<?php
// +----------------------------------------------------------------------
// | Name: 用户公共方法
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

function fansinfo($openidOruid){

	if (empty($openidOruid)) {
		return array();
	}
	$condition = array();
	if (is_numeric($openidOruid)) {
	    $condition['member_id'] = intval($openidOruid);
	}
	if (is_string($openidOruid)) {

		 $condition['weixin_openid'] = trim($openidOruid);
	}

	$info = M("member")->where($condition)->find();

	if($info){

	$info['uid']=$info['member_id'];
	$info['avatarUrl']=$info['member_avatar']?$info['member_avatar']:$info['weixin_headimgurl'];
	$info['nickName']=$info['member_truename']?$info['member_truename']:$info['weixin_nickname'];
	$info['rz_yyzz']=$info['rz_yyzz']?getImageUrl($info['rz_yyzz'],"renzheng"):"";
	}




	return !empty($info) ? $info : false;


}


function aes_pkcs7_decode($encrypt_data, $key, $iv = false) {


	require_once(HX_CORE.'/lib/PKCS7Encoder.php');

	$encrypt_data = base64_decode($encrypt_data);
	if (!empty($iv)) {
		$iv = base64_decode($iv);
	}


	$pc = new Prpcrypt($key);
	$result = $pc->decrypt($encrypt_data, $iv);

	if ($result[0] != 0) {
		return output_error('解密失败');
	}
	return $result[1];
}
