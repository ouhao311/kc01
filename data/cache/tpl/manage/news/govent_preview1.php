<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<style type="text/css">
.layui-container{width: 85%;margin-left: 4%;}
.ke-container{width: 100%!important;}
.layui-form-title em{color:red;}
.layui-form-value {display:block;width:100%;line-height:34px;min-width:60px;height:34px;margin-left: 30px}
</style>
<div class="layui-container">
<form class="layui-form"  id="article_list_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" />  
<div class="layui-row mb15 pt20">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md1">
<label class="layui-form-title"><em>*</em> 审核状态：</label>
</div>
<div class="layui-col-xs9 layui-col-sm10 layui-col-md11">
<div class="layui-input-block">
<input type='radio' lay-skin='primary' title='审核通过' checked name='revstatus' value='2' lay-filter='审核通过'/>
<input type='radio' lay-skin='primary' title='审核不通过' name='revstatus' value='3' lay-filter='审核不通过'/>
</div>
</div>
</div>
<div class="layui-row mb15 pt20">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 附件：</label>
</div>
<div class="layui-col-xs9 layui-col-sm10 layui-col-md10">
<div class="layui-form-value">
<a><?php echo empty($info['attachment']['realname']) ? '' : $info['attachment']['realname'];?></a>
</div>
</div>
</div> 


<div class="layui-row mb15 pt20">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 回复内容：</label>
</div>
<div class="layui-col-xs9 layui-col-sm10 layui-col-md10">
<div class="layui-input-block"> 
<textarea name="revcontent" id="revcontent" placeholder="请输入回复内容" class="layui-textarea"><?php echo $info['revcontent'];?></textarea>
</div>
</div>
</div> 


<div style="line-height:50PX;">&nbsp;</div>
<div class="layui-form-item" style="width:88%;height:45px;margin:0 auto;background:#fff;position:fixed;bottom:0;text-align:center;border-top-style: solid;border-top-width: 1px;border-top-color: #ffffff;padding-top: 5px;z-index: 99999;" id="submit">
<div class="layui-input-block" style="margin-left: -15px;">
<button class="layui-btn" lay-submit lay-filter="formDemo"><?php echo $lang['hx_submit'];?></button> 
<button type="reset" class="layui-btn layui-btn-primary" onclick="parent.location.reload();">关闭</button> 
</div>
</div>
</form>
<script src="<?php echo EXT_URL;?>/formSelects/js-pinyin.js" type="text/javascript" charset="utf-8"></script> 
<script> 
//加载模块
layui.use(['form'], function(){
var formSelects = layui.formSelects;
var form = layui.form;  

//监听提交
form.verify({
isreview: function(value, item){ 
if(value==''){
return '请选择审核状态!';
}
} 
}); 
});  
</script>
</div>
<?php include T('footer',1);?>