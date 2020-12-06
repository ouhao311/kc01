<?php
// +----------------------------------------------------------------------
// | Name: 关于我们
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class aboutusControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Language::read('dashboard');
    }

    public function indexDo() {
        $this->aboutusDo();
    }

    /**
     * 关于我们
     */
    public function aboutusDo(){
		$lang = Language::getLangContent();
        $version = C('version');
        $v_date = '201609';
        $s_date = '20160920';
        include T('aboutus');

    }

}
