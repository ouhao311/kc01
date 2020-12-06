<?php
// +----------------------------------------------------------------------
// | Name: 后台父类
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class SystemControl{

    /**
     * 管理员资料 name id group
     */
    protected $admin_info;

    /**
     * 权限内容
     */
    protected $power;

    /**
     * 菜单
     */
    protected $menu;

    /**
     * 常用菜单
     */
    protected $quick_link;
    protected function __construct() {
  
		Language::read('common,manage,explanation');
        /**
         * 验证用户是否登录
         * $admin_info 管理员资料 name id
         */
    
        $this->admin_info = $this->systemLogin();

        if ($this->admin_info['id'] != 1){
            //验证权限
            $this->checkPower();
        }
		//转码  防止GBK下用ajax调用时传汉字数据出现乱码
        if (($_GET['branch']!='' || $_GET['do']=='ajax') && strtoupper(CHARSET) == 'GBK'){
            $_GET = Language::getGBK($_GET);
        }


    }

    /**
     * 取得当前管理员信息
     *
     * @param
     * @return 数组类型的返回结果
     */
    protected final function getAdminInfo() {
        return $this->admin_info;
    }

    /**
     * 系统后台登录验证
     *
     * @param
     * @return array 数组类型的返回结果
     */
    protected final function systemLogin() {

        //取得cookie内容，解密，和系统匹配
        $user = unserialize(decrypt(cookie('sys_key'),MD5_KEY));

		//print_r($user);
		//exit();

        if (!key_exists('gid',(array)$user) || !isset($user['sp']) || (empty($user['name']) || empty($user['id']))){
            @header('Location: '. ADMIN_URL .'/index.php?url=login&do=login');exit;
        }else {
            $this->systemSetKey($user);
        }
        return $user;
    }

    /**
     * 系统后台 会员登录后 将会员验证内容写入对应cookie中
     *
     * @param string $name 用户名
     * @param int $id 用户ID
     * @return bool 布尔类型的返回结果
     */
    protected final function systemSetKey($user, $avatar = '', $avatar_compel = false) {
        setXwCookie('sys_key',encrypts(serialize($user),MD5_KEY),3600,'',null);
        if ($avatar_compel || $avatar != '') {
            setXwCookie('admin_avatar',$avatar,86400 * 365,'',null);
        }
    }

    /**
     * 验证当前管理员权限是否可以进行操作
     *
     * @param string $link_nav
     * @return
     */
    protected final function checkPower($link_nav = null) {
        if ($this->admin_info['sp'] == 1) return true;

        $url = $_GET['url'] ? $_GET['url'] : $_POST['url'];
        $url = $url == '' ? 'index' : $url;

        $power = $this->getPower();

        if (!defined('MODULE_NAME')) return true;//modules目录外的不需要验证
        if (is_array($power[MODULE_NAME]) && @in_array($url, $power[MODULE_NAME][$url])){
            return true;
        }

        showMessage(Language::get('hx_assign_right'),'','html','succ',0);
    }


	    /**
     * 验证当前管理员权限是否可以进行操作(页内)
     *
     * @param string $link_nav
     * @return
     */
    protected final function checkCzqx($caozuo ='') {
        if ($this->admin_info['sp'] == 1) return true;
		 if (!$caozuo) return false;

        $url = $_GET['url'] ? $_GET['url'] : $_POST['url'];
        $url = $url == '' ? 'index' : $url;

        $power = $this->getPower();


        if ($power[MODULE_NAME][$url][$caozuo]){
				return true;

        }

       return false;
    }

    /**
     * 取得后台菜单的Html形式
     *
     * @param string $permission
     * @return
     */
    protected final function getNav() {
        $_menu = $this->getMenu();
      
       // var_Dump($_menu);exit;
        $_menu = $this->parseMenu($_menu);
        $quicklink = $this->getQuickLink();
        $top_nav = '';
        $left_nav = '';
        $map_nav = '';
        $map_top = '';
        $quick_array = array();
        
        foreach ($_menu as $key => $value) {
            $top_nav .= '<li data-param="' . $key . '"><a href="javascript:void(0);">' . $value['name'] . '</a></li>';
            $left_nav .= '<div id="admincpNavTabs_'. $key .'" class="nav-tabs">';
            $map_top .= '<li><a href="javascript:void(0);" data-param="map-' . $key . '">' . $value['name'] . '</a></li>';
            $map_nav .= '<div class="admincp-map-div" data-param="map-' . $key . '">';
            foreach ($value['child'] as $ke => $val) {
                if (!empty($val['child'])) {
					if(!$val['ico']) $val['ico']='manage';
                    $left_nav .= '<dl><dt><a href="javascript:void(0);"><h3 class="clearfix"><i class="Hx-iconfont Hx-iconfont-'.$val['ico'].'"></i><p>' . $val['name']. '</p></h3></a></dt>';
                    $left_nav .= '<dd class="sub-menu"><ul>';
                    $map_nav .= '<dl><dt>' . $val['name'] . '</dt>';
                    foreach ($val['child'] as $k => $v) {
                        $left_nav .= '<li><a href="javascript:void(0);" data-param="' . $key . '|' . $k . '">' . $v["name"] . '</a></li>';
                        $selected = '';
                        if (in_array($key . '|' . $k , $quicklink)) {
                            $selected = 'selected';
                            $quick_array[$key . '|' . $k] = $v["name"];
                        }
                        $map_nav .= '<dd class="' . $selected . '"><a href="javascript:void(0);" data-param="' . $key . '|' . $k . '">' . $v["name"] . '</a><i class="fa fa-check-square-o"></i></dd>';
                    }
                    $left_nav .= '</ul></dd></dl>';
                    $map_nav .= '</dl>';
                }
            }
            $left_nav .= '</div>';
            $map_nav .= '</dl></div>';
        }
        $map_nav = '<ul class="admincp-map-nav">'.$map_top.'</ul>'.$map_nav;
        return array($top_nav, $left_nav, $map_nav, $quick_array);
    }

    /**
     * 过滤掉无权查看的菜单
     *
     * @param array $menu
     * @return array
     */
    private final function parseMenu($menu) {
       
        //$this->admin_info['sp']=1;
        if ($this->admin_info['sp'] == 1) return $menu;
        $permission = $this->getPermission();



        foreach ($menu as $key=>$value) {
            if (!isset($permission[$key])) {
                unset($menu[$key]);
                continue;
            }
            foreach ($value['child'] as $ke=>$val) {
                foreach ($val['child'] as $k=>$v) {

                    if (!@in_array($k, $permission[$key][$k])) {
                        unset($menu[$key]['child'][$ke]['child'][$k]);
                    }
                }
            }
        }


        return $menu;
    }

    /**
     * 获取权限内容
     *
     */
    private final function getPower() {
        if (empty($this->power)) {
            $gadmin = M('gadmin')->getby_gid($this->admin_info['gid']);
            $power = decrypt($gadmin['limits'],MD5_KEY.md5($gadmin['gname']));
            $this->power = unserialize($power);
        }


        return $this->power;
    }

	    /**
     * 获取权限内容
     *
     */
    private final function getPermission() {
        if (empty($this->permission)) {
            $gadmin = M('gadmin')->getby_gid($this->admin_info['gid']);

            $permission = decrypt($gadmin['limits'],MD5_KEY.md5($gadmin['gname']));

            $this->permission = unserialize($permission);
        }
        return $this->permission;
    }


    /**
     * 获取菜单
     */
    protected final function getMenu() {
   //var_Dump(33333);exit;
        if (empty($this->menu)) {

			$menu=H('admin_menu');
            $this->menu  = $menu?$menu:H('admin_menu',true);


        }
        return $this->menu;
    }

    /**
     * 获取快捷操作
     */
    protected final function getQuickLink() {
        if ($this->admin_info['qlink'] != '') {
            return explode(',', $this->admin_info['qlink']);
        } else {
            return array();
        }
    }

    /**
     * 取得顶部小导航
     *
     * @param array $links
     * @param 当前页 $actived
     */
    protected final function sublink($links = array(), $actived = '', $file='index.php') {
        $linkstr = '';
        foreach ($links as $k=>$v) {
            parse_str($v['url'],$array);
            if (empty($array['do'])) $array['do'] = 'index';
            if (!$this->checkPower($array)) continue;
            $href = ($array['do'] == $actived ? null : "href=\"{$file}?{$v['url']}\"");
            $class = ($array['do'] == $actived ? "class=\"current\"" : null);
            $lang = $v['text'] ? $v['text'] : L($v['lang']);
            $linkstr .= sprintf('<li><a %s %s><span>%s</span></a></li>',$href,$class,$lang);
        }
        return "<ul class=\"tab-base nc-row\">{$linkstr}</ul>";
    }

    /**
     * 记录系统日志
     *
     * @param $lang 日志语言包
     * @param $state 1成功0失败null不出现成功失败提示
     * @param $admin_name
     * @param $admin_id
     */
    protected final function log($lang = '', $state = 1, $admin_name = '', $admin_id = 0) {
        if (!C('sys_log') || !is_string($lang)) return;
        if ($admin_name == ''){
            $admin = unserialize(decrypt(cookie('sys_key'),MD5_KEY));
            $admin_name = $admin['name'];
            $admin_id = $admin['id'];
        }
        $data = array();
        if (is_null($state)){
            $state = null;
        }else{
            $state = $state ? '' : L('hx_fail');
        }
        $data['content']    = $lang.$state;
        $data['admin_name'] = $admin_name;
        $data['createtime'] = TIMESTAMP;
        $data['admin_id']   = $admin_id;
        $data['ip']         = getIp();
        $data['url']        = $_REQUEST['url'].'&'.$_REQUEST['do'];
        return M('admin_log')->insert($data);
    }

    /**
     * 输出JSON
     *
     * @param string $errorMessage 错误信息 为空则表示成功
     */
    protected function jsonOutput($errorMessage = false)
    {
        $data = array();

        if ($errorMessage === false) {
            $data['result'] = true;
        } else {
            $data['result'] = false;
            $data['message'] = $errorMessage;
        }

        $jsonFlag = C('debug') && version_compare(PHP_VERSION, '5.4.0') >= 0
            ? JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            : 0;

        echo json_encode($data, $jsonFlag);
        exit;
    }

}
