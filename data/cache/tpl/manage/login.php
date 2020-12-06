<?php defined('SSZCMS') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en" style="height:100%;min-height: 850px;min-width: 1024px;overflow: hidden;">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $html_title;?></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,minimal-ui">
  
    <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/login.css" />
<script src="<?php echo EXT_URL;?>/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo EXT_URL;?>/js/common.js" type="text/javascript"></script>
<script src="<?php echo EXT_URL;?>/js/jquery.validation.min.js"></script>
<script src="<?php echo ADMIN_EXT_URL;?>/js/jquery.supersized.min.js" ></script>
<script src="<?php echo ADMIN_EXT_URL;?>/js/jquery.progressBar.js" type="text/javascript"></script>
</head>
<body style="height:100%;">
    <div class="login">
    <div class="title">
<div class="clearfix">
<div class="logo">
<img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/logo1.png" alt="">
</div> 
</div>
    </div>
    <div class="login_main">
    <div class="inner clearfix"> 
    <div class="log_r">
     <form method="post" id="form_login">
    <?php Security::getToken();?>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="SiteUrl" id="SiteUrl" value="<?php echo SHOP_SITE_URL;?>" />
<h2></h2>
<h4>登录后台</h4>
<div>
<input type="text" name="user_name" id="user_name" autocomplete="off" placeholder="请输入账号" required>
<p class="p1 hide">账号不正确，请重新输入！</p>
</div>
<div>
<input name="password" id="password" class="input-text" autocomplete="off" type="password" required pattern="[\S]{6}[\S]*" placeholder="请输入密码">
<p class="p2 hide">密码不正确，请重新输入！</p>
</div>
<div>
                        <input name="xwhash" type="hidden" value="<?php echo getXwhash();?>" />
                             <input name="" class="input-button btn-submit" type="button" value="登　录" >
</div>
<!-- <div class="password">
<a href="#">
忘记密码？
</a>
<a href="#">
注册账号
</a>
</div> -->
    </form>
    </div>
    </div>
    </div>
    </div>
<div class="foot">
<div class="inner">
<span>后台管理系统</span> 
</div>
</div>
    
    <script>
$(function(){
     
//显示隐藏验证码
    $("#hide").click(function(){
        $(".code").fadeOut("slow");
    });
    $("#captcha").focus(function(){
        $(".code").fadeIn("fast");
    });
    //跳出框架在主窗口登录
   if(top.location!=this.location)top.location=this.location;
    $('#user_name').focus();
    if ($.browser.msie && ($.browser.version=="6.0" || $.browser.version=="7.0")){
        window.location.href='<?php echo ADMIN_TEMPLATES_URL;?>/ie6update.html';
    }

$('.btn-submit').click(function(e){
          
            $('#form_login').submit();
                    
          });
    // 回车提交表单
    $('#form_login').keydown(function(event){
        if (event.keyCode == 13) {
            $('.btn-submit').click();
        }
    });
});
</script>
</body>
</html>