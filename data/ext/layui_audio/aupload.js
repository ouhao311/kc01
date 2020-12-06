function layui_upaudio(upload_img,upload_img_list,picname,upurl,defaultatta,modelname,sizename){
console.log(222222);
	/*
	上传参数设定
	*/
	var upload_img=upload_img;
	var upload_img_list=upload_img_list;
	var picname=picname;
	var upurl = upurl;//上传图片地址 
	
	/*
	上传图片
	*/
	layui.use('upload', function() {
		upload = layui.upload;
		upload.render({
			elem: '#'+upload_img,
			url: upurl,  
			accept: 'audio',
			before: function(obj) {
				layer.msg('附件上传中...', {
					icon: 16,
					shade: 0.01,
					time: 0
				})
			},
			done: function(res) {
			    console.log(res)
				layer.close(layer.msg());//关闭上传提示窗口
				if(res.error==1){
					$('#'+upload_img_list).html('<dd class="item_img" id="' + res.imgid + '"><div class="operate"><i onclick=UPLOAD_AUDIO_DEL("' + res.imgid + '") class="close layui-icon"></i></div><img src="' + defaultatta + '" class="img" ><input type="hidden" name="'+picname+'" value="' + res.name + '" /><input type="hidden" name="'+modelname+'" value="' + res.model + '" /><input type="hidden" name="'+sizename+'" value="' + res.size + '" /></dd>');
					layer.msg(res.message);
				}else{
					layer.msg(res.message);
					return false;
				} 
			}
		})
	});
  
}
 

/*
删除上传附件
*/
function UPLOAD_AUDIO_DEL(divs) { 
	$("#"+divs).remove();
}
 