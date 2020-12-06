<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>  
<style type="text/css">
.layui-container{width: 85%;margin-left: 4%;}
.ke-container{width: 100%!important;}
.layui-form-title em{color:red;}
</style>
<div class="layui-container">
<form class="layui-form"  id="product_class_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
<?php if($_REQUEST['do']=='add') { ?>
<input type="hidden" name="pid" value="<?php echo $pid;?>" />
<?php } ?>
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
<div class="layui-tab layui-tab-card">
<ul class="layui-tab-title">
<li class="layui-this">常规选项</li>

</ul>
<div class="layui-tab-content">
<div class="layui-tab-item layui-show">  
<div class="layui-row mb15 pt20">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 排序</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="rank" id="rank" lay-verify="rank|number" autocomplete="off" class="layui-input" value="<?php if(empty($info['rank'])){echo 0;}else{echo $info['rank'];}?>"> 
</div>
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 部门名称</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="title" id="title" lay-verify="title" placeholder="请输入部门名称" autocomplete="off" class="layui-input" value="<?php echo $info['title'];?>"> 
</div>
</div>
</div>

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 部门图标</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getMorePic('upload_img_pic','upload_img_list_pic','pic',$info['pic'],'0');?>
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
<script type="text/javascript">  
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
return '请输入分类名称!';
}
} 
}); 
});
</script>
</div>
<?php include T('footer',1);?>