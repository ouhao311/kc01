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
<label class="layui-form-title"><em>*</em> 姓名</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="name" id="name" lay-verify="required|title" placeholder="请输入问题" autocomplete="off" class="layui-input" value="<?php echo $info['name'];?>"> 
</div>
</div>
</div>  

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 年龄</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="age" id="age" lay-verify="required|title" placeholder="请输入问题" autocomplete="off" class="layui-input" value="<?php echo $info['age'];?>"> 
</div>
</div>
</div>  

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 电话</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="mobile" id="mobile" lay-verify="required|title" placeholder="请输入电话" autocomplete="off" class="layui-input" value="<?php echo $info['mobile'];?>"> 
</div>
</div>
</div>  

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 村庄</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="village" id="village" lay-verify="required|title" placeholder="请输入村庄" autocomplete="off" class="layui-input" value="<?php echo $info['village'];?>"> 
</div>
</div>
</div>  

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 问题</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="title" id="title" lay-verify="required|title" placeholder="请输入问题" autocomplete="off" class="layui-input" value="<?php echo $info['title'];?>"> 
</div>
</div>
</div>  

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 问题描述</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<textarea name="content" id="content" placeholder="请输入简介" class="layui-textarea"><?php echo $info['content'];?></textarea>
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
<label class="layui-form-title">视频</label>
</div>
    <div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
    <div class="layui-input-block">
<?php echo getMorevideo('upload_video_pic','upload_video_list_pic','video',$info['video'],'0');?>
</div>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux"><video style="margin-left: 20px;margin-top:20px; height: 200px; width: 400px;float:left; overflow:hidden;" src="<?php echo $info['video'];?>" controls="controls"></div>
</div>
</div>
</div>

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 音频</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getMoreaudio('upload_audio_pic','upload_audio_list_pic','audio',$info['audio'],'0');?>
</div>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux">
    <div class="layui-form-mid layui-word-aux"><video style="margin-left: 20px;height: 80px; width: 400px;float:left; overflow:hidden;" src="<?php echo $info['audio'];?>" controls="controls"></div></div>
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