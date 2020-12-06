<?php defined('SSZCMS') or exit('Access Denied');?>
<?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style>
.user_three span{
    margin:0 8px ;
}
.banjian td{
    padding: 10px;
}
</style>
<div id="content_Height" class="clearfix">
<div style="overflow:hidden;">
<div class="content_top">
<div class="user ">
<div class="user_tx fl"><img src="<?php echo getImageUrl($member['avatar'],'avatar');?>" alt="用户头像" /> </div>
<div class="user_head fl">
<div class="yhm"><span class="yhm" id="mobilePhone"><?php echo $member['truename'];?> </span>，您好！</div>

</div>
</div>
   
</div>
<div class="section">
<!-- TODO 我的任务 start -->
<div class="ccon-cell">
<div>
<p class="banjian_tit"><span></span>我的提问</p>
<!--<a href="<?php echo url('task','myunquest',array('dodeal'=>0));?>"><span class="banjian_tit"><em style="float:left;width:50%;background-color:#FF4D4F;text-align:center;">未审核</em></span></a>-->
<!--<a href="<?php echo url('task','myunquest',array('dodeal'=>1));?>"><span class="banjian_tit"><em style="float:left;width:49%;background-color:#FF4D4F;text-align:center;border-right:1px solid white;">已审核</em></span></a>-->
<div item="zixun">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="banjian">
<thead>
<tr bgcolor="#f3f7fc">
<td width="20%" align="center" valign="middle">标题</td> 
<td width="40%" align="center" valign="middle">地址</td> 
<td width="25%" align="center" valign="middle">查看详情</td>
<td width="25%" align="center" valign="middle">查看回复</td>

<td width="25%" align="center" valign="middle">结果</td>
<td width="25%" align="center" valign="middle">进行评价</td>
</tr>
</thead>
<tbody>
    <?php if(is_array($visit_list)) { foreach($visit_list as $vl) { ?>
<tr>
<td align="center" valign="middle"><a  href="" class="bj_link" title="<?php echo $vl['title'];?>"><?php echo $vl['title']?></a></td> 
<td align="center" valign="middle"><span class="da-time">
 
    <?php echo $vl['village']?>
</span></td>
<td align="center" valign="middle">
<span class="icon_sq"> <a  href="<?php echo url('online','add',array('id'=>$vl['id']));?>"title="查看详情"> 查看详情 </a> </span>

</td>

<td align="center" valign="middle">
<span class="icon_sq"> <a  href="<?php echo url('online','answer',array('id'=>$vl['id']));?>"title="查看回复"> 查看回复 </a> </span>

</td>

<td align="center" valign="middle">
<span class="icon_sq"> <a  href=""title="">
   
</a>
<?php if(empty($vl['isreview'])&& empty($vl['istopreview'])) { ?>
  等待审核
<?php } ?>

<?php if(!empty($vl['isreview']) && empty($vl['istopreview'])|| !empty($vl['istopreview'])&&empty($vl['isreview'])) { ?>
 审核中
<?php } ?>

<?php if(!empty($vl['isreview'])&& !empty($vl['istopreview'])) { ?>
 审核完成
<?php } ?>
</span>

</td>


<?php if(empty($vl['grade'])) { ?>
<td align="center" valign="middle">
<span class="icon_sq"> <a  href="<?php echo url('online','changegrade',array('id'=>$vl['id']));?>"title="前去打分"> 进行评价 </a> </span>

</td>
<?php } ?>

<?php if(!empty($vl['grade'])) { ?>
<td align="center" valign="middle">
<span class="icon_sq"> <a  href=""title="已做评价"> 已做评价 </a> </span>

</td>
<?php } ?>

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
<!-- 我的任务 end -->
</div>
<div class="clear"></div> 
</div>
</div>
<style>
#zhuanjiao_list{display:none;}
.zhuanjiao_list{padding:20px;}
.zhuanjiao_list .layui-btn{margin-top:40px;}
</style>
<div id="zhuanjiao_list">
<div class="zhuanjiao_list">
<form class="layui-form" action="">
<select name="zhuanjiao_mid" id="zhuanjiao_mid" lay-verify="zhuanjiao_mid" lay-filter="zhuanjiao_mid" lay-search>
<option value="">请选择转让会员</option>
<?php if(is_array($member_list)) { foreach($member_list as $item) { ?>
<option value="<?php echo $item['id'];?>"><?php echo getSinglePas($table='attribute','department',$item['department'],'title');?>-<?php echo $item['truename'];?></option> 
<?php } } ?>
</select>
<div class="layui-col-xs5"><span class="layui-btn layui-btn-normal layui-btn-sm layui-btn-fluid queren" >确认</span></div>
<div class="layui-col-xs2">&nbsp;</div>
<div class="layui-col-xs5"><span class="layui-btn layui-btn-primary layui-btn-sm layui-btn-fluid quxiao">取消</span></div>
</form>
</div>
</div> 
<script> 
layui.use('form', function(){
var form = layui.form; 
$('.zhuanjiao').click(function(){
var id=$(this).attr('data-id');
var zhuanjiao_mid=0;
var mid="<?php echo $memberid;?>";
var zhuanjiao_list=$('#zhuanjiao_list').html();
layer.open({
type: 6,
title:"请选择转让会员",
skin: 'layui-layer-rim', //加上边框
area: ['400px', '300px'], //宽高
closeBtn: 0, //不显示关闭按钮
content: zhuanjiao_list,
success: function(layero, index){
form.render('select');
console.log(layero, index);
}
});
$('.quxiao').click(function(){
layer.closeAll();
$('#zhuanjiao_list').hide();
});
form.on('select(zhuanjiao_mid)', function(data){
zhuanjiao_mid=data.value;
}); 
$('.queren').click(function(){
if(0==zhuanjiao_mid){
layer.msg("请选择转让会员！");
return false;
}
if(mid==zhuanjiao_mid){
layer.msg("不能转让给自己！");
return false;
}
$.ajax({
async: false,  
type: "POST",
dataType: "json",
url: "/index.php?url=member&do=zhuanjiao",
data: {
"id" : id,
"mid" : mid,
"zhuanjiao_mid" : zhuanjiao_mid
},
success: function(res){
if (res.code == 200) { 
layer.msg(res.datas.msg);window.location.reload();return false; 
} else {
layer.msg(res.message);return false;
}
}
});
});
});
});
</script>
<?php include T('footer');?> 
