<?php defined('SSZCMS') or exit('Access Denied');?>
<link href="/ssz/css/fuwu.css" rel="stylesheet" type="text/css" />  
<?php include T('header');?>
<div class="mgtop-15 background-w1">
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/ueditor.all.min.js"> </script> 
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/lang/zh-cn/zh-cn.js"></script> 
<style type="text/css">
.layui-container{width: 100%;margin: 0 auto;padding:0px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:100%;line-height:34px;min-width:60px;height:34px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;}
.layui-tab-content{padding-top:20px;}
.layui-select-title .layui-input,.layui-input-block .layui-input,.layui-input-block .layui-textarea{width:100%;}
</style>
<div id="content_Height" class="clearfix">
<div style="overflow:hidden;">
<div class="content_top">
<div class="user fl">
<div class="user_tx fl"><img src="<?php echo getImageUrl($member['avatar'],'avatar');?>" alt="用户头像" /> </div>
<div class="user_head fl">
<div class="yhm"><span class="yhm" id="mobilePhone"><?php echo $member['truename'];?> </span>，您好！</div>
<div class="rz" id="rz"><img src="/ssz/images/rate@2x_1.png" alt="账号等级" />
职能部门：<span id="jibie"><?php echo getSinglePas($table='attribute','department',$member['department'],'title');?></span></div>
</div>
</div>
<div class="user_three fr"> <span><a href="<?php echo url('member','profile');?>" id="zhsz"><img src="/ssz/images/icon-setting@2x_1.png" alt="账号设置" /> 账号设置</a>
</span> <span><a href="<?php echo url('logout','index');?>" id="tcBtn1"><img src="/ssz/images/icon-exit@2x_1.png" alt="退出登录" /> 退出</a></span> </div>
</div>
<div class="section">
<div class="w351 fl">
<div style=" font-size:20px; font-weight:bold; color:#485261; padding-left:30px; padding-bottom:19px; padding-top: 18px;">用户中心</div>
<div class="yhmenu"> 
<ul>
            <li class="hmenu"> <a href="<?php echo url('member','index');?>"> <i class="s_icon zhuye"></i>我的主页 </a> </li>
<li class="hmenu active"> <a href="<?php echo url('member','message');?>"> <i class="s_icon zixuni"></i>我的消息 </a> </li>
<li class="hmenu" > <a href="<?php echo url('member','task');?>"> <i class="s_icon banshii"></i>我的任务</a> </li>
<li class="hmenu" > <a href="<?php echo url('member','addviews');?>"> <i class="s_icon youjii"></i>发布资讯</a> </li>
<li class="hmenu" > <a href="<?php echo url('onlines','add');?>"> <i class="s_icon youjii"></i>我要提问</a> </li>
<!-- <li class="hmenu" data-item="shoucang" data-url="collection/findByPage"> <a href="javascript:void(0);"> <i class="s_icon shoucangi"></i>我的收藏</a> </li>  -->
<!-- <li class="hmenu" data-item="zuji" data-url="userBrowsing/query"> <a href="javascript:void(0);"> <i class="s_icon zuji"></i>我的足迹</a> </li> -->
<!-- <li class="hmenu" data-item="youxiang" data-url="person/infoList"><a href="javascript:void(0);"><i class="s_icon youjii"></i>省长信箱</a></li> -->
</ul>
</div>
</div>
<div class="w818 fr ccontent">
<div class="ccon-cell" style="margin-top: -0px;">

<div class="layui-container">
<div class="m_new1 ht1">
              <ul>
<?php if(is_array($list)) { foreach($list as $item) { ?>
<li>
<a href="<?php echo url('member','taskview',array('id'=>$item['id']));?>" title="<?php echo $info['name'];?>"><?php echo $item['name'];?></a>
<em>截止时间：<?php echo $item['enddate'];?></em>
</li>  
<?php } } ?>
<li>
<a href="<?php echo url('member','taskview',array('id'=>$item['id']));?>" title="<?php echo $info['name'];?>">你有一个任务为完成</a>
<em>截止时间：2020-10-20</em>
</li>
<li>
<a href="<?php echo url('member','taskview',array('id'=>$item['id']));?>" title="<?php echo $info['name'];?>">你有一个任务为完成</a>
<em>截止时间：2020-10-20</em>
</li>
<li>
<a href="<?php echo url('member','taskview',array('id'=>$item['id']));?>" title="<?php echo $info['name'];?>">你有一个任务为完成</a>
<em>截止时间：2020-10-20</em>
</li>
              </ul>
            </div>

</div>

</div> 
</div>
</div>
<div class="clear"></div> 
</div>
</div>
</div>
<?php include T('footer');?> 