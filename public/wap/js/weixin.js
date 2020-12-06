$(document).ready(function () {
    //所有的ajax form提交,由于大多业务逻辑都是一样的，故统一处理
    var ajaxForm_list = $('form.js-ajax-form');
    if (ajaxForm_list.length) {
        Wind.use('ajaxForm', 'noty', 'validate', function () {

            //var form = btn.parents('form.js-ajax-form');
            var $btn;

            $('button.js-ajax-submit').on('click', function (e) {
                //e.preventDefault();
                /*var btn = $(this).find('button.js-ajax-submit'), form = $(this);*/
                var btn = $(this),
                    form = btn.parents('form.js-ajax-form');
                $btn = btn;
                if (btn.data("loading")) {
                    return false;
                }

                //批量操作 判断选项
                if (btn.data('subcheck')) {
                    btn.parent().find('span').remove();
                    if (form.find('input.js-check:checked').length) {
                        var msg = btn.data('msg');
                        if (msg) {
                            noty({
                                text: msg,
                                type: 'confirm',
                                layout: "center",
                                timeout: false,
                                modal: true,
                                buttons: [{
                                        addClass: 'btn btn-primary',
                                        text: '确定',
                                        onClick: function ($noty) {
                                            $noty.close();
                                            btn.data('subcheck', false);
                                            btn.click();
                                        }
                                    },
                                    {
                                        addClass: 'btn btn-danger',
                                        text: '取消',
                                        onClick: function ($noty) {
                                            $noty.close();
                                        }
                                    }
                                ]
                            });
                        } else {
                            btn.data('subcheck', false);
                            btn.click();
                        }

                    } else {
                        noty({
                            text: "请至少选择一项",
                            type: 'error',
                            layout: 'center'
                        });
                    }
                    return false;
                }

                //ie处理placeholder提交问题
                if ($.browser && $.browser.msie) {
                    form.find('[placeholder]').each(function () {
                        var input = $(this);
                        if (input.val() == input.attr('placeholder')) {
                            input.val('');
                        }
                    });
                }

            });

            ajaxForm_list.each(function () {
                $(this).validate({
                    //是否在获取焦点时验证
                    //onfocusout : false,
                    //是否在敲击键盘时验证
                    //onkeyup : false,
                    //当鼠标点击时验证
                    //onclick : false,
                    //给未通过验证的元素加效果,闪烁等
                    highlight: function (element, errorClass, validClass) {
                        if (element.type === "radio") {
                            this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                        } else if (element.type === "select-one" || element.type === "select-multiple") {
                            var $element = $(element);
                            $element.addClass(errorClass).removeClass(validClass);
                            $element.parent().parent().addClass("has-error"); //bootstrap3表单
                            $element.parents('.control-group').addClass("error"); //bootstrap2表单
                        } else {
                            var $element = $(element);
                            $element.addClass(errorClass).removeClass(validClass);
                            $element.parent().addClass("has-error"); //bootstrap3表单
                            $element.parents('.control-group').addClass("error"); //bootstrap2表单

                        }
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        if (element.type === "radio") {
                            this.findByName(element.name).removeClass(errorClass).addClass(validClass);
                        } else {
                            var $element = $(element);
                            $element.removeClass(errorClass).addClass(validClass);
                            $element.parent().removeClass("has-error"); //bootstrap3表单
                            $element.parents('.control-group').removeClass("error"); //bootstrap2表单
                        }
                    },
                    showErrors: function (errorMap, errorArr) {
                        var i, elements, error;
                        for (i = 0; this.errorList[i]; i++) {
                            error = this.errorList[i];
                            if (this.settings.highlight) {
                                this.settings.highlight.call(this, error.element, this.settings.errorClass, this.settings.validClass);
                            }
                            //this.showLabel( error.element, error.message );
                        }
                        if (this.errorList.length) {
                            //this.toShow = this.toShow.add( this.containers );
                        }
                        if (this.settings.success) {
                            for (i = 0; this.successList[i]; i++) {
                                //this.showLabel( this.successList[ i ] );
                            }
                        }
                        if (this.settings.unhighlight) {
                            for (i = 0, elements = this.validElements(); elements[i]; i++) {
                                this.settings.unhighlight.call(this, elements[i], this.settings.errorClass, this.settings.validClass);
                            }
                        }
                        this.toHide = this.toHide.not(this.toShow);
                        this.hideErrors();
                        this.addWrapper(this.toShow).show();
                    },
                    submitHandler: function (form) {
                        var $form = $(form);
                        $form.ajaxSubmit({
                            url: $btn.data('action') ? $btn.data('action') : $form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
                            dataType: 'json',
                            headers: {
                                'ZQDJ-Device-Type': 'mobile',
                                'ZQDJ-Token': getToken(),
                                'ZQDJ-Sign': GV.SIGN,
                                'ZQDJ-Timestamp': GV.TIMESTAMP
                            },
                            beforeSubmit: function (arr, $form, options) {
                                $btn.data("loading", true);
                                var text = $btn.text();
                                //按钮文案、状态修改
                                $btn.text(text + '...').prop('disabled', true).addClass('disabled');
                                //console.log(options);
                            },
                            success: function (data, statusText, xhr, $form) {

                                function _refresh() {
                                    if (data.url) {
                                        if (window.parent.art) {
                                            //iframe弹出页
                                            window.parent.location.href = data.url;

                                        } else {
                                            window.location.href = data.url;
                                        }
                                    } else {
                                        if (data.code == 1) {
                                            var wait = $btn.data("wait");
                                            if (window.parent.art) {
                                                reloadPage(window.parent);
                                            } else {
                                                //刷新当前页
                                                reloadPage(window);
                                            }
                                        }
                                    }
                                }

                                var text = $btn.text();
                                //按钮文案、状态修改
                                $btn.removeClass('disabled').prop('disabled', false).text(text.replace('...', '')).parent().find('span').remove();
                                if (data.code == 1) {
                                    if ($btn.data('success')) {
                                        var successCallback = $btn.data('success');
                                        window[successCallback](data, statusText, xhr, $form);
                                        return;
                                    }
                                    noty({
                                        theme: 'relax',
                                        timeout: 1500,
                                        text: data.msg,
                                        type: 'success',
                                        layout: 'center',
                                        modal: true,
                                        callback: {
                                            afterClose: function () {
                                                _refresh();
                                            }
                                        }
                                    });
                                } else if (data.code == 0) {
                                    if ($btn.data('error')) {
                                        var errorCallback = $btn.data('error');
                                        window[errorCallback](data, statusText, xhr, $form);
                                        return;
                                    }

                                    var $verify_img = $form.find(".verify_img");
                                    if ($verify_img.length) {
                                        $verify_img.attr("src", $verify_img.attr("src") + "&refresh=" + Math.random());
                                    }

                                    var $verify_input = $form.find("[name='verify']");
                                    $verify_input.val("");

                                    noty({
                                        theme: 'relax',
                                        timeout: 1500,
                                        text: data.msg,
                                        type: 'error',
                                        layout: 'center',
                                        callback: {
                                            afterClose: function () {
                                                _refresh();
                                            }
                                        }
                                    });
                                }


                            },
                            error: function (xhr, e, statusText) {
                                noty({
                                    text: statusText,
                                    type: 'error',
                                    layout: 'center',
                                    callback: {
                                        // afterClose: function () {
                                        //     if (window.parent.art) {
                                        //         reloadPage(window.parent);
                                        //     } else {
                                        //         //刷新当前页
                                        //         reloadPage(window);
                                        //     }
                                        // }
                                    }
                                });
                            },
                            complete: function () {
                                $btn.data("loading", false);
                            }
                        });
                    }
                });
            });

        });
    }

    //短信验证码
    var $js_get_mobile_code = $('.js-get-mobile-code');
    if ($js_get_mobile_code.length > 0) {
        Wind.use('noty', function () {

            $js_get_mobile_code.on('click', function () {
                var $this = $(this);
                if ($this.data('loading')) return;
                if ($this.data('sending')) return;
                var $mobile_input = $($this.data('mobile-input'));
                var mobile = $mobile_input.val();
                if (mobile == '') {
                    $mobile_input.focus();
                    return;
                }

                var $form = $this.parents('form');
                var $captchaInput = $("input[name='captcha']", $form);
                var $captchaIdInput = $("input[name='_captcha_id']", $form);
                var captcha = $captchaInput.val();
                var captchaId = $captchaIdInput.val();

                if (!captcha) {
                    $captchaInput.focus();
                    return;
                }


                $this.data('loading', true);
                $this.data('sending', true);

                var url = $this.data('url');

                var init_secode_left = parseInt($this.data('init-second-left'));
                init_secode_left = init_secode_left > 0 ? init_secode_left : 60;
                var init_text = $this.text();
                $this.data('second-left', init_secode_left);
                var wait_msg = $this.data('wait-msg');
                var codeType = $this.data('type');
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        username: mobile,
                        captcha: captcha,
                        captcha_id: captchaId,
                        type: codeType
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            noty({
                                text: data.msg,
                                type: 'success',
                                layout: 'center'
                            });

                            $this.text(wait_msg.replace('[second]', init_secode_left));

                            var mtimer = setInterval(function () {
                                if (init_secode_left > 0) {
                                    init_secode_left--;
                                    $this.text(wait_msg.replace('[second]', init_secode_left));

                                    $this.removeClass('am-btn-success');
                                    $this.addClass('am-btn-default');
                                } else {
                                    clearInterval(mtimer);
                                    $this.text(init_text);
                                    $this.data('sending', false);
                                    $this.removeClass('am-btn-default');
                                    $this.addClass('am-btn-success');
                                }

                            }, 1000);
                        } else {
                            $captchaInput.val('');
                            var $verify_img = $form.find(".verify_img");
                            if ($verify_img.length) {
                                $verify_img.attr("src", $verify_img.attr("src") + "&refresh=" + Math.random());
                            }
                            noty({
                                text: data.msg,
                                type: 'error',
                                layout: 'center'
                            });
                            $this.data('sending', false);
                        }
                    },
                    error: function () {
                        $this.data('sending', false);
                    },
                    complete: function () {
                        $this.data('loading', false);
                    }
                });
            });

        });
    }
});

//重新刷新页面，使用location.reload()有可能导致重新提交
function reloadPage(win) {
    if (win) {

    } else {
        win = window;
    }
    var location = win.location;
    location.href = location.pathname + location.search;
}

//页面跳转
function redirect(url) {
    location.href = url;
}

/**
 * 读取cookie
 * @param name
 * @returns
 */
function getCookie(name) {
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = jQuery.trim(cookies[i]);
            // Does this cookie string begin with the name we want?
            if (cookie.substring(0, name.length + 1) == (name + '=')) {
                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                break;
            }
        }
    }
    return cookieValue;
}

/**
 * 设置cookie
 */
function setCookie(name, value, options) {
    options = options || {};
    if (value === null) {
        value = '';
        options.expires = -1;
    }
    var expires = '';
    if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
        var date;
        if (typeof options.expires == 'number') {
            date = new Date();
            date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
        } else {
            date = options.expires;
        }
        expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
    }
    var path = options.path ? '; path=' + options.path : '';
    var domain = options.domain ? '; domain=' + options.domain : '';
    var secure = options.secure ? '; secure' : '';
    document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
}

function openIframeDialog(url, title, options) {
    var params = {
        title: title,
        lock: true,
        opacity: 0,
        width: "95%"
    };
    params = options ? $.extend(params, options) : params;
    Wind.use('artDialog', 'iframeTools', function () {
        art.dialog.open(url, params);
    });
}

/**
 * 查看图片对话框  单图
 * @param img 图片地址
 */
function imagePreviewDialog(img) {
    Wind.css('layer');
    Wind.use("layer", function () {
        layer.photos({
            photos: {
                "title": "", //相册标题
                "id": 'image_preview', //相册id
                "start": 0, //初始显示的图片序号，默认0
                "data": [ //相册包含的图片，数组格式
                    {
                        "alt": "",
                        "pid": 666, //图片id
                        "src": img, //原图地址
                        "thumb": img //缩略图地址
                    }
                ]
            } //格式见API文档手册页
            ,
            anim: 5, //0-6的选择，指定弹出图片动画类型，默认随机
            shadeClose: true,
            // skin: 'layui-layer-nobg',
            shade: [0.5, '#000000'],
            shadeClose: true,
        })
    });
}

/**
 * 打开文件上传对话框
 * @param dialog_title 对话框标题
 * @param callback 回调方法，参数有（当前dialog对象，选择的文件数组，你设置的extra_params）
 * @param extra_params 额外参数，object
 * @param multi 是否可以多选
 * @param filetype 文件类型，image,video,audio,file
 * @param app  应用名，CMF的应用名
 */
function openUploadDialog(dialog_title, callback, extra_params, multi, filetype, app) {
    Wind.css('artDialog');
    multi = multi ? 1 : 0;
    filetype = filetype ? filetype : 'image';
    app = app ? app : GV.APP;
    var params = '&multi=' + multi + '&filetype=' + filetype + '&app=' + app;
    Wind.use("artDialog", "iframeTools", function () {
        art.dialog.open(GV.ROOT + 'user/Asset/webuploader?' + params, {
            title: dialog_title,
            id: new Date().getTime(),
            width: '600px',
            height: '350px',
            lock: true,
            fixed: true,
            background: "#CCCCCC",
            opacity: 0,
            ok: function () {
                if (typeof callback == 'function') {
                    var iframewindow = this.iframe.contentWindow;
                    var files = iframewindow.get_selected_files();
                    console.log(files);
                    if (files && files.length > 0) {
                        callback.apply(this, [this, files, extra_params]);
                    } else {
                        return false;
                    }

                }
            },
            cancel: true
        });
    });
}

function ajaxLoginHtml() {
    openIframeLayer('/user/login/dologin.html', false, {
        shadeClose: false,
        area: ['700px', '463px']
    });
}

function getToken() {
    return getCookie('token');
}
//JS时间格式化
function getDateFormat(dateStr) {
    var publishTime = dateStr,
        d_seconds,
        d_minutes,
        d_hours,
        d_days,
        timeNow = parseInt(new Date().getTime() / 1000),
        d,

        date = new Date(publishTime * 1000),
        Y = date.getFullYear(),
        M = date.getMonth() + 1,
        D = date.getDate(),
        H = date.getHours(),
        m = date.getMinutes(),
        s = date.getSeconds();
    //小于10的在前面补0
    if (M < 10) {
        M = '0' + M;
    }
    if (D < 10) {
        D = '0' + D;
    }
    if (H < 10) {
        H = '0' + H;
    }
    if (m < 10) {
        m = '0' + m;
    }
    if (s < 10) {
        s = '0' + s;
    }

    d = timeNow - publishTime;
    d_days = parseInt(d / 86400);
    d_hours = parseInt(d / 3600);
    d_minutes = parseInt(d / 60);
    d_seconds = parseInt(d);

    if (d_days > 0 && d_days < 3) {
        return d_days + '天前';
    } else if (d_days <= 0 && d_hours > 0) {
        return d_hours + '小时前';
    } else if (d_hours <= 0 && d_minutes > 0) {
        return d_minutes + '分钟前';
    } else if (d_seconds < 60) {
        if (d_seconds <= 0) {
            return '刚刚发表';
        } else {
            return d_seconds + '秒前';
        }
    } else if (d_days >= 3 && d_days < 30) {
        return M + '-' + D + ' ' + H + ':' + m;
    } else if (d_days >= 30) {
        return Y + '-' + M + '-' + D + ' ' + H + ':' + m;
    }
}

function xw_alert(type, msg, url) {
    Wind.use('noty', function () {
        noty({
            theme: 'relax',
            timeout: 1500,
            text: msg,
            type: type,
            layout: 'center',
            callback: {
                afterClose: function () {
                    if (url != undefined && url != false) {
                        redirect(url);
                    }
                }
            }
        });
    });
}

function jsUrl(url, parm) {
    if (url == '') return;
    if (parm != undefined && parm != '') {
        var u = GV.ROOT + url + '?' + parm;
    } else {
        var u = GV.ROOT + url;
    }
    redirect(u);
}

function apiUrl(url, parm) {
    if (url == '') return;
    if (parm != undefined && parm != '') {
        return GV.API + url + '?' + parm;
    } else {
        return GV.API + url;
    }
}