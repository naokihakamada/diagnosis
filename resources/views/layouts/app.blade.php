<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>コミュニケーションスタイル診断　サイト</title>

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

    .top-paragraph{
        margin-bottom: 2em;
        line-height:1.75em;
        font-size:1.25em;
    }
    .top-main{
        font-weight:700;
    }
    .go-diagnosis{
        text-align: center;
    }
    .go-diagnosis a{
        padding: 0.25em 0.5em;
        font-size: 0.75em;
    }

    .ss-card{
        border:1px solid #444444;
    }

    .q-card-header{
        padding: 0.2em 0.2em 0.2em 1.5em;
        margin-bottom: 0;
        background-color: #444444;
        border-bottom: 1px solid #444444;

        color: white;
    }

    .ss-card-header{
        padding: 1.5em;
        margin-bottom: 0;
        background-color: #444444;
        border-bottom: 1px solid #444444;

        color: white;
    }

    .q-card-title{
        color: black;
font-weight:500;
padding-bottom: 1.25em;
line-height:1.25em;
font-size:1.5em;

text-align:center;
    }

    .q-card-end{
        color: black;
font-weight:500;
padding-bottom: 1em;
line-height:1em;
font-size:1.25em;

text-align:center;
    }

    .q-check-ans{
        font-weight:700;
line-height:1.25em;
font-size:1.5em;

text-align:center;
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
    p.send-title{
        text-align:center;
        padding: 0.5em 0;/*上下の余白*/
  border-top: solid 1px #38c172;/*上線*/
  border-bottom: solid 1px #38c172;/*下線*/
  margin-bottom: 2em;
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
        font-weight:500;
    }

    .table-bordered td.rc-block{
        border: 0px;
    }

    a.type-non-anchor{
        text-decoration: none;
    }
    a.type-non-anchor:visited { text-decoration: none;color: black;}
    a.type-non-anchor:hover { text-decoration: none;color: black;}
    a.type-non-anchor:active { text-decoration: none;color: black;}
    a.type-non-anchor:link { text-decoration: none;color: black;}

    .blinking{
    -webkit-animation:blink 1.5s ease-in-out infinite alternate;
    -moz-animation:blink 1.5s ease-in-out infinite alternate;
    animation:blink 1.5s ease-in-out infinite alternate;
    border-color: red;
}
@-webkit-keyframes blink{
    0% {opacity:0.2;}
    100% {opacity:1;}
}
@-moz-keyframes blink{
    0% {opacity:0.2;}
    100% {opacity:1;}
}
@keyframes blink{
    0% {opacity:0.2;}
    100% {opacity:1;}
}

    .action-button{
        font-size: 1.5em;
        line-height: 1.5em;
        text-align: center;
    }

    .navbar-brand {
        background: url("/images/comm-style.png") no-repeat left center;
        background-size: contain;
        height: 50px;
        width: 250px;
    }

    /* ボタンに長いテキスト対応 */
    .btn {
        white-space: normal;
    }

    .card-mark{
        line-height: 1.5em;
    }

    .table td, .table th {
        padding: 1em 0.6em 1em 0.6em;
    }

    hr{
        border-color: black;
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

    <script src="/js/jquery.cookie.js"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
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
