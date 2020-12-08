<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<style type="text/css">
/*.ke-container{width: 100%!important;}*/
/*.layui-form-title em{color:red;}*/
.layui-container{width: 100%;margin: 0 auto;padding:20px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:100%;line-height:34px;min-width:100px;height:34px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;}
.layui-tab-content{padding-top:20px;}
</style>
<div class="layui-container">
<form class="layui-form"  id="visit_list_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em>工作事项</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="name" id="name" lay-verify="required" placeholder="请输入工作事项" autocomplete="off" class="layui-input" value="<?php echo $info['name'];?>"  lay-verify="required"> 
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 安排负责人</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getMemberSelects('member',$info['managerid']);?> 
</div>
</div>
</div> 

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 完成负责人</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getMemberSelect('member',$info['memberid']);?> 
</div>
</div>
</div>  
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
                 <label class="layui-form-title"><em>*</em>完成时间</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="text" name="enddate" style="width:100%;" id="enddate" lay-v="required|title" autocomplete="off" class="layui-input" value="<?php echo $info['enddate']?>">
                 </div>
</div>
</div>

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 安排部门</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getNotSelect('department',$info['departid']);?>
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
layui.use(['form','laydate'], function() {
var form = layui.form,
laydate = layui.laydate;
//日期
laydate.render({
type: 'datetime',
trigger: 'click'
});
laydate.render({
type: 'datetime',
trigger: 'click'
});

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