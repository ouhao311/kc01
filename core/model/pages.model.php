<?php
// +----------------------------------------------------------------------
// | Name:单页管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class pagesModel extends Model {

    public function __construct() {
        parent::__construct('page_list');
    }

    /**
     * 获取列表
     * @param  array $type 类型
	 * @param  array $type 数量
	 * @param  array $type 字段
     * @return array 数组结构的返回结果
     */
    public function getList($branch ='new', $num = '10', $fields = 'id,pid,title,intro,pic,edittime,status,clicks'){

		switch ($branch){
			case 'new':
				//$condition["status"] = "";
				$order = "edittime desc,id desc";
			break;
			case 'newimg':
				$condition["url"] = array('neq','');
				$order = "edittime desc,id desc";
			break;
			case 'hot':
				$condition["ishot"] = 1;
				$order = "hottime desc,id desc";
			break;
			case 'rec':
				$condition["isrec"] = 1;
				$order = "rectime desc,id desc";
			break;

		}
		$condition["status"] = 1;
		return $this->where($condition)->field($fields)->limit($num)->order($order)->select();

    }

	 /**
     * 分页列表
     *
     * @param array $condition 检索条件
     * @param obj $page 分页
     * @return array 数组结构的返回结果
     */
    public function getPagesList($condition,$page=''){
        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'page_list';
        $param['where'] = $condition_str;
        $param['limit'] = $condition['limit'];
        $param['order'] = (empty($condition['order'])?'clicks desc':$condition['order']);
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

        if ($condition['status'] != ''){
            $condition_str .= " and page_list.status = '". $condition['status'] ."'";
        }
        if ($condition['isrec'] != ''){
            $condition_str .= " and page_list.isrec = '". $condition['isrec'] ."'";
        }
        if ($condition['ishot'] != ''){
            $condition_str .= " and page_list.ishot = '". $condition['ishot'] ."'";
        }
        if ($condition['pid'] != ''){
            $condition_str .= " and page_list.pid = '". $condition['pid'] ."'";
        }
        if ($condition['keywords'] != ''){
			
			$condition_str .= " and page_list.title like '%".$condition['keywords']."%' ";  
			 
        }
		
        return $condition_str;
    }




}
