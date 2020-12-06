<?php
// +----------------------------------------------------------------------
// | Name: 通用
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class commonControl extends SystemControl{
    public function __construct(){
        parent::__construct();

    }

    /**
     * 图片上传
     *
     */
    public function pic_uploadDo(){
        if (chksubmit()){
            //上传图片
            $upload = new UploadFile();
            $upload->set('thumb_width', 500);
            $upload->set('thumb_height',499);
            $upload->set('thumb_ext','_small');
            $upload->set('max_size',C('image_max_filesize')?C('image_max_filesize'):1024);
            $upload->set('ifremove',true);
            $upload->set('default_dir',$_GET['uploadpath']);

            if (!empty($_FILES['_pic']['tmp_name'])){
                $result = $upload->upfile('_pic');
                if ($result){
                    exit(json_encode(array('status'=>1,'dataurl'=>UPLOAD_SITE_URL.'/'.$_GET['uploadpath'].'/'.$upload->thumb_image)));
                }else {
                    exit(json_encode(array('status'=>0,'msg'=>$upload->error)));
                }
            }
        }
    }


    /**
     * 图片裁剪
     *
     */
    public function pic_cutDo(){
        Language::read('admin');
		$lang = Language::getLangContent();
		import('fun.thumb');

		if (chksubmit()){
			$thumb_width = $_POST['x'];
			$x1 = $_POST["x1"];
			$y1 = $_POST["y1"];
			$x2 = $_POST["x2"];
			$y2 = $_POST["y2"];
			$w = $_POST["w"];
			$h = $_POST["h"];
			$scale = $thumb_width/$w;

			$src = str_ireplace(UPLOAD_SITE_URL,HX_UPLOAD,$_POST['dataurl']);

			if (strpos($src, HX_UPLOAD) !== 0) {
			    exit();
			}

			if (!empty($_POST['filename'])){
// 				$save_file2 = HX_UPLOAD.'/'.$_POST['filename'];
				$save_file2 = str_ireplace(UPLOAD_SITE_URL,HX_UPLOAD,$_POST['filename']);
			}else{
				$save_file2 = str_replace('_small.','_sm.',$src);
			}
			$cropped = resize_thumb($save_file2, $src,$w,$h,$x1,$y1,$scale);
			@unlink($src);
			$pathinfo = pathinfo($save_file2);
			exit($pathinfo['basename']);
		}
		$save_file = str_ireplace(UPLOAD_SITE_URL,HX_UPLOAD,$_GET['dataurl']);
		$_GET['resize'] = $_GET['resize'] == '0' ? '0' : '1';

		$output['height']=get_height($save_file);
		$output['width']=get_width($save_file);

		include T('common.pic_cut',1);

    }

    /**
     * 查询每月的周数组
     */
    public function getweekofmonthDo(){
        import('fun.datehelper');
        $year = $_GET['y'];
        $month = $_GET['m'];
        $week_arr = getMonthWeekArr($year, $month);
        echo json_encode($week_arr);
        die;
    }

    /**
     * 设置常用菜单
     */
    public function common_operationsDo() {
        $type = $_GET['type'];
        $value = $_GET['value'];
        if (!in_array($type, array('add', 'del')) || empty($value)) {
            echo false;exit;
        }
        $quicklink = $this->getQuickLink();
        if (count($quicklink) == 10 && $type == 'add') {
            echo false;exit;
        }
        if ($type == 'add') {
            if (!empty($quicklink)) {
                array_push($quicklink, $value);
            } else {
                $quicklink[] = $value;
            }
        } else {
            $quicklink = array_diff($quicklink, array($value));
        }
        $quicklink = array_unique($quicklink);
        $quicklink = implode(',', $quicklink);

        $this->admin_info['qlink'] = $quicklink;
        $this->systemSetKey($this->admin_info);
        $result = M('admin')->updateAdmin(array('admin_id' => $this->admin_info['id'], 'admin_quick_link' => $quicklink));
        if ($result) {
            echo true;exit;
        } else {
            echo false;exit;
        }
    }

    /**
     * 代办事项
     */
    public function pending_mattersDo() {
        $statistics  = $this->get_pending_matters();
		$output['statistics']=$statistics;
		include T('common.pending_matters');

    }

    /**
     * 代办事项ajax数据
     */
    public function ajax_pending_mattersDo() {
        $statistics  = $this->get_pending_matters();
        $count = 0;
        foreach ($statistics as $value) {
            $count += $value;
        }
        echo $count;exit();
    }

    /**
     * 代办事项数据查询
     * @return array
     */
    private function get_pending_matters() {

        // 预存款提现
      //  $statistics['cashlist'] = 2;


      //  $statistics['pay_billno'] = 5;
       // $statistics['pay_vr_billno'] = 1;

        return $statistics;
    }
}
