<?php
// +----------------------------------------------------------------------
// | Name: 会员中心
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class memberControl extends BaseMemberControl{
	
    public function __construct(){
        parent::__construct();
    }

	// 首页部分
    public function indexDo(){

        $lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
        $title='我的首页';
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		
		//获取列表
		$condition=array();
		$condition['isdel']	= 0;
		$condition['releaseid']	= $mid;
		
		$news = M('article');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
		$list	= $news->getArticleList($condition,$page);
		$show_page=$page->show();  
		
		
		$member_list=M('member')->where(array('isdel'=>0,'isreview'=>1,'state'=>1,'id'=>array('neq',$mid)))->select();
			$mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		$count= Db::getAll("SELECT count(`id`) as count FROM ".DBPRE."online_list where releaseid=".$mid." and isreview=0 or istopreview=0  ORDER by id asc ");

		include T('member');
    }
	
	 
	//删除资讯
	public function delviewsDo(){
		$mid=$_SESSION['member_id'];
		$id=$_REQUEST['id'];
		if(empty($id)){echo output_error('您删除资讯不存在！');exit();}
		if(empty($mid)){echo output_error('您未登陆请先登陆！');exit();}
		$article_list=getTableInfohanett($id,'article_list');
		if(empty($article_list)){echo output_error('您删除资讯不存在！');exit();}
		$memberinfo=getTableInfohanett($mid,'member');
		if(empty($memberinfo)){echo output_error('您的账户不存在，请联系管理员！');exit();}
		if($memberinfo['state']==0){echo output_error('您的账户已被禁用，请联系管理员！');exit();} 
		$condition = array();
		$condition['id']=intval($id); 
		$condition['releaseid']=intval($mid); 
		$data = array();
		$data['isdel']=1;
		$result = M('article_list')->where($condition)->update($data);
		if($result){
			echo output_data(array('msg'=>'删除成功！'));exit();
		}else{
			echo output_error('删除失败！');exit();
		}
	}
	
	/*
     * 父类id  选中的id
     * */
  	public  function puttree11($pid=0,$selected=0){
        $rs = $this->gettree11($pid);
        $str='';
        $str .= "<select name='pid' id='pid' lay-verify='required|pid'>";
        $str .= '<option value="">请选择分类</option>';
        foreach($rs as $key=>$val){

            if($val['id'] == $selected){
                $selectedstr = "selected";
            }else{
                $selectedstr = "";
            }
            $str .= "<option $selectedstr value='".$val['id']."'>".$val['title']."</option>";
        }
        $str .= "</select>";
        return $str;
    } 
	public  function gettree11($pid=0,&$result=array(),$spac=0){
        $spac = $spac+2;
		$row = Db::getAll("SELECT * FROM ".DBPRE."article_class where pid=$pid and isdel=0 and isfabu=1 ORDER by rank asc ");
		if(!empty($row)){
			foreach($row as $v){
				if($v['pid']==0){
					$v['title'] = $v['title'];
				} else{
					$v['title'] = str_repeat('&nbsp;&nbsp;',$spac)."|--".$v['title'];
				}
				$result[] = $v;
				$this->gettree11($v['id'],$result,$spac);
			}
		} 
        return $result;
    }
    
    public function showviewsDo()
    {
          $lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
        $title='我的资讯';
        
        
      
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		
		//获取列表
		$condition=array();
		$condition['isdel']	= 0;
		$condition['releaseid']	= $mid;
		
		$news = M('article');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
		$list	= $news->getArticleList($condition,$page);
		$show_page=$page->show();  
		
		
		$member_list=M('member')->where(array('isdel'=>0,'isreview'=>1,'state'=>1,'id'=>array('neq',$mid)))->select();
		

        	include T('member_showviews');
    }
    
	
	//发布资讯
	public function addviewsDo(){
      header("Content-Security-Policy: upgrade-insecure-requests");

        $lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
        $title='发布资讯';
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition); 
		if (chksubmit()){
			$data = array(); 
			$data['pid']      = intval($_POST['pid']); 
			$data['rank']      = 0; 
			$data['title']      = trim($_POST['title']); 
			$data['shorttile']      = trim($_POST['shorttile']);
			$data['intro']      = trim($_POST['intro']);
			$data['content']  = htmlspecialchars_decode($_POST['content'], ENT_QUOTES); 
			$data['pic']      = trim($_POST['pic']); 
			$data['url']      = trim($_POST['url']); 
			$data['addtime']  = time(); 
			$data['mid']      = 0;
			$data['edittime']  = time(); 
			$data['editor']   = 0;
			$data['status']=1;
			$data['isreview']=0; 
			$data['revtime']  = 0; 
			$data['clicks']   = 0; 
			$data['ip']       = getIp();
			$data['seo_title']      = trim($_POST['seo_title']);
			$data['seo_keywords']      = trim($_POST['seo_keywords']);
			$data['seo_description']      = trim($_POST['seo_description']);
			$data['releaseid']      =  $mid;
			
			if(!$_POST['intro'])
			{
				$data['intro']    = clearHtmlText(str_cut(strip_tags($data['content']),200));//截取简介
			}	
			$result = M('article_list')->insert($data);
			if ($result){
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('发布成功！', { 
						time: 2000
					}, function(){
						window.location.href='/index.php?url=member';
					});  
					</script>";
				exit();
			}else {
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('发布失败！', { 
						time: 2000
					}, function(){
						window.history.back(-1);
					});  
					</script>";
				exit();
			}
		}
		include T('member_addviews');
    }	
	//编辑资讯
	public function editviewsDo(){

        $lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
        $title='编辑资讯';
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		$model=M('article_list');
		$condition1 	= array();
		$condition1['id'] = intval($_GET['id']);
		$info = $model->where($condition1)->find();
		if (empty($info)){
			echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
			echo '<script src="/public/layui/layui.all.js"></script>';
			echo "<script>
					layer.msg('没有找到此信息！', { 
						time: 2000
					}, function(){
						window.history.back(-1);
					});  
					</script>";
			exit();
		} 
		if (chksubmit()){
			$data = array(); 
			$data['pid']      = intval($_POST['pid']);  
			$data['title']      = trim($_POST['title']);  
			$data['intro']      = trim($_POST['intro']);
			$data['content']  = htmlspecialchars_decode($_POST['content'], ENT_QUOTES); 
			$data['pic']      = trim($_POST['pic']);  
			$data['edittime']  = time();  
			$data['ip']       = getIp();
			$data['releaseid']      =  $mid; 
			if(!$_POST['intro'])
			{
				$data['intro']    = clearHtmlText(str_cut(strip_tags($data['content']),200));//截取简介
			}	
			$condition2 	= array(); 
			$condition2['id'] = intval($_POST['id']); 
			$result = $model->where($condition2)->update($data); 
			if ($result){
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('编辑成功！', { 
						time: 2000
					}, function(){
						window.location.href='/index.php?url=member&do=views';
					});  
					</script>";
				exit();
			}else {
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('编辑失败！', { 
						time: 2000
					}, function(){
						window.history.back(-1);
					});  
					</script>";
				exit();
			}
		}
		include T('member_addviews');
    }
	
	
	// 转让资讯
    public function zhuanjiaoDo(){
		$mid=$_SESSION['member_id'];
		$zhuanjiao_mid=$_REQUEST['zhuanjiao_mid'];
		$id=$_REQUEST['id'];
		if(empty($id)){echo output_error('您转让资讯不存在！');exit();}
		if(empty($mid)){echo output_error('您未登陆请先登陆！');exit();}
		$article_list=getTableInfohanett($id,'article_list');
		if(empty($article_list)){echo output_error('您转让资讯不存在！');exit();}
		$memberinfo=getTableInfohanett($mid,'member');
		if(empty($memberinfo)){echo output_error('您的账户不存在，请联系管理员！');exit();}
		if($memberinfo['state']==0){echo output_error('您的账户已被禁用，请联系管理员！');exit();} 
		
		if($zhuanjiao_mid==$mid){echo output_error('不能转让给自己！');exit();} 
		$jieshou_memberinfo=getTableInfohanett($zhuanjiao_mid,'member');
		if(empty($jieshou_memberinfo)){echo output_error('您转让的账户不存在，请联系管理员！');exit();}
		if($jieshou_memberinfo['state']==0){echo output_error('您转让的账户已被禁用，请联系管理员！');exit();}
		
		$ress=M('article_list')->where(array('id'=>$id,'isdel'=>0))->update(array('releaseid'=>$zhuanjiao_mid,'edittime'=>time()));
		if($ress){
			echo output_data(array('msg'=>'转让资讯成功！'));exit();
		}else{
			echo output_error('转让资讯失败！');exit();
		}	
		
    } 
	
	
	// 我的资料
    public function profileDo(){
header("Content-Security-Policy: upgrade-insecure-requests");

        $lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
        $title='我的资料';
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		include T('member_profile');
		
    }	
	//资料编辑
	public function infosaveDo(){
		$lang = Language::getLangContent();

		$myinfo = M('member');
		$data=array();
		$condition=array();
 
		$condition['id']=$_SESSION['member_id'];
		$data['sex']=$_POST['sex'];
		$data['officeid']=$_POST['office'];
		if(!empty($_POST['password'])){
			$data['password']      = getPwd(trim($_POST['password']));
		}
		$data['mobile']=$_POST['mobile']; 
		$data['truename']=$_POST['truename'];
		$data['avatar']=$_POST['avatar'];
		$result = $myinfo->editMember($condition, $data);
		if($result == true){
			echo '{"status":"1"}';
			exit;
		}else{
			echo '{"status":"0"}';
			exit;
		}
	}
    
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}