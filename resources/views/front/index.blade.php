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
                <div class="brands_layout">
                    <div class="brands_content">
                        @foreach($brands as $brand)
                            @if($brand != null)

                                <a href="/{{ Config::get('services.brands_link') }}/{{ $brand['link'] }}">
                                    <div class="brand_info">
                                                                        <span class="brand_name">
                                                                        {{ $brand['name']}}
                                                                        </span>
                                        <span class="brand_count">{{$brand['cars_count'].' '.trans('front.site.cars')}}</span>
                                    </div>
                                    <div class="brand_image">
                                        <img src="{{ url('uploads') }}/images/brands/{{$brand['slug']}}.webp" loading="lazy">
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="main_content">
            <div>{!! $content !!}</div>
        </div>
    </main>
@endsection
