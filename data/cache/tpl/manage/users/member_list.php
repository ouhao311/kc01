<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="page">
<div class="fixed-bar">
<div class="item-title">
<div class="subject">
<h3>普通会员列表</h3>
<h5>普通会员列表管理</h5>
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
<!-- <label class="layui-form-label">范围选择</label>
<div class="layui-input-inline">
<input class="layui-input"  value="" name="kaishi" placeholder="开始时间" id="LAY_demorange_s" readonly>
</div>
<div class="layui-input-inline">
<input class="layui-input"  value="" name="jieshu" placeholder="截止时间" id="LAY_demorange_e" readonly>
</div> -->
<div class="layui-input-inline"> 
<input type="text" name="keywords" placeholder="请输入登陆账号" autocomplete="off" class="layui-input">
</div> 
<div class="layui-input-inline"> 
<input type="text" name="truename" placeholder="请输入普通会员姓名" autocomplete="off" class="layui-input">
</div> 
<div class="layui-input-inline"> 
<input type="text" name="mobile" placeholder="请输入手机号码" autocomplete="off" class="layui-input">
</div>  
<div class="layui-input-inline"> 
<select name="state" lay-verify="state" >
<option value="">开启状态</option>
<option value="-1">禁用</option> 
<option value="1">开启</option>
</select>
</div>
<div class="layui-input-inline"> 
<?php echo getNotSelect('department','');?> 
</div>
<div class="layui-input-inline"> 
<?php echo getNotSelect('isreview','');?> 
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
{display: '登陆账号', name : 'username', width : 100, sortable : false, align: 'center'},  
{display: '会员姓名', name : 'truename', width : 120, sortable : false, align: 'center'},  
{display: '性别', name : 'sex', width : 60, sortable : false, align: 'center'},  
{display: '手机号', name : 'mobile', width : 120, sortable : false, align: 'center'},  
{display: '积分', name : 'integral', width : 80, sortable : false, align: 'center'},  
{display: '注册时间', name : 'addtime', width: 160, sortable : true, align : 'center'}, 
{display: '最后登录', name : 'login_time', width: 160, sortable : true, align : 'center'}, 
{display: '状态', name : 'state', width: 60, sortable : true, align : 'center'},  
{display: '审核状态', name : 'isreview', width: 60, sortable : true, align : 'center'}, 
{display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'}
],  
sortname: "id",
sortorder: "desc"
}); 
}); 
//删除普通会员列表
$('.deldata').click(function(){
if($('.trSelected').length>0){
var itemlist = new Array();
$('.trSelected').each(function(){
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
//添加普通会员列表
function fg_add() { 
layer.open({
type: 2, 
title:"添加普通会员",
area: ['60%', '80%'],
content: "index.php?url=<?php echo $this->name;?>&do=add"
  });  
}
//编辑普通会员列表
function fg_edit(id) { 
layer.open({
type: 2, 
title:"编辑普通会员",
area: ['60%', '80%'],
content: "index.php?url=<?php echo $this->name;?>&do=edit&id="+id
  });  
}
//审核
function fg_shenhe(id) { 
layer.open({
type: 2, 
title:"审核数据",
area: ['45%', '45%'],
content: "index.php?url=<?php echo $this->name;?>&do=review&id="+id
  });  
}
</script> 
</div>
<?php include T('footer',1);?>
