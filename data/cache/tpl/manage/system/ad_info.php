<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>广告管理</h3>
        <h5>广告内容管理</h5>
      </div> 
      <span style="float: right;position:absolute;right:1%;top:10px;"> 
        <a class="layui-btn layui-btn-primary" href="javascript:void(0);" onclick="fg_operate('del')"  style="text-decoration:none">
            <i class="Hx-iconfont">&#xe609;</i> 删除
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
            <input class="layui-input"  value="" name="kaishi" placeholder="添加开始日" id="LAY_demorange_s" readonly>
          </div>
          <div class="layui-input-inline">
            <input class="layui-input"  value="" name="jieshu" placeholder="添加截止日" id="LAY_demorange_e" readonly>
          </div>
          <div class="layui-input-inline"> 
            <input type="text" name="title"  placeholder="请输入广告标题" autocomplete="off" class="layui-input">
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
  layui.use(['laydate'], function(){
    var laydate = layui.laydate; 
    laydate.render({    elem: '#LAY_demorange_s'  });
    laydate.render({    elem: '#LAY_demorange_e'  });
  })
  </script>
  <script type="text/javascript">
  $(function(){
    $('#ncsubmit').click(function(){
      $("#flexigrid").flexOptions({url: 'index.php?url=ad_info&do=get_xml&id=<?php echo $id;?>&'+$("#formSearch").serialize(),query:'',qtype:''}).flexReload();
    });
    $("#flexigrid").flexigrid({
        url: 'index.php?url=ad_info&do=get_xml&id=<?php echo $id;?>',
        colModel : [
          {display: '排序', name : 'rank', width : 60, sortable : false, align: 'left'},  
         {display: '广告标题', name : 'title', width : 160, sortable : false, align: 'left'},
         {display: '广告缩略图', name : 'pic', width : 150, sortable : false, align: 'center'},
         {display: '手机端缩略图', name : 'wappic', width : 150, sortable : false, align: 'center'},
         {display: '广告位名称', name : 'pid', width : 150, sortable : false, align: 'left'},
         {display: '是否显示', name : 'status', width: 120, sortable : false, align : 'center'}, 
         {display: '编辑时间', name : 'edittime', width : 180, sortable : false, align: 'center'},
         {display: '操作', name : 'operation', width : 180, sortable : false, align: 'center', className: 'handle'},
            ],
        sortname: "pid",
        sortorder: "asc"
    });    
});
function fg_operate(name, bDiv) {
    if (name == 'del') {
        if($('.trSelected',bDiv).length>0){
            var itemlist = new Array();
            $('.trSelected',bDiv).each(function(){
                itemlist.push($(this).attr('data-id'));
            });
            fg_delete(itemlist);
        } else {
            return false;
        }
    }
}
function fg_delete(id) {
  if (typeof id == 'number') {
      var id = new Array(id.toString());
  };
  if(confirm('删除后将不能恢复，确认删除这 ' + id.length + ' 项吗？')){
    id = id.join(',');
  } else {
        return false;
    }
  $.ajax({
        type: "GET",
        dataType: "json",
        url: "index.php?url=ad_info&do=del",
        data: "del_id="+id,
        success: function(data){
            if (data.state){
                $("#flexigrid").flexReload();
            } else {
              alert(data.msg);
            }
        }
    }); 
}
</script> 
<script>
    function fg_add(){
      layer.open({
      type: 2, 
      title:"添加广告信息",
      area: ['70%', '70%'],
      content: "index.php?url=ad_info&do=add&pid=<?php echo $id;?>"
      });  
    }
</script>
<script>
    function fg_edit(id) { 
      layer.open({
      type: 2, 
      title:"编辑广告信息",
      area: ['70%', '70%'],
      content: "index.php?url=ad_info&do=edit&id="+id
      });  
    }
</script>
<script type="text/javascript">
  function fg_set(id,branch) { 
    $.ajax({
      type: "GET",
      dataType: "json",
      url: "index.php?url=ad_info&do=set",
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
</script>
<?php include T('footer',1);?>