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
<style type="text/css">
.mgtop-15{width:660px;margin:0; padding:10px 20px 20px 20px;}
</style>
</head>
<body>
<div class="mgtop-15">
<table class="layui-table">
<colgroup>
  <col width="100">
  <col>
</colgroup>
<tbody>
  <tr>
<td>姓名:</td>
<td><?php echo $info['truename'];?></td>
  </tr>
  <tr>
<td>性别:</td>
<td><?php echo getSinglePas($table='attribute','sex',$info['sex'],'title');?></td>
  </tr>
  <tr>
<td>积分:</td>
<td><?php echo $info['integral'];?></td>
  </tr>
  <tr>
<td>手机号:</td>
<td><?php echo $info['mobile'];?></td>
  </tr>
  <tr>
<td>职能部门:</td>
<td><?php echo getSinglePas($table='attribute','department',$info['department'],'title');?></td>
  </tr>
</tbody>
  </table>
</div> 
</body>
</html>