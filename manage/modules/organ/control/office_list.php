<?php
// +----------------------------------------------------------------------
// | Name: 资讯列表
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class office_listControl extends SystemControl{
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
		//所有一级分类
		$article_class = M("article_class")->where(array("pid"=>0,"isdel"=>0))->order('rank asc')->select();
		$pid=$_REQUEST['pid'];
		include T($this->name);
    }

    /**
     * 异步调用列表
     */
    public function get_xmlDo(){
        $model = M($this->name);
        $condition = array(); 
		if(!empty($_REQUEST['pid'])){
			$pids=puttrees($_REQUEST['pid'],'article_class');
			$condition['pid'] = array('in',$pids);
		}
        $condition['isdel'] = 0;
		list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
	
        $list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
        $data = array();
        $data['now_page'] = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($list as $k => $v) {
            $list = array();
			 
			$list['rank'] = "<span title='".$v['rank']."'>".$v['rank']."</span>";
			$list['id'] = "<span title='".$v['id']."'>".$v['id']."</span>";
			if($v['pic']){
				$list['title'] = "<a class='pic-thumb-tip' onmouseover=\"toolTip('<img src=".$v['pic'].">')\" onmouseout='toolTip()' href='javascript:void(0);'> <i class='fa fa-picture-o'></i></a> <span title='".$v['title']."'>".$v['title']."</span>";
			}else{
				$list['title'] = "<span title='".$v['title']."'>".$v['title']."</span>";
			}
			if($v['pid']){
				$depart_list=getTableInfohanett($v['pid'],'depart_list');
				$list['pid'] = "<span title='".$depart_list['title']."'>".$depart_list['title']."</span>";
			}else{
				$list['pid'] ="暂无部门";
			}  
			if(empty($v['releaseid'])){
				$admininfo = Db::getAll("SELECT * FROM ".DBPRE."admin where admin_id={$v['mid']}"); 
				$list['releaseid'] = "<img src='".getImageUrlAdmin($admininfo[0]['admin_avatar'],'admin_avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrlAdmin($admininfo[0]['admin_avatar'],'admin_avatar').">\")'><span title='".$admininfo[0]['admin_name']."'>".$admininfo[0]['admin_name']."</span>"; 
			}else{
				$memberinfo=getTableInfohanett($v['releaseid'],'member');
				$list['releaseid'] = "<img src='".getImageUrl($memberinfo['avatar'],'avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrl($memberinfo['avatar'],'avatar').">\")'><span title='".$memberinfo['truename']."'>".$memberinfo['truename']."</span>"; 
			}
		
			$list['status'] = $v['status'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'show')\" title='设为显示'><i class='fa fa-ban'></i> 否</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unshow')\"  title='取消显示'><i class='fa fa-check-circle'></i> 是</span>"; 
		
			$list['edittime'] = $v['edittime']?date('Y-m-d H:i:s',$v['edittime']):'-';
		
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
	
	/*
     * 父类id  选中的id
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
		$row = Db::getAll("SELECT * FROM ".DBPRE."depart_list where  isdel=0 ORDER by rank asc ");
	
		if(!empty($row)){
			foreach($row as $v){
			
					$v['title'] = $v['title'];
			
				$result[] = $v;
			//	$this->gettree($v['id'],$result,$spac);
			}
		} 
        return $result;
    }
	
    /**
     * 添加
     */
    public function addDo(){
        $lang   = Language::getLangContent();
		$clicks=rand(0,999);
	     $departid=$_GET['pid'];
	     
        if (chksubmit()){
            $data = array(); 
			$data['pid']      = intval($_POST['pid']); 
			$data['rank']      = intval($_POST['rank']); 
			$data['title']      = trim($_POST['title']); 
			$data['intro']      = trim($_POST['intro']);
			$data['pic']      = trim($_POST['pic']); 
			$data['url']      = trim($_POST['url']); 
			$data['addtime']  = time(); 
			$data['mid']      = $this->admin_info['id'];
			$data['edittime']  = time(); 
			$data['editor']   = $this->admin_info['id'];
			$data['status']=1;
		
			$data['ip']       = getIp();
		
			if(!$_POST['intro'])
			{
				$data['intro']    = clearHtmlText(str_cut(strip_tags($data['content']),200));//截取简介
			}
		//	var_Dump($data,111,$this->name);exit;
			$result = M($this->name)->insert($data);
			if ($result){
				$this->log('科室列表添加'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			}
        }
		include T('office_list_edit'); 
    }

    /**
     * 编辑
     */
    public function editDo(){
        $lang    = Language::getLangContent();  
        $model=M($this->name);
		$condition['id'] = intval($_GET['id']);
	    $info = $model->where($condition)->find();
	   
		if (empty($info)){
			echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('没有找到此信息');</script>";
			exit();
		} 
		$clicks=$info['clicks'];
        if (chksubmit()){ 
			$data = array(); 
			$data['pid']      = intval($_POST['pid']); 
			$data['rank']      = intval($_POST['rank']); 
			$data['title']      = trim($_POST['title']); 
			$data['shorttile']      = trim($_POST['shorttile']);
			$data['intro']      = trim($_POST['intro']);
			$data['content']  = htmlspecialchars_decode($_POST['content'], ENT_QUOTES); 
			$data['pic']      = trim($_POST['pic']); 
			$data['url']      = trim($_POST['url']);
			$data['edittime']  = time(); 
			$data['editor']   = $this->admin_info['id']; 
			$data['clicks']   = intval($_POST['clicks']); 
			$data['ip']       = getIp();
			$data['seo_title']      = trim($_POST['seo_title']);
			$data['seo_keywords']      = trim($_POST['seo_keywords']);
			$data['seo_description']      = trim($_POST['seo_description']);   
			if(!$_POST['intro'])
			{
				$data['intro']    = clearHtmlText(str_cut(strip_tags($data['content']),200));//截取简介
			}	
			$condition['id'] = intval($_POST['id']); 
			$result = $model->where($condition)->update($data); 
			if ($result){
				$this->log('资讯列表编辑'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
        } 
		include T('article_list_edit');
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
			$condition['id'] = intval($_POST['id']); 
			$result = $model->where($condition)->update($data); 
			if ($result){
				$this->log('资讯数据审核'.'['.$info['title'].']',null);
				if($data['isreview']==1){
					if($info['releaseid']>0){
						$memberinfo=getTableInfohanett($info['releaseid'],'member');
						//更新积分
						M('member')->where(array('id'=>$info['releaseid']))->update(array('integral'=>$memberinfo['integral']+C('integral')));
						$this->log('发布'.'['.$info['title'].']审核成功奖励'.C('integral').'积分',null);
						//写入积分记录
						$data_record = array();
						$data_record['mid']=$info['releaseid'];  
						$data_record['integral']=C('integral');
						$data_record['type']=1;
						$data_record['addtime']=time();
						$data_record['source']=1;
						$data_record['intro']='发布'.'['.$info['title'].']审核成功奖励'.C('integral').'积分';
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
		include T('shuju_review');
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
            $this->log('删除科室列表'.'[ID:'.implode(',',$_GET['del_id']).']',null);
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
				$data['status']    = 0;
				$data['edittime']  = time();
				$msg              = "资讯取消显示";
			break;
			case 'show':
				$data['status']    = 1;
				$data['edittime']  = time();
				$msg              = "资讯设为显示";
			break; 
			case 'unrec':
				$data['isrec']    = 0;
				$data['rectime']  = time();
				$msg              = "资讯取消头条";
			break;
			case 'rec':
				$data['isrec']    = 1;
				$data['rectime']  = time();
				$msg              = "资讯设为头条";
			break;
			case 'unhot':
				$data['ishot']    = 0;
				$data['hottime']  = time();
				$msg              = "资讯取消热门";
			break;
			case 'hot':
				$data['ishot']    = 1;
				$data['hottime']  = time();
				$msg              = "资讯设为热门";
			break;
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
		if(!empty($_GET['pid'])){
			$pids=puttrees($_GET['pid'],'article_class');
			$condition['pid'] = array('in',$pids);
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
