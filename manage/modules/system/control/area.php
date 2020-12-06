<?php
// +----------------------------------------------------------------------
// | Name: 区域管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class areaControl extends SystemControl{

    public function __construct(){
        parent::__construct();
    }

    public function indexDo() {
		$lang = Language::getLangContent();
		include T('area.index');
    }

    public function get_xmlDo() {
        $model_area = M('area');
        $condition  = array();
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = array('like', '%' . $_POST['query'] . '%');
        } else {
            $condition['area_parent_id'] = intval($_GET['parent_id']);
        }
        $list = $model_area->getAreaList($condition,'*','',$_POST['rp']);
        $data = array();
        $data['now_page'] = $model_area->shownowpage();
        $data['total_num'] = $model_area->gettotalnum();
        foreach ($list as $k => $info) {
            $list = array();$operation_detail = '';
            $list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto' onclick=\"fg_delete({$info['area_id']})\"><i class='fa fa-trash-o'></i>删除</a>";
            $operation_detail .= "<li><a href=\"index.php?url=area&do=edit&area_id={$info['area_id']}\">编辑地区</a></li>";
            if ($info['area_deep'] <= 4) {
                $operation_detail .= "<li><a href=\"index.php?url=area&do=add&parent_id={$info['area_id']}\">新增下级</a></li>";
                $operation_detail .= "<li><a href=\"javascript:void(0);\" onclick=\"fg_show_children({$info['area_id']},{$info['area_parent_id']})\">查看下级</a></li>";
            }
            $list['operation'] .= "<span class='btn'><em><i class='fa fa-cog'></i>设置 <i class='arrow'></i></em><ul>{$operation_detail}</ul>";
            $list['area_name'] = $info['area_name'];
            $list['area_region'] = $info['area_region'];
            $list['area_deep'] = $info['area_deep'];
            $list['area_parent_id'] = $info['area_parent_id'];
            $list['status'] = $info['status'] == 0 ? "<span class='no' onclick=\"fg_set({$info['area_id']},'show')\" title='设为显示'><i class='fa fa-ban'></i> 否</span>" : "<span class='yes'  onclick=\"fg_set({$info['area_id']},'unshow')\"  title='取消显示'><i class='fa fa-check-circle'></i> 是</span>";
            $data['list'][$info['area_id']] = $list;
        }
        exit(Tpl::flexigridXML($data));
    }

    public function addDo() {
        $info = array();
        $model_area = M('area');
        if (isset($_GET['parent_id'])) {
            $info = $model_area->getAreaInfo(array('area_id'=>intval($_GET['parent_id'])));
            $data = array();
            $data['area_parent_id'] = $info['area_id'];
            $data['area_deep'] = $info['area_deep']+1;
            $data['area_parent_name'] = $model_area->getTopAreaName($_GET['parent_id']);
			$output['info']=$data;
        }

		$lang = Language::getLangContent();
		include T('area.add');
    }

    public function saveDo() {
        if (!chksubmit()) return ;
        $model_area = M('area');
        $data = array();
        $data['area_name'] = $_POST['area_name'];
        $data['area_region'] = $_POST['area_region'];
        $data['baidumap'] = $_POST['baidumap'];

        if ($_GET['area_id']) {
            $result = $model_area->editArea($data,array('area_id'=>intval($_GET['area_id'])));
        } else {
            $data['area_parent_id'] = $_POST['parent_id'];
            $data['area_deep'] = intval($_POST['area_deep']);


            $result = $model_area->addArea($data);
        }
        if ($result) {
            showMessage('操作成功',$_GET['area_id'] ? 'index.php?url=area' : '');
        } else {
            showMessage('操作失败','','html','error');
        }
    }

    public function editDo() {
		$lang = Language::getLangContent();
        $area_id = intval($_GET['area_id']);
        if ($area_id <= 0) {
            showMessage('参数错误','','html','error');
        }

        $model_area = M('area');
        $info = $model_area->getAreaInfo(array('area_id'=>$area_id));
        if (!$info) {
            showMessage('该地区不存在','','html','error');
        }
        $info['area_parent_name'] = $model_area->getTopAreaName($info['area_parent_id']);
		$output['info']=$info;

		include T('area.edit');

    }

    public function delDo(){
        $model_area = M('area');
        $condition = array();
        if (preg_match('/^[\d,]+$/', $_GET['area_id'])) {
            $area_ids = explode(',',trim($_GET['area_id'],','));
            foreach ($area_ids as $v) {
                $area_ids = array_merge($area_ids,$model_area->getChildrenIDs($v));
            }
            $condition['area_id'] = array('in',$area_ids);
        }else{
            $condition['area_id'] = intval($_GET['area_id']);
        }
        $result = $model_area->delArea($condition);
        if ($result) {
            $this->log('删除地区',1);
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
        }
        exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
    }

    /**
     * 设置操作
     */
    public function setDo() {
        $data =$condition= array();
        $condition['area_id'] = intval($_GET['area_id']);
        switch ($_GET['branch']){
            case 'unshow':
                $data['status']    = 0;
                $msg              = "地区取消显示";
            break;
            case 'show':
                $data['status']    = 1;
                $msg              = "地区设为显示";
            break; 
        }
        $result =M('area')->where($condition)->update($data);
        if($result){
        $this->log($msg.'[ID:'.$_GET['area_id'].']',null);
             exit(json_encode(array('state'=>true,'msg'=>'操作成功')));
        }else{
             exit(json_encode(array('state'=>false,'msg'=>'操作失败')));
        }
    }
}