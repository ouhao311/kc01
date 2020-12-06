<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="layui-container">
<form class="layui-form"  id="ad_position_form" enctype="multipart/form-data" method="post" >
  <input type="hidden" name="form_submit" value="ok"/>
  <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
  <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
  
  <div class="layui-row mb15 pt20">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"><em>*</em> 所属广告位</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <input type="text" value="<?php echo $classinfo['title'];?>（尺寸要求：<?php echo $classinfo['size'];?>）" class="layui-input"  readonly> 
      </div>
    </div>
  </div> 
   <div class="layui-row mb15 pt20">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"><em>*</em> 排序</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <input type="text" name="rank" id="rank" lay-verify="rank|number" autocomplete="off" class="layui-input" value="<?php if(empty($info['rank'])){echo 0;}else{echo $info['rank'];}?>"> 
      </div>
    </div>
  </div> 
  <div class="layui-row mb15">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"><em>*</em> 广告标题</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <input type="text" name="title" id="title" lay-verify="title" placeholder="广告位标题" autocomplete="off" class="layui-input" value="<?php echo $info['title'];?>"> 
      </div>
    </div>
  </div>
  <div class="layui-row mb15" style="display:none;">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"><em>*</em> 所属广告位</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
          <select name="pid" id="pid" lay-verify="pidtitle">
            <option value="">选择分类</option>
            <?php if(is_array($ad_class)) { foreach($ad_class as $pid) { ?>
            <option value="<?php echo $pid['id'];?>" <?php if($pid['id']==$info['pid']) { ?>selected<?php } ?>
><?php echo $pid['title'];?></option>
            <?php } } ?> 
          </select>
      </div>
    </div>
  </div> 
  <div class="layui-row mb15">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"><em>*</em> 跳转链接</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <input type="text" name="url" id="url" autocomplete="off" class="layui-input" value="<?php echo $info['url'];?>"> 
      </div>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux">第三方跳转链接</div>
</div>
    </div>
  </div> 
  <div class="layui-row mb15 ">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"> 广告图标</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <?php echo getMorePic('upload_img_pic','upload_img_list_pic','pic',$info['pic'],false);?>
      </div>
    </div>
  </div>
  <div class="layui-row mb15 ">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"> 手机端广告图</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <?php echo getMorePic('upload_img_wappic','upload_img_list_wappic','wappic',$info['wappic'],false);?>
      </div>
    </div>
  </div> 
  <div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"> 广告说明</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<textarea name="intro" id="intro" placeholder="请输入广告说明" class="layui-textarea"><?php echo $info['intro'];?></textarea>
</div> 
</div>
</div> 
  <div class="layui-row mb15">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"></label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <button class="layui-btn" lay-submit lay-filter="formDemo"><?php echo $lang['hx_submit'];?></button> 
      </div>
    </div>
  </div>
</form>
 
<script> 
layui.use('form', function(){
  var form = layui.form;
   
  //监听提交
  form.verify({
    title: function(value, item){
      if(value==''){
        return '请输入广告标题!';
      } 
    },
  }); 
});
</script>
</div>
<?php include T('footer',1);?>