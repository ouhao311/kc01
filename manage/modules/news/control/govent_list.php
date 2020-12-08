<?php
// +----------------------------------------------------------------------
// | Name: 智慧政务列表
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class govent_listControl extends SystemControl{
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
			$model = M('govent_list');
			$condition = array();  
			$condition['isdel'] = 0;
	list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
			$list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
			$data = array();
			$data['now_page'] = $model->shownowpage();
			$data['total_num'] = $model->gettotalnum();
			foreach ($list as $k => $v) {
					$list = array();
		 $list['id'] = "<span title='".$v['id']."'>".$v['id']."</span>";  
		$list['name'] = "<span title='".$v['name']."'>".$v['name']."</span>"; 
			$list['time'] = "<span title='".$v['enddate']."'>".$v['enddate']."</span>";

			$memberinfo=getTableInfohanett($v['memberid'],'member');
			$list['releaseid'] = "<img src='".getImageUrl($memberinfo['avatar'],'avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrl($memberinfo['avatar'],'avatar').">\")'><span title='".$memberinfo['truename']."'>".$memberinfo['truename']."</span>";
			if($v['departid']){
				$depart_title=getSinglePas('attribute', 'department', $v['departid'], 'title');
				$list['departid'] = "<span title='".$depart_title."'>".$depart_title."</span>";
			}else{
				$list['departid'] ="-";
			}  
				$membermanainfo=getTableInfohanett($v['managerid'],'member');
			$list['releasemanaid'] = "<img src='".getImageUrl($membermanainfo['avatar'],'avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrl($membermanainfo['avatar'],'avatar').">\")'><span title='".$membermanainfo['truename']."'>".$membermanainfo['truename']."</span>";
			if(empty($v['isself']))
			{
			    	$list['self'] = "-"; 
			}else{
			    	$list['self'] = "是"; 
			}

			if(empty($v['status']))
			{
			    	$list['status'] = "-"; 
			}else{
			    	$list['status'] = "是"; 
			}

		if($this->checkCzqx("edit")){
			$list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='javascript:void(0)' onclick='fg_edit(".$v['id'].")'><i class='fa fa-pencil-square-o'></i> 编辑</a>"; 
		} 
		if($this->checkCzqx("topshenhe")){
			$list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto' href='javascript:void(0)' onclick=\"fg_topshenhe({$v['id']})\"><i class='fa fa-check-circle'></i> 审核</a>"; 
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
		$clicks=rand(0,999);
        if (chksubmit()){
            $data = array(); 
			$data['name']      = trim($_POST['name']);  
			$data['managerid']      = trim($_POST['managemember']); 
		
			$data['memberid']      = trim($_POST['member']);
			$data['departid']      = trim($_POST['department']);  
			$data['enddate']      = trim($_POST['enddate']); 
			$data['status']      = 1;  
			$data['addtime']  = time();
	
			$result = M($this->name)->insert($data);
				//var_Dump($this->name,333,$data);exit;
			if ($result){
				$this->log('任务列表添加'.'['.$data['name'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			}
        }
		include T('govent_list_edit'); 
    }

    /**
     * 编辑
     */
    public function editDo(){
        $lang    = Language::getLangContent();
        $model=M($this->name);
		$condition['id'] = intval($_GET['id']);
	    $info = $model->where($condition)->find();
	    //var_dump($info);exit;
		if (empty($info)){
			echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('没有找到此信息');</script>";
			exit();
		}  
        $clicks=$info['clicks'];
        if (chksubmit()){ 
			$data = array(); 
			$data['name']      = trim($_POST['name']);  
			$data['managerid']      = trim($_POST['managemember']); 
		
			$data['memberid']      = trim($_POST['member']);
			$data['departid']      = trim($_POST['department']);  
			$data['enddate']      = trim($_POST['enddate']); 
			$data['status']      = 1;  
			$data['addtime']  = time();
		
			$result = $model->where($condition)->update($data); 
			if ($result){
				$this->log('任务列表编辑'.'['.$data['name'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
        }
		include T('govent_list_edit');
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
				$data['isdel']=1;
                $model->where($condition)->update($data); 
            }
            $this->log('删除任务列表'.'[ID:'.implode(',',$_GET['del_id']).']',null);
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
		}


	/*
     * 人员
     * */
	public  function puttree($pid=0,$selected=0){
        $rs = $this->gettree($pid);
        $str='';
        $str .= "<select name='pid' id='pid' lay-verify='required|pid'>";
        $str .= '<option value="">请选择分类</option>';
        foreach($rs as $key=>$val){

            if($val['id'] == $selected){
                $selectedstr = "selected";
            }else{
                $selectedstr = "";
            }
            $str .= "<option $selectedstr value='".$val['id']."'>".$val['title']."</option>";
        }
        $str .= "</select>";
        return $str;
    } 
	public  function gettree($pid=0,&$result=array(),$spac=0){
        $spac = $spac+2;
		$row = Db::getAll("SELECT * FROM ".DBPRE."article_class where pid=$pid and isdel=0 ORDER by rank asc ");
		if(!empty($row)){
			foreach($row as $v){
				if($v['pid']==0){
					$v['title'] = $v['title'];
				} else{
					$v['title'] = str_repeat('&nbsp;&nbsp;',$spac)."|--".$v['title'];
				}
				$result[] = $v;
				$this->gettree($v['id'],$result,$spac);
			}
		} 
        return $result;
    }
		
		/**
     * 审核
     */
    public function reviewDo(){ 
		$lang    = Language::getLangContent();
		$mid=$_SESSION['member_id'];
		$model=M('govent_detail_list');
		$condition['id'] = intval($_GET['id']);
		$info = $model->where($condition)->find();
		if (empty($info)){
			echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('没有找到此信息');</script>";
			exit(); 
		} 
		$goventinfo=getTableInfohanett($info['goventid'],'govent_list');
		if (chksubmit()){ 
			$data = array();
			$data['revstatus']      = intval($_POST['revstatus']);
			$data['revtime']  = time();
			$data['revuid']      = trim($mid);
			$data['revcontent']      = trim($_POST['revcontent']); 
			$condition['id'] = intval($_POST['id']); 
			if ($result){
				$this->log('任务数据审核'.'['.$goventinfo['name'].']',null);
				if($data['revstatus']==1){
					if($info['transaction']>0){
						$memberinfo=getTableInfohanett($info['transaction'],'member');
						//更新积分
						M('member')->where(array('id'=>$info['transaction']))->update(array('integral'=>$memberinfo['integral']+2)); //C('integral')
						$this->log('发布'.'['.$info['title'].']审核成功奖励2积分',null);
						//写入积分记录
						$data_record = array();
						$data_record['mid']=$info['releaseid'];  
						$data_record['integral']=2;
						$data_record['type']=1;
						$data_record['addtime']=time();
						$data_record['source']=1;
						$data_record['intro']='发布'.'['.$info['title'].']审核成功奖励2积分';
						M("member_integral")->insert($data_record);
					}
				}
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
		}  
		include T('govent_preview');
	}

		
		/**
     * 审核
     */
    public function topreviewDo(){ 
		$lang    = Language::getLangContent();
		$mid=$_SESSION['member_id'];
		$model=M('govent_detail_list');
		$goventinfo=getTableInfohanett($info['goventid'],'govent_list');
		if (chksubmit()){ 
			$data = array();
			$data['revstatus']      = intval($_POST['revstatus']);
			$data['revtime']  = time();
			$data['revuid']      = trim($mid);
			$data['revcontent']      = trim($_POST['revcontent']); 
			$condition['id'] = intval($_POST['id']); 
			if ($result){
				$this->log('任务数据审核'.'['.$goventinfo['name'].']',null);
				if($data['revstatus']==1){
					if($info['transaction']>0){
						$memberinfo=getTableInfohanett($info['transaction'],'member');
						//更新积分
						M('member')->where(array('id'=>$info['transaction']))->update(array('integral'=>$memberinfo['integral']+2)); //C('integral')
						$this->log('发布'.'['.$info['title'].']审核成功奖励2积分',null);
						//写入积分记录
						$data_record = array();
						$data_record['mid']=$info['releaseid'];  
						$data_record['integral']=2;
						$data_record['type']=1;
						$data_record['addtime']=time();
						$data_record['source']=1;
						$data_record['intro']='发布'.'['.$info['title'].']审核成功奖励2积分';
						M("member_integral")->insert($data_record);
					}
				}
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
		}  
		include T('govent_preview1');
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
