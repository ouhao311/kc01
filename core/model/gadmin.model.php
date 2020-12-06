<?php
// +----------------------------------------------------------------------
// | Name: 管理权限组
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class gadminModel extends Model{
    public function __construct() {
        parent::__construct('gadmin');
    }

    /**
     * 根据id查询后台管理员权限组
     * @param int $id
     * @return array
     */
    public function getGadminInfoById($id) {
        return $this->where(array('gid' => $id))->find();
    }
}
