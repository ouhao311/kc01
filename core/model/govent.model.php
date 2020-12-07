<?php
// +----------------------------------------------------------------------
// | Name: 政务管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class goventModel extends Model {

    public function __construct() {
        parent::__construct('govent_list');
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
			case 'newimg':
				$condition["pic"] = array('neq','');
				$order = "edittime desc,id desc";//有缩略图的显示
			break;
			case 'hot':
				$condition["ishot"] = 1;
				$order = "hottime desc,id desc";//热门或者精选显示
			break;
			case 'rec':
				$condition["isrec"] = 1;
				$order = "rectime desc,id desc";//头条显示
			break;
			default:
				$order = "rank asc,id desc";//默认排序
		}
		if(!empty($pid)){
			$pids=puttreestatus($pid,'article_class');
			$condition['pid'] = array('in',$pids);
		}
		$condition["status"] = 1;
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
    public function getGoventList($condition,$page=''){
        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'govent_list';
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

		$condition_str .= " and govent_list.isdel = 0 ";
        if ($condition['status'] != ''){
            $condition_str .= " and govent_list.status = '". $condition['status'] ."'";
        }
        if ($condition['isrec'] != ''){
            $condition_str .= " and govent_list.isrec = '". $condition['isrec'] ."'";
        }
        if ($condition['ishot'] != ''){
            $condition_str .= " and govent_list.ishot = '". $condition['ishot'] ."'";
        }
        if ($condition['keywords'] != ''){ 
			$condition_str .= " and govent_list.title like '%".$condition['keywords']."%' ";   
        }
		
        return $condition_str;
    }




}
