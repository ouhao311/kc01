<?php defined('SSZCMS') or exit('Access Denied');?>
<?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style>
.layui-container{width: 100%;margin: 0 auto;padding:0px;}
  .m_new1 {
    clear: both;
    overflow: hidden;
    width: 100%;
    padding: 0px 0px 0px 0px;
    clear: both;
    float: left;
    width: 100%;
}
.m_new1 ul {
    clear: both;
    float: left;
    width: 100%;
}
.m_new1 ul li {
    clear: both;
    float: left;
    width: 100%;
    font: 12px/43px "微软雅黑","Arial";
    border-bottom: 1px #ddd dashed;
}
.m_new1 ul li a {
    line-height: 25px;
    height: 25px;
    overflow: hidden;
    float: left;
    width: 60%;
    padding-left: 8px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.m_new1 ul li em {
    line-height: 25px;
    height: 25px;
    float: right;
    color: #999;
    font-size: 8px;
    width: 35%;
    text-align: right;
}
</style>
<div id="content_Height" class="clearfix">
<div style="overflow:hidden;">
<div class="content_top">
<div class="user ">
<div class="user_tx fl"><img src="<?php echo getImageUrl($member['avatar'],'avatar');?>" alt="用户头像" /> </div>
<div class="user_head fl">
<div class="yhm"><span class="yhm" id="mobilePhone"><?php echo $member['truename'];?> </span>，您好！</div>

</div>
</div>
   
</div>
<div class="section">
      <p class="banjian_tit"><span></span>我的消息</p>
      <div class="layui-container">
        <div class="m_new1 ht1">
          <ul>
              <?php if(is_array($list)) { foreach($list as $item) { ?>
              <li>
                  <a title="<?php echo $info['name'];?>"><?php echo $item['name'];?></a>
                  <em>截止时间：<?php echo $item['enddate'];?></em>
                </li>  
              <?php } } ?>
              <li>
                <a href="<?php echo url('member','taskview',array('id'=>$item['id']));?>" title="<?php echo $info['name'];?>">你有一个任务为完成</a>
                <em>截止时间：2020-10-20</em>
              </li>
              <li>
                <a href="<?php echo url('member','taskview',array('id'=>$item['id']));?>" title="<?php echo $info['name'];?>">你有一个任务为完成</a>
                <em>截止时间：2020-10-20</em>
              </li>
              <li>
                <a href="<?php echo url('member','taskview',array('id'=>$item['id']));?>" title="<?php echo $info['name'];?>">你有一个任务为完成</a>
                <em>截止时间：2020-10-20</em>
              </li>
          </ul>
        </div>
      
      </div>
</div>
</div>
</div>