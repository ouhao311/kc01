<?php
// +----------------------------------------------------------------------
// | Name: 福利管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class downloadModel extends Model {

    public function __construct() {
        parent::__construct('download_list');
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
				$order = "hottime desc,id desc";//热门或者首页显示
			break;
			case 'rec':
				$condition["isrec"] = 1;
				$order = "rectime desc,id desc";//推荐显示
			break;
			default:
				$order = "rank asc,id desc";//默认排序
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
    public function getArticleList($condition,$page=''){
        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'download_list';
        $param['where'] = $condition_str;
        $param['limit'] = $condition['limit'];
		if($condition['order']=='views'){
			$param['order'] = 'views desc,rank asc';
		}else{
			$param['order'] = 'rank asc,edittime desc';
		}
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

        $condition_str .= " and download_list.isdel = 0 ";
        if ($condition['status'] != ''){
            $condition_str .= " and download_list.status = '". $condition['status'] ."'";
        }
        if ($condition['isrec'] != ''){
            $condition_str .= " and download_list.isrec = '". $condition['isrec'] ."'";
        }
        if ($condition['ishot'] != ''){
            $condition_str .= " and download_list.ishot = '". $condition['ishot'] ."'";
        }
        if ($condition['pid'] != ''){
             $condition_str .= " and download_list.pid in (". $condition['pid'] .")";
        }
        if ($condition['keywords'] != ''){ 
			$condition_str .= " and download_list.title like '%".$condition['keywords']."%' ";   
        }
		
        return $condition_str;
    }




}
