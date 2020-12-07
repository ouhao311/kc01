<?php defined('SSZCMS') or exit('Access Denied'); return array (
  'news' => 
  array (
    'name' => '内容管理',
    'child' => 
    array (
      0 => 
      array (
        'name' => '新闻管理',
        'ico' => '',
        'child' => 
        array (
          'article_list' => 
          array (
            'name' => '资讯列表',
            'power' => 'view,add,edit,del,shenhe',
          ),
          'article_class' => 
          array (
            'name' => '资讯分类',
            'power' => 'view,add,edit,del,shenhe',
          ),
        ),
      ),
      1 => 
      array (
        'name' => '线上解疑',
        'ico' => '',
        'child' => 
        array (
          'online_list' => 
          array (
            'name' => '解疑平台',
            'power' => 'view,add,edit,del,shenhe,topshenhe,progress',
          ),
        ),
      ),
      2 => 
      array (
        'name' => '其它管理',
        'ico' => '',
        'child' => 
        array (
          'pages_list' => 
          array (
            'name' => '单页列表',
            'power' => 'view,add,edit,del,shenhe,all,progress',
          ),
          'links_list' => 
          array (
            'name' => '友情链接',
            'power' => 'view,add,edit,del,shenhe,all',
          ),
        ),
      ),
      3 => 
      array (
        'name' => '智慧政务',
        'ico' => '',
        'child' => 
        array (
          'govent_list' => 
          array (
            'name' => '列表',
            'power' => 'view,add,edit,del,shenhe,progress,all',
          ),
        ),
      ),
    ),
  ),
  'users' => 
  array (
    'name' => '人员管理',
    'child' => 
    array (
      0 => 
      array (
        'name' => '会员管理',
        'ico' => '',
        'child' => 
        array (
          'member_list' => 
          array (
            'name' => '会员列表',
            'power' => 'view,add,del,shenhe',
          ),
        ),
      ),
      1 => 
      array (
        'name' => '积分管理',
        'ico' => '',
        'child' => 
        array (
          'member_integral' => 
          array (
            'name' => '积分排行',
            'power' => 'view,add,edit,del,shenhe',
          ),
        ),
      ),
    ),
  ),
  'system' => 
  array (
    'name' => '系统设置',
    'child' => 
    array (
      0 => 
      array (
        'name' => '设置',
        'ico' => 'manage',
        'child' => 
        array (
          'setting' => 
          array (
            'name' => '站点设置',
            'power' => NULL,
          ),
          'admin_log' => 
          array (
            'name' => '操作日志',
            'power' => NULL,
          ),
          'gmenu' => 
          array (
            'name' => '功能权限',
            'power' => NULL,
          ),
          'area' => 
          array (
            'name' => '地区设置',
            'power' => NULL,
          ),
          'cache' => 
          array (
            'name' => '清理缓存',
            'power' => NULL,
          ),
          'admin' => 
          array (
            'name' => '权限设置',
            'power' => '',
          ),
        ),
      ),
      1 => 
      array (
        'name' => '广告位',
        'ico' => '',
        'child' => 
        array (
          'ad_position' => 
          array (
            'name' => '广告位管理',
            'power' => '',
          ),
          'ad_info' => 
          array (
            'name' => '广告内容',
            'power' => '',
          ),
        ),
      ),
      2 => 
      array (
        'name' => '属性管理',
        'ico' => '',
        'child' => 
        array (
          'attribute' => 
          array (
            'name' => '属性管理',
            'power' => '',
          ),
        ),
      ),
      3 => 
      array (
        'name' => '任务',
        'ico' => '',
        'child' => 
        array (
        ),
      ),
    ),
  ),
  'organ' => 
  array (
    'name' => '机构管理',
    'child' => 
    array (
      0 => 
      array (
        'name' => '打卡',
        'ico' => '',
        'child' => 
        array (
          'visit_list' => 
          array (
            'name' => '任务列表',
            'power' => 'view,add,edit,del,shenhe,topshenhe,progress,all',
          ),
          'clock_list' => 
          array (
            'name' => '打卡列表',
            'power' => 'view,add,edit,del',
          ),
        ),
      ),
      1 => 
      array (
        'name' => '组织机构管理',
        'ico' => '',
        'child' => 
        array (
          'depart_list' => 
          array (
            'name' => '部门列表',
            'power' => 'view,add,edit,del',
          ),
          'office_list' => 
          array (
            'name' => '科室分类',
            'power' => 'view,add,edit,del',
          ),
        ),
      ),
      2 => 
      array (
        'name' => '工作人员管理',
        'ico' => '',
        'child' => 
        array (
          'manager_list' => 
          array (
            'name' => '工作人员列表',
            'power' => 'view,add,edit,del,shenhe',
          ),
        ),
      ),
    ),
  ),
);