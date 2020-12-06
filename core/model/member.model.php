<?php
// +----------------------------------------------------------------------
// | Name: 会员模型
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class memberModel extends Model {



    public function __construct(){

        parent::__construct('member');

    }



    /**

     * 会员详细信息（查库）

     * @param array $condition

     * @param string $field

     * @return array

     */

    public function getMemberInfo($condition, $field = '*', $master = false) {
		$condition['isdel']=0;
        return $this->table('member')->field($field)->where($condition)->master($master)->find();

    }



    /**
     * 取得会员详细信息（优先查询缓存）
     * 如果未找到，则缓存所有字段
     * @param int $member_id
     * @param string $field 需要取得的缓存键值, 例如：'*','member_name,member_sex'
     * @return array
     */

    public function getMemberInfoByID($member_id, $fields = '*') {



        $member_info = $this->getMemberInfo(array('id'=>$member_id),'*',true);
        return $member_info;

    }



    /**

     * 会员列表

     * @param array $condition

     * @param string $field

     * @param number $page

     * @param string $order

     */

    public function getMemberList($condition = array(), $field = '*', $page = null, $order = 'id desc', $limit = '') {

       return $this->table('member')->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();

    }

	    /**

     * 会员列表

     * @param array $condition

     * @param string $field

     * @param number $page

     * @param string $order

     */

    public function getMembersList($condition, $page = null, $order = 'id desc', $field = '*') {

       return $this->table('member')->field($field)->where($condition)->page($page)->order($order)->select();

    }






    /**

     * 会员数量

     * @param array $condition

     * @return int

     */

    public function getMemberCount($condition) {

        return $this->table('member')->where($condition)->count();

    }


/**

	 * 删除会员

	 *

	 * @param int $id 记录ID

	 * @return array $rs_row 返回数组形式的查询结果

	 */

	public function del($id){

		if (intval($id) > 0){

			$where = " id = '". intval($id) ."'";

			$result = Db::delete('member',$where);

			return $result;

		}else {

			return false;

		}

	}

    /**

     * 编辑会员

     * @param array $condition

     * @param array $data

     */

    public function editMember($condition, $data) {

        $update = $this->table('member')->where($condition)->update($data);



        return $update;

    }



    /**

     * 登录时创建会话SESSION

     *

     * @param array $member_info 会员信息

     */

    public function createSession($member_info = array(),$reg = false) {

        if (empty($member_info) || !is_array($member_info)) return ;



        $_SESSION['is_login']   = '1';

        $_SESSION['member_id']  = $member_info['id'];

        $_SESSION['member_name']= $member_info['username'];

        $_SESSION['member_email']= $member_info['email'];

        $_SESSION['member_mobile']= $member_info['mobile'];

        $_SESSION['avatar']     = $member_info['avatar'];

		$_SESSION['member_truename'] = $member_info['truename'];





        // 头衔COOKIE

        $this->set_avatar_cookie();


        if (trim($member_info['qqopenid'])){

            $_SESSION['openid']     = $member_info['qqopenid'];

        }

        if (trim($member_info['sinaopenid'])){

            $_SESSION['slast_key']['uid'] = $member_info['sinaopenid'];

        }



        if(!empty($member_info['login_time'])) {

            $update_info    = array(

                'login_num'=> ($member_info['login_num']+1),

                'login_time'=> TIMESTAMP,

                'login_ip'=> getIp()


            );

            $this->editMember(array('id'=>$member_info['id']),$update_info);

        }


        // 自动登录

        if ($member_info['auto_login'] == 1) {

            $this->auto_login();

        }

    }



    /**

     * 7天内自动登录

     */

    public function auto_login() {

        // 自动登录标记 保存7天

        setXwCookie('auto_login', encrypts($_SESSION['member_id'], MD5_KEY), 7*24*60*60);

    }



    public function set_avatar_cookie() {

        setXwCookie('member_avatar', $_SESSION['avatar'], 365*24*60*60);

    }




  /**
     *
     */
    public function login($login_info) {
        if (process::islock('login')) {
            return array('error' => '您的操作过于频繁，请稍后再试');
        }
        process::addprocess('login');
        $user_name = $login_info['user_name'];
        $password = $login_info['password'];
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array(
                "input" => $user_name,
                "require" => "true",
                "message" => "请填写手机号码"
            ),
            array(
                "input" => $user_name,
                "validator" => "username",
                "message" => "请填写字母、数字、中文、_"
            ),
            array(
                "input" => $user_name,
                "max" => "20",
                "min" => "3",
                "validator" => "length",
                "message" => "手机号码长度要在6~20个字符"
            ),
            array(
                "input" => $password,
                "require" => "true",
                "message" => "密码不能为空"
            )
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            return array('error' => $error);
        }
        $condition = array();
        $condition['username'] = $user_name;
        $condition['password'] = getPwd($password);
        $member_info = $this->getMemberInfo($condition);

		//根据会员名没找到时查手机号
        if(empty($member_info) && preg_match('/^0?(13|14|15|16|17|18|19)[0-9]{9}$/i', $user_name)) {
            $condition = array();
            $condition['mobile'] = $user_name;
            $condition['password'] = getPwd($password);
            $member_info = $this->getMemberInfo($condition);
        }

        if (!empty($member_info)) {
			if($member_info['isdel']){
                return array('error' => '账号不存在，请先注册！');
            }
            if($member_info['isreview']!=1){
                return array('error' => '账号审核中，请耐心等待！');
            }
            if(!$member_info['state']){
                return array('error' => '账号被停用，联系管理员激活！');
            }
            process::clear('login');


            $update_info    = array(
                'login_num'=> ($member_info['login_num']+1),
                'login_time'=> TIMESTAMP,
                'login_ip'=> getIp()

            );
            $this->editMember(array('id'=>$member_info['id']),$update_info);

            return $member_info;
        } else {
            return array('error' => '登录失败，请填写正确手机号密码！');
        }
    }


    /**

     * 注册

     */

    public function register($register_info) {

        // 注册验证

        $obj_validate = new Validate();

        $obj_validate->validateparam = array(

		array("input"=>$register_info["truename"],      "require"=>"true",    "message"=>'姓名不能为空'),
        array("input"=>$register_info["username"],      "require"=>"true",    "message"=>'请正确填写手机号码'), 
        array("input"=>$register_info["password"],      "require"=>"true",      "message"=>'密码不能为空'), 
        array("input"=>$register_info["password_confirm"],"require"=>"true",    "validator"=>"Compare","operator"=>"==","to"=>$register_info["password"],"message"=>'密码与确认密码不相同'),

        /* array("input"=>$register_info["email"],            "validator"=>"email", "message"=>'电子邮件格式不正确'), */

		array("input"=>$register_info["mobile"],            "validator"=>"mobile", "message"=>'手机格式不正确'),
		 ); 
// 		array("input"=>$register_info["department"],      "require"=>"true",    "message"=>'请选择所属职能部门'),
		
//        

        $error = $obj_validate->validate();

        if ($error != ''){

            return array('error' => $error);

        }





        // 验证手机号码是否重复

        $check_member_name  = $this->getMemberInfo(array('username'=>$register_info['username']));

        if(is_array($check_member_name) and count($check_member_name) > 0) {

            return array('error' => '您已注册，请返回登录');

        }






		if(getUNname($register_info['username'])) {

            return array('error' => '您已注册，请返回登录');

        }


		if($register_info['email']){
        // 验证邮箱是否重复

        $check_member_email = $this->getMemberInfo(array('email'=>$register_info['email']));

        if(is_array($check_member_email) and count($check_member_email)>0) {

            return array('error' => '邮箱已存在');

        }
		}

		// 验证手机号是否重复

        $check_member_mobile = $this->getMemberInfo(array('mobile'=>$register_info['mobile']));

        if(is_array($check_member_mobile) and count($check_member_mobile)>0) {

            return array('error' => '您已注册，请返回登录');

        }

        // 会员添加

        $member_info    = array();


		$member_info['username']     = $register_info['username'];

        $member_info['password']   = $register_info['password'];

        $member_info['email']        = $register_info['email'];

		$member_info['mobile']        = $register_info['mobile'];

		$member_info['truename']        = $register_info['truename'];

		$member_info['department']        = $register_info['department'];
		
		$member_info['sex']   = intval($register_info['sex']);
	  

        $insert_id  = $this->addMember($member_info);

        if($insert_id) {

           $member_info['id'] = $insert_id;

            return $member_info;

        } else {

            return array('error' => '注册失败');

        }



    }



    /**

     * 注册会员

     *

     * @param   array $param 会员信息

     * @return  array 数组格式的返回结果

     */

    public function addMember($param) {

        if(empty($param)) {

            return false;

        }

        try {

            $this->beginTransaction();

            $member_info    = array();

            $member_info['username']         = trim($param['username']);

            $member_info['password']       = getPwd(trim($param['password']));

            $member_info['email']        = trim($param['email']);

            $member_info['addtime']         = TIMESTAMP;

            $member_info['login_time']   = TIMESTAMP;

            $member_info['login_ip']     = getIp();


            $member_info['truename']     = trim($param['truename']);
            $member_info['department']     = trim($param['department']);

            $member_info['qq']           = $param['qq'];

            $member_info['sex']          = $param['sex']==''?1:$param['sex'];

            $member_info['avatar']       = $param['avatar'];

            $member_info['qqopenid']     = $param['qqopenid'];

            $member_info['qqinfo']       = $param['qqinfo'];

            $member_info['sinaopenid']   = $param['sinaopenid'];

            $member_info['sinainfo'] = $param['sinainfo'];
 
			$member_info['state'] =1;
			
            if ($param['mobile']) {

                $member_info['mobile'] = $param['mobile'];

                $member_info['mobile_bind'] = 1;

            }

            if ($param['weixin_unionid']) {

                $member_info['weixin_unionid'] = $param['weixin_unionid'];

                $member_info['weixin_info'] = $param['weixin_info'];

            }
/* 
			$member_info['iscom']        = $param['iscom'] ; */

            $insert_id  = $this->table('member')->insert($member_info);


            if (!$insert_id) {

                throw new Exception();

            }

			//处理头像
			/*import('fun.file');
			$file_ext=file_ext($param['avatar']);

			file_copy(HX_UPLOAD.DS.ATTACH_AVATAR.DS.$param['member_avatar'],HX_UPLOAD.DS.ATTACH_AVATAR.DS.'avatar_'.$insert_id.'.'.$file_ext);
			file_del(HX_UPLOAD.DS.ATTACH_AVATAR.DS.$param['member_avatar']);

			$this->editMember(array('id'=>$insert_id),array('member_avatar'=>'avatar_'.$insert_id.'.'.$file_ext));
			*/ 


            $this->commit();

            return $insert_id;

        } catch (Exception $e) {

            $this->rollback();

            return false;

        }

    }



    /**

     * 会员登录检查

     *

     */

    public function checkloginMember() {

        if($_SESSION['is_login'] == '1') {

            @header("Location: index.php");

            exit();

        }

    }






    /**

     * 取单条信息

     * @param unknown $condition

     * @param string $fields

     */

    public function getMemberCommonInfo($condition = array(), $fields = '*') {

        return $this->table('member_common')->where($condition)->field($fields)->find();

    }



    /**

     * 插入扩展表信息

     * @param unknown $data

     * @return Ambigous <mixed, boolean, number, unknown, resource>

     */

    public function addMemberCommon($data) {

        return $this->table('member_common')->insert($data);

    }



    /**

     * 编辑会员扩展表

     * @param unknown $data

     * @param unknown $condition

     * @return Ambigous <mixed, boolean, number, unknown, resource>

     */

    public function editMemberCommon($data,$condition) {

        return $this->table('member_common')->where($condition)->update($data);

    }



}

