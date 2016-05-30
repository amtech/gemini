<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title>【{{$project->name}}】项目演示</title>
    <link rel="stylesheet" type="text/css" href="../css/base.css"/>

    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/jquery.easing.1.3.js"></script>
    <script src="../js/jquery.cookie-1.4.1.js"></script>
    <script id="basejs" src="../js/base.js"></script>
    <script>
        $(document).ready(function () {
            @if(\Illuminate\Support\Facades\Cache::get('autoplay'))
            setAutoplay(true);
            @endif

            speech('{{$project->description}}', function () {
                popup($(
                        '<div style="background-color:#ffffff;text-align:center;border-radius:10px;position:relative;">\
                        <div style="margin:0 60px 0px;padding-bottom:20px;color:#666;font-weight:bold;">\
                        <p style="line-height:44px;font-size:16px;color:coral;font-weight:bolder;border-radius:10px 10px 0 0;">{{$project->name}}</p>\
                        <p style="width:100%;height:1px;background-color:#dfdfdf;position:absolute;left: 0;"></p>\
                        <p style="line-height:36px;font-size:14px;">请选择一个用例：</p>\
                        <ul style="line-height:28px;font-size:14px;">\
                        @foreach($project->usecases as $usecase) \
                        <li><a href="../usecase/{{$usecase->id}}">{{$usecase->name}}</a></li>\
                        @endforeach \
                        </ul>\
                        </div>\
                        </div>'
                ));
                tts('请选择一个用例，点击进入！');
            });
        });
    </script>
</head>
    <body>
    @include($project->url)
    </body>
</html>
