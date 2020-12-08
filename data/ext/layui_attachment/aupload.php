<?php
// +----------------------------------------------------------------------
// | Name: 附件上传
// +----------------------------------------------------------------------
// | Version: V1.0 By:sanshui
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
/* defined('SSZCMS') or exit('Access Denied'); */

$typeArr = array("xls", "xlsx", "rar", "png", "jpg", "doc", "docx", "zip", "7z", "xmind", "Workbook", "XLS", "PNG", "XLSX", "DOCX", "PPTX");//允许上传文件格式 
$addtime=date("Ymd",time());      
$testdir="../../upload/attachment/".$addtime."/";   
if(file_exists($testdir)):   
else:   
mkdir($testdir,0777);   
endif;  
 
$path = $testdir; //上传路径
$pathzs = "/data/upload/attachment/".$addtime.'/'; //真实上传路径

if (isset($_FILES)) {
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $name_tmp = $_FILES['file']['tmp_name'];
    if (empty($name)) {
        echo json_encode(array("error" => "0","message" =>  "您还未选择文件"));
        exit;
    }
//    print_r($_FILES['file']);
    $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
    if (!in_array($type, $typeArr)) {
        echo json_encode(array("error" => "0","message" =>  "请上传指定类型的文件！","type"=>"types"));
        exit;
    }
    if ($size > (500000 * 1024)) { //上传大小
        echo json_encode(array("error" => "0","message" =>  "文件大小已超过500000KB！","type"=>"size"));
        exit;
    }
	$size=$size/1024; //转换为KB
	
	$imgid=rand(1000000, 9999999);
	$pic_name =  rand(1000000, 9999999) . "." . $type; //文件名称
    $pic_url = $path . $pic_name; //上传后图片路径+名称
    $pic_urlzs = $pathzs . $pic_name;
    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
        echo json_encode(array("error" => "1","message" => "上传成功！", "realname"=> $name,"pic" => $pic_urlzs,"imgid" => $imgid, "name" => $pic_urlzs, "model" => $type, "size" => $size));
    } else {
        echo json_encode(array("error" => "0","message" => "上传有误，清检查服务器配置！"));
    }
}
?>
 