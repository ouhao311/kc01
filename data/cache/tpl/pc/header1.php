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
<div class="top_u w1min">
<div class="w1">
<div class="topu_left">
<div class="topu_logo"><img src="/public/images/header_logo.png" /></div>
<div class="topu_zi"><h1><?php echo C('site_name');?></h1></div>
</div>
<div class="topu_right">
<dl><a href="/"><i class="iconfont icon-dangwugongkai"></i>首页</a></dl>
</div>
</div>
</div>
<!--top区域 end-->