<?php
// +----------------------------------------------------------------------
// | Name: 权限管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class adminControl extends SystemControl{
    private $links = array(
        array('url'=>'url=admin&do=admin','lang'=>'limit_admin'),
        array('url'=>'url=admin&do=gadmin','lang'=>'limit_gadmin'),
    );
    public function __construct(){
        parent::__construct();
        Language::read('admin');
    }

    public function indexDo() {
        $this->adminDo();
    }

    /**
     * 管理员列表
     */
    public function adminDo(){
		$lang = Language::getLangContent();
        $model = M();
        $admin_list = $model->table('admin,gadmin')->join('left join')->on('gadmin.gid=admin.admin_gid')->limit(200)->select();
        $page=$model->showpage();
        $top_link=$this->sublink($this->links,'admin');
		include T('admin.index');

    }

    /**
     * 管理员删除
     */
    public function admin_delDo(){
        if (!empty($_GET['admin_id'])){
            if ($_GET['admin_id'] == 1){
                showMessage(L('hx_common_save_fail'));
            }
            M()->table('admin')->where(array('admin_id'=>intval($_GET['admin_id'])))->delete();
            $this->log(L('hx_delete,limit_admin').'[ID:'.intval($_GET['admin_id']).']',1);
            showMessage(L('hx_common_del_succ'));
        }else {
            showMessage(L('hx_common_del_fail'));
        }
    }

    /**
     * 管理员添加
     */
    public function admin_addDo(){
		$lang = Language::getLangContent();
        if (chksubmit()){
            $limit_str = '';
            $model_admin = M('admin');
            $param['admin_name'] = $_POST['admin_name'];

			$param['admin_username'] = trim($_POST['admin_username']);
			$param['admin_bumen'] = trim($_POST['admin_bumen']);
			$param['admin_zhiwu'] = trim($_POST['admin_zhiwu']);
			$param['admin_tel'] = trim($_POST['admin_tel']);


			//$param['czlb']=rtrim($param['czlb'], ",");

            $param['admin_gid'] = $_POST['gid'];
            $param['admin_password'] = md5($_POST['admin_password']);
            $rs = $model_admin->addAdmin($param);
            if ($rs){
                $this->log(L('hx_add,limit_admin').'['.$_POST['admin_name'].']',1);
                showMessage(L('hx_common_save_succ'),'index.php?url=admin&do=admin');
            }else {
                showMessage(L('hx_common_save_fail'));
            }
        }

        //得到权限组
        $gadmin = M('gadmin')->field('gname,gid')->select();

        $top_link=$this->sublink($this->links,'admin_add');
        $limit=$this->permission();
		include T('admin.add');
    }

    /**
     * ajax操作
     */
    public function ajaxDo(){
        switch ($_GET['branch']){
            //管理人员名称验证
            case 'check_admin_name':
                $model_admin = M('admin');
                $condition['admin_name'] = $_GET['admin_name'];
                $list = $model_admin->infoAdmin($condition);
                if (!empty($list)){
                    exit('false');
                }else {
                    exit('true');
                }
                break;
            //权限组名称验证
            case 'check_gadmin_name':
                $condition = array();
                if (is_numeric($_GET['gid'])){
                    $condition['gid'] = array('neq',intval($_GET['gid']));
                }
                $condition['gname'] = $_GET['gname'];
                $info = M('gadmin')->where($condition)->find();
                if (!empty($info)){
                    exit('false');
                }else {
                    exit('true');
                }
                break;
        }
    }

    /**
     * 设置管理员权限
     */
    public function admin_editDo(){
		$lang = Language::getLangContent();
        if (chksubmit()){
            //没有更改密码
            if ($_POST['new_pw'] != ''){
                $data['admin_password'] = md5($_POST['new_pw']);
            }
			$data['admin_username'] = trim($_POST['admin_username']);
			$data['admin_bumen'] = trim($_POST['admin_bumen']);
			$data['admin_zhiwu'] = trim($_POST['admin_zhiwu']);
			$data['admin_tel'] = trim($_POST['admin_tel']);
            $data['admin_id'] = intval($_GET['admin_id']);
            $data['admin_gid'] = intval($_POST['gid']);


			//$data['czlb']=rtrim($data['czlb'], ",");


            //查询管理员信息
            $admin_model = M('admin');
            $result = $admin_model->updateAdmin($data);
            if ($result){

                $this->log(L('hx_edit,limit_admin').'[ID:'.intval($_GET['admin_id']).']',1);

                showMessage(Language::get('admin_edit_success'),'index.php?url=admin&do=admin');
            }else{
                showMessage(Language::get('admin_edit_fail'),'index.php?url=admin&do=admin');
            }
        }else{
            //查询用户信息
            $admin_model = M('admin');
            $admininfo = $admin_model->getOneAdmin(intval($_GET['admin_id']));
            if (!is_array($admininfo) || count($admininfo)<=0){
                showMessage(Language::get('admin_edit_admin_error'),'index.php?url=admin&do=admin');
            }
            $top_link=$this->sublink($this->links,'admin');

            //得到权限组
            $gadmin = M('gadmin')->field('gname,gid')->select();
			include T('admin.edit');
        }
    }

    /**
     * 取得所有权限项
     *
     * @return array
     */
    private function permission() {
              return H('admin_menu');
    }

    /**
     * 权限组
     */
    public function gadminDo(){
		$lang = Language::getLangContent();
        $model = M('gadmin');
        if (chksubmit()){
            if (@in_array(1,$_POST['del_id'])){
                showMessage(L('admin_index_not_allow_del'));
            }

            if (!empty($_POST['del_id'])){
                if (is_array($_POST['del_id'])){
                    foreach ($_POST['del_id'] as $k => $v){
                        $model->where(array('gid'=>intval($v)))->delete();
                    }
                }
                $this->log(L('hx_delete,limit_gadmin').'[ID:'.implode(',',$_POST['del_id']).']',1);
                showMessage(L('hx_common_del_succ'));
            }else {
                showMessage(L('hx_common_del_fail'));
            }
        }
        $list = $model->limit(100)->select();
        $page=$model->showpage();

        $top_link=$this->sublink($this->links,'gadmin');
        //var_Dump($array);exit;
		include T('gadmin.index');

    }

    /**
     * 添加权限组
     */
    public function gadmin_addDo(){
		$lang = Language::getLangContent();
        if (chksubmit()){
            $model = M('gadmin');

            $data['limits'] = encrypts(serialize($_POST['permission']),MD5_KEY.md5($_POST['gname']));

            $data['gname'] = $_POST['gname'];
            if ($model->insert($data)){
                $this->log(L('hx_add,limit_gadmin').'['.$_POST['gname'].']',1);
                showMessage(L('hx_common_save_succ'),'index.php?url=admin&do=gadmin');
            }else {
                showMessage(L('hx_common_save_fail'));
            }
        }
        $top_link=$this->sublink($this->links,'gadmin_add');
        $limit=$this->permission();
		include T('gadmin.add');
    }

    /**
     * 设置权限组权限
     */
    public function gadmin_editDo(){
		$lang = Language::getLangContent();
        $model = M('gadmin');
        $gid = intval($_GET['gid']);

        $ginfo = $model->getby_gid($gid);
        if (empty($ginfo)){
            showMessage(L('admin_set_admin_not_exists'));
        }
        if (chksubmit()){
            $limit_str = '';


            $limit_str = encrypts(serialize($_POST['permission']),MD5_KEY.md5($_POST['gname']));
            $data['limits'] = $limit_str;
            $data['gname']  = $_POST['gname'];



            $update = $model->where(array('gid'=>$gid))->update($data);
            if ($update){
                $this->log(L('hx_edit,limit_gadmin').'['.$_POST['gname'].']',1);
                showMessage(L('hx_common_save_succ'),'index.php?url=admin&do=gadmin');
            }else {
                showMessage(L('hx_common_save_succ'));
            }
        }

        //解析已有权限
        $hlimit = decrypt($ginfo['limits'],MD5_KEY.md5($ginfo['gname']));
        $ginfo['limits'] = unserialize($hlimit);

        $limit=$this->permission();
        //var_dump($limit);exit;
        $top_link=$this->sublink($this->links,'gadmin');
		include T('gadmin.edit');

    }

    /**
     * 组删除
     */
    public function gadmin_delDo(){
        if (is_numeric($_GET['gid'])){
            M('gadmin')->where(array('gid'=>intval($_GET['gid'])))->delete();
            $this->log(L('hx_delete,limit_gadmin').'[ID'.intval($_GET['gid']).']',1);
            showMessage(Language::get('hx_common_op_succ'),'index.php?url=admin&do=gadmin');
        }else {
            showMessage(L('hx_common_op_fail'));
        }
    }
}
