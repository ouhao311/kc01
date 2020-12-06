<?php
// +----------------------------------------------------------------------
// | Name: 缓存类
// +----------------------------------------------------------------------
// | Version: V1.0 By:Yutou
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
// +----------------------------------------------------------------------
defined('SSZCMS') or exit('Access Denied');
class cacheModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	public function call($method){
		$method = '_'.strtolower($method);

		if (method_exists($this,$method)){
			return $this->$method();
		}else{
			return false;
		}
	}

	/**
	 * 基本设置
	 *
	 * @return array
	 */
	private function _setting(){
		$list =$this->table('setting')->limit(false)->select();
		$array = array();
		foreach ((array)$list as $v) {
			$array[$v['name']] = $v['value'];
		}
		unset($list);
		return $array;
	}


    /**
     * 自定义导航
     *
     * @return array
     */
    private function _nav(){
        $list = $this->table('navigation')->order('nav_sort')->limit(false)->select();
        if (!is_array($list)) return null;
        return $list;
    }



   private function _admin_menu() {
		$one=array ();
		$one = Db::getAll("SELECT * FROM ".DBPRE."gmenu where pid=0  ORDER by list desc, id asc ");
        if($one){
		    foreach ($one as $k => $v) {

				$_menu[$v["code"]]['name'] = $v["uname"];
				//第二层
				$_tow=array ();$tow=array ();
				//
				$tow = Db::getAll("SELECT * FROM ".DBPRE."gmenu where pid=".$v["id"]."  ORDER by list desc, id asc ");

				foreach ($tow as $kk => $vv) {

				$_tow[$kk]['name']=$vv["uname"];
				$_tow[$kk]['ico']=$vv["ico"];

				//第三层
				$_three=array ();$three=array ();
				//s
				$three = Db::getAll("SELECT * FROM ".DBPRE."gmenu where pid=".$vv["id"]."  ORDER by list desc, id asc ");
                if ($three){
					foreach ($three as $kkk => $vvv) {
						$_three[$vvv["code"]]["name"]=$vvv["uname"];
						$_three[$vvv["code"]]["power"]=$vvv["power"];
					}                    
                }


				    $_tow[$kk]['child']=$_three;
				}
				    $_menu[$v["code"]]['child']=$_tow;

		}




        return $_menu;
    }
   }

}
