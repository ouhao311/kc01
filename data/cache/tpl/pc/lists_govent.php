<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<!--主体内容 开始-->
<div class="mgtop-15 background-w1">
<div class="fdiv mua">
<ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $title;?></b></ul>
<ol>当前位置：<a href="/">首页</a> >
<?php if(!empty($sonclass)&&$topclassinfo['id']!=$_GET['pid']) { ?>
<a href="<?php echo url('news','index',array('pid'=>$topclassinfo['id']));?>"><?php echo $topclassinfo['title'];?></a> > 
<?php } ?>
<a href="<?php echo url('news','index',array('pid'=>$classinfo['id']));?>"><?php echo $classinfo['title'];?></a> 
</ol>
</div>
<div class="m_newtu">
<ul>
<?php if(is_array($list)) { foreach($list as $item) { ?> 
   <li>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>">
<img src="<?php echo getImageUrl($item['pic'],'200');?>" />
<dl>
<dt><?php echo $item['title'];?></dt>
<dd><?php echo $item['intro'];?></dd>
<span><em><i class="iconfont icon-chakan1"></i><?php echo $item['clicks'];?></em>
<cite><i class="iconfont icon-shijian1"></i><?php echo date('Y-m-d',$item['edittime']);?></cite></span>
</dl>
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
 
<?php include T('footer');?> 