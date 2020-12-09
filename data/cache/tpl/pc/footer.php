<?php defined('SSZCMS') or exit('Access Denied');?>
<div class="sr_footer w1min">
<div class="w1">
<dl class="ft1">
<dd><b><?php echo C('site_name');?></b></dd>
<dd><?php echo C('site_copyright');?> </dd>
<dd>咨询专线：<?php echo C('site_tel');?></dd>
<dd>地址：<?php echo C('site_address');?></dd>
</dl>
<dl class="ft2">
<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('site_qq');?>&site=qq&menu=yes" target="_blank" rel="nofollow" class="layui-btn layui-btn-danger layui-btn-radius"><i class="iconfont icon-qq"></i>在线咨询</a>
</dl>
<dl class="ft4">
<dd>
<a href="<?php echo url('page','index',array('id'=>5));?>" title="<?php echo getTableInfohanettName(5,'pages_list','title');?>" target=""><i class="iconfont icon-dangwugongkai"></i><?php echo getTableInfohanettName(5,'pages_list','title');?></a>
<a href="<?php echo url('page','index',array('id'=>6));?>" title="<?php echo getTableInfohanettName(6,'pages_list','title');?>" target=""><i class="iconfont icon-dangwugongkai"></i><?php echo getTableInfohanettName(6,'pages_list','title');?></a>
<a href="<?php echo url('page','index',array('id'=>7));?>" title="<?php echo getTableInfohanettName(7,'pages_list','title');?>" target=""><i class="iconfont icon-dangwugongkai"></i><?php echo getTableInfohanettName(7,'pages_list','title');?></a> 
</dd>
</dl>
<dl class="ft3"><img src="/public/images/wx.png" border="0" /></dl>
</div>
</div>
<ul class="g-navFloat">
<li>
<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('site_qq');?>&site=qq&menu=yes" target="_blank"><i class="iconfont icon-qq"></i></a>
</li>
<li>
<div class="u-contents content-qr">
<img src="/public/images/wx.png">
<p><?php echo C('site_name');?></p>
</div>
<a href="javascript:void(0);"><i class="iconfont icon-weixin"></i></a>
</li>
<li>
<div class="u-contents content-tel">
<p>咨询专线：</p>
<p><?php echo C('site_tel');?></p>
</div>
<a href="javascript:void(0);"><i class="iconfont icon-dianhua"></i></a>
</li>
</ul>
<div style="display:none;"></div>
<script type="text/javascript">
jQuery(".index2_6_con").slide({
delayTime: 500,
effect: "left",
autoPlay: true,
});
$(".clearfix01 .bj_tab ul li").hover(function(){
$(this).find(".icon_bj").removeClass("transform0");
$(this).find(".icon_bj").addClass("transform1");

},function(){
$(this).find(".icon_bj").removeClass("transform1");
$(this).find(".icon_bj").addClass("transform0");

});
$(".bj_img_buttm").find("span").hover(function(){
var a=$(this).attr("class");
$(".bj01").removeClass("cut");
$("#"+a).addClass("cut");
});
</script>
<script src="/public/js/wind.js"></script>
<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/js/frontend.js"></script>
<!--gotop start-->
<!--gotop end-->  
<script>
$(function(){
$(window).scroll(function(){
if($(window).scrollTop()>100){  //距顶部多少像素时，出现返回顶部按钮
$("#side-bar .gotop").fadeIn();
}
else{
$("#side-bar .gotop").hide();
}
});
$("#side-bar .gotop").click(function(){
$('html,body').animate({'scrollTop':0},500); //返回顶部动画 数值越小时间越短
});
});
</script>
</body>
</html>