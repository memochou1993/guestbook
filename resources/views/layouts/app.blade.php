<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('app.name', 'Laravel') }}</title>
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
            <a class="navbar-brand" href="{{ route('signatures.index') }}">Guestbook</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('signatures') ? 'active' : '' }}" href="{{ route('signatures.index') }}">Signatures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('signatures/create') ? 'active' : '' }}" href="{{ route('signatures.create') }}">Sign</a>
                    </li>
                </ul>
            </div>
        </nav>

        @yield('content')
    </div>
    <script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
