<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
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
</style>
<div class="mgtop-15 background-w1">
    <input type="text" name="ids" value="<?php echo $_GET['id']?>" style="display:none">
<div class="fdiv mua">
    <ul><i class="iconfont icon-dangwugongkai"></i><b><?php echo $title;?></b></ul> 
</div>
<div class="tu_k link2"><br/></div> 
<div class="layui-container">
<form class="layui-form"  id="article_list_form" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
<div class="layui-tab-item layui-show">

<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 满意度</label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
<div class="layui-input-block">
<input  type="radio" name="satisfaction"  lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="满意"  value="1">
    <input type="radio" name="satisfaction"  lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="一般满意" value="2" >
    <input type="radio" name="satisfaction"  lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="不满意"  value="3" >
</div>
</div>
</div>

    
</div>    
                <div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> </label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
<div class="layui-input-block">
<button class="layui-btn layui-btn-primary updateinfo"  lay-submit lay-filter="formDemo">提交</button> 
</div>
</div>
</div>

</form>

<script> 
layui.use('form', function(){
var form = layui.form;
 
//监听提交


 
});


</script>
<div class="clear"></div> 
</div> 
<?php include T('footer');?> 
