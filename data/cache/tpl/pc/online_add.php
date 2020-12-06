<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<style type="text/css">
.layui-container{width: 100%;margin: 0 auto;padding:0px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:100%;line-height:34px;min-width:60px;height:34px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;}
.layui-tab-content{padding-top:20px;}
</style>
<!--主体内容 开始-->
<div class="mgtop-15 background-w1">
<div class="fdiv mua">
<ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $title;?></b></ul> 
</div>
<div class="tu_k link2"><br/>
</div> 
<div class="layui-container">
<form class="layui-form"  id="article_list_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
<div class="layui-tab-item layui-show">   
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 问题</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="title" style="width:100%;" id="title" lay-verify="required|title" placeholder="请输入问题" autocomplete="off" class="layui-input" value="<?php echo $info['title'];?>"> 
</div>
</div>
</div>  
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 问题描述</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<textarea name="intro" id="intro"  style="width:100%;" lay-verify="required|intro"  placeholder="请输入问题描述" class="layui-textarea"><?php echo $info['intro'];?></textarea>
</div> 
</div>
</div>  
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> </label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<button class="layui-btn layui-btn-primary updateinfo"  lay-submit lay-filter="formDemo">提交</button> 
</div>
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
return '请输入问题!';
}
}, 
intro: function(value, item){
if(value==''){
return '请输入问题描述!';
}
}

}); 

});
</script>
</div>
</div>
<!--主体内容 结束-->
<?php include T('footer');?>
