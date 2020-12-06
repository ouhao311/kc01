<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $pidname;?>的次级属性管理</h3>
        <h5>可对<?php echo $pidname;?>的次级属性配置进行编辑</h5>
      </div>
      <ul class="tab-base nc-row">
        <li><a class="current"><span><?php echo $pidname;?>的次级属性管理</span></a></li> 
      </ul>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['hx_prompts_title'];?>"><?php echo $lang['hx_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['hx_prompts_span'];?>"></span> </div>
    <ul>
      <li>管理员新增<?php echo $pidname;?>次级属性置时，会默认选择它所对应的顶级分类</li>
    </ul>
  </div>
  <div id="flexigrid"></div>
</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
      url: 'index.php?url=attribute_sec&do=get_xml&cid=<?php echo $pid;?>',
      colModel : [
          {display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
          {display: '排序', name : 'rank', width : 100, sortable : false, align: 'center'},
          {display: '次级属性名称', name : 'title', width : 120, sortable : false, align: 'center'},
          {display: '次级属性value值', name : 'value', width : 150, sortable : false, align: 'center'},
          {display: '次级属性code值', name : 'code', width : 150, sortable : false, align: 'center'},
          {display: '所属顶级属性', name : 'pid', width : 120, sortable : false, align: 'center'},
              
        ],
        buttons : [
            {display: '<i class="fa fa-plus"></i>添加<?php echo $pidname;?>的次级属性', name : 'add', bclass : 'add', title : '添加次级属性', onpress : fg_operate },
           {display: '<i class="fa fa-level-up"></i>返回上级', name : 'return', bclass : 'return', title : '返回上级', onpress : fg_operate },
        ],    
        searchitems : [
            {display: '属性名称', name : 'title'},
            ],
      sortname: "id",
      sortorder: "desc",
      title: '<?php echo $pidname;?>的次级属性列表'
    });    
});
function fg_operate(name, bDiv) {
    if (name == 'return') {
      window.location.href = 'index.php?url=attribute&do=index';
        
    } else if (name == 'add') {
      window.location.href = 'index.php?url=attribute_sec&do=add&pid=<?php echo $pid;?>';
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
        url: "index.php?url=attribute_sec&do=del",
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