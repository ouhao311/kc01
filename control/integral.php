<?php
// +----------------------------------------------------------------------
// | Name: 积分统计
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied'); 
class integralControl extends PcControl{

    public function __construct(){
        parent::__construct(); 
    }

    // 首页部分
    public function indexDo(){
		$lang = Language::getLangContent();
		$title="积分统计";
		$keywords=$classinfo['seo_keywords'];
		$description=$classinfo['seo_description'];
		
		$userlist=M('member')->where(array('isdel'=>0,'state'=>1,'isreview'=>1))->order('integral desc')->select(); 
			$mid=$_SESSION['member_id'];
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		include T('integral');
        
    }  
    //积分考核
   public function checkDo()
   {
      	$lang = Language::getLangContent();
		$title="积分考核"; 
	    $mid=$_SESSION['member_id']; 
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
		$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
	    $endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
	    $task= Db::getAll("SELECT count(`id`) as count FROM ".DBPRE."visit_list where memberid=".$mid." and addtime between ".$beginThismonth." and ".$endThismonth."  ORDER by id asc ");
        $userlist=M('member')->where(array('isdel'=>0,'state'=>1,'isreview'=>1))->order('integral desc')->limit(3)->select(); 
        //var_Dump($userlist);exit;
			include T('integral_check');
   }
   
   public function getdetailDo()
   {
       header('Content-type: application/json');
         $mid=$_SESSION['member_id']; 
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
    
       	$onestart=strtotime(date("Y")."-01-01 00:00:00");
		$oneend=strtotime(date("Y")."-01-30 23:59:59");
		$one=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$onestart." and ".$oneend."  ORDER by id asc ");
	    $onedata['AREA']="1月";
	    if(empty($one[0]['integral']))
	    {
	        $onedata['LANDNUM']=0;
	    }else{
	        $onedata['LANDNUM']=$one[0]['integral']; 
	    }
	   
	    $data[]=$onedata;
	    
	   $twostart=strtotime(date("Y")."-02-01 00:00:00");
		$twoend=strtotime(date("Y")."-02-30 23:59:59");
		$two=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$twostart." and ".$twoend."  ORDER by id asc ");
	    $twodata['AREA']="2月";
	     if(empty($two[0]['integral']))
	    {
	       $twodata['LANDNUM']=0;
	    }else{
	        $twodata['LANDNUM']=$two[0]['integral']; 
	    }
	   
	     $data[]=$twodata;
	     
	     
	     
	      $threestart=strtotime(date("Y")."-03-01 00:00:00");
		$threeend=strtotime(date("Y")."-03-30 23:59:59");
		$three=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$threestart." and ".$threeend."  ORDER by id asc ");
	    $threedata['AREA']="3月";
	    if(empty($three[0]['integral']))
	    {
	        $threedata['LANDNUM']=0;  
	    }else{
	        $threedata['LANDNUM']=$three[0]['integral'];  
	    }
	  
	     $data[]=$threedata;
	    
	   $fourstart=strtotime(date("Y")."-04-01 00:00:00");
		$fourend=strtotime(date("Y")."-04-30 23:59:59");
		$four=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$fourstart." and ".$fourend."  ORDER by id asc ");
	    $fourdata['AREA']="4月";
	    if(empty($four[0]['integral']))
	    {
	        $fourdata['LANDNUM']=0;  
	    }else{
	          $fourdata['LANDNUM']=$four[0]['integral'];
	    }
	  
	     $data[]=$fourdata;
	     
	     
	     
	    $fivestart=strtotime(date("Y")."-05-01 00:00:00");
		$fiveend=strtotime(date("Y")."-05-30 23:59:59");
		$five=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$fivestart." and ".$fiveend."  ORDER by id asc ");
	    $fivedata['AREA']="5月";
	    if(empty($five[0]['integral']))
	    {
	       $fivedata['LANDNUM']=0;   
	    }else{
	       $fivedata['LANDNUM']=$five[0]['integral'];   
	    }
	  
	     $data[]=$fivedata;
	     
	     
	       $sixstart=strtotime(date("Y")."-06-01 00:00:00");
		$sixend=strtotime(date("Y")."-06-30 23:59:59");
		$six=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$sixstart." and ".$sixend."  ORDER by id asc ");
	    $sixdata['AREA']="6月";
	    if(empty($six[0]['integral']))
	    {
	        $sixdata['LANDNUM']=0;  
	    }else{
	        $sixdata['LANDNUM']=$six[0]['integral'];  
	    }
	  
	     $data[]=$sixdata;
	     
	     
	        $sevenstart=strtotime(date("Y")."-07-01 00:00:00");
		$sevenend=strtotime(date("Y")."-07-30 23:59:59");
		$seven=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$sevenstart." and ".$sevenend."  ORDER by id asc ");
	    $sevendata['AREA']="7月";
	    if(empty($seven[0]['integral']))
	    {
	        $sevendata['LANDNUM']=0;  
	    }else{
	         $sevendata['LANDNUM']=$seven[0]['integral']; 
	    }
	  
	     $data[]=$sevendata;
	     
	     
	        $eightstart=strtotime(date("Y")."-08-01 00:00:00");
		$eightend=strtotime(date("Y")."-08-31 23:59:59");
		$eight=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$eightstart." and ".$eightend."  ORDER by id asc ");
	    $eightdata['AREA']="8月";
	    if(empty($eight[0]['integral']))
	    {
	       $eightdata['LANDNUM']=0;  
	    }else{
	         $eightdata['LANDNUM']=$eight[0]['integral'];
	    }
	   
	     $data[]=$eightdata;
	     
	     
	     
	        $ninestart=strtotime(date("Y")."-09-01 00:00:00");
		$nineend=strtotime(date("Y")."-09-31 23:59:59");
		$nine=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$ninestart." and ".$nineend."  ORDER by id asc ");
	    $ninedata['AREA']="9月";
	    if(empty($nine[0]['integral']))
	    {
	          $ninedata['LANDNUM']=0; 
	    }else{
	          $ninedata['LANDNUM']=$nine[0]['integral']; 
	    }
	 
	     $data[]=$ninedata;
	     
	     
	        $tenstart=strtotime(date("Y")."-10-01 00:00:00");
		$tenend=strtotime(date("Y")."-10-31 23:59:59");
		$ten=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$tenstart." and ".$tenend."  ORDER by id asc ");
	    $tendata['AREA']="10月";
	    if(empty($ten[0]['integral']))
	    {
	         $tendata['LANDNUM']=0; 
	    }else{
	       $tendata['LANDNUM']=$ten[0]['integral'];   
	    }
	  
	     $data[]=$tendata;
	     
	     
	         $elestart=strtotime(date("Y")."-11-01 00:00:00");
		$eleend=strtotime(date("Y")."-11-31 23:59:59");
		$ele=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$elestart." and ".$eleend."  ORDER by id asc ");
	    $eledata['AREA']="11月";
	    if(empty($ele[0]['integral']))
	    {
	       $eledata['LANDNUM']=0;  
	    }else{
	        $eledata['LANDNUM']=$ele[0]['integral']; 
	    }
	   
	     $data[]=$eledata;
	     
	     
	         $twestart=strtotime(date("Y")."-12-01 00:00:00");
		$tweend=strtotime(date("Y")."-12-31 23:59:59");
		$twe=Db::getAll("SELECT sum(`integral`) as integral FROM ".DBPRE."member_integral where mid=".$mid." and addtime between ".$twestart." and ".$tweend."  ORDER by id asc ");
	    $twedata['AREA']="12月";
	    if(empty($twe[0]['integral']))
	    {
	        $twedata['LANDNUM']=0;  
	    }else{
	        $twedata['LANDNUM']=$twe[0]['integral'];  
	    }
	  
	     $data[]=$twedata;
	     
	 output_data($data);exit();
   }
    public function integral()
    {
        
         $mid=$_SESSION['member_id']; 
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		$myinfo = M('member');
		$condition 	= array();
		$condition['id']	= $mid;
		$member= $myinfo->getMemberInfo($condition);
    
        
    }
	
	//总积分排行
	public function yearrankDo()
	{
	  	$lang = Language::getLangContent();
		$title="积分排行"; 
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('5');
		 $userlist=M('member')->where(array('isdel'=>0,'state'=>1,'isreview'=>1))->order('integral desc')->select(); 
		include T('integral_yearrank');  
	}
	//月积分增长排行
	public function monthrankDo()
	{
	    	$lang = Language::getLangContent();
		$title="月积分增长排行"; 
			include T('integral_monthrank');  
	}
}