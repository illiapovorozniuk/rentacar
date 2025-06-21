@extends('front.template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/front/login.css') }}">
@endsection

@section('body')
    <div class="login_container">
        <form method="POST" action="{{ route('front.register.post') }}">
            <h1>Sign Up</h1>
            @csrf

            <input type="text" name="name" placeholder="Name" required>
            @if ($errors->has('name'))
                <div class="error_message">{{ $errors->first('name') }}</div>
            @endif

            <input type="email" name="email" placeholder="Email" required>
            @if ($errors->has('email'))
                <div class="error_message">{{ $errors->first('email') }}</div>
            @endif

            <input type="password" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <div class="error_message">{{ $errors->first('password') }}</div>
            @endif

            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button class="button_submit" type="submit">Sign Up</button>
        </form>
    </div>
@endsection
