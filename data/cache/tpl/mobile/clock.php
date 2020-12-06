<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" />
<script charset="utf-8" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=NRYBZ-XEBKD-ETX4E-HJIQT-63SQT-3EFRM"></script>
    <link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
    <script src="/public/layui/layui.js"></script>
    <script charset="utf-8" src="<?php echo $mapurl?>">
        
    </script>
    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
        }
        body,button,input,select,textarea {
            font: 12px/16px Verdana, Helvetica, Arial, sans-serif;
        }
        .clock{
            position: relative;
        }
        #signbtn{
            position: absolute;
            left: 50%;
            margin: 30px -70px;
width:140px;
height:140px;
border-radius:50%;
box-shadow:0px 0px 8px #25a4ff;
font-size: 20px;
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
    #time{
font-size:16px;
color:#1e9fff;
font-weight:bold;
margin:10px;
}
    </style>
    <div class="clock">
        <div id="container" style=" border:2px solid #25a4ff;width:95%;height:300px;margin: 10px auto;"></div>
        <button id='signbtn' style="margin-bottom:100px" class="layui-btn layui-btn-normal">考勤签到</button>
        <div id='time'></div>
    </div>
    
    
    <script>
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
            // 逆地址解析(经纬度到地名转换过程)
            geocoder = new qq.maps.Geocoder({
                complete: function(res) {
                    console.log(res)
                    // 标志位置
                    var center = new qq.maps.LatLng(lat, lng);
                    var map = new qq.maps.Map(document.getElementById('container'), {
                        center: center,
                        zoom:20,
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
                    $("#signbtn").click(function(){
                        let address=res.detail.address;
                        console.log("经度："+res.detail.location.lat);
                        console.log("纬度："+res.detail.location.lng);
                        console.log("地址:"+res.detail.address)
                        $.ajax({
             type: "post",
             url: "<?php echo url('task','clock');?>",
             async: true,
             data: {
             lat:lat,
             lng:lng,
             address:address
             },
             success: function(res) {
             res = $.parseJSON(res);
             console.log(res)
             layui.use(['layer'], function(){
             if (res.err == 1) {
                 layer.msg(res.msg);
                        
                            } else {
                        globalFunc.time();
                          }
             });
             }
            });
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
        
        setInterval("document.getElementById('time').innerHTML=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());",1000);
        now = new Date(),hour = now.getHours();
    </script>
<?php include T('footer');?> 