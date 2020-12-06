<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<script charset="utf-8" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=NRYBZ-XEBKD-ETX4E-HJIQT-63SQT-3EFRM"></script>
    <link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
    <script src="/public/layui/layui.js"></script>
<style type="text/css">
.layui-container{width: 100%;margin: 20px auto;padding:0px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:60%;line-height:34px;min-width:80px;height:34px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;}
.layui-tab-content{padding-top:20px;}
.clock{
            position: relative;
        }
.layui-btn-normal {
            background-color: #1E9FFF;
        }
.layui-btn {
    display: inline-block;
    height: 38px;
    line-height: 38px;
    padding: 0 18px;
    background-color: #009688;
    color: #fff;
    white-space: nowrap;
    text-align: center;
    font-size: 14px;
    border: none;
    border-radius: 2px;
    cursor: pointer;
}
</style>
<div class="mgtop-15 background-w1">
<div class="layui-container">
<form class="layui-form"  id="visit_list_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
<label class="layui-form-title"><em>*</em>任务名称</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="name" id="name" lay-verify="required" placeholder="请输入任务名称" autocomplete="off" class="layui-input" value="<?php echo $data['name']?>"  lay-verify="required"> 
</div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
<label class="layui-form-title"><em>*</em> 管理人员</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getMemberSelects('member',$data['managerid']);?> 
</div>
</div>
</div> 

<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
<label class="layui-form-title"><em>*</em> 执行人员</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getMemberSelect('member',$data['memberid']);?> 
</div>
</div>
</div>  
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>开始时间</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="text" name="startdate" style="width:100%;" id="startdate" lay-v="required|title" autocomplete="off" class="layui-input" value="<?php echo $data['startdate']?>">
                 </div>
</div>
</div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>结束时间</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="text" name="enddate" style="width:100%;" id="enddate" lay-v="required|title" autocomplete="off" class="layui-input" value="<?php echo $data['enddate']?>">
                 </div>
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
<label class="layui-form-title"><em>*</em>任务地址</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<input type="text" name="address" id="address"  placeholder="请输入任务地址" autocomplete="off" class="layui-input" value="<?php echo $data['address']?>" > 
</div>
</div>
</div> 

 <?php if($member['identity']=="2") { ?>
                <div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>审核</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="radio" name="status" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="通过"  value="1"    <?php if($visitdetail['0']['status']=="1") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="processmode" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="未通过" value="-1" <?php if($visitdetail['0']['status']=="0") { ?> checked="checked" <?php } ?>
>
        
                 </div>
</div>
</div>
                <?php } ?>
                
                  <?php if($member['identity']=="3") { ?>
               <div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>审核</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="radio" name="topstatus" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="通过"  value="1"    <?php if($visitdetail['0']['topstatus']=="1") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="topstatus" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="未通过" value="-1" <?php if($visitdetail['0']['topstatus']=="0") { ?> checked="checked" <?php } ?>
>
        
                 </div>
</div>
</div> 
                
                 <?php } ?>











<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> </label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
<div class="layui-input-block">
<button  class="layui-btn layui-btn-primary updateinfo"  lay-submit lay-filter="formDemo">提交</button> 
</div>
</div>
</div>
</form>
</div>
<script>
layui.use(['form', 'layedit', 'laydate'], function() {
var form = layui.form,
layer = layui.layer,
layedit = layui.layedit,
laydate = layui.laydate;

//日期
laydate.render({
elem: '#startdate',
type: 'datetime',
        trigger: 'click'
});
laydate.render({
elem: '#enddate',
type: 'datetime',
        trigger: 'click'
});
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
<div class="clear"></div> 
</div> 
<?php include T('footer');?> 
