<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} :: {{ config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="container-fluid">
        @if(!isset($no_head))
            @include('layouts.head')
        @endif
        @yield('content')
    </div>
    @include('layouts.foot')
</div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
