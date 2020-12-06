<?php
// +----------------------------------------------------------------------
// | Name: 首页
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.hanett.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class indexControl extends PcControl{
	
    public function __construct(){
        parent::__construct(); 
    }
	
	
	public function newsDo()
	{
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
		    //	var_Dump(3123123);exit;
			include T('lists_index');
		}else{
			if(!empty($classinfo['templist'])){
				$templist=getSinglePas($table='attribute','templist',$classinfo['templist'],'title');
		//	var_dump($templist);exit;
				include T('list_articlec');
			}else{
			    //	var_Dump(3123123);exit;
				include T('list_articlec');
			}
		}
        
	}
	public function showDo()
	{
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
	public function indexDo(){
	    
// 	    	$lang = Language::getLangContent();
// 		$keyword=$_GET['keywords']; 
// 		$title="线上解疑平台";
// 		$keywords=C('site_keywords');
// 		$description=C('site_description');
// 		//获取列表
// 		$condition=array();
// 		$condition['isreview']	= 1;
// 		$condition['isdel']	= 0; 
		
// 		$online = M('online');
// 		$page	= new Page();
// 		$page->setEachNum(20);
// 		$page->setStyle('5');
// 		$list	= $online->getonlineList($condition,$page);
// 		$show_page=$page->show();  
		
// 		$banner_list=getAdinfoList(2);
// 			$mid=$_SESSION['member_id'];
// 		$myinfo = M('member');
// 		$condition 	= array();
// 		$condition['id']	= $mid;
// 		$member= $myinfo->getMemberInfo($condition);
// 		//var_Dump(T('online'));exit;
// 		include T('online');
      //var_Dump(31231);exit;
		$lang = Language::getLangContent();
		$title=C('site_name');
		$keywords=C('site_keywords');
		$description=C('site_description');
		//首页banner图
		$banner_list=getAdinfoList(1);
		//var_dump($banner_list);exit;
		$news = M('article');
		//头条列表
		$toutiao_list	= $news->getList('rec',1);  
	//var_dump($toutiao_list);exit;
		//特别推荐
		$banner3_list=getAdinfoList(3); 
		
		//最新20个会员
		$userlist=M('member')->where(array('isdel'=>0,'state'=>1,'isreview'=>1))->limit(20)->order('addtime desc')->select();
		   $lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		//var_Dump($member,$mid);exit;
		//	var_Dump(T('index'));exit;
		//var_Dump(31321);exit;
		include T('index');
	}
	  
}