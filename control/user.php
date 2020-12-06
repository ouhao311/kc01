<?php
// +----------------------------------------------------------------------
// | Name: 会员列表
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied'); 
class userControl extends PcControl{

    public function __construct(){
        parent::__construct(); 
    }

    // 首页部分
    public function indexDo(){
		$lang = Language::getLangContent();
		$title="先锋模范";
		$keywords=$classinfo['seo_keywords'];
		$description=$classinfo['seo_description'];
		//获取列表
		$condition=array();
		$condition['state']	= 1;
		$condition['isdel']	= 0;
		$condition['isreview']	= 1;
		
		$user = M('user');
		$page	= new Page();
		$page->setEachNum(18);
		$page->setStyle('5');
		$list	= $user->getArticleList($condition,$page);
		$show_page=$page->show();  
		
		include T('userlist');
        
    }  
	
	// 详情部分
    public function userviewDo(){
		$lang = Language::getLangContent();
		$id=$_GET['id'];
		$info=getTableInfohanett($id,'member'); 
		
        include T('userview');
    } 
	
	
}