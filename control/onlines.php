<?php
// +----------------------------------------------------------------------
// | Name: 线上解疑
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------

require "./aliyun-dysms-php-sdk/api_demo/SmsDemo.php";
defined('SSZCMS') or exit('Access Denied');

class onlinesControl extends PcControl{

    public function __construct(){
        parent::__construct(); 
    }

    // 首页部分
    public function indexDo(){
		$lang = Language::getLangContent();
		$keyword=$_GET['keywords']; 
		$title="线上解疑平台";
		$keywords=C('site_keywords');
		$description=C('site_description');
		//获取列表
		$condition=array();
		$condition['isreview']	= 1;
		$condition['isdel']	= 0; 
		
		$online = M('online');
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		$list	= $online->getonlineList($condition,$page);
		$show_page=$page->show();  
		
		$banner_list=getAdinfoList(2);
			$mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		//var_Dump(T('online'));exit;
		include T('online');
// 	$lang = Language::getLangContent();
// 		$title=C('site_name');
// 		$keywords=C('site_keywords');
// 		$description=C('site_description');
// 		//首页banner图
// 		$banner_list=getAdinfoList(1);
		
// 		$news = M('article');
// 		//头条列表
// 		$toutiao_list	= $news->getList('rec',1);  
// 	//var_dump($toutiao_list);exit;
// 		//特别推荐
// 		$banner3_list=getAdinfoList(3); 
		
// 		//最新20个会员
// 		$userlist=M('member')->where(array('isdel'=>0,'state'=>1,'isreview'=>1))->limit(20)->order('addtime desc')->select();
// 		   $lang = Language::getLangContent();
// 		$mid=$_SESSION['member_id'];
// 		$myinfo = M('member');
// 		$condition 	= array();
// 		$condition['id']	= $mid;
// 		$member= $myinfo->getMemberInfo($condition);
// 		//var_Dump($member,$mid);exit;
// 		//	var_Dump(T('index'));exit;
// 		//var_Dump(31321);exit;
// 		include T('index');
        
    } 
    public function progressDo()
    {
         $lang = Language::getLangContent();
		$mid=$_SESSION['member_id']; 
		if(empty($mid)){
			$mid=0;
		}
        $title='进度查询';
      
        $page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
	
		$show_page=$page->show();  
        $member=M("member")->where(array('id'=>$mid))->find();
       // var_Dump($member);exit;
       $list=M("online_list")->where(array('mobile'=>$member['mobile']))->select();
       //var_Dump($list,$member['mobile']);exit;
        	include T('online_progress');
    }
    //发送短信
    public function sendsmsDo()
    {
        
        session_start();

        $lang = Language::getLangContent();
        //var_Dump($_GET,44,$_POST);exit;
        $rand=rand(100000,999999);
        $con=[
            'phone'=>$_POST['number'],
            'rand'=>$rand,
            'code'=>"SMS_201451402",
            ];
        $result=SmsDemo::sendSms($con);
      
        if($result->Code=="OK"||$result->Code==OK)
        {
          
            $_SESSION['smscode']=$rand;
            //var_Dump($_SESSION);exit;
            //setXwCookie($con['phone'], $rand, 1*60);
            $msg=array('result'=>true, 'message'=>array('error'=>发送成功));
            exit(json_encode($msg));exit(); 
        }
           
        //var_Dump($result,$result->Code,444);exit;
    }
	//在线援助
	public function onlinehelpDo()
	{
	   $lang = Language::getLangContent();
		$mid=$_SESSION['member_id']; 
		if(empty($mid)){
			$mid=0;
		}
        $title='在线援助';
        $page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
	
		$show_page=$page->show();  
        $organ=M("member")->where(array('isorgan'=>1))->select();
       
        foreach($organ as $k=>&$v)
        {
            $officed=M("office_list")->where(array('id'=>$v['officeid']))->find();
            $v['offdata']=$officed['title'];
            $departd=M("depart_list")->where(array('id'=>$officed['pid']))->find();
            $v['depadata']=$departd['title'];
        }
        //var_Dump(31321321);exit;
        
    	include T('online_help');
	}
	public function replayonlineDo()
	{
	   	$lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
		if(empty($mid)){
			$mid=0;
		}
	
        $title='解疑平台提问'; 
        $mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		$id=$_GET['id'];
	
		$onlinedata=M('online_list')->where(array('id'=>$id))->find();
		if(!empty($_POST['replyinfo']) && !empty($_POST['id']))
		{
		    $result=M('online_list')->where(array('id'=>$id))->update(array('replyinfo'=>$_POST['replyintro']));
		    
		    $msg=array('result'=>true, 'message'=>array('error'=>回复成功));
            exit(json_encode($msg));exit(); 
		} 
	}
	//查看问题回复
	 public function answerDo()
	 {
	     	$lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
		if(empty($mid)){
			$mid=0;
		}
        $title='问题回复列表'; 
        $mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		$id=$_GET['id'];
		$list=M("online_replylist")->where(array('onlineid'=>$id))->select();
//	var_Dump($list);exit;
	$banner_list=getAdinfoList(2);
	
	$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		$show_page=$page->show();  
            include T('online_answer');
	 }
	 //用户回复详情
	 public function useranswerDo()
	 {
	    	$lang = Language::getLangContent();
	     		$id=$_GET['id'];
        $title='用户反馈列表';
         $mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
        	$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		$show_page=$page->show();  
		$list=M('online_replylist')->where(array('onlineid'=>$id))->select();
		 include T('online_useranswer');
	 }
	 
	  //用户打分fun
	 public function changegradeDo()
	 {
	     	$lang = Language::getLangContent();
	     		$id=$_GET['id'];
        $title='回复评价'; 
        if (chksubmit()){
			$data = array();
			
			$insert['grade']=$_POST['satisfaction'];
		
			$result=M('online_list')->where(array('id'=>$_GET['id']))->update($insert);
				if ($result){
				    
				    $madata=M('online_list')->where(array('id'=>$_GET['id']))->find();
				    
				    
				    $mainfo=getTableInfohanett($madata['managid'],'member');
						//更新积分
						if($_POST['satisfaction']=="1")//满
						{
						    $upcredit=10;
						}
							if($_POST['satisfaction']=="2")//满
						{
						    $upcredit=5;
						}
							if($_POST['satisfaction']=="3")//满
						{
						    $upcredit=-2;
						}
						
						M('member')->where(array('id'=>$madata['managid']))->update(array('integral'=>$madata['integral']+$upcredit));
						$this->log('用户评价'.'['.$info['title'].']成功奖励'.$upcredit.'积分',null);
				    
				    
				    
				    
				    
				    
				    
				    
				    
				    
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('回复成功！', { 
						time: 2000
					}, function(){
						window.location.href='/index.php?url=task&do=myunquest';
					});  
					</script>";
				exit();
			}else {
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('提交失败！', { 
						time: 2000
					}, function(){
						window.history.back(-1);
					});  
					</script>";
				exit();
			}			}



			
			
			  include T('online_changegrade');
	 }
	   public function log($lang = '', $state = 1, $admin_name = '', $admin_id = 0) {
        if (!C('sys_log') || !is_string($lang)) return;
        if ($admin_name == ''){
            $admin = unserialize(decrypt(cookie('sys_key'),MD5_KEY));
            $admin_name = $admin['name'];
            $admin_id = $admin['id'];
        }
        $data = array();
        if (is_null($state)){
            $state = null;
        }else{
            $state = $state ? '' : L('hx_fail');
        }
        $data['content']    = $lang.$state;
        $data['admin_name'] = $admin_name;
        $data['createtime'] = TIMESTAMP;
        $data['admin_id']   = $admin_id;
        $data['ip']         = getIp();
        $data['url']        = $_REQUEST['url'].'&'.$_REQUEST['do'];
        return M('admin_log')->insert($data);
    }
	 
	 //用户打分
	 public function dogradeDo()
	 {
	     	$lang = Language::getLangContent();
	     		$id=$_GET['id'];
        $title='回复评价'; 
        if (chksubmit()){
			$data = array();
			
			$insert['gradecontent']=$_POST['gradecontent'];
		
			$result=M('online_replylist')->where(array('id'=>$_GET['id']))->update($insert);
				if ($result){
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('回复成功！', { 
						time: 2000
					}, function(){
						window.location.href='/index.php?url=task&do=myquest';
					});  
					</script>";
				exit();
			}else {
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('提交失败！', { 
						time: 2000
					}, function(){
						window.history.back(-1);
					});  
					</script>";
				exit();
			}
			};
			
			  include T('online_dealgrade');
	 }
	 //工作人员处理问题页面
	 public function dealquestDo()
	 {
	     	$lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
		if(empty($mid)){
			$mid=0;
		}
		$id=$_GET['id'];
        $title='处理问题'; 
        $mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		
		if (chksubmit()){
			$data = array();
			$insert['replycontent']=$_POST['content'];
			$insert['onlineid']=$_POST['id'];
			$insert['managerid']=$mid;
			$result=M('online_replylist')->insert($insert);
				if ($result){
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('回复成功！', { 
						time: 2000
					}, function(){
						window.location.href='/index.php?url=task&do=myquest';
					});  
					</script>";
				exit();
			}else {
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('提交失败！', { 
						time: 2000
					}, function(){
						window.history.back(-1);
					});  
					</script>";
				exit();
			}
			};
		  include T('online_dealquest');
	 }
	// 提问
    public function addDo(){
     
            //   header("Content-Security-Policy: upgrade-insecure-requests");

		$lang = Language::getLangContent();
		$mid=$_SESSION['member_id'];
		if(empty($mid)){
			$mid=0;
		}
		
		//var_Dump($_SESSION);exit;
        $title='解疑平台提问'; 
        $mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		$id=$_GET['id'];
	
		$onlinedata=M('online_list')->where(array('id'=>$id))->find();
	
		if (chksubmit()){
			$data = array(); 
			//var_Dump($_POST);exit;
			$id=$_GET['id'];
			//var_Dump($id);exit;
			$data['title']      = trim($_POST['title']);  
			$data['name']      = trim($_POST['name']);  
			$data['age']      = trim($_POST['age']);  
			$data['mobile']      = trim($_POST['mobile']);  
			$data['intro']      = trim($_POST['intro']);  
			$data['pic']      = trim($_POST['pic']);  
			$data['video']      = trim($_POST['video']);  
			$data['audio']      = trim($_POST['audio']);  
			$data['content']      = trim($_POST['content']); 
			$data['village']      = trim($_POST['village']); 
			$data['managid']      = trim($_POST['managid']); 
			$data['addtime']  = time();  
			$data['ip']       = getIp(); 
			if(!empty($_POST['isreview']))
			{ 
			    if($_POST['isreview']<0)
			    {
			      	$data['isreview'] = 0;  
			    }else{
			       	$data['isreview'] = trim($_POST['isreview']); 
			    }
			  
			  	$data['revtime']=time();
			  	$data['revid']=$mid;
			}
			
			
				if(!empty($_POST['istopreview']))
			{
			    if(trim($_POST['istopreview'])<0)
			    {
			      	$data['istopreview'] = 0;  
			    }else{
			      	$data['istopreview'] = trim($_POST['istopreview']);  
			    }
			  
			  	$data['toprevtime']=time();
			  	$data['toprevid']=$mid;
			}
		
			$data['releaseid']      =  $mid;
			$code= (int)$_POST['verifyCode'];
			$usercode=$_SESSION['smscode'];
		//	var_Dump($_POST);exit;
		if(empty($id))
		{
		    	if($code!==$usercode)
			{
			    	echo '<script src="/public/layui/layui.all.js"></script>';
			    	echo "<script>
					layer.msg('验证码错误！', { 
						time: 2000
					}, function(){
						window.location.href='/index.php?url=online&do=add';
					});  
					</script>";
				exit();
			}else{
			    $result = M('online_list')->insert($data);/* echo M('online_list')->getLastSql(); */
			if ($result){
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('提交成功，请耐心等待回复！', { 
						time: 2000
					}, function(){
						window.location.href='/index.php?url=online';
					});  
					</script>";
				exit();
			}else {
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('提交失败！', { 
						time: 2000
					}, function(){
						window.history.back(-1);
					});  
					</script>";
				exit();
			}
			}
		}else{
		   	    $result = M('online_list')->where(array('id'=>$id))->update($data);/* echo M('online_list')->getLastSql(); */
			if ($result){
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('审核成功！', { 
						time: 2000
					}, function(){
						window.location.href='/index.php?url=online&do=add';
					});  
					</script>";
				exit();
			}else {
				echo '<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">';
				echo '<script src="/public/layui/layui.all.js"></script>';
				echo "<script>
					layer.msg('审核失败！', { 
						time: 2000
					}, function(){
						window.history.back(-1);
					});  
					</script>";
				exit();
			} 
		}
		
	
			 
			
		}
		//var_Dump(12312);exit;
		$banner_list=getAdinfoList(2);
		include T('online_add');
    } 
		public  function puttree11($pid=0,$selected=0){
        $rs = M("member")->where(array('isorgan'=>1,'isdel'=>0))->select();
      //var_dump($rs);exit; 
        $str='';
        $str .= "<select name='managid' id='managid' >";
        $str .= '<option value="">请选择工作人员</option>';
        foreach($rs as $key=>$val){

            if($val['id'] == $selected){
                $selectedstr = "selected";
            }else{
                $selectedstr = "";
            }
            $str .= "<option $selectedstr value='".$val['id']."'>".$val['username']."</option>";
        }
        $str .= "</select>";
        return $str;
    } 
	
}