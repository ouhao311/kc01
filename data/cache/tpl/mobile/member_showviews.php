<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style>
.user_three span{
    margin:0 8px ;
}
#zhsz{
    display: block;
    width: 100%;
}
.mem-list{
    width: 98%;
    height: 30px;
    margin: 10px 0;
    font-size: 16px;
    line-height: 30px;
    margin: 5 auto;
}
.list-title{
    width: 100%;
    padding-left:10px ;
    background-color: white;
    
}
.list-title img{
    width: 16px;
    height: 16px;
    margin: -5px 10px 0 0;
}
#zhsz span{
    display: inline-block;
    float: right;
    margin-right: 10px;
    color: #ccc;
    font-size: 12px;
}
/*#zhsz span em{*/
/*    color: #ccc;*/
/*}*/
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
       <div class="ccon-cell">
<div>
<p class="banjian_tit"><span></span>我的资讯</p>
<div item="zixun">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="banjian">
<thead>
<tr bgcolor="#f3f7fc">
<td width="43%" align="left" valign="middle">标题</td> 
<td width="14%" align="center" valign="middle">发布时间</td>
<td width="14%" align="center" valign="middle">审核状态</td>
<td width="15%" align="center" valign="middle">操作</td>
</tr>
</thead>
<tbody>
<?php if(is_array($list)) { foreach($list as $item) { ?> 
<tr >
<td align="left" valign="middle"><a target="_blank" href="<?php echo url('news','show',array('id'=>$item['id']));?>" class="bj_link" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a></td> 
<td align="center" valign="middle"><span class="da-time"><?php echo date('Y-m-d H:i:s',$item['edittime']);?></span></td>
<td align="center" valign="middle"><?php echo getReview('isreview',$item['isreview']);?></td>
<td align="center" valign="middle">
<?php if($item['isreview']!=1) { ?>
<span class="icon_sq"> <a target="_blank" href="<?php echo url('member','editviews',array('id'=>$item['id']));?>"title="编辑"> 编辑 </a> </span>
<span class="icon_sq"> <a class="delviews" data-id="<?php echo $item['id'];?>" href="JavaScript:;"title="删除"> 删除 </a> </span>
<?php } else { ?>
<span class="icon_sq"> <a class="zhuanjiao" data-id="<?php echo $item['id'];?>" title="转让"> 转让 </a> </span>
<?php } ?>
</td>
</tr>
<?php } } ?>
</tbody>
</table>
<ul class="xwpages">
<?php if(!empty($list)) { ?>
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
//删除资讯
$('.delviews').click(function(){
var id=$(this).attr('data-id');
$.ajax({
async: false,  
type: "POST",
dataType: "json",
url: "/?url=member&do=delviews" ,
data: {
"id" : id
},
success: function (result) {
if(result.code == 200){ 
layer.msg('删除资讯成功！', { 
time: 2000
}, function(){
window.location.href='/index.php?url=member';
});   
}else{
layer.msg(result.message);return false;
}
},
error : function() {
layer.msg("删除资讯失败！");
}
}); 

});
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