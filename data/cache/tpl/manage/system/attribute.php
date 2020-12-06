<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>顶级属性管理</h3>
        <h5>可对顶级属性配置进行编辑</h5>
      </div>
        <span style="float: right;position:absolute;right:1%;top:10px;">
             <a class="layui-btn layui-btn-primary" href='javascript:location.replace(location.href);'  title="刷新" style="text-decoration:none"><i class="Hx-iconfont">&#xe68f;</i> 刷新</a>
 </span>
    </div>
  </div>
  <!-- 操作说明 -->
  
  <div id="flexigrid"></div>
</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
      url: 'index.php?url=attribute&do=get_xml&cid=<?php echo $pid;?>',
      colModel : [
         
          {display: '排序', name : 'rank', width : 100, sortable : false, align: 'center'},
          {display: '顶级属性名称', name : 'title', width : 120, sortable : false, align: 'center'},
          {display: '顶级属性value值', name : 'value', width : 120, sortable : false, align: 'center'},
          {display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
        ],
        buttons : [
            {display: '<i class="fa fa-plus"></i>添加顶级属性', name : 'add', bclass : 'add', title : '添加属性', onpress : fg_operate },
        ],    
        
      sortname: "id",
      sortorder: "desc",
      
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
    } else if (name == 'add') {
      window.location.href = 'index.php?url=attribute&do=add';
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
        url: "index.php?url=attribute&do=del",
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
<?php include T('footer',1);?>