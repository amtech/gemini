<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title>项目演示</title>
    <link rel="stylesheet" type="text/css" href="..//css/jquery-ui-1.11.4.css"/>
    <link rel="stylesheet" type="text/css" href="..//css/base.css"/>

    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/jquery-ui-1.11.4.js"></script>
    <script src="../js/jquery.easing.1.3.js"></script>
    <script src="../js/jquery.cookie-1.4.1.js"></script>
    <script id="basejs" href="{{ URL::asset('/') }}" src="../js/base.js"></script>
    <script>
        $(document).ready(function () {

            @if(isset($usecase))
            {{--*/ $usecaseCount = count($usecase->setps) /*--}}
            function nextSetp() {
                var setpIndex=$.cookie('usecase_setp_index');
                if (setpIndex) {
                    setpIndex=parseInt(setpIndex);
                } else {
                    setpIndex=0;
                }
                setpIndex+=1;
                if(setpIndex>{{$usecaseCount-1}}) {
                    setpIndex={{$usecaseCount-1}};
                }
                $.cookie('usecase_setp_index', setpIndex, { expires: 365, path: "/"});
            }
            function endOfSetp() {
                popup($(
                        '<div style="background-color:#ffffff;text-align:center;border-radius:10px;position:relative;">\
                        <div style="margin:0 60px 0px;padding-bottom:20px;color:#666;font-weight:bold;">\
                        <p style="line-height:44px;font-size:16px;color:coral;font-weight:bolder;border-radius:10px 10px 0 0;">{{$usecase->name}}</p>\
                        <p style="width:100%;height:1px;background-color:#dfdfdf;position:absolute;left: 0;"></p>\
                        <p style="line-height:36px;font-size:14px;">请选择：</p>\
                        <ul style="line-height:28px;font-size:14px;">\
                        <li><a href="../usecase/{{$usecase->id}}">重播</a></li>\
                        <li><a href="../project/{{$usecase->project_id}}">返回首页</a></li>\
                        </ul>\
                        </div>\
                        </div>'
                ));
                tts('此用例演示已结束，请选择重播，或返回首页！');
            }
            {{--*/  $current_page=$usecase->setps->get($usecase_setp_index-1); /*--}}
            @if($page->id!=$current_page->page_id)
            {{--*/ $index=-1 /*--}}
                @for($i=0;$i<$usecaseCount;$i++)
                {{--*/ $tmp=$usecase->setps->get($i) /*--}}
                @if($tmp->page_id==$page->id)
                {{--*/ $index=$tmp->page_id /*--}}
                @break
                @endif
                @endfor

                window.setSetpIndex=function() {
                    $.cookie('usecase_setp_index', {{$i+1<$usecaseCount?$i+1:$usecaseCount}}, { expires: 365, path: "/"});
                    window.location.href='../page/{{$index}}';
                }
                popup($(
                    '<div style="background-color:#ffffff;text-align:center;border-radius:10px;position:relative;">\
                    <div style="margin:0 60px 0px;padding-bottom:20px;color:#666;font-weight:bold;">\
                    <p style="line-height:44px;font-size:16px;color:coral;font-weight:bolder;border-radius:10px 10px 0 0;">{{$usecase->name}}</p>\
                        <p style="width:100%;height:1px;background-color:#dfdfdf;position:absolute;left: 0;"></p>\
                        <p style="line-height:36px;font-size:14px;">演示被中断了，请选择：</p>\
                        <ul style="line-height:28px;font-size:14px;">\
                        @if($index>=0)
                        <li><a href="javascript:;" onclick="setSetpIndex();">从此处开始演示</a></li>\
                        @endif
                        <li><a href="../page/{{$current_page->page_id}}">继续演示</a></li>\
                        <li><a href="../usecase/{{$usecase->id}}">重新演示</a></li>\
                        <li><a href="../project/{{$usecase->project_id}}">返回首页</a></li>\
                        </ul>\
                        </div>\
                        </div>'
                ));
                tts('此用例演示被中断，请选择继续，或从此处开始演示！');
            @else
            var usecase=new Usecase();
            @for($i=$usecase_setp_index-1;$i<$usecaseCount;$i++)
            {{--*/ $setp = $usecase->setps->get($i)->detail()->first() /*--}}
                @if($i==$usecaseCount-1)
                {{--*/ $fun = 'endOfSetp' /*--}}
                @else
                {{--*/ $fun = 'nextSetp' /*--}}
                @endif

                @if (is_a($setp, 'App\Annotation'))
                    @if($setp->selector)
                    usecase.guide($('{{$setp->selector}}'));
                    @endif
                    usecase.speech('{{$setp->summary}}', {{$fun}});
                @elseif (is_a($setp, 'App\Click'))
                    usecase.click($('{{$setp->selector}}'), {{$fun}});
                @elseif (is_a($setp, 'App\Forward'))
                    usecase.forward('{{$setp->target_page_id}}', {{$fun}});
                @endif
            @endfor
                    usecase.done();
            @endif
            @endif
        });
    </script>
</head>
<body>
<div id="content">
@include($page->url)
</div>
</body>
</html>
