<?php defined('SSZCMS') or exit('Access Denied');?><?php include T('header',true);?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo L('web_set');?></h3>
        <h5><?php echo L('web_set_subhead');?></h5>
      </div>
      <?php echo $top_link;?> </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo L('hx_prompts_title');?>"><?php echo L('hx_prompts');?></h4>
      <span id="explanationZoom" title="<?php echo L('hx_prompts_span');?>"></span> </div>
    <ul>
      <li>网站全局基本设置，邮箱及其他模块相关内容在其各自栏目设置项内进行操作。</li>
    </ul>
  </div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="site_name"><?php echo L('web_name');?></label>
        </dt>
        <dd class="opt">
          <input id="site_name" name="site_name" value="<?php echo $list_setting['site_name'];?>" class="input-txt" type="text" />
          <p class="notic"><?php echo L('web_name_notice');?></p>
        </dd>
      </dl>
      <dl class="row">
      <dt class="tit">
          <label for="site_keywords">网站关键词</label>
        </dt>
        <dd class="opt">
          <input id="site_keywords" name="site_keywords" value="<?php echo $list_setting['site_keywords'];?>" class="input-txt" type="text" />
          <p class="notic">网站关键词</p>
        </dd>
      </dl>
      <dl class="row">
      <dt class="tit">
          <label for="site_description">网站描述</label>
        </dt>
        <dd class="opt">
          <input id="site_description" name="site_description" value="<?php echo $list_setting['site_description'];?>" class="input-txt" type="text" />
          <p class="notic">网站描述</p>
        </dd>
      </dl> 
  
<dl class="row">
      <dt class="tit">
          <label for="site_tel">顶部欢迎词</label>
        </dt>
        <dd class="opt">
          <input id="site_welcome" name="site_welcome" value="<?php echo $list_setting['site_welcome'];?>" class="input-txt" type="text" />
          <p class="notic"></p>
        </dd>
</dl> 
<dl class="row">
      <dt class="tit">
          <label for="site_company">联系人</label>
        </dt>
        <dd class="opt">
          <input id="site_company" name="site_company" value="<?php echo $list_setting['site_company'];?>" class="input-txt" type="text" />
          <p class="notic"></p>
        </dd>
</dl> 
<dl class="row">
      <dt class="tit">
          <label for="site_tel">联系电话</label>
        </dt>
        <dd class="opt">
          <input id="site_tel" name="site_tel" value="<?php echo $list_setting['site_tel'];?>" class="input-txt" type="text" />
          <p class="notic"></p>
        </dd>
</dl> 
<dl class="row">
      <dt class="tit">
          <label for="site_phone">联系手机</label>
        </dt>
        <dd class="opt">
          <input id="site_phone" name="site_phone" value="<?php echo $list_setting['site_phone'];?>" class="input-txt" type="text" />
          <p class="notic">手机号码</p>
        </dd>
    </dl> 
<dl class="row">
      <dt class="tit">
          <label for="site_email">联系邮箱</label>
        </dt>
        <dd class="opt">
          <input id="site_email" name="site_email" value="<?php echo $list_setting['site_email'];?>" class="input-txt" type="text" />
          <p class="notic">电子邮箱</p>
        </dd>
    </dl>  
<dl class="row">
      <dt class="tit">
          <label for="site_qq">联系QQ</label>
        </dt>
        <dd class="opt">
          <input id="site_qq" name="site_qq" value="<?php echo $list_setting['site_qq'];?>" class="input-txt" type="text" />
          <p class="notic">客服QQ</p>
        </dd>
    </dl>  
<dl class="row">
      <dt class="tit">
          <label for="site_fax">联系传真</label>
        </dt>
        <dd class="opt">
          <input id="site_fax" name="site_fax" value="<?php echo $list_setting['site_fax'];?>" class="input-txt" type="text" />
          <p class="notic">电子传真</p>
        </dd>
    </dl>   
    <dl class="row">
      <dt class="tit">
          <label for="site_address">地址</label>
        </dt>
        <dd class="opt">
          <input id="site_address" name="site_address" value="<?php echo $list_setting['site_address'];?>" class="input-txt" type="text" />
          <p class="notic">地址</p>
        </dd>
    </dl>
    <dl class="row">
      <dt class="tit">
          <label for="site_coordinate">地址坐标</label>
        </dt>
        <dd class="opt">
          <input id="site_coordinate" name="site_coordinate" value="<?php echo $list_setting['site_coordinate'];?>" class="input-txt" type="text" />
          <p class="notic">百度坐标</p>
        </dd>
    </dl>
     
    <dl class="row">
      <dt class="tit">
          <label for="integral">积分</label>
        </dt>
        <dd class="opt">
          <input id="integral" name="integral" value="<?php echo $list_setting['integral'];?>" class="input-txt" type="text" />
          <p class="notic">发布成功一篇文章奖励积分值，请填写正整数</p>
        </dd>
      </dl> 
    <dl class="row">
      <dt class="tit">
          <label for="site_url">网址</label>
        </dt>
        <dd class="opt">
          <input id="site_url" name="site_url" value="<?php echo $list_setting['site_url'];?>" class="input-txt" type="text" />
          <p class="notic">网址</p>
        </dd>
      </dl>
      
                <dl class="row">
      <dt class="tit">
          <label for="site_copyright">版权</label>
        </dt>
        <dd class="opt">
        <textarea name="site_copyright" rows="3" class="tarea" id="site_copyright"><?php echo $list_setting['site_copyright'];?></textarea>
          <p class="notic">版权</p>
        </dd>
      </dl>   
      
      
      
      <dl class="row">
        <dt class="tit">
          <label for="icp_number"><?php echo L('icp_number');?></label>
        </dt>
        <dd class="opt">
          <input id="icp_number" name="icp_number" value="<?php echo $list_setting['icp_number'];?>" class="input-txt" type="text" />
          <p class="notic"><?php echo L('icp_number_notice');?></p>
        </dd>
      </dl>
      <dl class="row" style="display:none;">
        <dt class="tit">
          <label for="statistics_code"><?php echo L('flow_static_code');?></label>
        </dt>
        <dd class="opt">
          <textarea name="statistics_code" rows="6" class="tarea" id="statistics_code"><?php echo $list_setting['statistics_code'];?></textarea>
          <p class="notic"><?php echo L('flow_static_code_notice');?></p>
        </dd>
      </dl>
      <dl class="row" style="display:none;">
        <dt class="tit">
          <label for="time_zone"> <?php echo L('time_zone_set');?></label>
        </dt>
        <dd class="opt">
          <select id="time_zone" name="time_zone">
            <option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
            <option value="-11">(GMT -11:00) Midway Island, Samoa</option>
            <option value="-10">(GMT -10:00) Hawaii</option>
            <option value="-9">(GMT -09:00) Alaska</option>
            <option value="-8">(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana</option>
            <option value="-7">(GMT -07:00) Mountain Time (US &amp; Canada), Arizona</option>
            <option value="-6">(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
            <option value="-5">(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>
            <option value="-4">(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz</option>
            <option value="-3.5">(GMT -03:30) Newfoundland</option>
            <option value="-3">(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is</option>
            <option value="-2">(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena</option>
            <option value="-1">(GMT -01:00) Azores, Cape Verde Islands</option>
            <option value="0">(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
            <option value="1">(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>
            <option value="2">(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa</option>
            <option value="3">(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi</option>
            <option value="3.5">(GMT +03:30) Tehran</option>
            <option value="4">(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
            <option value="4.5">(GMT +04:30) Kabul</option>
            <option value="5">(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
            <option value="5.5">(GMT +05:30) Bombay, Calcutta, Madras, New Delhi</option>
            <option value="5.75">(GMT +05:45) Katmandu</option>
            <option value="6">(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk</option>
            <option value="6.5">(GMT +06:30) Rangoon</option>
            <option value="7">(GMT +07:00) Bangkok, Hanoi, Jakarta</option>
            <option value="8">(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei</option>
            <option value="9">(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
            <option value="9.5">(GMT +09:30) Adelaide, Darwin</option>
            <option value="10">(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok</option>
            <option value="11">(GMT +11:00) Magadan, New Caledonia, Solomon Islands</option>
            <option value="12">(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island</option>
          </select>
          <p class="notic"><?php echo L('set_sys_use_time_zone');?>+8</p>
        </dd>
      </dl>
      <dl class="row" style="display:none;">
        <dt class="tit"><?php echo L('site_state');?></dt>
        <dd class="opt">
          <div class="onoff">
            <label for="site_status1" class="cb-enable <?php if($list_setting['site_status'] == '1'){ ?>selected<?php } ?>" ><?php echo L('open');?></label>
            <label for="site_status0" class="cb-disable <?php if($list_setting['site_status'] == '0'){ ?>selected<?php } ?>" ><?php echo L('close');?></label>
            <input id="site_status1" name="site_status" <?php if($list_setting['site_status'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="site_status0" name="site_status" <?php if($list_setting['site_status'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic"><?php echo L('site_state_notice');?></p>
        </dd>
      </dl>
      
       <dl class="row" style="display:none;">
        <dt class="tit">验证码</dt>
        <dd class="opt">
          <div class="onoff">
            <label for="captcha_status_login1" class="cb-enable <?php if($list_setting['captcha_status_login'] == '1'){ ?>selected<?php } ?>" ><?php echo L('open');?></label>
            <label for="captcha_status_login0" class="cb-disable <?php if($list_setting['captcha_status_login'] == '0'){ ?>selected<?php } ?>" ><?php echo L('close');?></label>
            <input id="captcha_status_login1" name="captcha_status_login" <?php if($list_setting['captcha_status_login'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="captcha_status_login0" name="captcha_status_login" <?php if($list_setting['captcha_status_login'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic">后台验证码开启关闭</p>
        </dd>
      </dl>
      
      <dl class="row"  >
        <dt class="tit">
          <label for="closed_reason"><?php echo L('closed_reason');?></label>
        </dt>
        <dd class="opt">
          <textarea name="closed_reason" rows="6" class="tarea" id="closed_reason" ><?php echo $list_setting['closed_reason'];?></textarea>
          <p class="notic"><?php echo L('closed_reason_notice');?></p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()"><?php echo L('hx_submit');?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript">
$(function(){
$('#time_zone').attr('value','<?php echo $list_setting['time_zone'];?>');
});
</script> 
<?php include T('footer',true);?>