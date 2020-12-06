<?php
// +----------------------------------------------------------------------
// | Name: 地区模型
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class gmenuModel extends Model {

    public function __construct() {
        parent::__construct('gmenu');
    }

    /**
     * 获取地址列表
     *
     * @return mixed
     */
    public function getList($condition = array(), $fields = '*', $group = '', $page = null) {
        return $this->where($condition)->field($fields)->page($page)->limit(false)->group($group)->order("list desc,id asc")->select();
    }

    /**
     * 获取地址详情
     *
     * @return mixed
     */
    public function getInfo($condition = array(), $fileds = '*') {
        return $this->where($condition)->field($fileds)->find();
    }

    /**
     * 获取一级地址（省级）名称数组
     *
     * @return array 键为id 值为名称字符串
     */
    public function getTopLevel() {
        $data = $this->getCache();

        $arr = array();
        foreach ($data['children'][0] as $i) {
            $arr[$i] = $data['name'][$i];
        }

        return $arr;
    }

  

    /**
     * 获取地区缓存
     *
     * @return array
     */
    public function getGmenu() {
        return $this->getCache();
    }

    /**
     * 获取全部地区名称数组
     *
     * @return array 键为id 值为名称字符串
     */
    public function getGmenuNames() {
        $data = $this->getCache();

        return $data['uname'];
    }

  

    /**
     * 获取地区数组 格式如下
     * array(
     *   'name' => array(
     *     '地区id' => '地区名称',
     *     // ..
     *   ),
     *   'parent' => array(
     *     '子地区id' => '父地区id',
     *     // ..
     *   ),
     *   'children' => array(
     *     '父地区id' => array(
     *       '子地区id 1',
     *       '子地区id 2',
     *       // ..
     *     ),
     *     // ..
     *   ),
     *   'region' => array(array(
     *     '华北区' => array(
     *       '省级id 1',
     *       '省级id 2',
     *       // ..
     *     ),
     *     // ..
     *   ),
     * )
     *
     * @return array
     */
    protected function getCache() {
        // 对象属性中有数据则返回
        if ($this->cachedData !== null)
            return $this->cachedData;

        // 缓存中有数据则返回
        if ($data = rkcache('gmenu')) {
            $this->cachedData = $data;
            return $data;
        }

        // 查库
        $data = $this->_getAll();
        wkcache('gmenu', $data);
        $this->cachedData = $data;

        return $data;
    }

    protected $cachedData;

    private function _getAll() {
        $data = array();
        $area_all_array = $this->limit(false)->select();
        foreach ((array) $area_all_array as $a) {
            $data['gname'][$a['id']] = $a['uname'];
            $data['parent'][$a['id']] = $a['pid'];
            $data['children'][$a['pid']][] = $a['id'];

        }
        return $data;
    }

    public function add($data = array()) {
        return $this->insert($data);
    }

    public function edit($data = array(), $condition = array()) {
        return $this->where($condition)->update($data);
    }

    public function del($condition = array()) {
        return $this->where($condition)->delete();
    }

    /**
     * 递归取得本地区及所有上级地区名称
     * @return string
     */
    public function getTopName($id,$area_name = '') {
        $info_parent = $this->getInfo(array('id'=>$id),'uname,pid');
        if ($info_parent) {
            return $this->getTopName($info_parent['pid'],$info_parent['name']).' '.$info_parent['name'];
        }
    }

    /**
     * 递归取得本地区所有孩子ID
     * @return array
     */
    public function getChildrenIDs($id) {
        $result = array();
        $list = $this->getList(array('pid'=>$id),'id');
        if ($list) {
            foreach ($list as $v) {
                $result[] = $v['id'];
                $result = array_merge($result,$this->getChildrenIDs($v['id']));
            }
        }
        return $result;
    }
}
