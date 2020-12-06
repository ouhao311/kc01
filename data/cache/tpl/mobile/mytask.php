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
    padding: 5px;
}
.icon_sq{
    padding: 0;
}
.banjian_tit em{
    height: 30px;
    float: left;
    width: 49%;
    background-color: #FF4D4F;
    text-align: center;
    border-right: 1px solid white;
    color: white;
    font-size: 20px;
    display: inline-block;
}
</style>
<div id="content_Height" class="clearfix">
<div style="overflow:hidden;">
<div class="content_top">
<div class="user ">
<div class="user_tx fl"><img src="<?php echo getImageUrl($member['avatar'],'avatar');?>" alt="用户头像" /> </div>
<div class="user_head fl">
<div class="yhm"><span class="yhm" id="mobilePhone"><?php echo $member['truename'];?> </span>，您好！</div>
<div class="rz" id="rz"><img src="/ssz/images/rate@2x_1.png" alt="账号等级" />
职能部门：<span id="jibie">
    <?php echo $departdata['0']['title']?>
    -
     <?php echo $officedata['0']['title']?>
</span></div>
</div>
</div>
    <div class="user_three "> 
<span><a href="<?php echo url('member','profile');?>" id="zhsz"><img src="/ssz/images/icon-setting@2x_1.png" alt="账号设置" /> 账号设置</a>
</span> 
<span><a href="<?php echo url('logout','index');?>" id="tcBtn1"><img src="/ssz/images/icon-exit@2x_1.png" alt="退出登录" /> 退出</a></span>  
</div>
</div>
<div class="section">
<!-- TODO 我的任务 start -->
<div class="ccon-cell">
<div>
<p class="banjian_tit"><span></span>我的任务</p>
<a href="<?php echo url('task','mytask',array('dodeal'=>0));?>"><span class="banjian_tit"><em>未审核</em></span></a>
                    <a href="<?php echo url('task','mytask',array('dodeal'=>1));?>"><span class="banjian_tit"><em>已审核</em></span></a>

<div item="zixun">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="banjian">
<thead>
<tr bgcolor="#f3f7fc">
<td width="20%" align="left" valign="middle">标题</td> 
<td width="20%" align="left" valign="middle">地址</td> 
<td width="15%" align="left" valign="middle">管理人员</td>
<td width="20%" align="left" valign="middle">时间</td>
<td width="20%" align="left" valign="middle">详情</td>
<td width="20%" align="left" valign="middle">状态</td>
<td width="20%" align="left" valign="middle">操作</td>
</tr>
</thead>
<tbody>
    <?php if(is_array($visit_list)) { foreach($visit_list as $vl) { ?>
<tr>
<td align="left" valign="middle"><a  href="<?php echo url('','',array('id'=>$vl['id']));?>" class="bj_link" title="<?php echo $vl['name'];?>"><?php echo $vl['name']?></a></td> 
<td align="left" valign="middle"><?php echo $vl['address']?></td>
<td align="left" valign="middle"><?php echo $vl['truename']?></td>
<td align="left" valign="middle"><span class="da-time">
    <?php echo $vl['startdate']?>-
    <?php echo $vl['enddate']?>
</span></td>

<td align="left" valign="middle">
<span class="icon_sq"> <a  href="<?php echo url('task','detailtask',array('id'=>$vl['id']));?>"title="任务详情"> 任务详情 </a> </span>

</td>
<td align="left" valign="middle">
  <?php if($member['identity']=="3") { ?>
     <?php if(empty($vl['topstatus'])) { ?>待审核<?php } ?>
     <?php if($vl['topstatus']=="1") { ?>审核完成<?php } ?>
  <?php } ?>
  <?php if($member['identity']=="2") { ?>
  <?php if(empty($vl['status'])) { ?>待审核<?php } ?>
     <?php if($vl['status']=="1") { ?>审核完成<?php } ?>
  <?php } ?>
   <?php if($member['identity']=="1"||$member['identity']=="0") { ?>
   
   <?php if(empty($vl['status']) && empty($vl['topstatus'])) { ?>
    待审核
    <?php } ?>
     <?php if(!empty($vl['status']) && !empty($vl['topstatus'])) { ?>
   审核完成
    <?php } ?>
    
      <?php if(empty($vl['status']) && !empty($vl['topstatus'])||!empty($vl['status'] )&& empty($vl['topstatus'])) { ?>
   审核中
    <?php } ?>
    
   <?php } ?>
  
    
    
    
    
</td>

<?php if(empty($vl['status'])||empty($vl['topstatus'])) { ?>
<td align="left" valign="middle">
<span class="icon_sq"> <a  href="" title="上传任务详情"> 等待审核 </a> </span>
</td>
<?php } ?>
<?php if(!empty($vl['status'])&&!empty($vl['topstatus'])) { ?>
<td align="left" valign="middle">
<span class="icon_sq"> <a  href="<?php echo url('task','finitask',array('id'=>$vl['id']));?>"title="上传任务详情"> 上传详情 </a> </span>
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
