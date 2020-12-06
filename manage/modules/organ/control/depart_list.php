<?php
// +----------------------------------------------------------------------
// | Name: 资讯分类
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
 //var_Dump(31312321);exit;
class depart_listControl extends SystemControl{
   
	public $name;
    public function __construct(){
        parent::__construct();
        //var_Dump(getUrl(__CLASS__),333,__CLASS__);exit;
		$this->name=getUrl(__CLASS__);

    }
	/**
     * 列表管理
     */
    public function indexDo() {
        $lang = Language::getLangContent();
		$pid=$_REQUEST['pid'];
		//var_Dump($this->name);exit;
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
		
			$list['title'] = "<span title='".$v['title']."'>".$v['title']."</span>"; 
			
		
			$list['status'] = $v['status'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'status')\" title='设为显示'><i class='fa fa-ban'></i> 设为不显示</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unstatus')\"  title='设为不显示'><i class='fa fa-check-circle'></i> 显示</span>";  
			$list['edittime'] = $v['edittime']?date('Y-m-d H:i:s',$v['edittime']):'-'; 
			$list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='javascript:void(0)' onclick='fg_edit(".$v['id'].")'><i class='fa fa-edit'></i> 编辑</a>";
			if(empty($v['pid'])){
				$list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='javascript:void(0)' onclick='fg_addson(".$v['id'].")'><i class='fa fa-pencil-square-o'></i> 新增科室</a>"; 
				; 
			}else{
			
			}
		 
            $data['list'][$v['id']] = $list;
        }
        //var_Dump($data);exit;
        exit(Tpl::flexigridXML($data));

    }
	 
	 
	 public function addofficeDo()
	 {
	       $lang   = Language::getLangContent();
		$clicks=rand(0,999);
		$article_class = M("article_class")->where(array("pid"=>0,"isdel"=>0))->order('rank asc')->select();
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
			$data['addtime']  = time(); 
			$data['mid']      = $this->admin_info['id'];
			$data['edittime']  = time(); 
			$data['editor']   = $this->admin_info['id'];
			$data['status']=1;
			$data['isreview']=1; 
			$data['revtime']  = time(); 
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
				$this->log('科室添加'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			}
        }
       
		include T('depart_office_edit'); 
	 }
    /**
     * 添加
     */
    public function addDo(){
        $lang   = Language::getLangContent();
		$pid=$_REQUEST['pid'];
        if (chksubmit()){
            $data = array(); 
          
			$data['rank']      = intval($_POST['rank']); 
			$data['title']      = trim($_POST['title']); 
		
			$data['pic']      = trim($_POST['pic']); 
		
			$data['status']=1;
			$data['edittime']  = time();  
			//var_Dump($this->name);exit;
			$result = M($this->name)->insert($data);
			if ($result){
				$this->log('部门添加'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			}
        }
		include T('depart_class_edit'); 
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
		$pid=$info['pid'];
	
        if (chksubmit()){ 
			$data = array(); 
			$data['rank']      = intval($_POST['rank']); 
			$data['title']      = trim($_POST['title']); 
		
			$data['pic']      = trim($_POST['pic']); 
		
			$data['edittime']  = time();  
			$condition['id'] = intval($_POST['id']); 
		//	var_Dump($data,111,$_POST['id']);exit;
			$result = $model->where($condition)->update($data); 
			if ($result){
				$this->log('部门管理编辑'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
        } 
		include T('depart_class_edit');
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
				$data['isdel']=0;
                $model->where($condition)->update($data); 
            }
            $this->log('删除工作人员'.'[ID:'.implode(',',$_GET['del_id']).']',null);
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
			case 'unstatus':
				$data['status']    = 0;
				$data['edittime']  = time();
				$msg              = "资讯分类设为不显示";
			break;
			case 'status':
				$data['status']    = 1;
				$data['edittime']  = time();
				$msg              = "资讯分类设为显示";
			break;
			case 'unfabu':
				$data['isfabu']    = 0;
				$data['edittime']  = time();
				$msg              = "资讯分类设为会员不可发布";
			break;
			case 'fabu':
				$data['isfabu']    = 1;
				$data['edittime']  = time();
				$msg              = "资讯分类设为会员可发布";
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
