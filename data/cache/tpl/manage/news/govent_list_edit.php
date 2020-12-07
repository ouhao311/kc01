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
<li>高级选项</li>
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
<label class="layui-form-title"><em>*</em> 标题</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="title" id="title" lay-verify="required|title" placeholder="请输入标题" autocomplete="off" class="layui-input" value="<?php echo $info['title'];?>"> 
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 缩略图</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getMorePic('upload_img_pic','upload_img_list_pic','pic',$info['pic'],'0');?>
</div>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux">缩略图尺寸：450*300</div>
</div>
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 简介</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<textarea name="intro" id="intro" placeholder="请输入简介" class="layui-textarea"><?php echo $info['intro'];?></textarea>
</div>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux">为空时将会自动截取内容200个字符</div>
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 内容</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php showEditor('content',$info['content']);?>
</div>
</div>
</div>
</div>  
<div class="layui-tab-item"> 
<div class="layui-row mb15 pt20" >
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 简短标题</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="shorttile" id="shorttile" lay-verify="shorttile" placeholder="请输入简短标题" autocomplete="off" class="layui-input" value="<?php echo $info['shorttile'];?>"> 
</div>
</div>
</div>
<div class="layui-row mb15 "> 
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> SEO标题</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="seo_title" id="seo_title" lay-verify="seo_title" placeholder="请输入SEO标题" autocomplete="off" class="layui-input" value="<?php echo $info['seo_title'];?>"> 
</div>
</div> 
</div>
<div class="layui-row mb15"> 
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> SEO关键词</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="seo_keywords" id="seo_keywords" lay-verify="seo_keywords" placeholder="请输入SEO关键词" autocomplete="off" class="layui-input" value="<?php echo $info['seo_keywords'];?>"> 
</div>
</div> 
</div>
<div class="layui-row mb15 pt20"> 
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> SEO描述</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<textarea name="seo_description" id="seo_description" placeholder="请输入SEO描述" class="layui-textarea"><?php echo $info['seo_description'];?></textarea>
</div>
</div> 
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 链接</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="url" id="url" lay-verify="weburl" placeholder="请输入跳转链接" autocomplete="off" class="layui-input" value="<?php echo $info['url'];?>"> 
</div>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux">第三方跳转链接</div>
</div>
</div>
</div> 
<div class="layui-row mb15 pt20" >
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 点击数</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="clicks" id="clicks" lay-verify="clicks|number" autocomplete="off" class="layui-input" value="<?php if(empty($info['clicks'])){echo rand(0,999);}else{echo $info['clicks'];}?>"> 
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