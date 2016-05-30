/**
 * Created by idear on 2016/5/16.
 */

$(function () {
    var basejs=$('#basejs');
    var url=$('#basejs').attr('src');
    var path=url.substring(0, url.lastIndexOf('/js/'));
    baseURL=realPath(path);

    var setting=$(
        '<div style="background-color: #c0ebd1;color:#00ad5f;position:fixed;top: 0;left: 0;z-index: 1001;padding: 5px 10px 10px;border-radius: 10px;line-height: 30px;">\
        <h3 style="border-bottom: 1px solid #00ad5f;line-height: 34px;">菜单</h3>\
        <p style="text-align: left;"><input id="autoplay" name="autoplay" type="checkbox" /> 自动播放</p>\
        <p style="text-align: left;"><input id="static" name="static" type="checkbox" /> 静态化页面</p>\
        <p style="text-align: left;"><input onclick="blurLayer(this)" type="button" value="显示触发区域('+$('.trigger').length+')" /></p>\
        </div>'
    );
    var autoplay=$.cookie('autoplay');
    if (autoplay=='true') {
        setting.find('#autoplay').attr('checked', true);
    } else {
        setting.find('#autoplay').attr('checked', false);
    }
    var static=$.cookie('static');
    if (static=='true') {
        setting.find('#static').attr('checked', true);
    } else {
        setting.find('#static').attr('checked', false);
    }
    $(document.body).append(setting);

    $('#autoplay').change(function () {
        $.cookie('autoplay', this.checked, { expires: 365, path: "/"});
    });
    $('#static').change(function () {
        $.cookie('static', this.checked, { expires: 365, path: "/"});
    });
});
function realPath(path) {
    if (/^http:\/\//.test(path)) {
        return path;
    }
    var currentDirs=window.location.pathname.split('/');
    var pathDirs=path.split('/');
    var dec=1;
    var tail='';
    for (var i=0;i<pathDirs.length;i++) {
        var dir=pathDirs[i];
        if (dir=='..') {
            dec++;
        } else {
            if (dir!='') {
                tail+='/'+dir;
            }
        }
    }
    var len=currentDirs.length-dec;
    var front='';
    for (var j=0;j<len;j++) {
        var dir=currentDirs[j];
        if (dir!='') {
            front+='/'+dir;
        }
    }
    return front+tail;
}
function blurLayer(ele) {
    var trigger=$('.trigger');
    if (/^显示触发区域/.test(ele.value)) {
        trigger.css({
            'background-color':'',
            'border':'1px solid #ffffff'
        });
        ele.value='隐藏触发区域('+trigger.length+')';
    } else {
        trigger.css({
            'background-color':'transparent',
            'border':'none'
        });
        ele.value='显示触发区域('+trigger.length+')';
    }

}
function Usecase() {
    var frames=[];
    this.custom=function (fun) {
        frames.push(fun);
        return this;
    };
    this.speech=function(text, fun) {
        this.custom(function () {
            //alert('speech');
            speech(text, function () {
                if (fun) {
                    fun();
                }
                $('#guidelayer').remove();
                $('.trigger').css({
                    'z-index':0,
                    'background-color':'rgba(0,0,0,0.2)'
                });
                $(document).dequeue('usecase');
            });
        });
        return this;
    };
    this.click=function (selector, fun) {
        this.custom(function () {
            //alert('click');
            click(selector, function () {
                if (fun) {
                    fun();
                }
                $(document).dequeue('usecase');
            });
        });
        return this;
    };
    this.forward=function (pageId, fun) {
        this.custom(function () {
            //alert('forward');
            if (fun) {
                fun();
            }
            var pathname=baseURL+'/page/'+pageId;
            if (window.location.pathname!=pathname) {
                window.location.href=pathname;
            } else {
                $(document).dequeue('usecase');
            }
        });
        return this;
    };
    this.guide=function (selector, fun) {
        this.custom(function () {
            //alert('guide');
            guide(selector, function () {
                if (fun) {
                    fun();
                }
                $(document).dequeue('usecase');
            });
        });
        return this;
    };
    this.done=function () {
        $(document).queue('usecase', frames).dequeue('usecase');
    };
    return this;
}

var guideSelector;
function guide(selector, nextSetp) {
    $('.trigger').css('z-index', 0);
    guideSelector=selector;
    var position=selector.position();
    $(document.body).animate({
        scrollTop: position.top
    }, {
        queue: true,
        duration:3000,
        easing: 'easeOutBounce',
        complete:function() {
            $('#guidelayer').remove();
            var content=$('#content');
            var guidelayer=$(
                '<div id="guidelayer">\
                <div class="guidelayer_t" style="background-color: rgba(0,0,0,0.7);position:absolute;left:0;top:0;width:100%;height:0px;z-index:1000;"></div>\
                <div class="guidelayer_l" style="background-color: rgba(0,0,0,0.7);position:absolute;left:0;top:'+position.top+'px;width:0px;height:'+selector.height()+'px;z-index:1000;"></div>\
                <div class="guidelayer_r" style="background-color: rgba(0,0,0,0.7);position:absolute;right:0px;top:'+position.top+'px;width:0px;height:'+selector.height()+'px;z-index:1000;"></div>\
                <div class="guidelayer_b" style="background-color: rgba(0,0,0,0.7);position:absolute;left:0px;bottom:0px;width:100%;height:0px;z-index:1000;"></div>\
                </div>'
            );
            content.append(guidelayer);
            guidelayer.children('.guidelayer_t').css({
                'height':position.top
            });
            guidelayer.children('.guidelayer_l').css({
                'width':position.left
            });
            guidelayer.children('.guidelayer_r').css({
                'width':content.width()-position.left-selector.width()
            });
            guidelayer.children('.guidelayer_b').css({
                'height':content.height()-position.top-selector.height()
            });
            nextSetp();

            // var t=200;
            // guidelayer.children('.guidelayer_t').animate({
            //     'height':position.top
            // }, t, 'easeOutBounce');
            // guidelayer.children('.guidelayer_l').animate({
            //     'width':position.left
            // }, t, 'easeOutBounce');
            // guidelayer.children('.guidelayer_r').animate({
            //     'width':content.width()-position.left-selector.width()
            // }, t, 'easeOutBounce');
            // guidelayer.children('.guidelayer_b').animate({
            //     'height':content.height()-position.top-selector.height()
            // }, t, 'easeOutBounce', function () {
            //     nextSetp();
            // });
        }
    });
    selector.css({
        'z-index': 1001,
        'background-color':'transparent',
    });
}

/**
 * 点击
 * @param selector
 * @param nextSetp
 */
function click(selector, nextSetp) {

}

/**
 * 朗读
 * @param text
 * @return setup
 */
function speech(text, nextSetp) {
    var animate;
    var mode=0;
    var duration=0;

    var chatcontent=$('#chatcontent');
    if(chatcontent.length>0) {
        chatcontent.html(text);
    } else {
        $(document.body).append(
            '<div class="chatbox_outer">\
                <div class="chatbox_wrap">\
                    <div class="chat_bg">\
                        <p style="background-color:#c0ebd1;height:20px;width:100%;"></p>\
                        <div class="chatbox">\
                            <p id="chatcontent">' + text + '\
                                <img id="next_flag" class="next_flag" src="../images/next_flag.gif"/>\
                            </p>\
                        </div>\
                        <p style="background-color:#c0ebd1;height:20px;width:100%;"></p>\
                    </div>\
                </div>\
            </div>'
        );
        chatcontent = $('#chatcontent');
        var chatParent=chatcontent.parent();
        chatParent.scroll(function () {
            var scrollmax=chatcontent.height()-chatParent.height();
            if (chatParent.scrollTop()==scrollmax) {
                $('#next_flag').css('visibility', 'visible');
            } else {
                $('#next_flag').css('visibility', 'hidden');
            }
        });

        chatParent.click(function () {
            if (mode!=2) {
                mode=2;
                if (animate) {
                    animate.stop(true, true);
                    animate=null;
                }
                $('#tts').remove();
            } else {
                //继续下一页
                if (nextSetp) {
                    nextSetp.call();
                }
            }
        });
    }

    function scrollStart() {
        var chatcontent = $('#chatcontent');
        var chatParent=chatcontent.parent();
        chatParent.scrollTop(0);
        var scrollmax=chatcontent.height()-chatParent.height();
        if (scrollmax>0) {
            mode=1;
            animate=chatParent.animate({'scrollTop': scrollmax}, {
                queue: true,
                duration:duration,
                easing: 'linear',
                complete:function() {
                    mode=2;
                    var autoplay=$.cookie('autoplay');
                    if (autoplay=='true') {
                        if (nextSetp) {
                            nextSetp.call();
                        }
                    }
                }
            });
        } else {
            setTimeout(function () {
                mode=2;
                var autoplay=$.cookie('autoplay');
                if (autoplay=='true') {
                    if (nextSetp) {
                        nextSetp.call();
                    }
                }
            }, duration);
        }
    }
    var tts=$('#tts');
    if(tts.length>0) {
        tts.attr('src', 'http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=4&text='+text+'');
    } else {
        $(document.body).append(
            '<audio src="http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=4&text='+text+'" controls="controls" preload id="tts" hidden>'
        );
        tts=$('#tts');
        var ttsElement=tts[0];
        ttsElement.oncanplaythrough=function () {
            duration=ttsElement.duration*1000;
            scrollStart();
            ttsElement.play();
        };
    }
}

function tts(text, callback) {
    var tts=
    $(
        '<audio src="http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=4&text='+text+'" controls="controls" preload id="tts" hidden>'
    );
    $(document.body).append(tts);

    var ttsElement=tts[0];
    ttsElement.oncanplaythrough=function () {
        var duration = ttsElement.duration * 1000;
        setTimeout(function () {
            tts.remove();
            if (callback) {
                callback.call();
            }
        }, duration);
        ttsElement.play();
    };
}

function popup(selector) {
    $('.popup_floor').remove();
    var dialog=$(
        '<div class="popup_floor">\
        <div class="popup_wrap">\
            <div class="popup"></div>\
        </div>\
        </div>'
    );
    dialog.find('.popup').append(selector);
    $(document.body).append(dialog);
}