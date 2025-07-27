@extends('front.template')

@section('style')
    <link rel="stylesheet" href="/css/front/login.css">
@endsection

@section('body')
    <div class="login_container">
        <form method="POST" action="{{ route('login.post') }}">
            <h1>{{trans('front.login')}}</h1>
            @csrf
            <input type="email" name="email" placeholder="Eлектронна адреса" required>
            <input type="password" name="password" placeholder="Пароль" required>
            @if ($errors->any())
                <div class="error_message">
                    {{trans('front.login.invalid_data')}}</div>
            @endif
            <button class="button_submit" type="submit">{{trans('front.login')}}</button>
        </form>
    </div>
@endsection
