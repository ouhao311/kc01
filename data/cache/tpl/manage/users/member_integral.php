<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="page">
<div class="fixed-bar">
<div class="item-title">
<div class="subject">
<h3>积分排行列表</h3>
<h5>积分排行列表管理</h5>
</div> 
<span style="float: right;position:absolute;right:1%;top:10px;"> 
<a class="layui-btn layui-btn-primary" href='javascript:' onclick='$("#flexigrid").flexReload();' title="刷新" style="text-decoration:none">
<i class="Hx-iconfont">&#xe68f;</i> 刷新
</a>
</span>
</div>
</div>
<form class="layui-form"  method="get" name="formSearch" id="formSearch">
<div class="layui-form-item">
<div class="layui-form-pane" style="margin-top: 15px;">

</div>
</div>
</form>
<div id="flexigrid"></div>

<script> 
//加载模块
layui.use(['laydate','form','element'], function(){
  var laydate = layui.laydate; 
  var element = layui.element; 
  var form = layui.form; 
  laydate.render({   elem: '#LAY_demorange_s'});
  laydate.render({   elem: '#LAY_demorange_e'});
 
})
</script>
<script type="text/javascript">
$(function(){
// 高级搜索提交
$('#ncsubmit').click(function(){
$("#flexigrid").flexOptions({url: 'index.php?url=<?php echo $this->name;?>&do=get_xml&'+$("#formSearch").serialize(),query:'',qtype:''}).flexReload();
});
$("#flexigrid").flexigrid({
url: 'index.php?url=<?php echo $this->name;?>&do=get_xml',
colModel : [
{display: '登陆账号', name : 'username', width : 100, sortable : false, align: 'left'},  
{display: '会员姓名', name : 'truename', width : 120, sortable : false, align: 'left'},    
{display: '积分', name : 'integral', width : 100, sortable : false, align: 'center'},  
{display: '注册时间', name : 'addtime', width: 160, sortable : true, align : 'center'}
],  
sortname: "integral",
sortorder: "desc"
}); 
}); 

</script> 
</div>
<?php include T('footer',1);?>
