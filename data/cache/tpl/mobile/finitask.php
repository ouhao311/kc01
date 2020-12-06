<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<script charset="utf-8" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=NRYBZ-XEBKD-ETX4E-HJIQT-63SQT-3EFRM"></script>
    <link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
    <script src="/public/layui/layui.js"></script>
<style type="text/css">
.layui-container{width: 100%;margin: 20px auto;padding:0px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:100%;line-height:34px;min-width:100px;height:34px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;}
.layui-tab-content{padding-top:20px;}
.clock{
            position: relative;
        }
.layui-btn-normal {
            background-color: #1E9FFF;
        }
.layui-btn {
    display: inline-block;
    height: 38px;
    line-height: 38px;
    padding: 0 18px;
    background-color: #009688;
    color: #fff;
    white-space: nowrap;
    text-align: center;
    font-size: 14px;
    border: none;
    border-radius: 2px;
    cursor: pointer;
}
</style>
<div class="mgtop-15 background-w1">
<div class="layui-container">
<form class="layui-form"  id="visit_detail_list" enctype="multipart/form-data" method="post" >
<input type="hidden" name="form_submit" value="ok"/>
<input type="hidden" name="id" value="<?php echo $id;?>" />
<input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
<div class="layui-tab-item layui-show">
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>接待人走访人员</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="text" name="reception" style="width:100%;" id="reception" lay-v="required|title" autocomplete="off" class="layui-input" placeholder="请输入走访人员" value="<?php echo $visitdetail['0']['reception'];?>">
                 </div>
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <!--<label class="layui-form-title"><em>*</em>事项登记日期</label>-->
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9" style="margin-left:25%">
  
                 <div class="layui-input-block">
                    
                       <div class="layui-input-block">
                <input  type="radio" name="depart" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="党代表"  value="1" <?php if($visitdetail['0']['depart']=="1") { ?> checked="checked" <?php } ?>
>
    <input type="radio" name="depart" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="人大代表" value="2" <?php if($visitdetail['0']['depart']=="2") { ?> checked="checked" <?php } ?>
>
    <input type="radio" name="depart" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="政协委员"  value="3" <?php if($visitdetail['0']['depart']=="3") { ?> checked="checked" <?php } ?>
>
                 </div>
  
                 </div>
                  
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs3 layui-col-sm3 layui-col-md3">
                 <label class="layui-form-title"><em>*</em>问题、建议描述</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                     <textarea name="qustion" id="qustion" placeholder="请输入问题、建议描述" class="layui-textarea"><?php echo $visitdetail['0']['qustion'];?></textarea>
                 </div>
</div>
</div>

<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>事项类别</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="radio" name="itemcategory" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="意见建议"  value="1"  
                 <?php if($visitdetail['0']['itemcategory']=="1") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="itemcategory" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="矛盾纠纷" value="2"  <?php if($visitdetail['0']['itemcategory']=="2") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="itemcategory" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="寻求帮助"   value="3" <?php if($visitdetail['0']['itemcategory']=="3") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="itemcategory" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="事项代办" value="4"  <?php if($visitdetail['0']['itemcategory']=="4") { ?> checked="checked" <?php } ?>
>
                 </div>
</div>
</div>
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>处理方式</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="radio" name="processmode" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="现场化解"  value="1"    <?php if($visitdetail['0']['processmode']=="1") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="processmode" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="网格员调解" value="2" <?php if($visitdetail['0']['processmode']=="2") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="processmode" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="部门承办" value="3"  <?php if($visitdetail['0']['processmode']=="3") { ?> checked="checked" <?php } ?>
>
                 </div>
</div>
</div>
<!--<div class="layui-row mb15 ">-->
<!--<div class=" layui-col-xs3  layui-col-sm3 layui-col-md3">-->
  <!--               <label class="layui-form-title"><em>*</em>处理结果</label>-->
<!--</div>-->
<!--<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">-->
  <!--               <div class="layui-input-block">-->
  <!--                   <textarea name="content" id="content" placeholder="请输入内容" class="layui-textarea"><?php echo $visitdetail['0']['content'];?></textarea>-->
  <!--               </div>-->
<!--</div>-->
<!--</div>-->
<!--<div class="layui-row mb15 ">-->
<!--<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">-->
  <!--               <label class="layui-form-title"><em>*</em>群众满意度反馈</label>-->
<!--</div>-->
<!--<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">-->
  <!--               <div class="layui-input-block">-->
 <!--               <input type="radio" name="satisfaction" lay-skin="primary" title="满意" lay-v="required|title" autocomplete="off" class="layui-input "  value="1" <?php if($visitdetail['0']['satisfaction']=="1") { ?> checked="checked" <?php } ?>
>-->
<!--        <input type="radio" name="satisfaction" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="基本满意" value="2" <?php if($visitdetail['0']['satisfaction']=="2") { ?> checked="checked" <?php } ?>
>-->
<!--        <input type="radio" name="satisfaction" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="不满意" value="3"  <?php if($visitdetail['0']['satisfaction']=="3") { ?> checked="checked" <?php } ?>
>-->
  <!--               </div>-->
<!--</div>-->
<!--</div>-->
<!--<div class="layui-row mb15 ">-->
<!--<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">-->
  <!--               <label class="layui-form-title"><em>*</em>办理人员签字</label>-->
<!--</div>-->
<!--<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">-->
  <!--               <div class="layui-input-block">-->
 <!--                <input type="text" name="transaction" style="width:100%;" id="transaction" lay-v="required|title" autocomplete="off" class="layui-input" placeholder="请输入办理人员" value="<?php echo $visitdetail['0']['transaction'];?>">-->
  <!--               </div>-->
<!--</div>-->
<!--</div>-->
<div class="layui-row mb15 ">
                <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
                <label class="layui-form-title"><em>*</em>地图</label>
                 </div>
                 <div class=" layui-col-xs12 layui-col-sm12 layui-col-md12">
                 <div class="clock">
                                 <div  id="container" style=" border:2px solid #25a4ff;width:95%;height:300px;margin: 10px auto;">
                                     <input id="lat" type="text" name="lat" style="width:100%;"  lay-v="required|title" autocomplete="off" class="layui-input" value="<?php echo $visitdetail['0']['lat'];?>" >
                                     <input id="lng" type="text" name="lng" style="width:100%;"  lay-v="required|title" autocomplete="off" class="layui-input" value="<?php echo $visitdetail['0']['lng'];?>" >
                                     <input id="addr" type="text" name="address" style="width:100%;"  lay-v="required|title" autocomplete="off" class="layui-input" value="<?php echo $visitdetail['0']['address'];?>" >
                                 </div>
                             </div>
                 </div>
                </div> 
                
                <?php if($member['identity']=="2") { ?>
                <div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>审核</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="radio" name="status" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="通过"  value="1"    <?php if($visitdetail['0']['status']=="1") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="processmode" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="未通过" value="-1" <?php if($visitdetail['0']['status']=="0") { ?> checked="checked" <?php } ?>
>
        
                 </div>
</div>
</div>
                <?php } ?>
                
                  <?php if($member['identity']=="3") { ?>
               <div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
                 <label class="layui-form-title"><em>*</em>审核</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
                 <div class="layui-input-block">
                 <input type="radio" name="topstatus" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="通过"  value="1"    <?php if($visitdetail['0']['topstatus']=="1") { ?> checked="checked" <?php } ?>
>
         <input type="radio" name="topstatus" lay-skin="primary" lay-v="required|title" autocomplete="off" class="layui-input " title="未通过" value="-1" <?php if($visitdetail['0']['topstatus']=="0") { ?> checked="checked" <?php } ?>
>
        
                 </div>
</div>
</div> 
                
                 <?php } ?>
                
                
                
                
                
                
                
                
                
                
                
                
                <?php if(empty($visitdetail['0'])||$member['identity']=="2"||$member['identity']=="3") { ?>
<div class="layui-row mb15 ">
<div class=" layui-col-xs3  layui-col-sm3  layui-col-md3">
<label class="layui-form-title"> </label>
</div>
<div class=" layui-col-xs10 layui-col-sm10 layui-col-md10 ">
<div class="layui-input-block">
<button style="margin-left: 50%"  class="layui-btn layui-btn-primary updateinfo"  lay-submit lay-filter="formDemo">提交</button> 
</div>
</div>
</div>
<?php } ?>
               </div>
</form>
</div>
<script>
layui.use(['form', 'layedit', 'laydate'], function() {
var form = layui.form,
layer = layui.layer,
layedit = layui.layedit,
laydate = layui.laydate;

//日期
laydate.render({
elem: '#date',
type: 'datetime',
        trigger: 'click'
});
laydate.render({
elem: '#enddate',
type: 'datetime',
        trigger: 'click'
});
//监听提交
form.verify({
rank: function(value, item){
if(value==''){
return '请输入排序!';
} 
},
pidtitle: function(value, item){ 
if(value==''){
return '请选择所属分类!';
}
},
title: function(value, item){
if(value==''){
return '请输入标题!';
}
}


}); 
});
//地图
        var geolocation = new qq.maps.Geolocation("NRYBZ-XEBKD-ETX4E-HJIQT-63SQT-3EFRM", "myapp");
        var options = {
            timeout: 8000 //延时
        };
        var geocoder;
        var latLng;
        // 定位成功之后调用的方法
        function showPosition(position) {
            console.log(position)
            let lat = position.lat;
            let lng = position.lng;
            document.getElementById("lat").value=lat;
            document.getElementById("lng").value=lng;
            // 逆地址解析(经纬度到地名转换过程)
            geocoder = new qq.maps.Geocoder({
                complete: function(res) {
                    console.log(res)
                    document.getElementById("addr").value=res.detail.address;
                    // 标志位置
                    var center = new qq.maps.LatLng(lat, lng);
                    var map = new qq.maps.Map(document.getElementById('container'), {
                        center: center,
                        zoom: 15,
                    });
                    //创建标记
                    var marker = new qq.maps.Marker({
                        position: center,
                        map: map
                    });
                    //添加到提示窗
                    var info = new qq.maps.InfoWindow({
                        map: map
                    });
                    //获取标记的点击事件
                    qq.maps.event.addListener(marker, 'click', function() {
                        info.open();
                        info.setContent('<div style="text-align:center;white-space:nowrap;margin:10px;">' + res.detail.address + '</div>');
                        info.setPosition(center);
                    });
                }
            });
            latLng = new qq.maps.LatLng(lat, lng);
            geocoder.getAddress(latLng);
        };
        function showErr() {
            console.log('定位失败');
        }
        geolocation.getLocation(showPosition, showErr, options);

</script>
<div class="clear"></div> 
</div> 
<?php include T('footer');?> 
