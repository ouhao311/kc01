<?php
// +----------------------------------------------------------------------
// | Name: 积分排行
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class member_integralControl extends SystemControl{
	public $name;
    public function __construct(){
        parent::__construct();
		$this->name=getUrl(__CLASS__);

    }
	/**
     * 列表管理
     */
    public function indexDo() {
        $lang = Language::getLangContent();

		include T($this->name);
    }

    /**
     * 异步调用列表
     */
    public function get_xmlDo(){

		//if (!chksubmit()) exit(Tpl::flexigridXML(''));//默认不显示数据

        $model = M('member');
        $condition = array();
        $condition['state'] = 1;
        $condition['isdel'] = 0;
		list($condition,$order) = $this->_get_condition($condition);//处理条件和排序
        $list = $model->where($condition)->order($order)->page($_POST['rp'])->select();
        $data = array();
        $data['now_page'] = $model->shownowpage();
        $data['total_num'] = $model->gettotalnum();
        foreach ($list as $k => $v) {
            $list = array(); 
			$list['username'] = "<span title='".$v['username']."'>".$v['username']."</span>";
			$list['truename'] = "<img src='".getImageUrl($v['avatar'],'avatar')."' class='user-avatar' onMouseOut='toolTip()' onMouseOver='toolTip(\"<img src=".getImageUrl($v['avatar'],'avatar').">\")'><span title='".$v['truename']."'>".$v['truename']."</span>"; 
			$sex=getSinglePas($table='attribute','sex',$v['sex'],'title'); 
			$list['integral'] = "<span title='".$v['integral']."'>".$v['integral']."</span>"; 
			$list['addtime']  = $v['addtime']?date('Y-m-d H:i:s',$v['addtime']):'-';  
            $data['list'][$v['id']] = $list;
        }
        exit(Tpl::flexigridXML($data));

    }
	 

    
	/**
     * 设置操作
     */
    public function setDo() { 
		$data =$condition= array();
		$condition['id'] = intval($_GET['id']); 
		switch ($_GET['branch']){
			case 'unshow':
				$data['state']    = 0;
				$data['edittime']  = time();
				$msg              = "积分排行取消禁用";
			break;
			case 'show':
				$data['state']    = 1;
				$data['edittime']  = time();
				$msg              = "积分排行设为启用";
			break;  
			
		}
		$result =M('member')->where($condition)->update($data);
		if($result){
		$this->log($msg.'[ID:'.$_GET['id'].']',null);
			 exit(json_encode(array('state'=>true,'msg'=>'操作成功')));
		}else{
			 exit(json_encode(array('state'=>false,'msg'=>'操作失败')));
		} 
	}

	/**
     * 封装公共代码
     */
    private function _get_condition($condition) {
 
        if ($_GET['keywords'] != '') {
            $condition['username']          = array('like',"%{$_GET['keywords']}%"); 
        }
        if ($_GET['truename'] != '') {
            $condition['truename']          = array('like',"%{$_GET['truename']}%"); 
        }
        if ($_GET['mobile'] != '') {
            $condition['mobile']          = array('like',"%{$_GET['mobile']}%"); 
        } 
		if($_GET['state'] == '1') {
            $condition['state']          = 1;
        }
		if($_GET['state'] == '-1') {
            $condition['state']       =   0;
        } 
        if ($_GET['department'] != '') {
            $condition['department']          = $_GET['department']; 
        }
		if($_GET['isreview']  != '') {
            $condition['isreview']     = $_GET['isreview']; 
        } 
		//更新时间
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['kaishi']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['jieshu']);
        $start_unixtime = $if_start_time ? strtotime($_GET['kaishi']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['jieshu']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['addtime'] = array('time',array($start_unixtime,$end_unixtime));
        }

        $sort_fields = array('id','addtime');
		if ($_REQUEST['sortorder'] != '' && in_array($_REQUEST['sortname'],$sort_fields)) {
            $order = $_REQUEST['sortname'].' '.$_REQUEST['sortorder'];
        }

        return array($condition,$order);
    }

}
