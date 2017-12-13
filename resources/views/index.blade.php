<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Chat bot</title>

        <link rel="shortcut icon" type="image/png" href="img/bot_logo.png"/>
        <link rel="apple-touch-icon" sizes="57x57" href="img/bot_logo.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/bot_logo.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/bot_logo.png">
        <link rel="apple-touch-icon" sizes="144x144" href="img/bot_logo.png">

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="/libs/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/libs/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/libs/bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="/libs/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="/libs/dist/css/skins/_all-skins.min.css">

        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div id="app">
            <router-view></router-view>
            <notifications group="notification" classes="my-notification"/>
        </div>

        <script src="/libs/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/libs/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/libs/bower_components/fastclick/lib/fastclick.js"></script>
        <script src="/libs/dist/js/adminlte.min.js"></script>
        <script src="/libs/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
        <script src="/libs/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="/libs/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="/libs/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
