<?php
// +----------------------------------------------------------------------
// | Name: 线上解疑列表
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class manager_listControl extends SystemControl{
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
        $model = M('member');
        $condition = array();  
        $condition['isdel'] = 0;
        $condition['identity']= array('egt',1);
		list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
        $list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
     
        $data = array();
        $data['now_page'] = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($list as $k => $v) {
            $list = array();
			 
			$list['number'] = "<span title='".$v['servicenum']."'>".$v['servicenum']."</span>";  
		
			
			$list['releaseid'] = "<img src='".getImageUrl($v['avatar'],'avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrl($v['avatar'],'avatar').">\")'><span title='".$v['truename']."'>".$v['truename']."</span>"; 
		    $sex=getSinglePas($table='attribute','sex',$v['sex'],'title');
		   
			$list['sex'] = "<span title='".$sex."'>".$sex."</span>"; 
			$list['age'] = "<span title='".$v['age']."'>".$v['age']."</span>";
			 $officedata= M('office_list')->where(array('id'=>$v['officeid']))->select();
			 $departdata= M('depart_list')->where(array('id'=>$officedata[0]['pid']))->select();
		    $list['departdt']="<span >".$departdata[0]['title']."</span>";
		    $list['officedt']="<span >".$officedata[0]['title']."</span>";
		
			$list['education'] = "<span title='".$v['education']."'>".$v['education']."</span>";
			
			$list['mobile'] ="<span>".$v['mobile']."</span>";
			
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
			$data['password']      = trim($_POST['password']); 
			if(!empty($data['password'])){
				$data['password']      = getPwd(trim($data['password']));
			}else{
				$data['password']      = getPwd('123456');
			}
			$data['servicenum']      = trim($_POST['servicenum']);  
			$data['truename']      = trim($_POST['truename']);  
			$data['avatar']      = trim($_POST['avatar']);  
			$data['sex']      = trim($_POST['sex']);
			$data['officeid'] = trim($_POST['office']);
			$data['age']      = trim($_POST['age']); 
			$data['education']      = trim($_POST['education']);
			$data['politicsstatus']      = trim($_POST['politicsstatus']);  
			$data['position']      = trim($_POST['position']);  
			$data['mobile']      = trim($_POST['mobile']);  
			$data['addtime']  = time();
			$data['isreview']=1;
			$data['isorgan']=1;
			$data['identity']=1;
			$result = M('member')->insert($data);
			if ($result){
				$this->log('机构工作人员列表添加'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			}
        }
		include T('manager_list_edit'); 
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
          
			$data['username']      = trim($_POST['username']);  
			$data['password']      = trim($_POST['password']); 
			if(!empty($data['password'])){
				$data['password']      = getPwd(trim($data['password']));
			}else{
				$data['password']      = getPwd('123456');
			}
			$data['servicenum']      = trim($_POST['servicenum']);  
			$data['truename']      = trim($_POST['truename']);  
			$data['avatar']      = trim($_POST['avatar']);  
			$data['sex']      = trim($_POST['sex']);
			$data['officeid'] = trim($_POST['office']);
			$data['age']      = trim($_POST['age']); 
			$data['education']      = trim($_POST['education']);
			$data['politicsstatus']      = trim($_POST['politicsstatus']);  
			$data['position']      = trim($_POST['position']);  
			$data['mobile']      = trim($_POST['mobile']);  
			$data['addtime']  = time();
			$data['isreview']=1;
			$data['isorgan']=1;
		
		
			$condition['id'] = intval($_POST['id']); 
			$result =  M('member')->where($condition)->update($data); 
			if ($result){
				$this->log('机构人员列表编辑'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
        } 
		include T('manager_list_edit');
    }
	
	 /**
     * 审核
     */
    public function reviewDo(){ 
        $lang    = Language::getLangContent();
		$model=M($this->name);
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
			$data['reviewinfo']      = trim($_POST['reviewinfo']); 
			$data['replyintro']      = trim($_POST['reviewinfo']); 
			$condition['id'] = intval($_POST['id']); 
			$result = $model->where($condition)->update($data); 
			if ($result){
				$this->log('线上解疑数据审核'.'['.$info['title'].']',null); 
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
        }  
		include T('shuju_review1');
    }
	
	 
    /**
     * 删除
     */
    public function delDo() {
        $model=M($this->name);
        if (preg_match('/^[\d,]+$/', $_GET['del_id'])) {
            $_GET['del_id'] = explode(',',trim($_GET['del_id'],','));
            foreach ($_GET['del_id'] as $k => $v){
				$condition = array();
				$condition['id']=intval($v); 
				$data = array();
				$data['isorgan']=1;
                $model->where($condition)->update($data); 
            }
            $this->log('删除工作人员疑列表'.'[ID:'.implode(',',$_GET['del_id']).']',null);
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
			
		} 
		$result =M($this->name)->where($condition)->update($data);
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
            $condition['title']          = array('like',"%{$_GET['keywords']}%"); 
        }
		
		//更新时间
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['kaishi']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['jieshu']);
        $start_unixtime = $if_start_time ? strtotime($_GET['kaishi']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['jieshu']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['edittime'] = array('time',array($start_unixtime,$end_unixtime));
        } 
        $sort_fields = array('rank','id','edittime');
		if ($_REQUEST['sortorder'] != '' && in_array($_REQUEST['sortname'],$sort_fields)) {
            $order = $_REQUEST['sortname'].' '.$_REQUEST['sortorder'];
        } 
        return array($condition,$order);
    }

}
