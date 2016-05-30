<!DOCTYPE html>
<html>
<head>
    <title>【{{$project->name}}】项目演示</title>
    <link rel="stylesheet" type="text/css" href="..//css/base.css"/>

    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/jquery.easing.1.3.js"></script>
    <script id="basejs" src="../js/base.js"></script>
    <script>
        $(document).ready(function () {setAutoplay(true);
            @if(\Illuminate\Support\Facades\Cache::get('autoplay'))
            setAutoplay(true);
            @endif

            speech('{{$project->description}}', function () {
                @if($nextid)
                        window.location.href='..//sheet/{{$nextid}}';
                @else
                //
                @endif
            });
        });
    </script>
</head>
    <body>
        @include($project->url)

    </body>
</html>
