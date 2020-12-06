<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<!--主体内容 开始-->
<div class="mgtop-15 background-w1">
<?php if(is_array($sonclass)) { foreach($sonclass as $item) { ?>
<div class="fdiv mua">
<ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $item['title'];?></b></ul>
<ol><a href="<?php echo url('news','index',array('pid'=>$item['id']));?>">更多+</a></ol>
</div>
<div class="m_newtu">
<ul>
<?php $list=M('article')->getList('new',4,$item['id']); ?>
<?php if(is_array($list)) { foreach($list as $key => $item2) { ?>
   <li>
<a href="<?php echo url('news','show',array('id'=>$item2['id']));?>" target="_blank" title="<?php echo $item2['title'];?>">
<img src="<?php echo getImageUrl($item2['pic'],'200');?>" />
<dl>
<dt><?php echo $item2['title'];?></dt>
<dd><?php echo $item2['intro'];?></dd>
<span><em><i class="iconfont icon-chakan1"></i><?php echo $item2['clicks'];?></em>
<cite><i class="iconfont icon-shijian1"></i><?php echo date('Y-m-d',$item2['edittime']);?></cite></span>
</dl>
</a>
</li>
<?php } } ?>
</ul>
</div>
<?php } } ?>
</div>
<!--主体内容 结束-->
<?php include T('footer');?> 