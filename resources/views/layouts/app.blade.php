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
@include('layouts/head')
<div class="container mx-auto">
@yield('content')
</div>
</body>
</html>
