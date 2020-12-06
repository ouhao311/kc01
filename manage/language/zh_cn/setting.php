<?php
defined('SSZCMS') or exit('Access Denied');
/**
 * 设置 语言包
 */

$lang['web_set']        = '系统设置';
$lang['web_email']        = '发件邮箱设置';
$lang['web_set_subhead'] = '网站全局内容基本选项设置';

$lang['sys_set']        = '系统设置';
$lang['basic_info']     = '基本信息';
$lang['upload_set']		= '上传设置';
$lang['upload_set_subhead']	= '网站全局图片、上传等参数设定';
$lang['default_thumb']	= '默认图片';
$lang['upload_set_ftp'] = '远程图片';
$lang['upload_param']	= '上传参数';

$lang['user_auth'] 		= '用户权限';


$lang['domain']         = '二级域名';


$lang['time_zone_set']         = '默认时区';
$lang['set_sys_use_time_zone'] = '设置系统使用的时区，中国为';

$lang['flow_static_code']      = '第三方流量统计代码';
$lang['flow_static_code_notice']     = '前台页面底部可以显示第三方统计';
$lang['image_dir_type']		= '图片存放类型';
$lang['image_dir_type_0']	= '按照文件名存放 (例:/分类id/图片)';
$lang['image_dir_type_1']	= '按照年份存放 (例:/分类id/年/图片)';
$lang['image_dir_type_2']	= '按照年月存放 (例:/分类id/年/月/图片)';
$lang['image_dir_type_3']	= '按照年月日存放 (例:/分类id/年/月/日/图片)';
$lang['image_width']	= '宽';
$lang['image_height']	= '高';
$lang['image_typeerror']	= '上传图片格式不正确';
$lang['image_thumb_tool']	= '压缩工具';
$lang['image_thumb_tool_tips']	= '默认使用GD库生成缩略图，GD使用广泛但占用系统资源较多，ImageMagick速度快系统资源占用少，但需要服务器有执行命令行命令的权;';


$lang['update_cycle_hour']                  = '更新周期(小时)';
$lang['web_name']                           = '网站名称';
$lang['web_name_notice']					= '网站名称，将显示在前台顶部欢迎信息等位置';
$lang['site_description']                   = '网站描述';
$lang['site_description_notice']			= '网站描述，出现在前台页面头部的 Meta 标签中，用于记录该页面的概要与描述';
$lang['site_keyword']                       = '网站关键字';
$lang['site_keyword_notice']                = '网站关键字，出现在前台页面头部的 Meta 标签中，用于记录该页面的关键字，多个关键字间请用半角逗号 "," 隔开';
$lang['site_logo']                          = '网站Logo';

$lang['icp_number']                         = 'ICP证书号';
$lang['icp_number_notice']                  = '前台页面底部可以显示 ICP 备案信息，如果网站已备案，在此输入你的授权码，它将显示在前台页面底部，如果没有请留空';
$lang['site_phone']                         = '平台客服联系电话';


$lang['site_state']                         = '站点状态';
$lang['site_state_notice']                  = '可暂时将站点关闭，其他人无法访问，但不影响管理员访问后台';
$lang['closed_reason']                      = '关闭原因';
$lang['closed_reason_notice']               = '当网站处于关闭状态时，关闭原因将显示在前台';

$lang['email_type_open']                    = '邮件功能开启';
$lang['email_type']                         = '邮件发送方式';
$lang['use_other_smtp_service']             = '采用其他的SMTP服务';
$lang['use_server_mail_service']            = '采用服务器内置的Mail服务';
$lang['if_choose_server_mail_no_input_follow'] = '如果您选择服务器内置方式则无须填写以下选项';
$lang['smtp_server']             = 'SMTP 服务器';
$lang['set_smtp_server_address'] = '设置 SMTP 服务器的地址，如 ssl://smtp.163.com';
$lang['smtp_port']               = 'SMTP 端口';
$lang['set_smtp_port']           = '设置 SMTP 服务器的端口，默认为 465';
$lang['sender_mail_address']     = '发信人邮件地址';
$lang['if_smtp_authentication']  = '使用SMTP协议发送的邮件地址，如 123456@163.com';
$lang['smtp_user_name']          = 'SMTP 身份验证用户名';
$lang['smtp_user_name_tip']      = '如 123456';
$lang['smtp_user_pwd']           = 'SMTP 身份验证密码';
$lang['smtp_user_pwd_tip']       = '123456@163.com邮件的密码，如 123456';
$lang['test_mail_address']       = '测试接收的邮件地址';
$lang['test']                    = '测试';
$lang['open_checkcode']          = '使用验证码';



$lang['default_img_wrong']       = '图片限于png,gif,jpeg,jpg格式';

$lang['upload_image_filesize']	= '图片文件大小';
$lang['image_allow_ext']	= '图片扩展名';
$lang['image_allow_ext_notice']	= '图片扩展名，用于判断上传图片是否为后台允许，多个后缀名间请用半角逗号 "," 隔开。';
$lang['image_allow_ext_not_null']	= '图片扩展名不能为空';
$lang['upload_image_file_size']	= '大小';
$lang['upload_image_filesize_is_number']    = '图片文件大小仅能为数字';
$lang['image_max_size_tips'] = '当前服务器环境，最大允许上传'.ini_get('upload_max_filesize').'B 的文件，您的设置请勿超过该值。';
$lang['upload_image_size_c_num'] = '图片像素最多四位数';
$lang['image_max_size_only_num'] = '图片文件大小仅能为数字';
$lang['image_max_size_c_num'] = '图片文件大小最多四位数';  

$lang['open_yes']    	= '是';
$lang['open_no']    	= '否';

$lang['font_set'] = '水印字体';
$lang['font_help1'] = '如果图片空间中水印使用汉字则要下载并安装相应字体库。';
$lang['font_help2'] = '使用方法：将您下载到的字体库上传到网站根目录下\data\ext\font这个文件夹内，同时需要修改此文件夹下的font.info.php文件。例如：您下载了一个“宋体”字库simsun.ttf，将其放置于前面所述文件夹内，打开font.info.php文件在其中的$fontInfo = array(\'arial\'=>\'Arial\')数组后面添加宋体字库信息,“=>”符号左边是文件名，右边是您想在网站上显示的文字信息，添加后的样子是array(\'arial\'=>\'Arial\',\'simsun\'=>\'宋体\')';
$lang['font_info'] = '已经安装字体如下';



$lang['seo_set_index'] 		= '首页';

$lang['seo_set_prompt'] 	= '插入的变量必需包括花括号“{}”，当应用范围不支持该变量时，该变量将不会在前台显示(变量后边的分隔符也不会显示)，留空为系统默认设置，SEO自定义支持手写。以下是可用SEO变量:';
$lang['seo_set_tips1'] 	= '站点名称 {sitename}，（应用范围：全站）';
$lang['seo_set_tips2'] 	= '名称 {name}，（应用范围：团购名称、商品名称、品牌名称、文章标题、分类名称）';
$lang['seo_set_tips3'] 	= '文章分类名称 {article_class}，（应用范围：文章分类页）';

