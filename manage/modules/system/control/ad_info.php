<?php
// +----------------------------------------------------------------------
// | Name: 广告内容管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class ad_infoControl extends SystemControl{
    public $name;
    public function __construct(){
        parent::__construct();
        $this->name=getUrl(__CLASS__);
    }
    /**
     * 广告内容列表管理
     */
    public function indexDo() {
           header("Content-Security-Policy: upgrade-insecure-requests");
        $lang = Language::getLangContent();

        $id = $_GET['id'];

        include T($this->name);
    }
    /**
     * 异步调用列表
     */
    public function get_xmlDo(){
         header("Content-Security-Policy: upgrade-insecure-requests");
        $class=getval('ad_position');
        $model = M('ad_info');
        $condition = array();
        list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
        if(!empty($_GET['id'])){
            $condition['pid'] = $_GET['id'];
        }
        $list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
        $data = array();
        $data['now_page'] = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($list as $k => $v) {
            $list = array();
            $list['rank'] = "<span title='".$v['rank']."'>".$v['rank']."</span>";
            $list['title'] = "<span title='".$v['title']."'>".$v['title']."</span>";
			if($v['pic']){
                $list['pic'] = "<a class='pic-thumb-tip' onmouseover=\"toolTip('<img src=".$v['pic'].">')\" onmouseout='toolTip()' href='javascript:void(0);'> <i class='fa fa-picture-o'></i></a>";
            }else{
                $list['pic'] ="暂无缩略图";
            }
			if($v['wappic']){
                $list['wappic'] = "<a class='pic-thumb-tip' onmouseover=\"toolTip('<img src=".$v['wappic'].">')\" onmouseout='toolTip()' href='javascript:void(0);'> <i class='fa fa-picture-o'></i></a>";
            }else{
                $list['wappic'] ="暂无手机端缩略图";
            }
            $list['pname'] = "<span title='".$class[$v['pid']]."'>".$class[$v['pid']]."</span>";
            $list['status'] = $v['status'] == 0 ? "<span class='no' onclick=\"fg_set({$v['id']},'show')\" title='设为显示'><i class='fa fa-ban'></i> 否</span>" : "<span class='yes'  onclick=\"fg_set({$v['id']},'unshow')\"  title='取消显示'><i class='fa fa-check-circle'></i> 是</span>";
            $list['edittime'] = $v['edittime']?date('Y-m-d H:i:s',$v['edittime']):'-';
            $list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='javascript:void(0)' onclick='fg_edit(".$v['id'].")'><i class='fa fa-pencil-square-o'></i> 编辑</a>"; 
            $list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto' href='javascript:void(0)' onclick=\"fg_delete({$v['id']})\"><i class='fa fa-trash'></i> 删除</a>"; 
            $data['list'][$v['id']] = $list;
        }
        exit(Tpl::flexigridXML($data));
    }
    /**
     * 广告内容添加
     */
    public function addDo(){
         header("Content-Security-Policy: upgrade-insecure-requests");
        $lang   = Language::getLangContent();
        $ad_class = Db::getAll("SELECT * FROM ".DBPRE."ad_position ORDER by rank asc "); 
        $model = M('ad_info');
        $info['pid'] = $_GET['pid'];
		$classinfo=getTableInfohanett($info['pid'],'ad_position');
        if (chksubmit()){
            //验证
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["title"], "require"=>"true", "message"=>"请填写广告标题"),
                array("input"=>$_POST["pid"], "require"=>"true", "message"=>"请选择广告位"),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $data = array();
                $data['pid']      = intval($_POST['pid']);
                $data['rank']    = trim($_POST['rank']);
                $data['title']    = trim($_POST['title']);
                $data['intro']    = trim($_POST['intro']);
                $data['url']      = trim($_POST['url']);
                $data['edittime']  = time();
                $data['pic']      = trim($_POST['pic']); 
                $data['wappic']      = trim($_POST['wappic']); 
                $data['status']   = trim($_POST['status']); 
                $data['status']=1;    
                $result = M($this->name)->insert($data); 
                if ($result){
                    $this->log('广告内容添加',null);
                    echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功');</script>";
                    exit(); 
                }else {
                    echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
                    exit();  
                }
            }
        } 
        include T('ad_info_edit');
    } 
    /**
     * 广告内容编辑
     */
    public function editDo(){
           header("Content-Security-Policy: upgrade-insecure-requests");
        $lang    = Language::getLangContent();
        $ad_class = Db::getAll("SELECT * FROM ".DBPRE."ad_position ORDER by rank asc "); 
        $model=M($this->name);
		$condition['id'] = intval($_GET['id']);
	    $info = $model->where($condition)->find();
		if (empty($info)){
			echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('没有找到此信息');</script>";
			exit(); 
		}
		$classinfo=getTableInfohanett($info['pid'],'ad_position');
        if (chksubmit()){
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["title"], "require"=>"true", "message"=>"请填写广告标题"),
                array("input"=>$_POST["pid"], "require"=>"true", "message"=>"请选择广告位"),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $data = array();
                $data['pid']      = intval($_POST['pid']);
                $data['rank']    = trim($_POST['rank']);
                $data['title']    = trim($_POST['title']);
                $data['intro']    = trim($_POST['intro']);
                $data['url']      = trim($_POST['url']);
                $data['edittime']  = time();
                $data['pic']      = trim($_POST['pic']);
                $data['wappic']      = trim($_POST['wappic']); 
                $condition['id'] = intval($_POST['id']);
                $result = $model->where($condition)->update($data);
                if ($result){
					echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作成功')</script>";
					exit();
				}else {
					echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
					exit();
				}
			}
		} 
		include T('ad_info_edit');
    }

    /**
     * 广告内容删除
     */
     public function delDo() {
          header("Content-Security-Policy: upgrade-insecure-requests");
        $model=M('ad_info');
        if (preg_match('/^[\d,]+$/', $_GET['del_id'])) {
            $_GET['del_id'] = explode(',',trim($_GET['del_id'],','));
            foreach ($_GET['del_id'] as $k => $v){
                $condition = array();
                $condition['id']=intval($v);
                $model->where($condition)->delete();
            }
            $this->log('删除广告内容',null);           
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
    }
    /**
     * 设置操作
     */
    public function setDo() {
 header("Content-Security-Policy: upgrade-insecure-requests");
        $data =$condition= array();
        $condition['id'] = intval($_GET['id']);
        switch ($_GET['branch']){
            case 'unshow':
                $data['status']    = 0;
                $data['edittime']  = time();
                $msg              = "广告取消显示";
            break;
            case 'show':
                $data['status']    = 1;
                $data['edittime']  = time();
                $msg              = "广告设为显示";
            break; 
        }
        $result =M('ad_info')->where($condition)->update($data);
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
 header("Content-Security-Policy: upgrade-insecure-requests");
        if ($_GET['title'] != '') {
            $condition['title']            = array('like',"%{$_GET['title']}%");
        }

        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['kaishi']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['jieshu']);
        $start_unixtime = $if_start_time ? strtotime($_GET['kaishi']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['jieshu']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['edittime'] = array('time',array($start_unixtime,$end_unixtime));
        }
        $sort_fields = array('id','pid','rank','edittime');
        if ($_REQUEST['sortorder'] != '' && in_array($_REQUEST['sortname'],$sort_fields)) {
            $order = $_REQUEST['sortname'].' '.$_REQUEST['sortorder'];
        }
        return array($condition,$order);
    }
}