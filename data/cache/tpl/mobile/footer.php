<?php defined('SSZCMS') or exit('Access Denied');?><footer class="zyw-footer">
<ul class="am-nav am-nav-pills am-nav-justify f09">
<!--<li <?php if($_GET['url']==''||$_GET['url']=='index') { ?> class="weui-this"<?php } ?>
><a href="/">-->
<!--<p class="navicon">-->
<!--<img src="/public/wap/images/4ad322c76c661b9348681407be33d2a0.png" alt="首页">-->
<!--</p>-->
<!--<span>首页</span></a></li>-->


   
<?php if($member['identity']>=1) { ?>
<li <?php if($_GET['url']=='member') { ?> class="weui-this"<?php } ?>
><a href="<?php echo url('member','index');?>">
<p class="navicon">
<img src="/public/wap/images/4ad322c76c661b9348681407be33d2a0.png" alt="首页">
</p>
<span>首页</span></a></li>
<li  <?php if($_GET['url']=='integral') { ?> class="weui-this"<?php } ?>
><a href="<?php echo url('integral','index');?>">
<p class="navicon">
<img src="/public/wap/images/dd964823c091bec90c1e977bc7014687.png" alt="积分">
</p>
<span>积分</span></a></li>
<?php } ?>

<?php if(empty($member['identity'])) { ?>
<li  <?php if($_GET['url']==''||$_GET['url']=='online') { ?> class="weui-this"<?php } ?>
><a href="<?php echo url('online','index');?>">
<p class="navicon">
<img src="/public/wap/images/7a576445bcafe19ce6f7b68ba2bd257b.png" alt="解疑">
</p>
<span>解疑</span></a></li>
<?php } ?>
<li <?php if($_GET['url']=='news') { ?> class="weui-this"<?php } ?>
><a href="<?php echo url('news','index');?>">
<p class="navicon">
<img src="/public/wap/images/ae91eb82bbe906408da3a69f1aa22d7a.png" alt="动态">
</p>
<span>动态</span></a></li>
<li <?php if($_GET['url']=='index') { ?> class="weui-this"<?php } ?>
><a href="<?php echo url('index','index');?>">
<p class="navicon">
<img src="/public/wap/images/4ad322c76c661b9348681407be33d2a0.png" alt="学习">
</p>
<span>学习</span></a></li>
</ul>
</footer>
<div style="height: 50px;"></div>
<script src="/public/wap/js/amazeui.min.js"></script>
<script src="/public/wap/js/weixin.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script language="javascript" type="text/javascript">
$(function () {
//渲染页面

});
</script> 

</body>
</html>