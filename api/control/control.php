<?php
// +----------------------------------------------------------------------
// | Name:mobile父类
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');


/********************************** 前台control父类 **********************************************/

class mobileControl{

    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios', 'windows');
    //列表默认分页数
    protected $page = 5;


    public function __construct() {
        Language::read('mobile');
		$lang = Language::getLangContent();

        //分页数处理
        $page = intval($_GET['page']);
        if($page > 0) {
            $this->page = $page;
        }
    }
}

class mobileHomeControl extends mobileControl{
    public function __construct() {
        parent::__construct();
    }

    protected function getMemberIdIfExists()
    {
        $key = $_POST['key'];
        if (empty($key)) {
            $key = $_GET['key'];
        }

        $model_mb_user_token = M('mb_user_token');
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if (empty($mb_user_token_info)) {
            return 0;
        }

        return $mb_user_token_info['member_id'];
    }
}

class mobileMemberControl extends mobileControl{

    protected $member_info = array();

    public function __construct() {
        parent::__construct();

        $model_mb_user_token = M('mb_user_token');
        $key = $_POST['key'];
        if(empty($key)) {
            $key = $_GET['key'];
        }
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) {
            output_error('请登录', array('login' => '0'));
        }

        $model_member = M('member');
        $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);

        if(empty($this->member_info)) {
            output_error('请登录', array('login' => '0'));
        } else {
            $member_gradeinfo = $model_member->getOneMemberGrade(intval($this->member_info['member_exppoints']));
            $this->member_info['level'] = $member_gradeinfo['level'];
            $this->member_info['client_type'] = $mb_user_token_info['client_type'];
            $this->member_info['openid'] = $mb_user_token_info['openid'];
            $this->member_info['token'] = $mb_user_token_info['token'];

            //读取卖家信息
            //$seller_info = Model('seller')->getSellerInfo(array('member_id'=>$this->member_info['member_id']));
            //$this->member_info['store_id'] = $seller_info['store_id'];
        }
    }

    public function getOpenId()
    {
        return $this->member_info['openid'];
    }

    public function setOpenId($openId)
    {
        $this->member_info['openid'] = $openId;
        Model('mb_user_token')->updateMemberOpenId($this->member_info['token'], $openId);
    }
}

