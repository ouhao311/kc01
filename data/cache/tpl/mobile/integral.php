<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<div class="mgtop-15 background-w1">
 
<div class="fdiv mua"><ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $title;?></b></ul>
<ol>当前位置：<a href="/">首页</a> > <a href="<?php echo url('integral','index');?>">积分统计</a> >
列表
</ol></div>
<table class="layui-table my-table">
  <colgroup>
<col width="20%">
<col width="40%">
<col width="20%">
<col>
  </colgroup>
  <thead>
<tr>
<th>排行</th>
<th>姓名</th>
<th>积分</th>
<th>所属支部</th>
</tr> 
  </thead>
  <tbody>
<?php if(is_array($userlist)) { foreach($userlist as $key => $item) { ?>
<?php $i=$key+1;?>
<?php if($i>4) { ?>
<?php $i=4;?>
<?php } ?>
  <tr>
<td><i class="jf<?php echo $i;?>"><?php echo $key+1;?></i></td>
<td><a ><legend><div class="layui-inline">
<img src="<?php echo getImageUrl($item['avatar'],'avatar');?>" class="layui-circle" />
</div></legend><span><?php echo $item['truename'];?></span></a></td>
<td><?php echo $item['integral'];?></td> 
<td><?php echo getSinglePas($table='attribute','department',$item['department'],'title');?></td>
</tr>
<?php } } ?>
</tbody>
</table>

</div>
 
<!--主体内容 结束-->
 
<?php include T('footer');?> 