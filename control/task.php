<?php
// +----------------------------------------------------------------------
// | Name: 会员中心
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

class taskControl extends BaseMemberControl{
	
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
		
		include T('member');
    }
    
    //我提出的问题
    public function myunquestDo()
	{
	    	$mid=$_SESSION['member_id'];
		$id=$_REQUEST['id'];
			$myinfo = M('member');
				$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		  $title='我的提问';
		  $page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
	
		$show_page=$page->show();
		$model = M('online_list');
	      $where['releaseid']=$mid;
	      //$where['mobile']=$member['mobile'];
// 		$visit_list=$model->where($where)
		
// 		->select();
     $dodeal=!empty($_REQUEST['dodeal'])?$_REQUEST['dodeal']:0;
    //  if($dodeal=="1")
    //  {
    //   $visit_list= Db::getAll("SELECT * FROM ".DBPRE."online_list where releaseid=".$mid." and ( isreview=1 and istopreview=1  ) "." or mobile=".$member['mobile']." and ( isreview=1 and istopreview=1  ) ORDER by id desc ");
  
    //  }else{
        
    //       $visit_list= Db::getAll("SELECT * FROM ".DBPRE."online_list where releaseid=".$mid." and ( isreview=0 or istopreview=0 ) "." or mobile=".$member['mobile']." and (isreview=0 or istopreview=0)  ORDER by id desc ");
    //  }
     //var_dump($visit_list,444);exit;
       $visit_list= Db::getAll("SELECT * FROM ".DBPRE."online_list where releaseid=".$mid." or mobile=".$member['mobile']."   ORDER by id desc ");
			if(empty($mid)){echo output_error('您未登陆请先登陆！');exit();}
				include T('myunquest');
	}
	//
	public function mytaskDo()
	{
	    	$mid=$_SESSION['member_id'];
		$id=$_REQUEST['id'];
			$myinfo = M('member');
				$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		  $title='我的任务';
		  $page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
	
		$show_page=$page->show();
		$model = M('visit_list');
		//var_Dump($member['identity']);exit;
		$dodeal=!empty($_REQUEST['dodeal'])?$_REQUEST['dodeal']:0;
		
	    if($member['identity']=="1")
	    {
	        if($dodeal=="1")
	        {
	          $visit_list=Db::getAll("SELECT * FROM ".DBPRE."visit_list where memberid=".$mid." and status=1 and topstatus=1  ORDER by id asc ");   
	        }else{
	             $visit_list=Db::getAll("SELECT * FROM ".DBPRE."visit_list where memberid=".$mid." and status=0 or topstatus=0  ORDER by id asc ");
	        }
	       
	        //$visit_list=$model->where(array('memberid'=>$mid))->order('id desc')->select();
	    }
		
		
		 if($member['identity']=="2")
	    {
	        if($dodeal=="1")
	        {
	           $visit_list=$model->where(array('status'=>1,'statuid'=>$mid))->order('id desc')->select();  
	        }else{
	             $visit_list=$model->where(array('status'=>0))->order('id desc')->select();
	        }
	       
	    }
	    
	     if($member['identity']=="3")
	    {
	        if($dodeal=="1")
	        {
	            $visit_list=$model->where(array('topstatus'=>1,'status'=>1,'topstatuid'=>$mid))->order('id desc')->select();  
	        }else{
	            $visit_list=$model->where(array('topstatus'=>0,'status'=>1))->order('id desc')->select();    
	        }
	      
	    }
          $officedata=M('office_list')->where(array('id'=>$member['officeid']))->select();
         $departdata=M('depart_list')->where(array('id'=>$officedata[0]['pid']))->select();
		foreach($visit_list as &$v)
		{
		    $minfo=M('member')->where(array('id'=>$v['managerid']))->select();
		   $v['truename']=$minfo[0]['truename'];
		}
	//var_dump($visit_list);exit;
		
			if(empty($mid)){echo output_error('您未登陆请先登陆！');exit();}
				include T('mytask');
	}
		public function myquestDo()
	{
	    	$mid=$_SESSION['member_id'];
		    $id=$_REQUEST['id'];
			$myinfo = M('member');
				$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		  $title='解决问题';
		  $page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('5');
	
		$show_page=$page->show();
		$model = M('online_list');
	//var_Dump($_REQUEST);exit;
	$dodeal=!empty($_REQUEST['dodeal'])?$_REQUEST['dodeal']:0;
	if($member['identity']=="2")
	{
	    if($dodeal=="1")
	    {
	      	 $visit_list=$model->where(array('isreview'=>1,'revid'=>$mid))->order('id desc')->select();
  
	    }else{
	        $visit_list=$model->where(array('isreview'=>0))->order('id desc')->select();

	    }
       
	}elseif($member['identity']=="3"){
	    if($dodeal=="1")
	    {
	     	$visit_list=$model->where(array('istopreview'=>1,'isreview'=>1,'toprevid'=>$mid))->order('id desc')->select();   
	    }else{
	        	$visit_list=$model->where(array('istopreview'=>0,'isreview'=>1))->order('id desc')->select();
	    }
	    	   

	}else{
	    //Db::getAll("SELECT * FROM ".DBPRE."user_clock where mid=".$mid." and createtime>".'"'.date("Y-m-d 8:30:00").'"'."   ORDER by id asc ");
	    if($dodeal=="1")
	    {
	        $visit_list=Db::getAll("SELECT * FROM ".DBPRE."online_list where managid=".$mid." and isreview=1 and istopreview=1  ORDER by id asc ");
	    }else{
	       $visit_list=Db::getAll("SELECT * FROM ".DBPRE."online_list where managid=".$mid." and isreview=0 or istopreview=0  ORDER by id asc ");  
	    }
	  
        
	}
	
	
	//var_dump($visit_list);exit;
		
			if(empty($mid)){echo output_error('您未登陆请先登陆！');exit();}
				include T('myquest');
	}
	
	public function finitaskDo()
	{
	    	$mid=$_SESSION['member_id'];
		$id=$_REQUEST['id'];
		//$visitd=$_REQUEST['visitid'];
			if(empty($mid)){echo output_error('您未登陆请先登陆！');exit();}
				$condition 	= array();
		$conditions['id']	= $mid;
		$member= M('member')->getMemberInfo($conditions);
			$condition['visitid']=$id;
			$visitdetail=M('visit_detail_list')->where($condition)->select();
			//var_Dump($visitdetail,$condition);exit;
	        $office_list=M('office_list')->where()->select();
				if (chksubmit()){
				    $data['reception']=$_POST['reception'];
				    $data['depart']=$_POST['depart'];
				      $data['qustion']=$_POST['qustion'];
				        $data['itemcategory']=$_POST['itemcategory'];
				          $data['processmode']=$_POST['processmode'];
				                  $data['lat']=$_POST['lat'];
				                    $data['lng']=$_POST['lng'];
				                    $data['address']=$_POST['address'];
				                    if(!empty($_GET['id']))
				                    {
				                          $data['visitid']=$_GET['id'];
				                    }
				                  
				            if(!empty($_POST['status'])||!empty($_POST['topstatus']))
				            {
				                if(!empty($data['status']))
				                {
				                   $data['status']=$_POST['status'];
				                if($data['status']<0)
				                {
				                    $data['status']=0;
				                }
				                $data['statuid']=$mid;
				                }
				               
				               
				               if(!empty($_POST['topstatus']))
				               {
				                   $data['topstatus']=$_POST['topstatus'];
				                if($data['topstatus']<0)
				                {
				                    $data['topstatus']=0;
				                }
				                $data['topstatuid']=$mid;
				               }
				                
				               // var_dump($data);exit;
				                $result= M('visit_detail_list')->where(array('visitid'=>$id))->update($data); 
				            }else{
				                $result= M('visit_detail_list')->insert($data); 
				            }
                          
                             //var_Dump($data,6666,$result);exit; 
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
			//var_Dump($office_list);exit;
				include T('finitask');
	}
	
		public function taskmanageDo()
	{
	    	$mid=$_SESSION['member_id'];
		    $id=$_REQUEST['id'];
		    $condition['id']	= $mid;
		    $myinfo = M('member');
		    $member= $myinfo->getMemberInfo($condition);
		    $model = M('visit_list');
	
	    	$visit_list=$model->where(array('memberid'=>$mid))->select();
             $officedata=M('office_list')->where(array('id'=>$member['officeid']))->select();
            $departdata=M('depart_list')->where(array('id'=>$officedata[0]['pid']))->select();
			if(empty($mid)){echo output_error('您未登陆请先登陆！');exit();}
			$title='分配任务管理';
            $page	= new Page();
    		$page->setEachNum(10);
    		$page->setStyle('5');
    	
    		$show_page=$page->show(); 
    		$dodeal=!empty($_REQUEST['dodeal'])?$_REQUEST['dodeal']:0;
    		//var_Dump($member['identity']);exit;
    		if($member['identity']=="2")
    		{
    		    if($dodeal=="1")
    		    {
    		        $task=M('visit_list')->where(array('status'=>1,'statuid'=>$mid))->order('id desc')->select();  
    		        $status="通过";
    		    }else{
    		       $task=M('visit_list')->where(array('status'=>0))->order('id desc')->select();   
    		        $status="未通过";
    		    }
    		   
    		}
    		if($member['identity']=="3")
    		{
    		    if($dodeal=="1")
    		    {
    		        $task=M('visit_list')->where(array('status'=>1,'topstatus'=>1,'topstatuid'=>$mid))->order('id desc')->select();    
    		         $status="通过";
    		    }else{
    		          $task=M('visit_list')->where(array('status'=>1,'topstatus'=>0))->order('id desc')->select();  
    		           $status="未通过";
    		    }
    		  
    		}
    	//	var_dump($task);exit;
    		
    		if($member['identity']=="1")
    		{
    		    if($dodeal=="1")
    		    {
    		       $task=Db::getAll("SELECT * FROM ".DBPRE."visit_list where managerid=".$mid." and status=1 and topstatus=1  ORDER by id asc ");  
    		        $status="通过";
    		    }else{
    		         $task=Db::getAll("SELECT * FROM ".DBPRE."visit_list where managerid=".$mid." and status=0 or topstatus=0  ORDER by id asc "); 
    		          $status="未通过";
    		    }
    		     
    		    //$task=M('visit_list')->where(array('managerid'=>$mid))->order('id desc')->select();  
    		}
			 
			  foreach($task  as &$ta)
			  {
			     // if(empty($ta['status']))
			     // {
			     //     $ta['state']="未通过";
			     // }else{
			     //    $ta['state']="通过"; 
			     // }
			     $ta['state']=$status;
			      $myinfos=$myinfo->getMemberInfo(array('id'=>$ta['memberid']));
			      $vidata=M('visit_detail_list')->where(array('visitid'=>$ta['id']))->select();
			      if(!empty($vidata))
			      {
			          $ta['states']="是";
			      }else{
			          $ta['states']="否"; 
			      }
			      $ta['mebes']=$myinfos['truename'];
			  }
			  //var_Dump($task);exit;
				include T('taskmanage');
	}
	
	public function clockDo()
	{
	   	$mid=$_SESSION['member_id'];
	   	//var_Dump($mid);exit;
		$id=$_REQUEST['id'];
		$condition['id']	= $mid;
		    $myinfo = M('member');
		    $member= $myinfo->getMemberInfo($condition);
		$mapurl="https://map.qq.com/api/js?v=2.exp&key=NRYBZ-XEBKD-ETX4E-HJIQT-63SQT-3EFRM";
			if(empty($mid)){echo output_error('您未登陆请先登陆！');exit();}
			
		if(!empty($_POST))
		{
		    
		    if(strtotime(date("Y-m-d H:m:s"))<strtotime(date("Y-m-d 8:30:00"))||strtotime(date("Y-m-d H:m:s"))>strtotime(date("Y-m-d 17:30:00")))
		    {
		       //var_Dump(31312);exit;
		        if(strtotime(date("Y-m-d H:m:s"))<strtotime(date("Y-m-d 8:30:00")))
		        {
		           	exit('{"err":"1","msg":"不在打卡范围内！"}'); 
		        }else{
		             $clodata=Db::getAll("SELECT * FROM ".DBPRE."user_clock where mid=".$mid." and createtime>".'"'.date("Y-m-d 8:30:00").'"'."   ORDER by id asc ");
		             if(empty($clodata))
		             {
		                    $data['mid']=$mid;
                		    $data['lat']=$_POST['lat'];
                		    $data['lng']=$_POST['lng'];
                		    $data['address']=$_POST['address'];
                		    $data['credit']=-1;
                		    $result=M('user_clock')->insert($data);
		     
		                 
		                 
		                $memberinfo=getTableInfohanett($mid,'member');
						//更新积分
						M('member')->where(array('id'=>$mid))->update(array('integral'=>$memberinfo['integral']-1));
						$this->log('打卡'.date("Y-m-d").'迟到减掉1积分',null);
						//写入积分记录
						$data_record = array();
						$data_record['mid']=$mid;  
						$data_record['integral']=-1;
						$data_record['type']=1;
						$data_record['addtime']=time();
						$data_record['source']=1;
						$data_record['intro']='打卡'.date("Y-m-d").'迟到减掉1积分';
						M("member_integral")->insert($data_record);
		           
		           
		           
		           	exit('{"err":"1","msg":"迟到打卡！"}');  
		             }
		             
		           
		           
		            
		        }
		        
		    }else{
		        //var_Dump(555);exit;
		          $clodata=Db::getAll("SELECT * FROM ".DBPRE."user_clock where mid=".$mid." and createtime>".'"'.date("Y-m-d 8:30:00").'"'."   ORDER by id asc ");
		          //$clodata=0;
		     if(!empty($clodata))
		     {
		        
		     // var_dump($result);exit;
		   
		        	exit('{"err":"1","msg":"今天已经刚打过卡,请勿重复打卡！"}');
		  
		     }else{
		         
		         $data['mid']=$mid;
		    $data['lat']=$_POST['lat'];
		    $data['lng']=$_POST['lng'];
		    $data['address']=$_POST['address'];
		     $data['credit']=5;
		    $result=M('user_clock')->insert($data);
		     
		     
		     
		            $memberinfo=getTableInfohanett($mid,'member');
						//更新积分
						M('member')->where(array('id'=>$mid))->update(array('integral'=>$memberinfo['integral']+5));
						$this->log('打卡'.date("Y-m-d").'成功奖励5积分',null);
						//写入积分记录
						$data_record = array();
						$data_record['mid']=$mid;  
						$data_record['integral']=5;
						$data_record['type']=1;
						$data_record['addtime']=time();
						$data_record['source']=1;
						$data_record['intro']='打卡'.date("Y-m-d").'成功奖励5积分';
						M("member_integral")->insert($data_record);
		     
		     
		     
		     
		     
		     
		     
    		    if(!empty($result))
    		    {
    		        	exit('{"err":"1","msg":"打卡成功！"}');
    		    } 
		     }
		   
		    }
		   
		}
		      
				include T('clock'); 
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

	
	
	 public function detailtaskDo()
	 {
	    	$mid=$_SESSION['member_id'];
		    $id=$_REQUEST['id'];
		 $condition['id']	= $mid;
		    $myinfo = M('member');
		    $member= $myinfo->getMemberInfo($condition);
		    $data=M('visit_list')->where(array('id'=>$id))->find();
		    //var_Dump($data);exit;
		      if (chksubmit()){
            $data = array();  
         // var_Dump($_POST);exit;
            $id=$_GET['id'];
			$data['name']      = trim($_POST['name']);  
			$data['managerid']      = trim($_POST['managemember']); 
		
			$data['memberid']      = $mid;  
			$data['startdate']      = trim($_POST['startdate']);  
			$data['enddate']      = trim($_POST['enddate']); 
			$data['isself']=1;
			$data['address'] = trim($_POST['address']);
			$data['addtime']  = time();
		//	var_dump($_POST);exit;
	                if(!empty($_POST['status'])||!empty($_POST['topstatus']))
				            {
				                if(!empty($_POST['status']))
				                {
				                   $data['status']=$_POST['status'];
				                if($data['status']<0)
				                {
				                    $data['status']=0;
				                }
				                $data['statuid']=$mid;
				                }
				               
				               
				               if(!empty($_POST['topstatus']))
				               {
				                   $data['topstatus']=$_POST['topstatus'];
				                if($data['topstatus']<0)
				                {
				                    $data['topstatus']=0;
				                }
				                $data['topstatuid']=$mid;
				               }
				                
				               //var_dump($_POST,444,$data,555,$id);exit;
				                $result= M('visit_list')->where(array('id'=>$id))->update($data); 
				            }else{
				                	$result = M('visit_list')->insert($data);
				            }
		
				//var_Dump($this->name,333,$data);exit;
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
				echo "<script>window.parent.layer.closeAll();window.parent.$('#flexigrid').flexReload();window.parent.layer.msg('操作失败');</script>";
				exit();
			}
        }
			include T('detailtask');
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
	
	//发布资讯
	public function addviewsDo(){

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
		$data['department']=$_POST['department'];
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