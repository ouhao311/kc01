<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<div class="mgtop-15 background-w1">
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b>正文</b></ul>
<ol>
当前位置：<a href="/">首页</a> >
    <?php if(!empty($sonclass)&&$topclassinfo['id']!=$_GET['pid']) { ?>
<a href="<?php echo url('news','index',array('pid'=>$topclassinfo['id']));?>"><?php echo $topclassinfo['title'];?></a> >
<?php } ?>

<a href="<?php echo url('news','index',array('pid'=>$classinfo['id']));?>"><?php echo $classinfo['title'];?></a> >

正文
</ol>
</div>
<div class="lnmu">
<ul><?php echo $info['title'];?></ul>
<ol>来源：<a href="<?php echo url('news','index',array('id'=>$classinfo['id']));?>" target="_blank"><?php echo $classinfo['title'];?></a>  发布时间：<?php echo date('Y-m-d H:i:s',$info['addtime']);?>　点击数量:<span id="hits"><?php echo $info['clicks'];?></span></ol>
</div>
<div class="listn imgk" id="articlePreviewDialog">
<?php echo $info['content'];?>
</div>
<div class="xiaz">
<ul>
<li><strong>上一篇：</strong>
<?php if(empty($preinfo)) { ?>
没有了
<?php } else { ?>
<a href="<?php echo url('news','show',array('id'=>$preinfo['id']));?>"><?php echo $preinfo['title'];?></a><?php } ?>
</li>
<li><strong>下一篇：</strong>
<?php if(empty($nextinfo)) { ?>
没有了
<?php } else { ?>
<a href="<?php echo url('news','show',array('id'=>$nextinfo['id']));?>"><?php echo $nextinfo['title'];?></a><?php } ?>
</li>
</ul>
</div>
</div>
 
<!--主体内容 结束-->
 
<?php include T('footer');?> 