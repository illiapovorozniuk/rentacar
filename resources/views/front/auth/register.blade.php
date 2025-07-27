@extends('front.template')

@section('style')
    <link rel="stylesheet" href="/css/front/login.css">
@endsection

@section('body')
    <div class="login_container">
        <form method="POST" action="{{ route('front.register.post') }}">
            <h1>{{trans('front.sign_up')}}</h1>
            @csrf

            <input type="text" name="name" placeholder="{{trans('front.register.name')}}" required>
            @if ($errors->has('name'))
                <div class="error_message">{{ $errors->first('name') }}</div>
            @endif

            <input type="email" name="email" placeholder="Email" required>
            @if ($errors->has('email'))
                <div class="error_message">{{ $errors->first('email') }}</div>
            @endif

            <input type="password" name="password" placeholder="Пароль" required>
            @if ($errors->has('password'))
                <div class="error_message">{{ $errors->first('password') }}</div>
            @endif

            <input type="password" name="password_confirmation" placeholder="{{trans('admin-user.columns.password_confirm')}}" required>
            <button class="button_submit" type="submit">{{trans('front.sign_up')}}</button>
        </form>
    </div>
@endsection
