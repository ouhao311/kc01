<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style>
.user_three span{
    margin:0 8px ;
}
#zhsz, #message {
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
#zhsz span,#myque span,#myunque span, #message span{
    display: inline-block;
    float: right;
    margin-right: 10px;
    color: #ccc;
    font-size: 12px;
}
.mytask .tabsInfo {
    position: absolute;
    margin-top: 2px;
    margin-left: 7px;
    border-radius: 100%;
    background-color: #fc6678;
    font-size: 4px;
    color: #fff;
    line-height: 1;
    vertical-align: 10px;
    padding: 2px 4px;
}
/*.mem-list .list-title em:after {*/
/*    content: "\e601";*/
/*    color: #B2B2B2;*/
/*}*/
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
<!--<div class="user_three " style="margin-top:10px;"> -->
<!--<span><a href="<?php echo url('member','index');?>" id="zhsz"><img src="/ssz/images/mine-home-nor@2x.png" alt="我的主页" /> 我的主页</a>-->
<!--</span>-->
<!--<span><a href="<?php echo url('member','addviews');?>" id="zhsz"><img src="/ssz/images/mine-zixun-nor@2x.png" alt="发布资讯" /> 发布资讯</a>-->
<!--</span>-->
<!--<span><a href="<?php echo url('member','showviews');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="我的资讯" />我的资讯</a>-->
<!--</span> -->
<!--<span><a href="<?php echo url('online','add');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="我要提问" /> 我要提问</a>-->
<!--</span> -->
<!--<span><a href="<?php echo url('integral','check');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="积分考核" /> 积分考核</a>-->
<!--</span> -->


<!--<span><a href="<?php echo url('task','mytask');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="我的任务" />我的任务 </a>-->
<!--</span>-->

<!--<span><a href="<?php echo url('task','taskmanage');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="分配任务管理" />分配任务管理 </a>-->
<!--</span> -->

<!--<span><a href="<?php echo url('task','clock');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="考勤打卡" />考勤打卡</a>-->
<!--</span> -->

<!--</div>-->
</div>
<div class="section">
    <!-- TODO 我的主页 start --> 
    <?php if($member['identity']=="0") { ?>
    <div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('member','index');?>" id="zhsz"><img src="/ssz/images/mine-home-nor@2x.png" alt="我的主页" />我的主页 <span>查看 <em>></em></span></a></p>
</div>
</div>
<!-- 我的主页 end -->
<!-- 我的消息 start --> 
<div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('member','message');?>" id="message"><img src="/ssz/images/mine-home-nor@2x.png" alt="我的消息" />我的消息 <span>查看 <em>></em></span></a></p>
</div>
  </div>
<!-- 我的消息 end -->
    <!-- TODO 我要提问 start --> 
    <div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('online','add');?>" id="zhsz"> <img src="/ssz/images/mine-youji-nor@2x.png" alt="我要提问" />我要提问<span>查看 <em>></em></span></a></p>
</div>
</div>
    <!-- 我要提问 end -->

<div class="mem-list">
<div>
<p class="list-title myquest"><a href="<?php echo url('task','myunquest');?>" id="myunque"><img src="/ssz/images/mine-youji-nor@2x.png" alt="我的提问" />我的提问<span>查看 <em>></em></span></a></p>
</div>
</div>
<?php } ?>
<div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('task','myquest');?>" id="zhsz"> <img src="/ssz/images/mine-zixun-nor@2x.png" alt="发布资讯" />党建公告<span>查看 <em>></em></span></a></p>
</div>
</div>

    <!-- TODO 发布资讯 start --> 
    <?php if($member['identity']>="1") { ?>
    <div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('member','addviews');?>" id="zhsz"> <img src="/ssz/images/mine-zixun-nor@2x.png" alt="发布资讯" />发布资讯<span>查看 <em>></em></span></a></p>
</div>
</div>
<?php } ?>
 <?php if($member['identity']>="1") { ?>
<div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('member','showviews');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="我的资讯" />我的资讯<span>查看 <em>></em></span></a></p>
</div>
</div>
<?php } ?>
<!-- 我的资讯 end -->

    <!-- TODO 积分考核 start --> 
     <?php if($member['identity']>="1") { ?>
    <div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('integral','check');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="积分考核" />积分考核<span>查看 <em>></em></span></a></p>
</div>
</div>
<?php } ?>



 <?php if($member['identity']>="1") { ?>
<div class="mem-list">
<div>
<p class="list-title myquest"><a href="<?php echo url('task','myquest');?>" id="myque"><img src="/ssz/images/mine-youji-nor@2x.png" alt="问题" />解决问题<span>查看 <em>></em></span></a></p>
</div>
</div>
<?php } ?>
    <!-- 我的主页 end -->
    <!-- TODO 我的任务 start --> 
     <?php if($member['identity']>="1") { ?>
    <div class="mem-list">
<div>
<p class="list-title mytask"><span class="tabsInfo">
    <?php if(!empty($count['count'])) { ?>
    <?php echo $count['count']?>
    <?php } ?>
    <?php if($member['identity']>="2") { ?>
</span><a href="<?php echo url('task','mytask');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="我的任务" />审核任务<span>查看 <em>></em></span></a></p>
   <?php } ?>
     <?php if($member['identity']=="1") { ?>
</span><a href="<?php echo url('task','mytask');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="我的任务" />我的任务<span>查看 <em>></em></span></a></p>
   <?php } ?>
</div>
</div>
<?php } ?>
    <!-- 我的我的任务 end -->
    <!-- TODO 分配任务管理 start --> 
    <?php if($member['identity']>="1") { ?>
    <div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('task','taskmanage');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="分配任务管理" />分配任务管理 <span>查看 <em>></em></span></a></p>
</div>
</div>
<?php } ?>
    <!-- 分配任务管理 end -->
     <?php if($member['identity']>="1") { ?>
    <div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('task','detailtask');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="走访调研" />走访调研<span>查看 <em>></em></span></a></p>
</div>
</div>
    <!-- TODO 考勤打卡 start --> 
    <div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('task','clock');?>" id="zhsz"><img src="/ssz/images/mine-youji-nor@2x.png" alt="考勤打卡" />考勤打卡<span>查看 <em>></em></span></a></p>
</div>
</div>
<?php } ?>


 <?php if($member['identity']>="1") { ?>
    <div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('hotline','add');?>" id="zhsz"> <img src="/ssz/images/mine-zixun-nor@2x.png" alt="12345市民热线" />12345市民热线<span>查看 <em>></em></span></a></p>
</div>
</div>
<?php } ?>
    <!-- 考勤打卡 end -->
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