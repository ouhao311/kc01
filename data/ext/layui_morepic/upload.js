function layui_upimg(upload_img,upload_img_list,picname,upurl,duotu){
	  
	/*
	上传参数设定
	*/
	var upload_img=upload_img;
	var upload_img_list=upload_img_list;
	var picname=picname;
	var upurl = upurl;//上传图片地址
	if(duotu==true){
		var duotu = true;//是否为多图上传true false
	}else{
		var duotu = false;//是否为多图上传true false
	}
	/*
	上传图片
	*/
	layui.use('upload', function() {
		upload = layui.upload;
		upload.render({
			elem: '#'+upload_img,
			url: upurl,
			multiple: duotu,
			before: function(obj) {
				layer.msg('图片上传中...', {
					icon: 16,
					shade: 0.01,
					time: 0
				})
			},
			done: function(res) {
				layer.close(layer.msg());//关闭上传提示窗口
				if(res.error){
						if (duotu == true) {//调用多图上传方法,其中res.imgid为后台返回的一个随机数字
						$('#'+upload_img_list).append('<dd class="item_img" id="' + res.imgid + '"><div class="operate"><i onclick=toleft("' + upload_img_list + '") class="toleft layui-icon"></i><i  onclick=toright("' + upload_img_list + '") class="toright layui-icon"></i><i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div><img src="' + res.pic + '" onclick="previewImg(this)" class="img" ><input type="hidden" name="'+picname+'[]" value="' + res.name + '" /></dd>');
					}else{//调用单图上传方法,其中res.imgid为后台返回的一个随机数字
						$('#'+upload_img_list).html('<dd class="item_img"  id="' + res.imgid + '"><div class="operate"><i onclick=UPLOAD_IMG_DEL("' + res.imgid + '") class="close layui-icon"></i></div><img src="' + res.pic + '" onclick="previewImg(this)" class="img" ><input type="hidden" name="'+picname+'" value="' + res.name + '" /></dd>');
					}
					layer.msg(res.message);
				}else{
					layer.msg(res.message);
					return false;
				} 
			}
		})
	});
  
}
function previewImg(obj) {
        var img = new Image();  
        img.src = obj.src;
        //var height = img.height + 50; // 原图片大小
        //var width = img.width; //原图片大小
        var imgHtml = "<img src='" + obj.src + "' width='800px' height='1000px'/>"; 
       // var imgHtml = "<img src='" + obj.src + "' width='400px' height='500px'/>";  
        //弹出层
        //弹出层
        console.log(313213123);
        layer.open({  
            type: 1,  
            shade: 0.8,
            offset: 'auto',
            area: [100+'%',100+'%'],  // area: [width + 'px',height+'px']  //原图显示
            shadeClose:true,
            scrollbar: false,
            title: "图片预览", //不显示标题  
            content: imgHtml, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响  
            cancel: function () {  
                //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });  
            }  
        }); 
    } 

/*
删除上传图片
*/
function UPLOAD_IMG_DEL(divs) { 
	$("#"+divs).remove();
}

/*
多图上传变换左右位置
*/
function toleft(upload_img_list){
	$(".toleft").live("click", function() {
		var item = $(this).parent().parent(".item_img");
		var item_left = item.prev(".item_img");
		if ($('#'+upload_img_list).children(".item_img").length >= 2) {
			if (item_left.length == 0) {
				item.insertAfter($('#'+upload_img_list).children(".item_img:last"))
			} else {
				item.insertBefore(item_left)
			}
		}
	});
}
function toright(upload_img_list){ 
	$(".toright").live("click", function() {
		var item = $(this).parent().parent(".item_img");
		var item_right = item.next(".item_img");
		if ($('#'+upload_img_list).children(".item_img").length >= 2) {
			if (item_right.length == 0) {
				item.insertBefore($('#'+upload_img_list).children(".item_img:first"))
			} else {
				item.insertAfter(item_right)
			}
		}
	});
}