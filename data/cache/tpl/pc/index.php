<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?> 
<div class="mgtop-15 w1 tout link1">
<?php if(is_array($toutiao_list)) { foreach($toutiao_list as $item) { ?>
<ul>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a>
</ul>
<ol><?php echo subtext($item['intro'], 80);?><ol>
<?php } } ?>
</div>
<div class="mgtop-15 background-w1">
<!--左区域_s-->
<div class="w1-left">
<div class="banner_x">
<div id="banner_x">
<div id="banner">
<ul class="bannerlist">
<?php if(is_array($banner_list)) { foreach($banner_list as $item) { ?>
    <li><a href="<?php echo $item['url'];?>" title="<?php echo $item['title'];?>" target="_blank"><img src="<?php echo getImageUrl($item['pic'],'670');?>"><span><?php echo $item['title'];?></span></a></li>        
<?php } } ?>
</ul>
</div>
<div class="hd"><ul></ul></div>
<!-- 下面是前/后按钮代码，如果不需要删除即可 -->
<a class="prev" href="javascript:void(0)"></a>
<a class="next" href="javascript:void(0)"></a>
</div>
</div>
<script>jQuery("#banner_x").hover(function(){ jQuery(this).find(".prev,.next").stop(true,true).fadeTo("show",0.2) },function(){ jQuery(this).find(".prev,.next").fadeOut() });
jQuery('#banner_x').slide({ titCell:'.hd ul', mainCell:'#banner ul', autoPlay:true, autoPage:true, delayTime:500,interTime:6000,effect:'fold'});
</script>
<!--JS幻灯片 结束-->
</div>
<!--右区域_s-->
<div class="w1-right">
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo getTableInfohanettName(18,'article_class','title');?></b></ul><ol><a href="<?php echo url('news','index',array('pid'=>18));?>" target="_blank">更多+</a></ol></div>
<div class="m_new1">
<ul>
<?php $list=M('article')->getList('new',8,18); ?>
<?php if(is_array($list)) { foreach($list as $key => $item) { ?>
<li>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a>
<em><?php echo date('Y-m-d',$item['addtime']);?></em>
</li>
<?php } } ?>  
</ul>
</div>
</div> 
</div>
 
<div class="mgtop-15 background-w1">
<div class="w2-left">
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo getTableInfohanettName(2,'article_class','title');?></b></ul><ol><a href="<?php echo url('news','index',array('pid'=>2));?>" target="_blank">更多+</a></ol></div>
<div class="m_new1 ht1">
<?php $list2=M('article')->getList('new',6,2); ?>
<?php if(is_array($list2)) { foreach($list2 as $key => $item) { ?>
<?php if($key==0) { ?>
<ol>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>">
 <img src="<?php echo getImageUrl($item['pic'],'400');?>" />
<span><?php echo $item['title'];?></span>
</a>
</ol>
<?php } ?>
<?php } } ?>
<ul>
<?php if(is_array($list2)) { foreach($list2 as $key => $item) { ?>
<?php if($key>0) { ?>
<li><a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a> 
<em><?php echo date('Y-m-d',$item['addtime']);?></em></li> 
<?php } ?>
 
<?php } } ?>
</ul>
</div>
<!--ol_循环1行/ul里li_循环8行-->
</div>
<div class="w2-right">
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo getTableInfohanettName(1,'article_class','title');?></b></ul><ol><a href="<?php echo url('news','index',array('pid'=>1));?>" target="_blank">更多+</a></ol></div>
<div class="m_new1 ht1">
<ul>
<?php $list8=M('article')->getList('new',8,1); ?>
<?php if(is_array($list8)) { foreach($list8 as $key => $item) { ?> 
<li>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a>
<em><?php echo date('Y-m-d',$item['addtime']);?></em></li>  
<?php } } ?> 
</ul>
</div>
</div> 
</div> 
<div class="mgtop-15 background-w2">
<!--专题专栏-->
<div class="ztimg">
<ul>特别推荐</ul>
<ol>
<div class="ladyScroll">
<a class="prev" href="javascript:void(0)"></a>
<div class="scrollWrap link2">
<div class="dlList">
<?php if(is_array($banner_list)) { foreach($banner_list as $item) { ?>
    <li><a href="<?php echo $item['url'];?>" title="<?php echo $item['title'];?>" target="_blank"><img src="<?php echo getImageUrl($item['pic'],'670');?>"><b><?php echo $item['title'];?></b></a></li>        
<?php } } ?>
</div>
</div>
<a class="next" href="javascript:void(0)"></a>
</div>
<script type="text/javascript">
jQuery(".ladyScroll").slide({ mainCell:".dlList", effect:"leftLoop",vis:4,scroll:1,interTime:10000,delayTime:1000, autoPlay:true});
</script>
</ol>
</div>
</div>
<div class="mgtop-15 background-w1">
<div class="w2-left">
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo getTableInfohanettName(4,'article_class','title');?></b></ul><ol><a href="<?php echo url('news','index',array('pid'=>4));?>" target="_blank">更多+</a></ol></div>
<div class="m_new1 ht1">
<?php $list2=M('article')->getList('new',6,4); ?>
<?php if(is_array($list2)) { foreach($list2 as $key => $item) { ?>
<?php if($key==0) { ?>
<ol>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>">
 <img src="<?php echo getImageUrl($item['pic'],'400');?>" />
<span><?php echo $item['title'];?></span>
</a>
</ol>
<?php } ?>
<?php } } ?>
<ul>
<?php if(is_array($list2)) { foreach($list2 as $key => $item) { ?>
<?php if($key>0) { ?>
<li><a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a> 
<em><?php echo date('Y-m-d',$item['addtime']);?></em></li> 
<?php } ?>
 
<?php } } ?>
</ul>
</div>
<!--ol_循环1行/ul里li_循环8行-->
</div>
<div class="w2-right">
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo getTableInfohanettName(3,'article_class','title');?></b></ul><ol><a href="<?php echo url('news','index',array('pid'=>3));?>" target="_blank">更多+</a></ol></div>
<div class="m_new1 ht1">
<ul>
<?php $list8=M('article')->getList('new',8,3); ?>
<?php if(is_array($list8)) { foreach($list8 as $key => $item) { ?> 
<li>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a>
<em><?php echo date('Y-m-d',$item['addtime']);?></em></li>  
<?php } } ?> 
</ul>
</div>
</div> 
</div> 
<!--这里报错-->
<div class="mgtop-15 background-w1">
<div class="fdiv mua"><ul><i class="iconfont icon-icon-test"></i><b><?php echo getTableInfohanettName(7,'article_class','title');?></b></ul><ol><a href="<?php echo url('news','index',array('pid'=>7));?>">更多+</a></ol></div>
<div class="ladyDcroll">
<a class="prev" href="javascript:void(0)"></a>
<div class="scrollWrap link2">
<div class="dlList">
<?php $list3=M('article')->getList('new',8,7); ?>
<?php if(is_array($list3)) { foreach($list3 as $key => $item) { ?>
<li>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" title="<?php echo $item['title'];?>" target="_blank">
<img src="<?php echo getImageUrl($item['pic'],'500');?>" />
<b><?php echo $item['title'];?></b> 
</a>
</li>
<?php } } ?> 
</div>
</div>
<a class="next" href="javascript:void(0)"></a>
</div>
<script type="text/javascript">
jQuery(".ladyDcroll").slide({ mainCell:".dlList", effect:"leftLoop",vis:5,scroll:1,interTime:10000,delayTime:1000, autoPlay:true});
</script>
</div>
<div class="mgtop-15 background-w1">
<div class="w2-left">
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo getTableInfohanettName(6,'article_class','title');?></b></ul><ol><a href="<?php echo url('news','index',array('pid'=>6));?>" target="_blank">更多+</a></ol></div>
<div class="m_new1 ht1">
<?php $list2=M('article')->getList('new',6,6); ?>
<?php if(is_array($list2)) { foreach($list2 as $key => $item) { ?>
<?php if($key==0) { ?>
<ol>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>">
 <img src="<?php echo getImageUrl($item['pic'],'400');?>" />
<span><?php echo $item['title'];?></span>
</a>
</ol>
<?php } ?>
<?php } } ?>
<ul>
<?php if(is_array($list2)) { foreach($list2 as $key => $item) { ?>
<?php if($key>0) { ?>
<li><a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a> 
<em><?php echo date('Y-m-d',$item['addtime']);?></em></li> 
<?php } ?>
 
<?php } } ?>
</ul>
</div>
<!--ol_循环1行/ul里li_循环8行-->
</div>
<div class="w2-right">
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo getTableInfohanettName(9,'article_class','title');?></b></ul><ol><a href="<?php echo url('news','index',array('pid'=>9));?>" target="_blank">更多+</a></ol></div>
<div class="m_new1 ht1">
<ul>
<?php $list8=M('article')->getList('new',8,9); ?>
<?php if(is_array($list8)) { foreach($list8 as $key => $item) { ?> 
<li>
<a href="<?php echo url('news','show',array('id'=>$item['id']));?>" target="_blank" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a>
<em><?php echo date('Y-m-d',$item['addtime']);?></em></li>  
<?php } } ?> 
</ul>
</div>
</div> 
</div> 
<div class="mgtop-15 background-w1">
<div class="fdiv mua"><ul><i class="iconfont icon-dangyuandangyuanguanlidangyuanzhuanchu"></i><b>先锋模范</b></ul><ol><a href="<?php echo url('user','index');?>">更多+</a></ol></div>
<div class="ladyTcroll">
<a class="prev" href="javascript:void(0)"></a>
<div class="scrollWrap link2">
<div class="dlList">
<?php if(is_array($userlist)) { foreach($userlist as $item) { ?>
<li class="layui-elem-field">
<legend>
<div class="layui-inline">
<img src="<?php echo getImageUrl($item['avatar'],'avatar');?>" />
</div>
</legend>
<div class="layui-field-box">
<a href="javascript:openIframeLayer('<?php echo url('user','userview',array('id'=>$item['id']));?>','用户信息',{area:['700px', '500px']});"><b><?php echo $item['truename'];?></b></a>
<em></em>
</div>
</li>
<?php } } ?>
</div>
</div>
<a class="next" href="javascript:void(0)"></a>
</div>
<script type="text/javascript">
jQuery(".ladyTcroll").slide({ mainCell:".dlList", effect:"leftLoop",vis:5,scroll:1,interTime:10000,delayTime:1000, autoPlay:true});
</script>
</div>
 
<!--主体内容 结束-->
<?php include T('footer');?>