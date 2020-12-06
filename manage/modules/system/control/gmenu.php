<?php
// +----------------------------------------------------------------------
// | Name: 区域管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class gmenuControl extends SystemControl{

    public function __construct(){
        parent::__construct();
    }

    public function indexDo() {
		$lang = Language::getLangContent();
		include T('gmenu.index');
    }

    public function get_xmlDo() {
        $model_area = M('gmenu');
        $condition  = array();
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = array('like', '%' . $_POST['query'] . '%');
        }

		$condition['pid'] = intval($_GET['pid']);
      
        $list = $model_area->getList($condition,'*','',$_POST['rp']);
        $data = array();
        $data['now_page'] = $model_area->shownowpage();
        $data['total_num'] = $model_area->gettotalnum();
        foreach ($list as $k => $info) {
            $list = array();$operation_detail = '';
            $list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto' onclick=\"fg_delete({$info['id']})\"><i class='fa fa-trash-o'></i>删除</a>";
            $operation_detail .= "<li><a href=\"index.php?url=gmenu&do=edit&id={$info['id']}\">编辑功能</a></li>";
            if ($info['area_deep'] <= 3) {
                $operation_detail .= "<li><a href=\"index.php?url=gmenu&do=add&pid={$info['id']}\">新增下级</a></li>";
                $operation_detail .= "<li><a href=\"javascript:void(0);\" onclick=\"fg_show_children({$info['id']},{$info['pid']})\">查看下级</a></li>";
            }
            $list['operation'] .= "<span class='btn'><em><i class='fa fa-cog'></i>设置 <i class='arrow'></i></em><ul>{$operation_detail}</ul>";
            $list['uname'] = $info['uname'];
            $list['code'] = $info['code'];

			$list['list'] = $info['list'];
			$vv= array();
			$vv=explode(',',$info["power"]);

			if(in_array('all', $vv)){
			$list['view'] ="<i class='ok'></i>";
			$list['add'] ="<i class='ok'></i>";
			$list['edit'] = "<i class='ok'></i>";
			$list['del'] = "<i class='ok'></i>";
			$list['shenhe'] = "<i class='ok'></i>"; 
			$list['progress'] = "<i class='ok'></i>";
			$list['topshenhe'] = "<i class='ok'></i>";
			$list['all'] = "<i class='all'></i>";
		
			}else{
			$list['view'] =in_array('view', $vv)?"<i class='ok'></i>":"";
			$list['add'] =in_array('add', $vv)?"<i class='ok'></i>":"";
			$list['edit'] = in_array('edit', $vv)?"<i class='ok'></i>":"";
			$list['del'] = in_array('del', $vv)?"<i class='ok'></i>":"";
			$list['shenhe'] = in_array('shenhe', $vv)?"<i class='ok'></i>":""; 
			$list['progress'] = in_array('progress', $vv)?"<i class='ok'></i>":"";
			$list['topshenhe'] = in_array('topshenhe', $vv)?"<i class='ok'></i>":""; 
		 
			$list['all'] ="";
		
			}




            $data['list'][$info['id']] = $list;
        }
        exit(Tpl::flexigridXML($data));
    }

    public function addDo() {
        $info = array();
        $model_area = M('gmenu');
        if (isset($_GET['pid'])) {
            $info = $model_area->getInfo(array('id'=>intval($_GET['pid'])));

            $data = array();
            $data['pid'] = $info['id'];
			$data['pname'] = $info['uname'];
			$output['info']=$data;

        }
		$lang = Language::getLangContent();
		include T('gmenu.edit');
    }

    public function saveDo() {
        if (!chksubmit()) return ;
        $model_area = M('gmenu');
        $data = array();
        $data['uname'] = $_POST['uname'];
        $data['code'] = $_POST['code'];
		$data['list'] = $_POST['list'];
		$data['ico'] = $_POST['ico'];

		$ps="";
		if($_POST['view']){
			$ps.="view,";
		}
		if($_POST['add']){
					$ps.="add,";
		}
		if($_POST['edit']){
					$ps.="edit,";
		}
		if($_POST['del']){
					$ps.="del,";
		}

		if($_POST['shenhe']){
					$ps.="shenhe,";
		} 
		
			if($_POST['topshenhe']){
					$ps.="topshenhe,";
		} 
		
		if($_POST['progress']){
					$ps.="progress,";
		} 

		if($_POST['all']){
					$ps.="all,";
		}


		$data['power'] = rtrim($ps,',');

        if ($_GET['id']) {
            $result = $model_area->edit($data,array('id'=>intval($_GET['id'])));
        } else {
            $data['pid'] = $_POST['pid'];
            $result = $model_area->add($data);
        }
        if ($result) {
			//更新缓存
			H('admin_menu',true);
            showMessage('操作成功','index.php?url=gmenu&pid='.$_POST['pid']);
        } else {
            showMessage('操作失败','','html','error');
        }
    }

    public function editDo() {
		$lang = Language::getLangContent();
        $id = intval($_GET['id']);
        if ($id <= 0) {
            showMessage('参数错误','','html','error');
        }

        $model_area = M('gmenu');
        $info = $model_area->getInfo(array('id'=>$id));
        if (!$info) {
            showMessage('该功能不存在','','html','error');
        }

		$pinfo = $model_area->getInfo(array('id'=>intval($info['pid'])));
		$info["pname"]=$pinfo["uname"];
		$output['info']=$info;
		$vv= array();
		$vv=explode(',',$info["power"]);
		$info['view'] =in_array('view', $vv)?true:false;
		$info['add'] =in_array('add', $vv)?true:false;
		$info['edit'] = in_array('edit', $vv)?true:false;
		$info['del'] = in_array('del', $vv)?true:false;
		$info['shenhe'] = in_array('shenhe', $vv)?true:false; 
		$info['progress'] = in_array('progress', $vv)?true:false; 
		$info['topshenhe'] = in_array('topshenhe', $vv)?true:false; 
		$info['all'] =in_array('all', $vv)?true:false;

		include T('gmenu.edit');

    }

    public function delDo(){
        $model_area = M('gmenu');
        $condition = array();
        if (preg_match('/^[\d,]+$/', $_GET['id'])) {
            $area_ids = explode(',',trim($_GET['id'],','));


            foreach ($area_ids as $v) {
                $area_ids = array_merge($area_ids,$model_area->getChildrenIDs($v));
            }
            $condition['id'] = array('in',$area_ids);
        }else{
            $condition['id'] = intval($_GET['id']);
        }


        $result = $model_area->del($condition);
        if ($result) {
           			//更新缓存
			H('admin_menu',true);
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
        }
        exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
    }

}