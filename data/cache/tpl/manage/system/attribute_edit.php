<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="index.php?url=attribute" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>顶级属性管理 - 添加/编辑 - <?php echo $info['title'];?></h3>
        <h5>顶级属性索引与管理</h5>
      </div>
    </div>
  </div>
  <form id="article_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" />
     <input type="hidden" name="old_pic" value="<?php echo $info['pic'];?>" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="title"><em>*</em>顶级属性名称</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $info['title'];?>" name="title" id="title" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      
      <dl class="row">
        <dt class="tit">
          <label for="title">顶级属性排序</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $info['rank'];?>" name="rank" id="rank" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="title"><em>*</em>顶级属性value值</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $info['value'];?>" name="value" id="value" class="input-txt">
          <span class="err"></span>
          <p class="notic">顶级属性value值和它对应的次级属性code值相等。请慎重操作！</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['hx_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jquery.nyroModal.js"></script>
<script>
//按钮先执行验证再提交表单
$(function(){
  
  $("#submitBtn").click(function(){
    if($("#article_form").valid()){
     $("#article_form").submit();
  }
  });
  
});
//
$(document).ready(function(){
  $('#article_form').validate({
        errorPlacement: function(error, element){
      var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
    rules : {
      title : {
                required   : true
            },
      pid : {
                required   : true
            },
        },
   messages : {
      title : {
                required : '<i class="fa fa-exclamation-circle"></i>标题不能为空！'
            },
      pid : {
                required : '<i class="fa fa-exclamation-circle"></i>请选择分类！'
            },
        }
    });
});
</script>
<?php include T('footer',1);?>