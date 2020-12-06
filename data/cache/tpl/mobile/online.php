<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style>
.user_three span{
    margin:0 8px ;
}
#zhsz,#progress{
    display: block;
    width: 100%;
}
.mem-list{
    width: 98%;
    height: 30px;
    margin: 10px 0;
    font-size: 16px;
    line-height: 30px;
    margin: 5 auto;
}
.list-title{
    width: 100%;
    padding-left:10px ;
    background-color: white;
    
}
.list-title img{
    width: 16px;
    height: 16px;
    margin: -5px 10px 0 0;
}
#zhsz span,#progress span{
    display: inline-block;
    float: right;
    margin-right: 10px;
    color: #ccc;
    font-size: 12px;
}
.mytask .tabsInfo {
    position: absolute;
    margin-top: 2px;
    margin-left: 7px;
    border-radius: 100%;
    background-color: #fc6678;
    font-size: 4px;
    color: #fff;
    line-height: 1;
    vertical-align: 10px;
    padding: 2px 4px;
}
</style>
<div class="mgtop-15 background-w1">
    <input type="text" name="ids" value="<?php echo $_GET['id']?>" style="display:none">
<div class="mem-list">
<div>
<p class="list-title"><span></span><a href="<?php echo url('online','add');?>" id="zhsz"> <img src="/ssz/images/mine-youji-nor@2x.png" alt="我要提问" />我要提问<span>查看 <em>></em></span></a></p>
</div>
</div>

<div class="mem-list">
<div>
<p class="list-title"><a href="<?php echo url('task','myunquest');?>" id="progress"><img src="/ssz/images/mine-youji-nor@2x.png" alt="进度查询" />进度查询<span>查看 <em>></em></span></a></p>
</div>
</div>
</div>
<div class="clear"></div> 
</div> 
<?php include T('footer');?> 
