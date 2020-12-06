<?php
// +----------------------------------------------------------------------
// | Name: 会员相关接口
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class memberControl extends mobileHomeControl {

    public function __construct(){
        parent::__construct();
    }
	 
	
	/**
     * 会员首页
     */
    public function indexDo(){ 
		header('Content-type: application/json');
		
    }
	
	//工号绑定
	public function bangdingDo(){ 
		header('Content-type: application/json');
		$model_member   = M('member'); 
		$openid=$_REQUEST['openid'];
		$username=$_REQUEST['username'];
			
		if(empty($openid)){
			output_error('请在公众号内使用！');exit();
		}
		$rs = M("member")->where("openid='$openid'")->field("*")->find();
		if(empty($rs)){
			output_error('请在公众号内使用！');exit();
		}else{
			$condition_cf['username'] = $username; 
			$info_cf=$model_member->where($condition_cf)->find();
			if(empty($info_cf)){
				$condition = array();
				$condition['openid'] = $openid; 
				$data = array(); 
				$data['username']=$username; 
				$info=$model_member->where($condition)->update($data);
				if(empty($info)){
					output_error('请在公众号内使用！');exit();
				}else{
					output_data($data);exit();
				}
			}else{
				output_error('您的工号已使用，请联系管理员！');exit();
			}
		}
    }
	
	//获取工资信息
	public function payrollinfoDo(){ 
		header('Content-type: application/json'); 
		$openid=$_REQUEST['openid'];
		$month=$_REQUEST['month'];
		$year=$_REQUEST['year'];
			
		if(empty($openid)){
			output_error('请在公众号内使用！');exit();
		}
		$rs = M("member")->where("openid='$openid'")->field("*")->find();
		if(empty($rs)){
			output_error('请在公众号内使用！');exit();
		}else{
			$condition = array();
			$yearmonth=$year.'-'.$month;
			$username=$rs['username']; 
			$condition['yearmonth'] = strtotime($yearmonth);
			$condition['username'] = $username;  
			$info=M('payroll_list')->where($condition)->find();
			if(empty($info)){
				output_error('empty');exit();
			}else{
				if(!empty($info['zhidate'])){
					$info['zhidate']=date('Y-m-d',$info['zhidate']);
				}
				output_data($info);exit();
			}
		}
    }
	
	 
}

