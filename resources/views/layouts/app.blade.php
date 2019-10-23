<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>
    .vertical {
        writing-mode: tb-lr;
        writing-mode: vertical-lr;
        -webkit-writing-mode: vertical-lr;
        letter-spacing: .2em;
        text-aling: center;
    }

    .ss-card{
        border:1px solid #444444;
    }

    .ss-card-header{
        padding: .75rem 1.25rem;
        margin-bottom: 0;
        background-color: #444444;
        border-bottom: 1px solid #444444;

        color: white;
    }

    .ss-card-header h2{
        margin-bottom:0 ;
    }

    div.card-body h4{
color: black;
font-weight:700;
padding-bottom: 0.5em;
line-height:1.5em;
text-align:center;
font-size:2em;

padding: 0.5em 0;/*上下の余白*/
  border-top: solid 2px #444444;/*上線*/
  border-bottom: solid 2px #444444;/*下線*/
} 
    div.card-body h5{
        font-size:1.5em;
color: black;
font-weight:700;
margin-top: 1em;
margin-bottom: 0.5em;
border-bottom:2px solid #444444;
    }
    div.card-body p{
        font-size:1.2em;
        padding: 1.5em;
    }

    .table-bordered td.rc-block{
        border: 0px;
    }

</style>
    <!-- CSS Files -->
    <!--
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/avantui.css">
    -->

    <!-- bs-stepper 
    <link rel="stylesheet" href="https://unpkg.com/bs-stepper/dist/css/bs-stepper.min.css">
    <script src="https://unpkg.com/bs-stepper/dist/js/bs-stepper.min.js"></script>
    -->

    <script src="/js/js.cookie.js"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1>ソーシャル</h1>
                </a>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- <script src="https://rawgit.com/ftlabs/fastclick/master/lib/fastclick.js"></script> -->
</body>
</html>
