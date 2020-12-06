<?php
// +----------------------------------------------------------------------
// | Name: 个人中心收藏管理
// +----------------------------------------------------------------------
// | Version: V1.0 By:haiping
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class member_collectModel extends Model {

    public function __construct() {
        parent::__construct('member_collect');
    }

    /**
     * 获取列表
     * @param  array $type 类型
	 * @param  array $type 数量
	 * @param  array $type 字段
     * @return array 数组结构的返回结果
     */
    public function getList($branch ='new', $num = '10', $fields = '
        id,title,pid,pinpai_id,leixing,price,pic,edittime,status,clicks'){

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
    public function getmemcollList($condition,$page=''){
        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'member_collect';
        $param['where'] = $condition_str;
        $param['limit'] = $condition['limit'];
		if($condition['order']=='new'){
			$param['order'] = 'addtime desc';
		}else if($condition['order']=='clicks'){
			$param['order'] = ' rand()';
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

        if ($condition['status'] != ''){
            $condition_str .= " and member_collect.status = '". $condition['status'] ."'";
        }
        if ($condition['pidpid'] != ''){
            $condition_str .= " and member_collect.pidpid in (". $condition['pidpid'] .")";
        }
        if ($condition['typeid'] != ''){
            $condition_str .= " and member_collect.typeid in (". $condition['typeid'] .")";
        }
        if ($condition['uid'] != ''){
            $condition_str .= " and member_collect.uid in (". $condition['uid'] .")";
        }
        return $condition_str;
    }

}
