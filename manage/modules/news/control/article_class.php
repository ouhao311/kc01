<?php
// +----------------------------------------------------------------------
// | Name: 资讯分类
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class article_classControl extends SystemControl{
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
			$condition['pid'] = $_REQUEST['pid'];
		}else{
			$condition['pid'] = 0;
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
			$list['title'] = "<span title='".$v['title']."'>".$v['title']."</span>"; 
			if($v['pic']){
				$list['pic'] = "<a class='pic-thumb-tip' onmouseover=\"toolTip('<img src=".$v['pic'].">')\" onmouseout='toolTip()' href='javascript:void(0);'> <i class='fa fa-picture-o'></i></a>";
			}else{
				$list['pic'] ="暂无图片";
			}
			$list['isfabu'] = $v['isfabu'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'fabu')\" title='设为可发布'><i class='fa fa-ban'></i> 否</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unfabu')\"  title='取消可发布'><i class='fa fa-check-circle'></i> 是</span>";
			$list['status'] = $v['status'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'status')\" title='设为显示'><i class='fa fa-ban'></i> 设为不显示</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unstatus')\"  title='设为不显示'><i class='fa fa-check-circle'></i> 显示</span>";  
			$list['edittime'] = $v['edittime']?date('Y-m-d H:i:s',$v['edittime']):'-'; 
			$list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='javascript:void(0)' onclick='fg_edit(".$v['id'].")'><i class='fa fa-edit'></i> 编辑</a>";
			if(empty($v['pid'])){
				$list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='javascript:void(0)' onclick='fg_addson(".$v['id'].")'><i class='fa fa-pencil-square-o'></i> 新增下级</a>"; 
				$list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='?url=".$this->name."&pid=".$v['id']."' ><i class='fa fa-pencil-square-o'></i> 下级分类</a>"; 
			}else{
				$list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='?url=".$this->name."&pid=0' ><i class='fa fa-pencil-square-o'></i> 上级分类</a>"; 
			}
			$list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='?url=article_list&pid=".$v['id']."' ><i class='fa fa-list'></i> 内容</a>"; 
            $data['list'][$v['id']] = $list;
        }
        exit(Tpl::flexigridXML($data));

    }
	 
    /**
     * 添加
     */
    public function addDo(){
        $lang   = Language::getLangContent();
		$pid=$_REQUEST['pid'];
        if (chksubmit()){
            $data = array(); 
			$data['pid']      = intval($_POST['pid']); 
			$data['rank']      = intval($_POST['rank']); 
			$data['title']      = trim($_POST['title']); 
			$data['en_title']      = trim($_POST['en_title']);
			$data['cate'] =trim($_POST['cate']);
			$data['templist']      = intval($_POST['templist']); 
			$data['pic']      = trim($_POST['pic']); 
			$data['seo_title']      = trim($_POST['seo_title']);
			$data['seo_keywords']      = trim($_POST['seo_keywords']);
			$data['seo_description']      = trim($_POST['seo_description']); 
			$data['status']=1;
			$data['edittime']  = time(); 
		//	var_Dump($data,333,$_POST);exit;
			$result = M($this->name)->insert($data);
			if ($result){
				$this->log('资讯分类添加'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			}
        }
		include T('article_class_edit'); 
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
		//所有一级分类
		$article_class = M("article_class")->where(array("pid"=>0,"isdel"=>0))->order('rank asc')->select();
        if (chksubmit()){ 
			$data = array(); 
			$data['pid']      = intval($_POST['pid']); 
			$data['rank']      = intval($_POST['rank']); 
			$data['title']      = trim($_POST['title']); 
			$data['en_title']      = trim($_POST['en_title']);
			$data['templist']      = intval($_POST['templist']); 
			$data['pic']      = trim($_POST['pic']); 
			$data['cate'] =trim($_POST['cate']);
			$data['seo_title']      = trim($_POST['seo_title']);
			$data['seo_keywords']      = trim($_POST['seo_keywords']);
			$data['seo_description']      = trim($_POST['seo_description']);  
			$data['edittime']  = time();  
			$condition['id'] = intval($_POST['id']); 
			$result = $model->where($condition)->update($data); 
			if ($result){
				$this->log('资讯分类编辑'.'['.$data['title'].']',null);
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
				exit();
			}else {
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			} 
        } 
		include T('article_class_edit');
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
            $this->log('删除资讯分类'.'[ID:'.implode(',',$_GET['del_id']).']',null);
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
