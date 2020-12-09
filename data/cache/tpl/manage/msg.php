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
<meta charset="<?php echo CHARSET;?>">
<title><?php echo $html_title;?></title>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/index.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="msgpage">
  <div class="msgbox">
    <div class="pic"></div>
    <div class="con">
      <?php echo $msg;?>
    </div>
<?php if($time) { ?>
    <?php if(($is_show)) { ?>
    <div class="scon"><?php echo L('hx_auto_redirect');?></div>
    <div class="button">
      <?php if (is_array($url)){ foreach($url as $k => $v){ ?>
      <a href="<?php echo $v['url'];?>" class="ncap-btn"><?php echo $v['msg'];?></a>
      <?php } ?>
 
      <script type="text/javascript"> window.setTimeout("javascript:location.href='<?php echo $url['0']['url'];?>'", <?php echo $time;?>); </script>
     
      <?php }else { if ($url != ''){ ?>
      <a href="<?php echo $url;?>" class="ncap-btn"><?php echo L('hx_back_to_pre_page');?></a> 

      <script type="text/javascript"> window.setTimeout("javascript:location.href='<?php echo $url;?>'", <?php echo $time;?>); </script>
      <?php }else { ?>
  
      <a href="javascript:history.back()" class="ncap-btn"><?php echo L('hx_back_to_pre_page');?></a> 
      <script type="text/javascript"> window.setTimeout("javascript:history.back()", <?php echo $time;?>); </script>
 
      <?php } } ?>
 
    </div>
    <?php } ?>
<?php } ?>
    <div class="powerby"><?php echo L('hx_SSZCMS_message');?></div>
  </div>
</div>
</body>
</html>