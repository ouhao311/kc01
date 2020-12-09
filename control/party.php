<?php
// +----------------------------------------------------------------------
// | Name: 党建系统
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied'); 
class goventControl extends PcControl{

    public function __construct(){
        parent::__construct(); 
    }

    // 首页部分
    public function indexDo(){
		$lang = Language::getLangContent();
        $keyword=$_GET['keywords'];
        $title="党建系统";
		$keywords=C('site_keywords');
		$description=C('site_description');
		
		//获取列表
		$condition=array();
		$condition['status']	= 1;
		$condition['isdel']	= 0;
		
		$news = M('govent');
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		$list	= $news->getGoventList($condition,$page);
		$show_page=$page->show();  
		
		$banner_list=getAdinfoList(2);
			$mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		
		if(!empty($sonclass)&&empty($classinfo['pid'])){
			include T('lists_index');
		}else{
			if(!empty($classinfo['templist'])){
				$templist=getSinglePas($table='attribute','templist',$classinfo['templist'],'title');
				//var_dump($templist);exit;
				include T($templist);
			}else{
				include T('lists_govent');
			}
		}
        
    } 
	
	
	 // 搜索部分
    public function searchDo(){
		$lang = Language::getLangContent();
		$keywords=$_GET['keywords'];  
		$title="搜索结果";
		
		//获取列表
		$condition=array();
		$condition['status']	= 1;
		$condition['isdel']	= 0;
		if(!empty($keywords)){
			$condition['keywords']	= $keywords;
		}
		
		$news = M('govent');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
		$list	= $news->getGoventList($condition,$page);
		$show_page=$page->show();  
		
		$banner_list=getAdinfoList(2);
		
		include T('search');
        
    } 
	
	
	// 详情部分
    public function showDo(){
		$lang = Language::getLangContent();
		$id=$_GET['id'];
		$info=getTableInfohanett($id,'govent_list');
		
		$title=$info['seo_title'];
		$keywords=$info['seo_keywords'];
		$description=$info['seo_description'];  
		if(empty($title)){
			$title=$info['title'];
		} 
		$news = M('govent');
		//精选列表
		$jingxuan_list1	= $news->getList('rank',8);   
		
		//点击量刷新
		M('govent_list')->where(array('id'=>$id))->update(array('clicks'=>$info['clicks']+1)); 
		
		
		//上一篇
		$preinfo=M('govent_list')->where(array('id'=>array('lt',$id),'status'=>1,'isdel'=>0))->find();
		//下一篇
		$nextinfo=M('govent_list')->where(array('id'=>array('gt',$id),'status'=>1,'isdel'=>0))->find();
		
		$banner_list=getAdinfoList(2);
		
        include T('govent_show');
    } 
	
	
}