<?php
 // +----------------------------------------------------------------------
 // | Name:记录日志
 // +----------------------------------------------------------------------
 // | Version: V1.0 By:Yutou
 // +----------------------------------------------------------------------
 // | Copyright (c) 2012-2018 http://www.sanshuizhou.com All rights reserved.
 // +----------------------------------------------------------------------
 defined('SSZCMS') or exit('Access Denied');

class Log{

    const SQL       = 'SQL';
    const ERR       = 'ERR';
    private static $log =   array();

    public static function record($message,$level=self::ERR) {
        $now = @date('Y-m-d H:i:s',time());
        switch ($level) {
            case self::SQL:
               self::$log[] = "[{$now}] {$level}: {$message}\r\n";
               break;
            case self::ERR:
                $log_file = HX_DATA.'/log/'.date('Ymd',TIMESTAMP).'.log';
                $url = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'];
                $url .= " ( url={$_GET['url']}&do={$_GET['do']} ) ";
                $content = "[{$now}] {$url}\r\n{$level}: {$message}\r\n";
                file_put_contents($log_file,$content, FILE_APPEND);
                break;
        }
    }

    public static function read(){
    	return self::$log;
    }
}