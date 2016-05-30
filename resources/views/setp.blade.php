<!DOCTYPE html>
<html>
<head>
    <title>项目演示</title>
    <link rel="stylesheet" type="text/css" href="..//css/base.css"/>

    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/jquery.easing.1.3.js"></script>
    <script id="basejs" src="../js/base.js"></script>
    <script>
        $(document).ready(function () {
            @if(\Illuminate\Support\Facades\Cache::get('autoplay'))
            setAutoplay(true);
            @endif

            var usercase=new Usecase();
            @for($i=$index;$i<$setpOfUsecase->count();$i++)
            @define $setp = $setpOfUsecase->get($i)->runnable
            @if (is_a($setp, 'annotation'))
                    usercase.annotation('{{$setp}}');
            @elseif (is_a($setp, 'click'))
            @elseif (is_a($setp, 'forward'))
            @endif
        });
        function annotation() {

        }
    </script>
</head>
    <body>
        @include($sheet->url)

    </body>
</html>
