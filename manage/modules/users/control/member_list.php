<?php
// +----------------------------------------------------------------------
// | Name: 普通会员
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class member_listControl extends SystemControl{
	public $name;
    public function __construct(){
        parent::__construct();
		$this->name=getUrl(__CLASS__);

    }
	/**
     * 列表管理
     */
    public function indexDo() {
        $lang = Language::getLangContent();

		include T($this->name);
    }

    /**
     * 异步调用列表
     */
    public function get_xmlDo(){

		//if (!chksubmit()) exit(Tpl::flexigridXML(''));//默认不显示数据

        $model = M('member');
        $condition = array(); 
        $condition['isdel'] = 0;
		list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
        $list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
        $data = array();
        $data['now_page'] = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($list as $k => $v) {
            $list = array(); 
			$list['username'] = "<span title='".$v['username']."'>".$v['username']."</span>";
			$list['truename'] = "<img src='".getImageUrl($v['avatar'],'avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrl($v['avatar'],'avatar').">\")'><span title='".$v['truename']."'>".$v['truename']."</span>"; 
			$sex=getSinglePas($table='attribute','sex',$v['sex'],'title');
			$list['sex'] = "<span title='".$sex."'>".$sex."</span>"; 
			$list['mobile'] = "<span title='".$v['mobile']."'>".$v['mobile']."</span>"; 
			$department=getSinglePas($table='attribute','department',$v['department'],'title');
// 			$list['department'] = "<span title='".$department."'>".$department."</span>"; 
			$list['integral'] = "<span title='".$v['integral']."'>".$v['integral']."</span>"; 
			$list['addtime']  = $v['addtime']?date('Y-m-d H:i:s',$v['addtime']):'-';
			$list['login_time'] = $v['login_time']?date('Y-m-d H:i:s',$v['login_time']):'-'; 
			$list['state'] = $v['state'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'show')\" title='设为启用'><i class='fa fa-ban'></i> 禁用</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unshow')\"  title='取消禁用'><i class='fa fa-check-circle'></i> 启用</span>";  
			$list['isreview'] = getReview('isreview',$v['isreview']);
			if($this->checkCzqx("edit")){
				$list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='javascript:void(0)' onclick='fg_edit(".$v['id'].")'><i class='fa fa-pencil-square-o'></i> 编辑</a>"; 
			} 
			if($this->checkCzqx("shenhe")){
				$list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto' href='javascript:void(0)' onclick=\"fg_shenhe({$v['id']})\"><i class='fa fa-check-circle'></i> 审核</a>"; 
			}
            $data['list'][$v['id']] = $list;
        }
        exit(Tpl::flexigridXML($data));

    }
	 

    /**
     * 添加
     */
    public function addDo(){
        $lang   = Language::getLangContent(); 
        if (chksubmit()){
            $data = array(); 
			$data['username']      = trim($_POST['username']);
			$data['truename']      = trim($_POST['truename']);   
			$data['password']      = trim($_POST['password']);
			if(!empty($data['password'])){
				$data['password']      = getPwd(trim($data['password']));
			}else{
				$data['password']      = getPwd('123456');
			}
			$data['mobile']      = trim($_POST['mobile']);
			$data['avatar']      = trim($_POST['avatar']);  
			$data['sex']      = intval($_POST['sex']); 
			$data['department']      = intval($_POST['department']);  
			$data['state']=1;
			$data['type']=1;
			$data['isreview']=1;
			$data['addtime']  = time();
			$data['edittime']  = time(); 
			$data['revtime']  = time(); 
			$result = M('member')->insert($data);
			if ($result){
				$this->log('普通会员添加'.'['.$data['truename'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			}
        }
		include T('member_list_edit');

    }

    /**
     * 编辑
     */
    public function editDo(){

        $lang    = Language::getLangContent();
        $model=M('member');
		$condition['id'] = intval($_GET['id']);
	    $info = $model->where($condition)->find();
		if (empty($info)){
			echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('没有找到此信息');</script>";
			exit(); 
		} 
        if (chksubmit()){ 
			$data = array(); 
			$data['truename']      = trim($_POST['truename']);   
			if(!empty($_POST['password'])){
				$data['password']      = getPwd(trim($_POST['password']));
			}
			$data['mobile']      = trim($_POST['mobile']); 
			$data['avatar']      = trim($_POST['avatar']);   
			$data['sex']      = intval($_POST['sex']);   
			$data['department']      = intval($_POST['department']);  
			$data['type']=1;
			$data['edittime']  = time();
		
			$condition['id'] = intval($_POST['id']); 
			$result = $model->where($condition)->update($data); 
			if ($result){
				$this->log('普通会员编辑'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
        } 
		include T('member_list_edit');
    }
	
	/**
     * 审核
     */
    public function reviewDo(){ 
        $lang    = Language::getLangContent();
		$model=M('member');
		$condition['id'] = intval($_GET['id']);
	    $info = $model->where($condition)->find();
		if (empty($info)){
			echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('没有找到此信息');</script>";
			exit(); 
		} 
        if (chksubmit()){ 
			$data = array();
			$data['isreview']      = intval($_POST['isreview']);
			$data['revtime']  = time();
			$data['identity'] = trim($_POST['identity']);
			if($data['identity']>=1)
			{
			    $data['isorgan']=1;
			}
			$data['reviewinfo']      = trim($_POST['reviewinfo']);
			$data['isorgan'] = $_POST['isreview'];
			$condition['id'] = intval($_POST['id']); 
			//var_Dump($_POST);exit;
			$result = $model->where($condition)->update($data); 
			if ($result){
				$this->log('资讯数据审核'.'['.$info['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
        }  
		include T('shuju_review');
    }
	
	/**
     * 排重
     */
    public function repeatDo(){

        $lang    = Language::getLangContent();
        $model=M('member');
		$username=$_REQUEST['username'];
		$data=array();
		$data['username']=$username;
		$info=$model->where($data)->find(); 
		if(empty($info)){
			output_error('暂无数据！');exit();
		}else{
			output_data($info);exit(); 
		}
    }
	

    /**
     * 删除
     */

    public function delDo() {
        $model=M('member');
        if (preg_match('/^[\d,]+$/', $_GET['del_id'])) {
            $_GET['del_id'] = explode(',',trim($_GET['del_id'],','));
            foreach ($_GET['del_id'] as $k => $v){ 
				$condition = array();
				$condition['id']=intval($v); 
				$data = array();
				$data['isdel']=1;
                $model->where($condition)->update($data); 
            }
            $this->log('删除普通会员'.'[ID:'.implode(',',$_GET['del_id']).']',null);
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
    }
	
	/**
     * 设置操作
     */
    public function setDo() { 
		$data =$condition= array();
		$condition['id'] = intval($_GET['id']); 
		switch ($_GET['branch']){
			case 'unshow':
				$data['state']    = 0;
				$data['edittime']  = time();
				$msg              = "普通会员取消禁用";
			break;
			case 'show':
				$data['state']    = 1;
				$data['edittime']  = time();
				$msg              = "普通会员设为启用";
			break;  
			
		}
		$result =M('member')->where($condition)->update($data);
		if($result){
		$this->log($msg.'[ID:'.$_GET['id'].']',null);
			 exit(json_encode(array('state'=>true,'msg'=>'操作成功')));
		}else{
			 exit(json_encode(array('state'=>false,'msg'=>'操作失败')));
		} 
	}

	/**
     * 封装公共代码
     */
    private function _get_condition($condition) {
 
        if ($_GET['keywords'] != '') {
            $condition['username']          = array('like',"%{$_GET['keywords']}%"); 
        }
        if ($_GET['truename'] != '') {
            $condition['truename']          = array('like',"%{$_GET['truename']}%"); 
        }
        if ($_GET['mobile'] != '') {
            $condition['mobile']          = array('like',"%{$_GET['mobile']}%"); 
        } 
		if($_GET['state'] == '1') {
            $condition['state']          = 1;
        }
		if($_GET['state'] == '-1') {
            $condition['state']       =   0;
        } 
        if ($_GET['department'] != '') {
            $condition['department']          = $_GET['department']; 
        }
		if($_GET['isreview']  != '') {
            $condition['isreview']     = $_GET['isreview']; 
        } 
		//更新时间
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['kaishi']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['jieshu']);
        $start_unixtime = $if_start_time ? strtotime($_GET['kaishi']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['jieshu']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['addtime'] = array('time',array($start_unixtime,$end_unixtime));
        }

        $sort_fields = array('id','addtime');
		if ($_REQUEST['sortorder'] != '' && in_array($_REQUEST['sortname'],$sort_fields)) {
            $order = $_REQUEST['sortname'].' '.$_REQUEST['sortorder'];
        }

        return array($condition,$order);
    }

}
