<?php
// +----------------------------------------------------------------------
// | Name: 收藏管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class favoriteModel extends Model {

    public function __construct() {
        parent::__construct('tutorial_favorite');
    } 

	 /**
     * 分页列表
     *
     * @param array $condition 检索条件
     * @param obj $page 分页
     * @return array 数组结构的返回结果
     */
    public function getArticleList($condition,$page=''){
        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'tutorial_favorite';
        $param['where'] = $condition_str;
        $param['limit'] = $condition['limit'];
        $param['group'] = 'tlid';
        $param['order'] = (empty($condition['order'])?'addtime desc':$condition['order']);
        $result = Db::select($param,$page);
        return $result;
    }
    /**
     * 构造检索条件
     *
     * @param int $id 记录ID
     * @return string 字符串类型的返回结果
     */
    private function _condition($condition){
        $condition_str = '';

        if ($condition['isdel'] != ''){
            $condition_str .= " and tutorial_favorite.isdel = '". $condition['isdel'] ."'";
        }
        if ($condition['mid'] != ''){
            $condition_str .= " and tutorial_favorite.mid = '". $condition['mid'] ."'";
        }
		
        return $condition_str;
    }




}
