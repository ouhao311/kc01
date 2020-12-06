<?php
// +----------------------------------------------------------------------
// | Name: 清理缓存
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class cacheControl extends SystemControl
{
    protected $cacheItems = array(
        'setting',          // 基本缓存     
        'admin_menu',       // 后台菜单
		'tpl',   // 模板缓存
        

    );

    public function __construct() {
        parent::__construct();

    }

    public function indexDo() {
        $this->clearDo();
    }

    /**
     * 清理缓存
     */
    public function clearDo() {
		$lang = Language::getLangContent();
        if (!chksubmit()) {
			include T('cache.clear');
            return;
        }

        $lang = Language::getLangContent();

        // 清理所有缓存
        if ($_POST['cls_full'] == 1) {
            foreach ($this->cacheItems as $i) {
                H($i,null);
            }
		 

        } else {
            $todo = (array) $_POST['cache'];

            foreach ($this->cacheItems as $i) {
                if (in_array($i, $todo)) {
                    H($i,null);
                }
            }
			//删除模板文件
            if (in_array('tpl', $todo)) {
				delCacheFile('tpl');
            }



        }

        $this->log(L('cache_cls_operate'));
        showMessage($lang['cache_cls_ok']);
    }
}
