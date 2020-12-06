<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header2');?>
<script type="text/javascript" charset="utf-8" src="/data/ext/echarts/build/dist/echarts.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/ueditor.all.min.js"> </script> 
<script type="text/javascript" charset="utf-8" src="/data/ext/ueditor/lang/zh-cn/zh-cn.js"></script>
<link href="/ssz/wap/css/fuwu.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="/public/layui/css/layui.css">
<script src="/public/layui/layui.js"></script>
<style type="text/css">
.layui-container{width: 100%;margin: 0 auto;padding:0px;font-size:12px;}
.ke-container{width: 100%!important;} 
.layui-form-title{text-align:right;display:block;width:100%;line-height:34px;min-width:60px;height:34px;font-size:12px;}
.layui-form-title em{font: bold 14px/20px tahoma, verdana;color: red;vertical-align: middle;}
.mb15 { margin-bottom: 15px; }
.layui-input-block {margin-left: 20px;font-size:12px;}
.layui-tab-content{padding-top:20px;}
.layui-form-mid{font-size:12px;}
h1,h2,h3,h4,h5,h6{
 font-size:100%; 
 font-weight: normal;
}
.integral{
width: 100%;
}
.integrallist{
width:95%;
margin: 10px auto;
overflow: hidden;
}
.integrallist1,.integrallist2{
width: 100%;
background-color: white;
height: 80px;
overflow: hidden;
padding: 10px 0;
}
.integrallist2{
margin-top: 10px;
}
.integtallist1-left{
width: 50%;
float: left;
padding: 5px 0 5px 10px;
overflow: hidden;
}
.integtallist1-left img,.integtallist1-right img{
width: 25px;
height: 25px;
float: left;
overflow: hidden;

}
.integralnum,.tasknum,.monthnum,.flagnum{
width: 75%;
display: block;
height: 25px;
margin-left: 10px;
float: left;
line-height: 25px;
overflow: hidden;
font-size: 24px;
}
.integraltxt,.tasktxt,.monthtxt,.flagtxt{
width: 75%;
float: left;
height: 25px;
margin-left: 35px;
line-height: 25px;
color: #CCCCCC;
overflow: hidden;
font-size: 16px;
}.integtallist1-right{
float: right;
width: 50%;
padding: 5px 0 5px 10px;
overflow: hidden;
}
.integtallist1-middle{
width: 95%;
margin: 10px auto;
background-color: white;
height: 300px;
overflow: hidden;
}
#chart{
width: 100%;
height: 200px;
overflow: hidden;
}
.integral-bottom{
width: 95%;
background-color: white;
height: 140px;
margin: 10px auto;
}
.rank{
width: 33%;
height: 120px;
float: left;
position: relative;
}
.rank img{
width: 30px;
height: 30px;
position: absolute;
top: 5%;
left: 50%;
margin-left: -15px;
}
.rank p{
height: 20px;
line-height: 20px;
font-size: 14px;
text-align: center;
}
.rankNo1,.rankNo2,.rankNo3{
margin-top: 40px;
color: #CCCCCC;
}
.integralgrowth,.tasksnamber{
width: 95%;
height: 50px;
background-color: white;
margin: 10px auto;
}
.integralrank span,.integralgrowth span {
    font-size: 12px;
                width: 20%;
                float: left;
                color: #ccc;
                padding: 10px;
            }            
            
            h3{
                width: 80%;
                float: left;
                padding: 10px;
            }
</style>
<div id="content_Height" class="clearfix">
<div style="overflow:hidden;">
<div class="integral">
<div id="integral_top">
<div class="integrallist">
<div class="integrallist1">
<div class="integtallist1-left">
<i class="layui-icon layui-icon-username" style="font-size: 25px; color: #69D8FF; float:left;"></i>  
<p class="integralnum"><?php echo $member['integral']?></p>
<p class="integraltxt">个人积分总数</p>
</div>
<div class="integtallist1-right">
<i class="layui-icon layui-icon-star-fill" style="font-size: 25px; color: #FF7B50; float:left;"></i>  
<p class="tasknum"><?php echo $task['0']['count']?></p>
<p class="tasktxt">本月任务总数</p>
</div>
</div>

</div>
<div class="integtallist1-middle">
<h3>月度积分累计增长折线图</h3>
<div id="chart">

</div>
</div>
<div class="integral-bottom">
<div class="integralrank">
<h3>总积分排行榜</h3>
<a href="<?php echo url('integral','yearrank');?>" class="items"><span>查看更多</span></a>
<?php if(is_array($userlist)) { foreach($userlist as $user) { ?>
<div class="rank">
<img src="11.png"/>
<p class="rankNo1"><?php echo $user['truename']?></p>
<p><?php echo $user['integral']?></p>
</div>
    <?php } } ?>
</div>


</div>
<div class="integralgrowth">
<h3>月度积分增长排行榜</h3>
<a href="<?php echo url('integral','monthrank');?>" class="items"><span>查看更多</span></a>
</div>
<div class="tasksnamber">
<h3>任务数量占比(数量)</h3>
</div>
</div>
</div>
</div>

</div>

<script type="text/JavaScript">
function lineChart() {
    var myChart = echarts.init(document.getElementById('chart'));
    // 显示标题，图例和空的坐标轴
    myChart.setOption({
        // title: {
        //     text: '月度积分累计增长折线图'
        // },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['积分']
        },
        toolbox: {
            show: true,
            feature: {
                mark: { show: true },
                dataView: { show: true, readOnly: false },
                magicType: { show: true, type: ['line', 'bar'] },
                restore: { show: true },
                saveAsImage: { show: true }
            }
        },
        grid:{
            height:'120'
        },
        calculable: true,
        xAxis: {
            type: 'category',
            boundaryGap: false, //取消左侧的间距
            data: []
        },
        yAxis: {
            type: 'value',
            splitLine: { show: true },//是否去除网格线
            name: ''
        },
        series: [{
            name: '积分',
            type: 'line',
            symbol: 'emptydiamond',    //设置折线图中表示每个坐标点的符号 emptycircle：空心圆；emptyrect：空心矩形；circle：实心圆；emptydiamond：菱形
            data: []
        }]
    });
    myChart.showLoading();    //数据加载完之前先显示一段简单的loading动画
    var names = [];    //类别数组（实际用来盛放X轴坐标值）    
    var series = [];
    $.ajax({
        type: 'get',
        url: "<?php echo url('integral','getdetail');?>",//请求数据的地址
        dataType: "json",        //返回数据形式为json
        success: function (results) {
            var result=results.datas;
            console.log(result,5555555);
            //请求成功时执行该函数内容，result即为服务器返回的json对象           
            $.each(result, function (index, item) {
                names.push(item.AREA);    //挨个取出类别并填入类别数组
                series.push(item.LANDNUM);
            });
            myChart.hideLoading();    //隐藏加载动画
            myChart.setOption({        //加载数据图表
                xAxis: {
                    data: names
                },
                series: [{                    
                    data: series
                }]
            });
        },
        error: function (errorMsg) {
            //请求失败时执行该函数
            alert("图表请求数据失败!");
            myChart.hideLoading();
        }
    });
};
lineChart();

</script>
 
<?php include T('footer');?> 