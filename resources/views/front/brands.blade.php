@extends('front.template')
<?php
$currency = 'uah';
$current_locale = app()->getLocale();
?>
@section('title')
    {{ $title }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/front/plp_without_cars.css') }}">
@endsection

@section('body')
        <main class="brandPage brand">

            <div class="brands">

                <div class="navigation">

                    {{--                    {{ Breadcrumbs::render('brands', $site, $site->cars_brands_slug, getBrandTitle($site)) }}--}}


                </div>

                <div class="main">
                    <div class="brands_title">
                        <h1>{{$h1 }}</h1>
                    </div>

                    <div class="brands_content_card">

                        <div class="brands_content">
                            @foreach($brands as $brand)

                                <a href="{{ baseUrl() }}/{{ Config::get('services.brands_link') }}/{{ $brand['link'] }}">
                                    <div class="brand_info">
                                                                        <span class="brand_name">
                                                                        {{ $brand['name']}}
                                                                        </span>
                                        <span class="brand_count">{{$brand['cars_count'].' '.trans('front.site.cars')}}</span>
                                    </div>
                                    <div class="brand_image">
                                        <img src="{{ url('uploads') }}/images/brands/{{$brand['slug']}}.webp" alt="{{$brand['name']}}" loading="lazy">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="text_content">{!! $content !!}</div>
                </div>
            </div>
        </main>
@endsection
