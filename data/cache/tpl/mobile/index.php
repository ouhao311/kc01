<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?> 
<div class="swiper-container banner swiper-container-horizontal">
<ul class="swiper-wrapper" style="transform: translate3d(-414px, 0px, 0px); transition-duration: 0ms;">
<?php if(is_array($banner_list)) { foreach($banner_list as $item) { ?>

<li class="swiper-slide swiper-slide-prev" style="width: 414px;"><img src="<?php echo getImageUrl($item['pic'],'450');?>"></li>
<?php } } ?>
</ul>
<div id="swiper-pagination" class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
<span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span>
</div>
</div>
<div class="grace-body">
   
<div class="grace-grids five">
<?php $class_list=channel();?>
<?php if(is_array($class_list)) { foreach($class_list as $item) { ?>

<!--<a href="<?php echo url('news','index',array('pid'=>$item['id']));?>" style="width: 25%;" class="items">-->
<a href="<?php echo url('index','news',array('pid'=>$item['id']));?>" style="width: 25%;" class="items">
<div class="icon">
<img src="<?php echo $item['pic'];?>">
</div>
<div class="text">
<?php echo $item['title'];?>
</div>
</a>
<?php } } ?> 

</div>
</div>
<div class="grace-list zbgd">
<div class="items">
<div class="xmIconfont icontz">

</div>
<div class="headle_right" style="max-width: 84%;">
<div class="weui-cell__bd content" style="height: 40px; overflow: hidden;">
<ul style="margin-top: 0px;">
<?php $list18=M('article')->getList('new',8,18); ?>
<?php if(is_array($list18)) { foreach($list18 as $key => $item) { ?> 
<li class="zbgdp"><?php echo $item['title'];?></li> 
<?php } } ?>
</ul>
</div>
</div>
<div class="arrow-right">
</div>
</div>
</div>
<div class="listnew" style="position: relative; height: 808px;">
<div data-v-ecaca2b0="" id="outer-8wxrw" class="_v-container" style="position: static; width: 100%; height: 100%;">
<div data-v-ecaca2b0="" id="inner-9ang0" class="_v-content" style="transform: translate3d(0px, 0px, 0px) scale(1);">
 <?php $list2=M('article')->getList('new',8); ?>
<?php if(is_array($list2)) { foreach($list2 as $key => $item) { ?>
<div data-v-ecaca2b0="" class="grace-news-list">
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>">
<div data-v-ecaca2b0="" class="item">
<div data-v-ecaca2b0="" class="body">
<div data-v-ecaca2b0="" class="title"><?php echo $item['title'];?></div>
<div data-v-ecaca2b0="" class="desc">
<div data-v-ecaca2b0="" class="right uni-ellipsis"><?php echo getTableInfohanettName($item['pid'],'article_class','title');?></div>
<div data-v-ecaca2b0="" class="left"><?php echo date('Y-m-d',$item['addtime']);?></div>
</div>
</div>
<div data-v-ecaca2b0="" class="img img-r">
<img data-v-ecaca2b0="" src="<?php echo getImageUrl($item['pic'],'400');?>">
</div>
</div>
</a>
</div> 
<?php } } ?>
</div>
</div>
</div>
<script src="/public/wap/js/swiper.js"></script>
<script>
setTimeout(() => { // 战报滚动
setInterval(() => {
$('.headle_right .content').find("ul").animate({
marginTop: "-40px"
}, 500, function () {
$(this).css({
marginTop: "0px"
}).find("li:first").appendTo(this);
})
}, 2000);
}, 10);
new Swiper('.swiper-container', { // 首页轮播图
autoplay: 2500,
autoplayDisableOnInteraction: false,
pagination: '.swiper-pagination',
paginationClickable: true,
observer: true
})
</script>
<?php include T('footer');?>
