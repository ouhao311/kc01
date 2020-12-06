<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style type="text/css">
.layui-container{width: 100%;margin: 0 auto;padding:0px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:100%;line-height:34px;min-width:60px;height:34px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;height:auto;}
.layui-tab-content{padding-top:20px;}
.satisfaction{
    width: 80px;
    height: 80px;
    float: left;
    text-align: center;
    position: relative;
}
#satisfaction1,#satisfaction2,#satisfaction3{
    position: absolute;
    left: 50%;
    top: 50%;
    margin: -25px -25px;
}
.satisfaction span{
    display: block;
    position: absolute;
    left: 50%;
    top: 80%;
    margin:0 -20px;
}
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
    input[type=button]
{
 width: 130px;
 height: 30px;
 background-color: #ff3000;
 border: 0;
 border-radius: 15px;
 color: #fff;
 margin-left: 20px;
}
input[type=button].on {
 background-color: #eee;
 color: #ccc;
 cursor: not-allowed;
}
</style>
<div class="mgtop-15 background-w1">
    <input type="text" name="ids" value="<?php echo $_GET['id']?>" style="display:none">
<div class="tu_k link2"><br/></div> 
<div id="content_Height" class="clearfix">
<div style="overflow:hidden;">
<div class="section">
<div class="ccon-cell">
<div>
    <p class="banjian_tit"><span></span>进度查询</p>
<div item="zixun">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="banjian">
<thead>
<tr bgcolor="#f3f7fc">
    <td width="20%" align="center" valign="middle">问题</td>
    <td width="20%" align="center" valign="middle">问题描述</td>

<td width="20%" align="center" valign="middle">查看处理详情</td>
</tr>
</thead>
<tbody>
    <?php if(is_array($list)) { foreach($list as $vl) { ?>
<tr>
    <td align="center" valign="middle"><?php echo $vl['title']?></a></td> 
    <td align="center" valign="middle"><?php echo $vl['content']?></td>
   
<td align="center" valign="middle"><span class="icon_sq"> <a  href="<?php echo url('','',array('id'=>$vl['id']));?>"title="前去评价"> 查看详情 </a> </span>
</td>
</tr>
<?php } } ?>
</tbody>
</table>
<ul class="xwpages">
<?php if(!empty($list)) { ?>

<?php echo $show_page;?>
<?php } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="clear"></div> 
</div>
</div>

<script> 
layui.use('form','laydate', function(){
var form = layui.form,
laydate = layui.laydate;
laydate.render({
elem: '#time',
type: 'datetime',
        trigger: 'click'
});
});

</script>
<div class="clear"></div> 
</div> 
<?php include T('footer');?> 
