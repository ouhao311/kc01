<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header1');?>  
<div class="mgtop-15 login-w1">
    <div class="layadmin-user-login-main">
<div class="layadmin-user-login-box layadmin-user-login-header">
<h2>用户登录</h2>
<p><?php echo C('site_name');?></p>
</div>
<div class="layadmin-user-login-box layadmin-user-login-body layui-form">
<form class="layui-form js-ajax-form" id="J_loginMod"  method="post" action="" >
<div class="layui-form-item">
  <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
  <input type="text" required name="username" placeholder="用户名 / 电子邮件 / 手机" id="LAY-user-login-username" class="layui-input">
</div>
<div class="layui-form-item">
<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
<input type="password" required name="password" id="LAY-user-login-password" placeholder="密码" class="layui-input">
</div>
<div class="layui-form-item">
<button class="layui-btn layui-btn-fluid layui-btn-danger js-ajax-submit" type="button"  onclick="login()">登 入</button>
</div>
<div class="layui-trans layui-form-item layadmin-user-login-other">
<a href="<?php echo url('register','index');?>" class="layadmin-user-jump-change layadmin-link" style="float:left;">我要注册</a>
<a href="<?php echo url('forget','index');?>" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>
</div>
</form>
</div>
    </div>
</div>
<!--主体内容 结束-->
<script>
layui.use('layer', function(){
    var $ = layui.jquery, layer = layui.layer;
});
var gotourl="<?php echo url('member');?>";
<?php if($_GET['gotourl']) { ?>
gotourl="<?php echo $_GET['gotourl'];?>";
<?php } ?>
//获取用户名和密码并判断不能为空
function login(){
    var data= $("form#J_loginMod").serialize(); 
    $.ajax({
        type: "POST",
        url: "<?php echo url('login','loginajax');?>",
        data: data,
        dataType: 'json',
        success: function(msg){
            if(msg.result==false){
                layer.alert(msg.message.error, {
                    time: 3000, //3s后自动关闭
                    btn: ['确定']
                });
            }else{
layer.msg(msg.message.error, { 
time: 2000
}, function(){ 
window.location.href = gotourl;
}); 
            }
        }
    });
}
</script>
<?php include T('footer');?>