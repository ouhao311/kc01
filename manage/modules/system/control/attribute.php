<?php
// +----------------------------------------------------------------------
// | Name: 顶级属性管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:Haiping
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class attributeControl extends SystemControl{
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

        $pid = $_GET['pid'];

        include T($this->name);
    }

    /**
     * 异步调用列表
     */
    public function get_xmlDo(){

        $model = M($this->name);

        $condition = array();

        $pid = $_GET['cid'];

        if (empty($pid)){

            $condition['pid'] = 0;
        }else{

            $condition['pid'] = $pid;
        }

        // print_r($condition['pid']);

        list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
        $list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
        $data = array();
        $data['now_page'] = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($list as $k => $v) {
            $list = array();$operation_detail = '';


            $list['rank'] = "<span title='".$v['rank']."'>".$v['rank']."</span>";
            $list['title'] = "<span title='".$v['title']."'>".$v['title']."</span>";
            $list['value'] = "<span title='".$v['value']."'>".$v['value']."</span>";

			 $list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto' onclick=\"fg_delete({$v['id']})\"><i class='fa fa-trash'></i>删除</a>";

            $operation_detail .= "<li><a href=\"index.php?url=attribute&do=edit&id={$v['id']}\">编辑功能</a></li>";
            $operation_detail .= "<li><a href=\"index.php?url=attribute_sec&do=add&pid={$v['id']}\">新增下级</a></li>";
            $operation_detail .= "<li><a href=\"index.php?url=attribute_sec&do=index&pid={$v['id']}\">查看下级</a></li>";

            $list['operation'] .= "<span class='btn'><em><i class='fa fa-cog'></i>设置 <i class='arrow'></i></em><ul>{$operation_detail}</ul>";

            $data['list'][$v['id']] = $list;
        }
        exit(Tpl::flexigridXML($data));

    }


    /**
     * 添加
     */
    public function addDo(){
        $lang   = Language::getLangContent();

        $pid = $_GET['pid'];

        if (chksubmit()){

            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["title"], "require"=>"true", "message"=>"属性名称不能为空"),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $data = array();
                $data['title']      = trim($_POST['title']);
                $data['rank']       = intval($_POST['rank']);
                $data['value']      = trim($_POST['value']);
                $result = M($this->name)->insert($data);
                if ($result){

                    $this->log('添加顶级属性',null);
                    showMessage("操作成功",'?url='.$this->name);
                }else {
                    showMessage('操作失败');
                }
            }
        }
        include T('attribute_edit');

    }

    /**
     * 编辑
     */
    public function editDo(){
        $lang    = Language::getLangContent();
        $model=M($this->name);
        if (chksubmit()){

            $obj_validate = new Validate();
            $obj_validate->validateparam = array(

                array("input"=>$_POST["title"], "require"=>"true", "message"=>"属性名称不能为空"),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }else {
                $data = array();
                $data['title']    = trim($_POST['title']);
                $data['rank']     = intval($_POST['rank']);
                $data['value']    = trim($_POST['value']);
                $condition['id']  = intval($_POST['id']);

                $result = $model->where($condition)->update($data);

                if ($result){

                    $this->log('编辑顶级属性',null);

                    showMessage("操作成功",'?url='.$this->name);
                }else {
                    showMessage('操作失败');
                }
            }
        }

        $condition['id'] = intval($_GET['id']);

        $info = $model->where($condition)->find();

        if (empty($info)){

                 showMessage('没有找到此信息','index.php?url='.$this->name);
             }
        include T('attribute_edit');
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

                $model->where($condition)->delete();
            }

            $this->log('删除属性',null);
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));

        } else {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
    }


    /**
     * 封装公共代码
     */
    private function _get_condition($condition) {

        if ($_REQUEST['query'] != '' && in_array($_REQUEST['qtype'],array('number','name'))) {
            $condition[$_REQUEST['qtype']] = array('like',"%{$_REQUEST['query']}%");
        }

        $sort_fields = array('id','need_price','need_acreage','communicate','status','lutime');
        if ($_REQUEST['sortorder'] != '' && in_array($_REQUEST['sortname'],$sort_fields)) {
            $order = $_REQUEST['sortname'].' '.$_REQUEST['sortorder'];
        }
        return array($condition,$order);
    }

}