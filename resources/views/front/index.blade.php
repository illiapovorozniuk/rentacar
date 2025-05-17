@extends('front.template')
<?php
?>
@section('title')
    {{ $title }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/front/index.css') }}">
@endsection

@section('body')
    <main>
        <div class="banner" style="background-image: url({{ $cover[0]->getUrl() }})">
            <div class="banner_content">
                <h1>
                    {{$h1}}
                </h1>
                <div class="home_description">
                    {!! $description !!}
                </div>
            </div>
            <div class="main_content">
                <div>{!! $content !!}</div>
            </div>
        </div>
    </main>
@endsection
