<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/ueditor.all.min.js"> </script> 
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/lang/zh-cn/zh-cn.js"></script>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
<style type="text/css">
.layui-container{width: 100%;margin: 0 auto;padding:0px;font-size:12px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:100%;line-height:34px;min-width:60px;height:34px;font-size:12px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;font-size:12px;}
.layui-tab-content{padding-top:20px;}
.layui-form-mid{font-size:12px;}
</style>
<div id="content_Height" class="clearfix">
<div style="overflow:hidden;">
<div class="content_top">
<div class="user ">
<div class="user_tx fl"><img src="<?php echo getImageUrl($member['avatar'],'avatar');?>" alt="用户头像" /> </div>
<div class="user_head fl">
<div class="yhm"><span class="yhm" id="mobilePhone"><?php echo $member['truename'];?> </span>，您好！</div>
<div class="rz" id="rz"><img src="/ssz/images/rate@2x_1.png" alt="账号等级" />
职能部门：<span id="jibie"><?php echo getSinglePas($table='attribute','department',$member['department'],'title');?></span></div>
</div>
</div>
<div class="user_three "> 
<span><a href="<?php echo url('member','profile');?>" id="zhsz"><img src="/ssz/images/icon-setting@2x_1.png" alt="账号设置" /> 账号设置</a>
</span> 
<span><a href="<?php echo url('logout','index');?>" id="tcBtn1"><img src="/ssz/images/icon-exit@2x_1.png" alt="退出登录" /> 退出</a></span>  
</div>

</div>
<div class="section">
<div class="layui-container">
<form class="layui-form"  id="article_list_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
<div class="layui-tab-item layui-show">
<div class="layui-row mb15 pt20">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 所属分类</label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
<div class="layui-input-block">
<?php echo $this->puttree11(0,$info['pid']);?>
</div>
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 标题</label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
<div class="layui-input-block">
<input type="text" name="title" id="title" lay-verify="required|title" placeholder="请输入标题" autocomplete="off" class="layui-input" value="<?php echo $info['title'];?>"> 
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 缩略图</label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
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
<label class="layui-form-title"> 内容</label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
<div class="layui-input-block">
<textarea name="content" id="content" placeholder="请输入内容" class="layui-textarea"><?php echo $info['content'];?></textarea>
</div>
</div>
</div>
</div>    
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> </label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
<div class="layui-input-block">
<button class="layui-btn layui-btn-primary updateinfo"  lay-submit lay-filter="formDemo">发布</button> 
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
pidtitle: function(value, item){ 
if(value==''){
return '请选择所属分类!';
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
</div>
<div class="clear"></div> 
</div>
</div> 
<?php include T('footer');?> 
 