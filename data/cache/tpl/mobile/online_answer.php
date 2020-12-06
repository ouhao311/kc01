<?php defined('SSZCMS') or exit('Access Denied');?>
<?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style>
.user_three span{
    margin:0 8px ;
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
<p class="banjian_tit"><span></span>工作人员回复</p>
<div item="zixun">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="banjian">
<thead>
<tr bgcolor="#f3f7fc">

<td width="20%" align="center" valign="middle">回复内容</td>
<td width="20%" align="center" valign="middle">自己回复</td>
<td width="20%" align="center" valign="middle">前去评价</td>
</tr>
</thead>
<tbody>
    <?php if(is_array($list)) { foreach($list as $vl) { ?>
<tr>
    
<td align="center" valign="middle"><a  href="" class="bj_link" title="<?php echo $vl['replycontent'];?>"><?php echo $vl['replycontent']?></a></td> 


<td align="center" valign="middle"><a  href="" class="bj_link" title="<?php echo $vl['grade'];?>">
 
    </a><?php echo $vl['gradecontent']?></td> 
<td align="center" valign="middle">
<span class="icon_sq"> <a  href="<?php echo url('online','dograde',array('id'=>$vl['id']));?>"title="前去评价"> 前去评价 </a> </span>

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
