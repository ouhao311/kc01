<?php
// +----------------------------------------------------------------------
// | Name: 会员列表
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class userModel extends Model {

    public function __construct() {
        parent::__construct('member');
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
				$order = "edittime desc,id desc"; //更新时间排序
			break;
			break;
			default:
				$order = "addtime desc,id desc";//默认排序
		} 
		$condition["state"] = 1;
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
    public function getArticleList($condition,$page=''){
        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'member';
        $param['where'] = $condition_str;
        $param['limit'] = $condition['limit'];
        $param['order'] = (empty($condition['order'])?'edittime desc':$condition['order']);
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

		$condition_str .= " and member.isdel = 0 ";
        if ($condition['state'] != ''){
            $condition_str .= " and member.state = '". $condition['state'] ."'";
        }
        if ($condition['isreview'] != ''){
            $condition_str .= " and member.isreview = '". $condition['isreview'] ."'";
        }
        if ($condition['keywords'] != ''){ 
			$condition_str .= " and member.truename like '%".$condition['keywords']."%' ";   
        }
		
        return $condition_str;
    }




}
