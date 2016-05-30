<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title>项目演示</title>
    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/jquery-ui-1.11.4.js"></script>
    <script src="../js/jquery.easing.1.3.js"></script>
    <script src="../js/jquery.cookie-1.4.1.js"></script>

    <script>
        $.cookie('usecase_id', {{$usecase_id}}, { expires: 365, path: "/"});
        $.cookie('usecase_setp_index', 1, { expires: 365, path: "/"});
        window.location.href='../page/{{$first_setp_id}}';
    </script>
</head>
<body>

</body>
</html>
