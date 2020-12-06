<?php
// +----------------------------------------------------------------------
// | Name: 资讯动态
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied'); 
class newsControl extends PcControl{

    public function __construct(){
        parent::__construct(); 
    }

    // 首页部分
    public function indexDo(){
		$lang = Language::getLangContent();
		$keyword=$_GET['keywords'];
		$pid=$_GET['pid'];
		//获取当前下级栏目
		$classinfo=getTableInfohanett($pid,'article_class');
		//查询顶级栏目
		if(empty($classinfo['pid'])){
			$sonclass=M('article_class')->where(array('isdel'=>0,'status'=>1,'pid'=>$classinfo['id']))->order('rank asc')->select();
			$topclassinfo=$classinfo;
			$pids=puttreestatus($pid,'article_class');
		}else{
			$sonclass=M('article_class')->where(array('isdel'=>0,'status'=>1,'pid'=>$classinfo['pid']))->order('rank asc')->select();
			$topclassinfo=getTableInfohanett($classinfo['pid'],'article_class');
			$pids=$pid;
		}
		$title=$classinfo['seo_title'];
		$keywords=$classinfo['seo_keywords'];
		$description=$classinfo['seo_description'];
		if(empty($title)){
			$title=$classinfo['title'];
		} 
		//获取列表
		$condition=array();
		$condition['status']	= 1;
		$condition['isdel']	= 0;
		if(!empty($pids)){
			$condition['pid']	= $pids;
		}
		
		$news = M('article');
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		$list	= $news->getArticleList($condition,$page);
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
				include T('lists_article');
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
		
		$news = M('article');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
		$list	= $news->getArticleList($condition,$page);
		$show_page=$page->show();  
		
		$banner_list=getAdinfoList(2);
		
		include T('search');
        
    } 
	
	
	// 详情部分
    public function showDo(){
		$lang = Language::getLangContent();
		$id=$_GET['id'];
		$info=getTableInfohanett($id,'article_list');
		$classinfo=getTableInfohanett($info['pid'],'article_class');
		//查询顶级栏目
		if(empty($classinfo['pid'])){
			$sonclass=M('article_class')->where(array('isdel'=>0,'status'=>1,'pid'=>$classinfo['id']))->order('rank asc')->select();
			$topclassinfo=$classinfo;
		}else{
			$sonclass=M('article_class')->where(array('isdel'=>0,'status'=>1,'pid'=>$classinfo['pid']))->order('rank asc')->select();
			$topclassinfo=getTableInfohanett($classinfo['pid'],'article_class');
		}
		$title=$info['seo_title'];
		$keywords=$info['seo_keywords'];
		$description=$info['seo_description'];  
		if(empty($title)){
			$title=$info['title'];
		} 
		$news = M('article');
		//精选列表
		$jingxuan_list1	= $news->getList('rank',8);   
		
		//点击量刷新
		M('article_list')->where(array('id'=>$id))->update(array('clicks'=>$info['clicks']+1)); 
		
		
		//上一篇
		$preinfo=M('article_list')->where(array('id'=>array('lt',$id),'status'=>1,'isdel'=>0,'pid'=>$info['pid']))->find();
		//下一篇
		$nextinfo=M('article_list')->where(array('id'=>array('gt',$id),'status'=>1,'isdel'=>0,'pid'=>$info['pid']))->find();
		
		$banner_list=getAdinfoList(2);
		
        include T('article_show');
    } 
	
	
}