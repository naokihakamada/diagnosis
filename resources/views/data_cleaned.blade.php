<html>
    <head>
        <meta http-equiv="refresh" content="3; URL='{{route('index')}}" />
    </head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="/js/jquery.cookie.js"></script>
    <script>
$(document).ready( function(){
    $.removeCookie('answers');
    $.removeCookie('diagnosis');
    $.removeCookie('user_result_id');
});
        </script>
    <body>
処理中です、少々おまちくださいませ。
    </body>
</html>