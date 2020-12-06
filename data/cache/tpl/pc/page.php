<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<div class="mgtop-15 background-w1">
<div class="nab-left">
<div class="nmuz">
<ul>
<?php if(is_array($pagelist)) { foreach($pagelist as $item) { ?>
<span><a href="<?php echo url('page','index',array('id'=>$item['id']));?>" <?php if($_GET['id']==$item['id']) { ?>class="curr"<?php } ?>
 title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a></span>
<?php } } ?>        
</ul>
</div>
</div>
<div class="nab-right">
<div class="fdiv mub"><ul><?php echo $title;?></ul></div>
<div class="listn imgk"><?php echo $info['content'];?></div>
</div>
</div>
<?php include T('footer');?>