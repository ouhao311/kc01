<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<style type="text/css">
.layui-container{width: 85%;margin-left: 4%;}
.ke-container{width: 100%!important;}
.layui-form-title em{color:red;}
</style>
<div class="layui-container">
<form class="layui-form"  id="member_list_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 

<div class="layui-row mb15 pt20" > 
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 登陆账号</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="username" id="username" autocomplete="off" class="layui-input" value="<?php echo $info['username'];?>" <?php if($info['username']) { ?>readonly<?php } ?>
  placeholder="请输入登陆账号" lay-verify="required|username"> 
</div> 
</div>
</div>
<div class="layui-row mb15" > 
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 登陆密码</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="password" name="password" id="password"  <?php if($info['id']>0){?> <?php }else{ echo 'lay-verify="required"';} ?> placeholder="请输入登陆密码" autocomplete="off" class="layui-input" > 
</div>
<?php if($info['id']>0){?>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux">不填写即不修改密码！</div>
</div>
<?php }else{ ?>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux">不填写默认密码为：123456！</div>
</div>
<?php } ?>
</div> 
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 所属职能科室</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getNotSelectoff('office',$info['officeid']);?> 
</div>
</div>
</div>  
<div class="layui-row mb15 pt20" > 
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 服务编号</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="servicenum" id="servicenum" lay-verify="required" placeholder="请输入服务编号" autocomplete="off" class="layui-input" value="<?php echo $info['servicenum'];?>"  lay-verify="required"> 
</div> 
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 姓名</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="truename" id="truename" lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input" value="<?php echo $info['truename'];?>"  lay-verify="required"> 
</div>
</div>
</div>  
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 头像</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getMorePic('upload_img_avatar','upload_img_list_avatar','avatar',$info['avatar'],'0');?>
</div>
</div>
</div>   
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em>性别</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block" > 
<?php echo getNotRadio('sex',$info['sex']);?> 
</div>
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em>年龄</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="age" id="age" lay-verify="required" placeholder="请输入年龄" autocomplete="off" class="layui-input" value="<?php echo $info['age'];?>"  lay-verify="required"> 
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em>学历</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="education" id="education" lay-verify="required" placeholder="请输入学历" autocomplete="off" class="layui-input" value="<?php echo $info['education'];?>"  lay-verify="required"> 
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em>政治面貌</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="politicsstatus" id="politicsstatus" lay-verify="required" placeholder="请输入政治面貌" autocomplete="off" class="layui-input" value="<?php echo $info['politicsstatus'];?>"  lay-verify="required"> 
</div>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux">政治面貌：中共党员、共青团员、群众、其他党派人士</div>
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em>职务</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="position" id="position" lay-verify="required" placeholder="请输入职务" autocomplete="off" class="layui-input" value="<?php echo $info['position'];?>"  lay-verify="required"> 
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em>手机号码</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="mobile" id="mobile"  placeholder="请输入手机号码" autocomplete="off" class="layui-input" value="<?php echo $info['mobile'];?>" > 
</div>
</div>
</div>     
<div style="line-height:50PX;">&nbsp;</div>
<div class="layui-form-item" style="width:88%;height:45px;margin:0 auto;background:#fff;position:fixed;bottom:0;text-align:center;border-top-style: solid;border-top-width: 1px;border-top-color: #009688;padding-top: 5px;z-index: 99999;" id="submit">
<div class="layui-input-block" style="margin-left: -15px;">
<button class="layui-btn" lay-submit lay-filter="formDemo"><?php echo $lang['hx_submit'];?></button> 
<button type="reset" class="layui-btn layui-btn-primary" onclick="parent.location.reload();">关闭</button> 
</div>
</div>
</form>
 
<script> 
layui.use('form', function(){
var form = layui.form;

<?php if($_GET['do']=='add') { ?>
//监听提交
form.verify({
username: function(value, item){
var tanchu=false;
$.ajax({
async: false,  
type: "POST",
dataType: "json",
url: "index.php?url=<?php echo $this->name;?>&do=repeat",
data: {
"username" : value
},
success: function(res){
var res=eval(res);
if(res.code==200){
tanchu=true;
}
}
}); 
if(tanchu){
  return '登陆账号已存在，请换一个';
}
if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
  return '用户名不能有特殊字符';
}
if(/(^\_)|(\__)|(\_+$)/.test(value)){
  return '用户名首尾不能出现下划线\'_\'';
}
if(/^\d+\d+\d$/.test(value)){
  return '用户名不能全为数字';
}
} 
,levelid: function(value, item){
if(value==''){
  return '请选择学员等级';
}
} 
}); 
<?php } ?>
});
</script>
</div>
<?php include T('footer',1);?>