@extends('layouts.app', ['title' => 'Login', 'no_head' => true])
@section('content')
    <login appname="{{ config('app.name') }}" :affiliations="{{ json_encode($affiliations) }}"></login>
@endsection
<style>
    html,
    body {
        height: 100%;
    }

    body {
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5 !important;
    }

    .form-signin .checkbox {
        font-weight: 400;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
