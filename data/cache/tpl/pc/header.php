<?php defined('SSZCMS') or exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<meta name="keywords" content="<?php if(empty($keywords)) { ?><?php echo C('site_keywords');?><?php } else { ?><?php echo $keywords;?><?php } ?>
" />
<meta name="description" content="<?php if(empty($description)) { ?><?php echo C('site_description');?><?php } else { ?><?php echo $description;?><?php } ?>
" />
<meta name="author" content="<?php echo C('site_name');?>" />  
<link href="//at.alicdn.com/t/font_759613_byou54gk0v7.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/public/css/style.css" />
<script language="javascript" type="text/javascript" src="/public/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="/public/js/jquery.superslide.js"></script>
<link rel="stylesheet" href="/public/css/layui.css"  media="all">
<script src="/public/layui/layui.js"></script> 
<script type="text/javascript"> 
//全局变量
var GV = {
ROOT: "/",
WEB_ROOT: "",
JS_ROOT: "/public/js/",
TMPL: "/public/"
};
</script>
</head>
<body>
<!--top区域 start-->
<div class="top_x w1min">
<div class="w1">
<div class="topx_left">
<div class="topx_logo"><img src="/public/images/header_logo.png" /></div>
<div class="topx_zi">
<h1><?php echo C('site_name');?></h1>
</div>
</div>
<div class="topx_right" id="ucenterlogin">
<?php if($_SESSION['is_login']) { ?> 
<dl class="login" >
你好, <span class="user-nickname">[<?php echo $_SESSION['member_name'];?>]</span>
<a href="<?php echo url('member','index');?>"><i class="iconfont icon-user"></i>会员中心</a>
<a href="<?php echo url('logout','index');?>">&nbsp;&nbsp;退出登录</a>
</dl>
<?php } else { ?> 
<dl class="offline" >
<a href="<?php echo url('login','index');?>" class="signin"><i class="iconfont icon-gongchandang"></i>登录</a>
</dl>
<?php } ?>
<div class="top-search">
<form method="GET" action="/index.php"  target="_blank">
<input type="hidden" name="url" value="news"/>
<input type="hidden" name="do" value="search"/>
<input type="text" name="keywords" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
<button class="layui-btn layui-bg-orange" lay-submit lay-filter="formDemo"><i class="iconfont icon-xiazai15"></i>搜索</button>
</form>
</div>
</div>
</div>
</div>
<div class="lang_mu w1min">
<ul class="layui-nav" lay-filter="">
   <li class="layui-nav-item <?php if($_GET['url']==''||$_GET['url']=='index') { ?>layui-this<?php } ?>
">
<a href="/" target="">
<b>首页</b>
</a>
</li>
    <?php $class_list=channel();?>
<?php if(is_array($class_list)) { foreach($class_list as $item) { ?>            
   <li class="layui-nav-item <?php if($_GET['pid']==$item['id']) { ?>layui-this<?php } ?>
">
<a href="<?php echo url('news','index',array('pid'=>$item['id']));?>" <?php if(!empty($item['son_channel'])) { ?>data-toggle="dropdown"<?php } ?>
><b><?php echo $item['title'];?></b></a>
        <?php if(!empty($item['son_channel'])) { ?>
        <dl class="layui-nav-child">
<?php $son_channel=$item['son_channel'];?>
<?php if(is_array($son_channel)) { foreach($son_channel as $item2) { ?>       
<dd><a href="<?php echo url('news','index',array('pid'=>$item2['id']));?>" target="_self"  ><?php echo $item2['title'];?></a></dd>
<?php } } ?> 
         </dl>
<?php } ?>

    </li>
<?php } } ?>
 <li class="layui-nav-item <?php if($_GET['url']=='onlines') { ?>layui-this<?php } ?>
">
<a href="<?php echo url('onlines','index');?>" target="">
<b>线上解疑平台</b>
</a>
</li>
<li class="layui-nav-item <?php if($_GET['url']=='integral') { ?>layui-this<?php } ?>
">
<a href="<?php echo url('integral','index');?>" target="">
<b>积分统计</b>
</a>
</li>
<li class="layui-nav-item <?php if($_GET['url']=='govent') { ?>layui-this<?php } ?>
">
<a href="<?php echo url('govent','index');?>" target="">
<b>智慧政务</b>
</a>
</li>
<li class="layui-nav-item <?php if($_GET['url']=='party') { ?>layui-this<?php } ?>
">
<a href="<?php echo url('party','index');?>" target="">
<b>党建系统</b>
</a>
</li>    
</ul>
<script>
//注意：导航 依赖 element 模块，否则无法进行功能性操作
layui.use('element', function(){
  var element = layui.element;
  
  //…
});
</script>
</div>
<!--top区域 end-->