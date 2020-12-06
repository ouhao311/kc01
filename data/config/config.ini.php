<?php

$cfg = array();

$cfg['version']                 = 'v3.0';
$cfg['setup_date']			    = '2018-08-20 09:03:55';
$cfg['gip']                     = 0;
$cfg['dbdriver']                = 'mysql';
$cfg['tablepre']                = 'hx_';
$cfg['db']['1']['dbhost']       = '127.0.0.1';
$cfg['db']['1']['dbport']       = '3306';
$cfg['db']['1']['dbuser']       = 'root';
$cfg['db']['1']['dbpwd']        = 'root';
$cfg['db']['1']['dbname']       = 'test';
$cfg['db']['1']['dbcharset']    = 'UTF-8';
$cfg['db']['slave']             = $cfg['db']['master'];
$cfg['session_expire']          = 3600;
$cfg['lang_type']               = 'zh_cn';
$cfg['cookie_pre']              = 'hx_xz_';
$cfg['cache_open']		        = true;
$cfg['cache_pre']		        = 'hx_xz_';
$cfg['debug']                   = false;
$cfg['url_model']		        = false;
$cfg['subdomain_suffix']        = '';
$cfg['sys_log']                 = true;
$cfg['salt']                    = 'xz_2018';
$cfg['https']                   = false;
return $cfg;