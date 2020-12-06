<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<div class="mgtop-15 background-w1">
<div class="fdiv mua">
<ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $title;?></b></ul>
<ol>当前位置：<a href="/">首页</a> > <?php echo $title;?>
</ol>
</div>
<div class="ladyUcroll link2">
<ul>
<?php if(is_array($list)) { foreach($list as $item) { ?> 
   <li class="layui-elem-field">
<legend><div class="layui-inline">
<img src="<?php echo getImageUrl($item['avatar'],'avatar');?>" />
</div></legend>
<div class="layui-field-box">
<p><a href="javascript:openIframeLayer('<?php echo url('user','userview',array('id'=>$item['id']));?>','用户信息',{area:['700px', '500px']});"><b><?php echo $item['truename'];?></b>
<span class="zt_1"><i class="iconfont icon-dangwugongkai"></i>入党申请</span> 
</a></p>
<em>党组织: <?php echo getSinglePas($table='attribute','department',$item['department'],'title');?><br /></em>
</div>
</li>
<?php } } ?>  
<ul>
</div>
<ul class="xwpages">
<?php if(!empty($list)) { ?>
<?php echo $show_page;?>
<?php } ?>
</ul>
</div>
<?php include T('footer');?>