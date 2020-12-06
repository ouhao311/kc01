<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header1');?>  
<div class="mgtop-15 login-w1">
    <div class="layadmin-user-login-main">
<div class="layadmin-user-login-box layadmin-user-login-header">
<h2>用户注册</h2>
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
<input type="password" required name="regPassword" id="LAY-user-login-password" placeholder="输入密码" class="layui-input">
</div>
<div class="layui-form-item">
<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
<input type="password" required name="confirmPassword" id="LAY-user-login-password" placeholder="确认密码" class="layui-input">
</div>
<div class="layui-form-item">
  <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
  <input type="text" required name="truename" placeholder="您的真实姓名" id="LAY-user-login-username" class="layui-input">
</div>
<div class="layui-form-item">
  <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
  <?php echo getNotSelect('department','');?> 
</div>
<div class="layui-form-item">
<button class="layui-btn layui-btn-fluid layui-btn-danger js-ajax-submit" type="button"  onclick="register()">注 册</button>
</div>
<div class="layui-trans layui-form-item layadmin-user-login-other"> 
<a href="<?php echo url('login','index');?>" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">返回登录</a>
</div>
</form>
</div>
    </div>
</div>
<!--主体内容 结束-->
<script>
layui.use(['layer','form'], function(){
    var $ = layui.jquery, layer = layui.layer, form = layui.form;
});
//获取用户名和密码并判断不能为空
function register(){
    var data= $("form#J_loginMod").serialize(); 
    $.ajax({
        type: "POST",
        url: "<?php echo url('register','preSave');?>",
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
window.location.href = "<?php echo url('member');?>";
}); 
            }
        }
    });
}
//发送验证码
$(".get_code").click(function() {
var mobile = $("#mobile").val();
if (mobile == "") {
layer.msg("手机号不能为空!");
return false;
}
if ($('.get_code').attr("disabled")) {
return false;
}else {
$.post('/index.php?url=ajax&do=sendCode&mobile=' + $("#mobile").val(), function(data) {
data = $.parseJSON(data);
if (data.err == 1) {
globalFunc.time();
} else {
layer.msg(data.msg);
}
});
}
});
var second = 60;
var globalFunc = {
time: function() { 
if (second == 0) {
$(".get_code").removeAttr("disabled");
$(".get_code").val("输入验证码");
$(".get_code").css({
background: '#EA5514',
borderColor: '#EA5514',
color: '#fff'
}); 
second = 60; 
} else {
$(".get_code").attr("disabled", 'disabled');
$(".get_code").val(second + "秒后重新获取");
$(".get_code").css({
background: '#333',
borderColor: '#333',
color: '#f1f1f1'
}); 
second--;
setTimeout(function() {
globalFunc.time()
}, 1000)
}
}
};
</script>
<?php include T('footer');?>