<?php
// +----------------------------------------------------------------------
// | Name: 次级属性管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:Haiping
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class attribute_secControl extends SystemControl{
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

        $resultname = M('attribute')->where('id='.$pid)->select();

        // 把该次级属性所属的顶级属性名分配到前端
        $pidname = $resultname['0']['title'];  

        include T($this->name);
    }

    /**
     * 异步调用列表
     */
    public function get_xmlDo(){

        $model = M('attribute');
        $condition = array();
        $pid = $_GET['cid'];          
        $condition['pid'] = $pid;

        list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
        $list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
        $data = array();
        $data['now_page'] = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($list as $k => $v) {
            $list = array();$operation_detail = '';

            $list['operation'] = "<a class='layui-btn layui-btn-sm layui-btn-auto2' href='index.php?url=attribute_sec&do=edit&id={$v['id']}'><i class='fa fa-pencil-square-o'></i>编辑</a>";

            $list['operation'] .= "<a class='layui-btn layui-btn-sm layui-btn-auto' onclick=\"fg_delete({$v['id']})\"><i class='fa fa-trash'></i>删除</a>";
            $resultname = M('attribute')->where('id='.$v['pid'])->select();
            $pidname = $resultname['0']['title'];

            $list['rank'] = "<span title='".$v['rank']."'>".$v['rank']."</span>";
            $list['title'] = "<span title='".$v['title']."'>".$v['title']."</span>";
            $list['value'] = "<span title='".$v['value']."'>".$v['value']."</span>";
            $list['code'] = "<span title='".$v['code']."'>".$v['code']."</span>";
            $list['pid'] = "<span title='".$pidname."'>".$pidname."</span>";
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

        $resultname = M('attribute')->where('id='.$pid)->select();
        // 把该次级属性所属的顶级属性名分配到前端
        $pidname = $resultname['0']['title'];  

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
                $data['title']   = trim($_POST['title']);
                $data['rank']    = intval($_POST['rank']);
                $data['pid']     = intval($_POST['pid']);
                $data['value']   = trim($_POST['value']);
                $data['code']    = trim($_POST['code']);

                $result = M('attribute')->insert($data);
                if ($result){

                    $this->log('添加次级属性',null);
                    showMessage("操作成功",'?url='.$this->name."&pid=".$pid);
                }else {
                    showMessage('操作失败');
                }
            }
        }
        include T('attribute_sec_edit');

    }

    /**
     * 编辑
     */
    public function editDo(){

        // $pid = $_GET['pid'];

        $id = $_GET['id'];

        $resultname = M('attribute')->where('id='.$id)->select();
        // 把该次级属性所属的顶级属性名分配到前端
        $pid = $resultname['0']['pid'];  

        $resultnames = M('attribute')->where('id='.$pid)->select();

        $pidname = $resultnames['0']['title'];  

        $lang    = Language::getLangContent();

        $model=M('attribute');

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
                $data['pid']      = intval($_POST['pid']);
                $data['title']    = trim($_POST['title']);
                $data['rank']    = intval($_POST['rank']);
                $data['value']   = trim($_POST['value']);
                $data['code']    = trim($_POST['code']);
                $condition['id'] = intval($_GET['id']);

                $result = $model->where($condition)->update($data);

                if ($result){

                    $this->log('编辑次级属性',null);

                    showMessage("操作成功",'?url='.$this->name."&pid=".$pid);
                }else {
                    showMessage('操作失败');
                }
            }
        }

        $condition['id'] = intval($_GET['id']);

        $info = $model->where($condition)->find();

        if (empty($info)){

                 showMessage('没有找到此信息','index.php?url='.$this->name."&pid=".$pid);
             }
        include T('attribute_sec_edit');
    }
    /**
     * 删除
     */

    public function delDo() {

        $model=M('attribute');

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