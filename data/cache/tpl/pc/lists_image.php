<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<!--主体内容 开始-->
<div class="mgtop-15 background-w1">
<div class="fdiv mua">
<ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $classinfo['title'];?></b></ul>
<ol>当前位置：<a href="/">首页</a> >
<?php if(!empty($sonclass)&&$topclassinfo['id']!=$_GET['pid']) { ?>
<a href="<?php echo url('news','index',array('pid'=>$topclassinfo['id']));?>"><?php echo $topclassinfo['title'];?></a> > 
<?php } ?>
<a href="<?php echo url('news','index',array('pid'=>$classinfo['id']));?>"><?php echo $classinfo['title'];?></a> 
</ol>
</div>
<div class="tu_k link2">
<ul>
<?php if(is_array($list)) { foreach($list as $item) { ?> 
<li>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" title="<?php echo $item['title'];?>" target="_blank">
<img src="<?php echo getImageUrl($item['pic'],'500');?>" />
<b><?php echo $item['title'];?></b> 
</a>
</li>
<?php } } ?>

</ul>
</div> 
<ul class="xwpages">
    <?php if(!empty($list)) { ?>
<?php echo $show_page;?>
<?php } ?>
</ul>
</div>
<!--主体内容 结束-->
<?php include T('footer');?> 