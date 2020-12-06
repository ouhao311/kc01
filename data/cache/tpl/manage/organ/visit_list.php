<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<style>
</style>
<div class="page">
<div class="fixed-bar">
<div class="item-title">
<div class="subject">
<h3>走访记录列表</h3>
   <h3>走访记录管理列表</h3>
</div> 
<span style="float: right;position:absolute;right:1%;top:10px;">
<?php if($this->checkCzqx("add")) { ?>
<a class="layui-btn layui-btn-primary" href='javascript:void(0)' onclick='fg_add()' style="text-decoration:none">
<i class="Hx-iconfont">&#xe600;</i> 新增
</a>
<?php } ?>
<?php if($this->checkCzqx("del")) { ?>
<a class="layui-btn layui-btn-primary deldata" href="javascript:;"  style="text-decoration:none">
<i class="Hx-iconfont">&#xe6e2;</i> 删除
</a>
<?php } ?>
<a class="layui-btn layui-btn-primary" href='javascript:' onclick='$("#flexigrid").flexReload();' title="刷新" style="text-decoration:none">
<i class="Hx-iconfont">&#xe68f;</i> 刷新
</a>
</span>
</div>
</div>
<form class="layui-form"  method="get" name="formSearch" id="formSearch">
<div class="layui-form-item">
<div class="layui-form-pane" style="margin-top: 15px;">
<div class="layui-form-item">
<label class="layui-form-label">范围选择</label>
<div class="layui-input-inline">
<input class="layui-input"  value="" name="kaishi" placeholder="开始时间" id="LAY_demorange_s" readonly>
</div>
<div class="layui-input-inline">
<input class="layui-input"  value="" name="jieshu" placeholder="截止时间" id="LAY_demorange_e" readonly>
</div>
<div class="layui-input-inline"> 
<input type="text" name="keywords" placeholder="请输入关键字" autocomplete="off" class="layui-input">
</div>
<a class="layui-btn " id="ncsubmit" lay-submit="" lay-filter="demo11">
<i class="Hx-iconfont">&#xe665;</i> 立即查找
</a>  
</div>
</div>
</div>
</form>
<div id="flexigrid"></div>

<script> 
//加载模块
layui.use(['laydate','element','form'], function(){
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
$("#flexigrid").flexOptions({url: 'index.php?url=<?php echo $this->name;?>&do=get_xml&pid=<?php echo $_GET['pid']?>&'+$("#formSearch").serialize(),query:'',qtype:''}).flexReload();
});
$("#flexigrid").flexigrid({
url: 'index.php?url=<?php echo $this->name;?>&do=get_xml&pid=<?php echo $_GET['pid']?>',
colModel : [
{display: 'ID', name : 'id', width : 60, sortable : false, align: 'center'},      
{display: '任务名称', name : 'name', width: 180, sortable : true, align : 'center'},
{display: '地点', name : 'address', width : 180, sortable : false, align: 'center'}, 
{display: '是否主动', name : 'isself', width: 60, sortable : true, align : 'center'},
{display: '完成时间', name : 'time', width: 100, sortable : true, align : 'center'},
{display: '完成人', name : 'finishpar', width: 80, sortable : true, align : 'center'}, 
{display: '分配人', name : 'assignpar', width: 80, sortable : true, align : 'center'}, 
    {display: '是否完成', name : 'status', width: 60, sortable : true, align : 'center'},
{display: '操作', name : 'operation', width : 200, sortable : false, align: 'center', className: 'handle'} 
],  
sortname: "id",
sortorder: "desc"
}); 
}); 
//删除走访任务
$('.deldata').click(function(){
if($('#flexigrid .trSelected').length>0){
var itemlist = new Array();
$('#flexigrid .trSelected').each(function(){
itemlist.push($(this).attr('data-id'));
});
fg_delete(itemlist);
} else {
layer.msg('请先选择要删除行！');
return false;
}
}); 
function fg_delete(id) {
if (typeof id == 'number') {
var id = new Array(id.toString());
}; 
layer.confirm('删除后将不能恢复，确认删除这 ' + id.length + ' 项吗？', {
btn: ['确定','取消'] //按钮
}, function(index){
id = id.join(',');
$.ajax({
type: "GET",
dataType: "json",
url: "index.php?url=<?php echo $this->name;?>&do=del",
data: "del_id="+id,
success: function(data){
layer.close(index);
if (data.state){
layer.msg('删除成功！');
$("#flexigrid").flexReload();
} else {
layer.msg(data.msg);
}
}
}); 
}, function(){
layer.msg('删除失败！');
return false;
});  
}
//设置操作
function fg_set(id,branch) { 
$.ajax({
type: "GET",
dataType: "json",
url: "index.php?url=<?php echo $this->name;?>&do=set",
data: "id="+id+'&branch='+branch,
success: function(data){
if (data.state){
$("#flexigrid").flexReload();
} else {
alert(data.msg);
}
}
});
}
//添加走访任务
function fg_add() { 
layer.open({
type: 2, 
title:"添加走访任务",
area: ['85%', '85%'],
content: "index.php?url=<?php echo $this->name;?>&do=add"
  });  
}
//编辑走访任务
function fg_edit(id) { 
layer.open({
type: 2, 
title:"编辑走访任务",
area: ['85%', '85%'],
content: "index.php?url=<?php echo $this->name;?>&do=edit&id="+id
  });  
}



//查看完成详情
function fg_checkdetail(id) { 
layer.open({
type: 2, 
title:"查看完成详情",
area: ['85%', '85%'],
content: "index.php?url=<?php echo $this->name;?>&do=checkdetail&id="+id
  });  
}
//审核
function fg_shenhe(id) { 
layer.open({
type: 2, 
title:"审核数据",
area: ['65%', '45%'],
content: "index.php?url=<?php echo $this->name;?>&do=review&id="+id
  });  
}


//审核
function fg_topshenhe(id) { 
layer.open({
type: 2, 
title:"审核数据",
area: ['65%', '45%'],
content: "index.php?url=<?php echo $this->name;?>&do=topreview&id="+id
  });  
}
</script> 
</div>
<?php include T('footer',1);?>
