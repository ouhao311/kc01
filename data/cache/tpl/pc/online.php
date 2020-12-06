<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<!--主体内容 开始-->
<div class="mgtop-15 background-w1">
<div class="fdiv mua">
<ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $title;?></b></ul>
<ol><a href="<?php echo url('online','add');?>">我要提问+</a></ol>
</div>
<div class="tu_k link2"><br/>
</div> 
<?php if(is_array($list)) { foreach($list as $item) { ?>
<div class="chat-discussion">
<div class="chat-message left">
<img class="message-avatar" src="<?php echo getImageUrl($member['avatar'],'avatar');?>" alt="">
<div class="message">
<span class="message-content"><?php echo $item['title'];?></span>
</div>
</div>
<div style="text-align:right">
<div class="chat-message right " style="text-align:center;width: auto;display: inline-block;align-items: center">
<img class="message-avatar" src="<?php echo getImageUrl($member['avatar'],'avatar');?>" alt="">
<div class="message" style="background-color: #a13b3b;float: right;margin-right: 0px">
<span class="message-content" style="color: white;display: inline-block"><?php echo $item['replyintro'];?></span>
</div>
</div>
</div>       
</div>
<?php } } ?>
<ul class="xwpages">
    <?php if(!empty($list)) { ?>
<?php echo $show_page;?>
<?php } ?>
</ul>
</div>
<!--主体内容 结束-->
<?php include T('footer');?>