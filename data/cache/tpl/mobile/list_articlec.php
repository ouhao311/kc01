<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header1');?>
<div class="gdtys grace-scroll-x">
<?php $class_list=channel();?>
<?php if(is_array($class_list)) { foreach($class_list as $item) { ?>
<a href="<?php echo url('news','index',array('pid'=>$item['id']));?>" style="width:20%">
<div class="items  <?php if($_GET['pid']==$item['id']||$topclassinfo['id']==$item['id']) { ?>dtbh<?php } ?>
">
<?php echo $item['title'];?>
</div>
</a>
<?php } } ?>
</div>
<?php if(!empty($sonclass)) { ?>
<div class="xwbt">
<div class="grace-scroll-x gdtys scrollqb"> 
<a href="<?php echo url('index','show',array('pid'=>$topclassinfo['id']));?>"><span <?php if($_GET['pid']==$topclassinfo['id']) { ?>class="dtbh1"<?php } ?>
>全部</span></a>
<?php if(is_array($sonclass)) { foreach($sonclass as $item) { ?>
<a href="<?php echo url('index','show',array('pid'=>$item['id']));?>"><span <?php if($_GET['pid']==$item['id']) { ?>class="dtbh1"<?php } ?>
><?php echo $item['title'];?></span></a>
<?php } } ?>
<span class="">集中活动</span>
</div>
</div>
<?php } ?>

<div class="listnew" style="position: relative;">
<div data-v-ecaca2b0="" id="outer-jjmts" class="_v-container" style="position: static; width: 100%; height:auto;">
<div data-v-ecaca2b0="" id="inner-15hhk" class="_v-content" style="transform: translate3d(0px, 0px, 0px) scale(1);">
<?php if(is_array($list)) { foreach($list as $item) { ?> 
<div data-v-ecaca2b0="" class="grace-news-list">
<a href="<?php echo url('index','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>">
<div data-v-ecaca2b0="" class="item">
<div data-v-ecaca2b0="" class="body">
<div data-v-ecaca2b0="" class="title"><?php echo $item['title'];?></div>
<div data-v-ecaca2b0="" class="desc">
<div data-v-ecaca2b0="" class="xmIconfont watch"></div>
<div data-v-ecaca2b0="" class="left time"><?php echo date('Y-m-d',$item['edittime']);?></div>
<div data-v-ecaca2b0="" class="xmIconfont watch"></div>
<div data-v-ecaca2b0="" class="left"><?php echo $item['clicks'];?></div>
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
<ul class="xwpages">
<?php if(!empty($list)) { ?>
<?php echo $show_page;?>
<?php } ?>
</ul>
</div>
<!--主体内容 结束-->
<?php include T('footer');?>