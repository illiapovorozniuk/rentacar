@extends('front.template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/front/login.css') }}">
@endsection

@section('body')
    <div class="login_container">
        <form method="POST" action="{{ route('login.post') }}">
            <h1>Login</h1>
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            @if ($errors->any())
                <div class="error_message">Invalid data provided. Please check your inputs.</div>
            @endif
            <button class="button_submit" type="submit">Login</button>
        </form>
    </div>
@endsection
