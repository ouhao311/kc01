<?php defined('SSZCMS') or exit('Access Denied');?><!--月积分增长排行榜-->
<!--里面有选择每月的-->
<?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<link rel="stylesheet" type="text/css" href="/public/css/month-picker.min.css"/>
<script type="text/javascript" src="/public/js/month-picker.min.js" ></script>
<script src="/public/layui/layui.js"></script>
<style>
.user_three span{
    margin:0 8px ;
}
.selectTime{
    width: 98%;
    margin: 10px auto;
}
</style>
<div id="content_Height" class="clearfix">
<div style="overflow:hidden;">
<div class="section">
<div class="ccon-cell">
<div>
<p class="banjian_tit"><span></span>月度积分增长排行</p>
<div item="zixun">
    <div class="selectTime">
        <label class="layui-form-title">选择日期</label>
        <input type="text" name="startTime" id="startTime" value="" />
    </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="banjian">
<thead>
<tr bgcolor="#f3f7fc">
    <td width="20%" align="center" valign="middle">排行</td>
<td width="20%" align="center" valign="middle">姓名</td> 
<td width="20%" align="center" valign="middle">增长度</td>
<td width="20%" align="center" valign="middle">积分</td> 
</tr>
</thead>
<tbody>
    <?php if(is_array($visit_list)) { foreach($visit_list as $vl) { ?>
<tr>
<td align="center" valign="middle"><?php echo $vl['']?></td> 
<td align="center" valign="middle"><?php echo $vl['']?></td>
<td align="center" valign="middle"><?php echo $vl['']?></td> 
<td align="center" valign="middle"><?php echo $vl['']?></td>
</tr>
<?php } } ?>
</tbody>
</table>
<ul class="xwpages">
<?php if(!empty($visit_list)) { ?>
<?php echo $show_page;?>
<?php } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="clear"></div> 
</div>
</div>
<style>
#zhuanjiao_list{display:none;}
.zhuanjiao_list{padding:20px;}
.zhuanjiao_list .layui-btn{margin-top:40px;}
</style>
<script> 
layui.use('form', function(){
var form = layui.form;
$(function(){
$('#startTime').MonthPicker();
})
})
</script>
<?php include T('footer');?> 
