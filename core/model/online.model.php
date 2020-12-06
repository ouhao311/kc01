<?php
// +----------------------------------------------------------------------
// | Name: 解疑管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
//var_dump(3123123);exit;
class onlineModel extends Model {

    public function __construct() {
        parent::__construct('online_list');
    }

    /**
     * 获取列表
     * @param  array $type 类型
	 * @param  array $type 数量
	 * @param  array $type 字段
     * @return array 数组结构的返回结果
     */
    public function getList($branch ='new', $num = '10',$pid=0, $fields = '*'){

		switch ($branch){
			case 'new': 
				$order = "addtime desc,id desc"; //更新时间排序
			break;
			default:
				$order = "addtime desc,id desc";//默认排序
		}
		$condition["isreview"] = 1;
		$condition["isdel"] = 0;
		return $this->where($condition)->field($fields)->limit($num)->order($order)->select();

    }

	 /**
     * 分页列表
     *
     * @param array $condition 检索条件
     * @param obj $page 分页
     * @return array 数组结构的返回结果
     */
    public function getonlineList($condition,$page=''){
        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'online_list';
        $param['where'] = $condition_str;
        $param['limit'] = $condition['limit'];
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

		$condition_str .= " and online_list.isdel = 0 "; 
        if ($condition['isreview'] != ''){
            $condition_str .= " and online_list.isreview = '". $condition['isreview'] ."'";
        }
        if ($condition['releaseid'] != ''){
            $condition_str .= " and online_list.releaseid = '". $condition['releaseid'] ."'";
        }
        if ($condition['keywords'] != ''){ 
			$condition_str .= " and online_list.title like '%".$condition['keywords']."%' ";   
        }
		
        return $condition_str;
    }




}
