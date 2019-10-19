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

      form {
  background: #fff;
  width: 100%;
  margin: auto;
  padding: 30px;
  min-width: 320px;
  max-width: 540px;
  box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.16), 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  border-radius: 3px;
}

h1 {
  color: #fff;
}

group + group {
  margin-top: 20px;
}

.inline-radio {
    display: flex;
  border-radius: 3px;
    overflow: hidden;
  border: 1px solid #b6b6b6;


    div {
        position: relative;
        flex: 1;
    }

    input {
    width: 100%;
        height: 60px;
    opacity: 0;
    }

    label {
        position: absolute;
        top: 0; left: 0;
        color: #b6b6b6;
        width: 100%;
        height: 100%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        border-right: 1px solid #b6b6b6;
    }

    div:last-child label {
        border-right: 0;
    }

    input:checked + label {
        background: #d81b60;
    font-weight: 500;
        color: #fff;
    }
}
    </style>
    <!-- CSS Files -->
    <link href="/assets/css/.min.css?v=2.0.6" rel="stylesheet" />

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
                    <h1>{{ config('app.name', 'Laravel') }}</h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (0)
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>
</html>
