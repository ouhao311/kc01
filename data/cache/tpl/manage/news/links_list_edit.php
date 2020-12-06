<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',1);?>
<div class="layui-container">
<form class="layui-form"  id="ad_position_form" enctype="multipart/form-data" method="post" >
  <input type="hidden" name="form_submit" value="ok"/>
  <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
  <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" /> 
 
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
      <label class="layui-form-title"><em>*</em> 友情链接标题</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <input type="text" name="title" id="title" lay-verify="title" placeholder="友情链接位标题" autocomplete="off" class="layui-input" value="<?php echo $info['title'];?>"> 
      </div>
    </div>
  </div> 
<div class="layui-row mb15 ">
<div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
<label class="layui-form-title"><em>*</em> 友情链接分类</label>
</div>
<div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
<div class="layui-input-block">
<?php echo getNotSelect('links_class',$info['links_class']);?> 
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
 <!--  <div class="layui-row mb15 ">
    <div class=" layui-col-xs2  layui-col-sm2  layui-col-md2">
      <label class="layui-form-title"> 友情链接图标</label>
    </div>
    <div class=" layui-col-xs9 layui-col-sm9 layui-col-md9">
      <div class="layui-input-block">
        <?php echo getMorePic('upload_img_pic','upload_img_list_pic','pic',$info['pic'],false);?>
      </div>
    </div>
  </div>  -->
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
        return '请输入友情链接标题!';
      } 
    },
  }); 
});
</script>
</div>
<?php include T('footer',1);?>