<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi Enkripsi & Deskripsi File</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>
<body class="bg-gradient-light">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card o-hidden border-0 shadow-lg" style="margin: auto; top:100px;">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="{{ asset('/img/logo.png') }}" width="150px;" alt="">
                                        <h1 class="h4 text-gray-900 mb-4">Lupa Password?</h1>
                                    </div>
                                    @if ($message)
                                        <p>{{ $message }}</p>
                                        <div class="form-group">
                                            <a href="/login" class="text-primary">
                                                {{ __('Login') }}
                                            </a>
                                        </div>
                                    @else
                                        <form class="user" method="POST" action="{{ route('request.reset') }}" autocomplete="off">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" style="font-size: 15px" class="form-control" placeholder="Username or Email" name="email_or_username" maxlength="100" required autofocus>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                <span style="font-size:18px;">{{ __('Submit') }}</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


     <!-- Bootstrap core JavaScript-->
     <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
