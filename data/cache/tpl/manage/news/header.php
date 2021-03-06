<?php defined('SSZCMS') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  
<link href="<?php echo ADMIN_TEMPLATES_URL?>/css/index.css" rel="stylesheet" type="text/css">
<link href="<?php echo ADMIN_RESOURCE_URL?>/font/css/font-awesome.min.css" rel="stylesheet" />
<link href="<?php echo ADMIN_RESOURCE_URL?>/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo EXT_URL;?>/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css"/>
<style type="text/css">html, body { overflow: visible;}</style>
<link rel="stylesheet" href="<?php echo EXT_URL;?>/js/layui/css/layui.css"  media="all">
<link rel="stylesheet" href="<?php echo EXT_URL;?>/formSelects/formSelects-v4.css"  media="all">
<link rel="stylesheet" type="text/css" href="<?php echo EXT_URL;?>/fonts/iconfont.css"/>
<script type="text/javascript">
var SITEURL = '<?php echo SITE_URL;?>';
var MEMBER_SITE_URL = '<?php echo MEMBER_SITE_URL;?>';
var RESOURCE_SITE_URL = '<?php echo EXT_URL;?>';
var MICROSHOP_SITE_URL = '<?php echo MICROSHOP_SITE_URL;?>';
var CIRCLE_SITE_URL = '<?php echo CIRCLE_SITE_URL;?>';
var ADMIN_TEMPLATES_URL = '<?php echo ADMIN_TEMPLATES_URL;?>';
var LOADING_IMAGE = "<?php echo ADMIN_TEMPLATES_URL.DS.'images/loading.gif';?>";
var ADMIN_RESOURCE_URL = '<?php echo ADMIN_RESOURCE_URL;?>';
</script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/admin.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/dialog/dialog.js" id="dialog_js"></script>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/flexigrid.js"></script>
<script type="text/javascript" src="<?php echo EXT_URL;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo EXT_URL;?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo EXT_URL;?>/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo EXT_URL;?>/js/jquery.mousewheel.js"></script>
<script src="<?php echo EXT_URL;?>/js/layui/layui.all.js" charset="utf-8"></script> 
<script src="<?php echo EXT_URL;?>/js/layui/layui.js" charset="utf-8"></script> 
<script type="text/javascript" charset="utf-8" src="<?php echo EXT_URL;?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo EXT_URL;?>/ueditor/ueditor.all.min.js"> </script> 
<script type="text/javascript" charset="utf-8" src="<?php echo EXT_URL;?>/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body style="background-color: #FFF; overflow: auto;">
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL?>/js/jquery.picTip.js"></script>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>