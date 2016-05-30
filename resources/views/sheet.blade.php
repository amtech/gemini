<!DOCTYPE html>
<html>
<head>
    <title>【{{$sheet->name}}】项目演示</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/') }}/css/base.css"/>

    <script src="{{ URL::asset('/') }}js/jquery-1.11.2.min.js"></script>
    <script src="{{ URL::asset('/') }}js/jquery.easing.1.3.js"></script>
    <script id="basejs" src="{{ URL::asset('/') }}js/base.js"></script>
    <script>
        $(document).ready(function () {
            @if(\Illuminate\Support\Facades\Cache::get('autoplay'))
            setAutoplay(true);
            @endif

            speech('{{$sheet->description}}', function () {
                @if($nextid)
                        window.location.href='{{ URL::asset('/') }}/sheet/{{$nextid}}';
                @else
                        setTimeout(function () {
                            tts('演示到此结束，谢谢观看，再见');
                        }, 3000);
                @endif
            }, function () {
                @if($preid)
                        window.location.href='{{ URL::asset('/') }}/sheet/{{$preid}}';
                @else
                    //
                @endif
            });
        })
    </script>
</head>
    <body>
        @include($sheet->url)

    </body>
</html>
