<?php
// +----------------------------------------------------------------------
// | Name: 单页
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied'); 
class pageControl extends PcControl{

    public function __construct(){
        parent::__construct(); 
    }

    // 首页部分
    public function indexDo(){
		$lang = Language::getLangContent();
		$id=$_GET['id'];
		$info=getTableInfohanett($id,'pages_list'); 
		$title=$info['title'];
		$keywords=$info['seo_keywords'];
		$description=$info['seo_description'];   
		
		$pagelist=M('pages_list')->where(array('isdel'=>0,'status'=>1))->order('rank asc,edittime desc')->select();
		
		include T('page');
        
    }  
	
	
	
}