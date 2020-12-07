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
        $model = M($this->name);
        $condition = array(); 
        $condition['isdel'] = 0;
		list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
        $list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
        $data = array();
        $data['now_page'] = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($list as $k => $v) {
            $list = array();
			 
			$list['rank'] = "<span title='".$v['rank']."'>".$v['rank']."</span>";
			if($v['pic']){
				$list['title'] = "<a class='pic-thumb-tip' onmouseover=\"toolTip('<img src=".$v['pic'].">')\" onmouseout='toolTip()' href='javascript:void(0);'> <i class='fa fa-picture-o'></i></a> <span title='".$v['title']."'>".$v['title']."</span>";
			}else{
				$list['title'] = "<span title='".$v['title']."'>".$v['title']."</span>";
			}
			if(empty($v['releaseid'])){
				$admininfo = Db::getAll("SELECT * FROM ".DBPRE."admin where admin_id={$v['mid']}"); 
				$list['releaseid'] = "<img src='".getImageUrlAdmin($admininfo[0]['admin_avatar'],'admin_avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrlAdmin($admininfo[0]['admin_avatar'],'admin_avatar').">\")'><span title='".$admininfo[0]['admin_name']."'>".$admininfo[0]['admin_name']."</span>"; 
			}else{
				$memberinfo=getTableInfohanett($v['releaseid'],'member');
				$list['releaseid'] = "<img src='".getImageUrl($memberinfo['avatar'],'avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrl($memberinfo['avatar'],'avatar').">\")'><span title='".$memberinfo['truename']."'>".$memberinfo['truename']."</span>"; 
			}
			$list['isrec'] = $v['isrec'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'rec')\" title='设为头条'><i class='fa fa-ban'></i> 否</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unrec')\"  title='取消头条'><i class='fa fa-check-circle'></i> 是</span>";
			//$list['ishot'] = $v['ishot'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'hot')\" title='设为热门'><i class='fa fa-ban'></i> 否</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unhot')\"  title='取消热门'><i class='fa fa-check-circle'></i> 是</span>";
			$list['status'] = $v['status'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'show')\" title='设为显示'><i class='fa fa-ban'></i> 否</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unshow')\"  title='取消显示'><i class='fa fa-check-circle'></i> 是</span>"; 
			$list['clicks'] = "<span title='".$v['clicks']."'>".$v['clicks']."</span>";
			$list['edittime'] = $v['edittime']?date('Y-m-d H:i:s',$v['edittime']):'-';
			if($this->checkCzqx("edit")){
				$list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='javascript:void(0)' onclick='fg_edit(".$v['id'].")'><i class='fa fa-pencil-square-o'></i> 编辑</a>"; 
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
			$data['rank']      = intval($_POST['rank']); 
			$data['title']      = trim($_POST['title']); 
			$data['shorttile']      = trim($_POST['shorttile']);
			$data['intro']      = trim($_POST['intro']);
			$data['content']  = htmlspecialchars_decode($_POST['content'], ENT_QUOTES); 
			$data['pic']      = trim($_POST['pic']); 
			$data['url']      = trim($_POST['url']); 
			$data['addtime']  = time(); 
			$data['mid']      = $this->admin_info['id'];
			$data['edittime']  = time(); 
			$data['editor']   = $this->admin_info['id'];
			$data['status']=1;
			$data['clicks']   = intval($_POST['clicks']); 
			$data['ip']       = getIp();
			$data['seo_title']      = trim($_POST['seo_title']);
			$data['seo_keywords']      = trim($_POST['seo_keywords']);
			$data['seo_description']      = trim($_POST['seo_description']);   
			if(!$_POST['intro'])
			{
				$data['intro']    = clearHtmlText(str_cut(strip_tags($data['content']),200));//截取简介
			}	
			$result = M($this->name)->insert($data);
			if ($result){
				$this->log('智慧政务列表添加'.'['.$data['title'].']',null);
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
				$this->log('智慧政务列表编辑'.'['.$data['title'].']',null);
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
            $this->log('删除智慧政务列表列表'.'[ID:'.implode(',',$_GET['del_id']).']',null);
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
