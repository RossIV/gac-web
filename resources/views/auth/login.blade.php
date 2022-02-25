@extends('layouts.app', ['title' => 'Login', 'no_head' => true])
@section('content')

<main class="form-signin">
    <h1>{{ config('app.name') }}</h1>
    <h2 class="h3 mb-3 fw-normal">Login</h2>

    @if(!session()->has('success'))
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-floating">
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" value="{{old('email')}}">
                <label for="email">Email address</label>
                @error('email')
                <small style="color: red">{{ $message }}</small>
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Login</button>
        </form>

        <div class="row pt-3">
            <div class="col">
                <small>
                    {{ config('app.name') }} uses magic links to authenticate.
                    Simply submit your email address above, click the link in your inbox, and you're in!<br/><br/>
                    If you're new here, don't worry - we'll create an account for you automatically.
                </small>
            </div>
        </div>
    @else
        <p>Please click the link sent to your email to finish logging in.</p>
    @endif
</main>
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

    .form-signin {
        width: 100%;
        max-width: 500px;
        padding: 15px;
        margin: auto;
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
