<?php
// +----------------------------------------------------------------------
// | Name: 多图上传
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');

$path = "../../upload/fangyuan"; //上传路
$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$name_tmp = $_FILES['file']['tmp_name'];
if($name)
{
    $filetype= strtolower(substr(strrchr($name, '.'), 1));//取得文件类型
    if(!stristr(',.gif,.jpg,.png,',','.$filetype.','))
    {
        echo "附件上传有误！";
        exit();
    }
	
	$pic_name = time().rand(10000, 99999) . "." . $type; //文件名称
    $pic_url = $path . $pic_name; //上传后图片路径+名称
    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹 
		echo $pic_url;
		exit();
    } else {
        echo "上传有误，清检查服务器配置！";
		exit();
    }
	
    exit();
}else{
	echo "您还未选择文件！";
    exit();
}

?>