<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header');?>
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style type="text/css">
.layui-container{width: 100%;margin: 0 auto;padding:0px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:100%;line-height:34px;min-width:60px;height:34px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;}
.layui-tab-content{padding-top:20px;}
.assist{
width: 100%;
height: 100%;
    }
    .assist-content{
    width: 90%;
    height: auto;
    margin: 0 auto;
    border-left: 2px solid #EEEEEE;
    border-right: 2px solid #EEEEEE;
    background-color: white;
    }
    .con-left{
    width: 15%;
    height: auto;
    float: left;
    }
    .con-left img{
    width: 40px;
    height: 40px;
    border-radius: 50%;
    }
    .con-right{
    width: 85%;
    height: auto;
    float: right;
    }
    .conname{
    font-size: 18px;
    height: 25px;
    margin: 5px;
    line-height: 25px;
    }
    span{
    font-size: 16px;
    /*margin-left: 10px;*/
    }
    .speciality,.concompany{
    font-size: 14px;
    color: #CCCCCC;
    margin: 5px;
    }
    .contact{
    padding:10px ;
    height: auto;
    overflow: hidden;
    }
    .con-right img{
    height: 25px;
    float: right;
    margin: 0 auto;
    }
    .con-right .con-tel{
        height: 20px;
    margin-right: 10px;
    padding-right: 10px;
    border-right: 1px solid #999;
    }
    .xhx{
    width: 96%;
    border: 2px solid #eeeeee;
    margin: 0 auto;
    }
    .xwpages{
        display: block;
        width: 90%;
        margin: 50px auto;
    }
</style>
<div class="assist">
<div class="fdiv mua">
            <ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $title;?></b></ul> 
        </div>
        <div class="tu_k link2"><br/></div> 
        <?php if(is_array($organ)) { foreach($organ as $og) { ?>
<div class="assist-content">
<div class="contact">
<div class="con-left">
<img src="<?php echo getImageUrl($member['avatar'],'avatar');?>"/>
</div>
<div class="con-right">
<p class="conname"><?php echo $og['truename'];?>  <img src="/ssz/images/message.png"/>
<a href="tel:<?php echo $og['mobile'];?>) "><img class="con-tel" src="/ssz/images/tel.png"/></a></p>
<p class="concompany">职位：
<?php echo $og['depadata'];?>
<?php echo $og['offdata'];?>
</p>

</div>
</div>
<div class="xhx"></div>
</div>
<?php } } ?>
<ul class="xwpages">
<?php if(!empty($organ)) { ?>
<?php echo $show_page;?>
<?php } ?>
</ul>
</div>
<?php include T('footer');?> 