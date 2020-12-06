<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="index.php?url=area&do=index" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>功能设置 - 新增</h3>
        <h5>功能新增与编辑</h5>
      </div>
    </div>
  </div>
  <form id="form" method="post" action="index.php?url=gmenu&do=save&id=<?php echo $_GET['id']?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="pid" id="pid" value="<?php echo $output['info']['pid']?>">
    <div class="ncap-form-default">
     <dl class="row">
        <dt class="tit">
          <label for="pname">父级名称</label>
        </dt>
        <dd class="opt">
          <?php if($output['info']['pname']) { ?><?php echo $output['info']['pname'];?><?php } else { ?>顶级功能<?php } ?>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
    
      <dl class="row">
        <dt class="tit">
          <label for="uname"><em>*</em>功能名称</label>
        </dt>
        <dd class="opt">
          <input type="text" name="uname" value="<?php echo $output['info']['uname']?>" maxlength="20" id="uname" class="input-txt">
          <span class="err"></span>
          <p class="notic">请认真填写功能名称。</p>
        </dd>
      </dl>
            <dl class="row">
        <dt class="tit">
          <label for="code"><em>*</em>代码</label>
        </dt>
        <dd class="opt">
          <input type="text" name="code" value="<?php echo $output['info']['code']?>" maxlength="20" id="code" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      
                  <dl class="row">
        <dt class="tit">
          <label for="ico">图标</label>
        </dt>
        <dd class="opt">
          <input type="text" name="ico" value="<?php echo $output['info']['ico']?>" maxlength="20" id="ico" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      
            <dl class="row">
        <dt class="tit">
          <label for="list">排序</label>
        </dt>
        <dd class="opt">
          <input type="text" name="list" value="<?php if($output['info']['list']) { ?><?php echo $output['info']['list']?><?php } else { ?>0<?php } ?>
" maxlength="20" id="list" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      
          <dl class="row">
        <dt class="tit">
          <label for="power">功能操作</label>
        </dt>
        <dd class="opt">
        
        <label for="view"><input name="view"   id="view" type="checkbox" <?php if($info['view']) { ?>checked<?php } ?>
 /> 查看 </label>
         <label for="add"><input name="add"   id="add" type="checkbox" <?php if($info['add']) { ?>checked<?php } ?>
 /> 添加 </label>
          <label for="edit"><input name="edit"   id="edit" type="checkbox" <?php if($info['edit']) { ?>checked<?php } ?>
 /> 修改 </label>
           <label for="del"><input name="del"   id="del" type="checkbox" <?php if($info['del']) { ?>checked<?php } ?>
 /> 删除 </label>
            <label for="shenhe"><input name="shenhe"   id="shenhe" type="checkbox" <?php if($info['shenhe']) { ?>checked<?php } ?>
 /> 审核 </label> 
             <label for="progress"><input name="progress"   id="progress" type="checkbox" <?php if($info['progress']) { ?>checked<?php } ?>
 /> 进度 </label>
              <label for="topshenhe"><input name="topshenhe"   id="topshenhe" type="checkbox" <?php if($info['topshenhe']) { ?>checked<?php } ?>
 /> 超级审核 </label>
              <label for="all"><input name="all"   id="all" type="checkbox"  <?php if($info['all']) { ?>checked<?php } ?>
 /> 所有 </label>
          
          
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
    
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['hx_submit'];?></a></div>
    </div>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#form").valid()){
        
        $("#form").submit();
    }
});
});
//
$(document).ready(function(){
$('#form').validate({
        errorPlacement: function(error, element){
var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
            uname : {
            required   : true
            },
code : {
            required   : true
            }
        },
        messages : {
        uname : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写功能名称'
            },
code : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写代码'
            }
        }
    });
});
</script>
<?php include T('footer',1);?>