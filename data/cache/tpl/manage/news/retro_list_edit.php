<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<style type="text/css">
.layui-container{width: 85%;margin-left: 4%;}
.ke-container{width: 100%!important;}
.layui-form-title em{color:red;}
</style>
<div class="layui-container">
<form class="layui-form"  id="article_list_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
<div class="layui-tab layui-tab-card">
<ul class="layui-tab-title">
<li class="layui-this">常规选项</li> 
</ul>
<div class="layui-tab-content">
<div class="layui-tab-item layui-show">   
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 满意度名称</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="name" id="name" lay-verify="required|title" placeholder="请输入满意度名称" autocomplete="off" class="layui-input" value="<?php echo $info['name'];?>"> 
</div>
</div>
</div>  

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 积分设置</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="credit" id="credit" lay-verify="required|title" placeholder="请输入积分" autocomplete="off" class="layui-input" value="<?php echo $info['credit'];?>"> 
</div>
</div>
</div>  














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
 
//监听提交
form.verify({
rank: function(value, item){
if(value==''){
return '请输入排序!';
} 
}, 
title: function(value, item){
if(value==''){
return '请输入标题!';
}
}

}); 

});
</script>
</div>
<?php include T('footer',1);?>