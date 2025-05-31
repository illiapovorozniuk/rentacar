@extends('front.template')

<?php

$current_locale = App::getLocale();

$current_locale = Config::get("app.current_locale");
if ($current_locale == NULL) {
    $current_locale = Config::get("app.fallback_locale");
}
$imageMeta = baseUrl() . $data[0]->photo;


//$currency = (new \App\Models\RcCurrency)->getCurrencyData(Config::get('services.currency'));

$getFilter = $_GET['sortBy'] ?? null;
?>




@section('style')
    <link rel="stylesheet" href="{{ asset('css/front/plp.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/front/bootstrap.css') }}" media="all">
@endsection
@section('title')
    {{ $title }}
@endsection

<?php
$car_link = Config::get('services.car_link');
?>


@section('body')

    <main class="carPage_two">

{{--        <div class="navigation">--}}
{{--            {{ Breadcrumbs::render('brand', $site, $site->cars_brands_slug, getBrandTitle($site), $data[0]->brand_slug,--}}
{{--            $data[0]->en_brand) }}--}}
{{--        </div>--}}
{{--        @if($h1 !== NULL)--}}
{{--            <h1 class="title">{{ $h1.((int)$page>1?', '.trans('trans_rentacar.car.page').' '.$page:'') }}</h1>--}}
{{--        @endif--}}
{{--        @include('templates.smart-car-lover.template-parts.filter', ['brand' => $brand])--}}

{{--        @if($interlinking !== [] && $interlinking !== null )--}}
{{--            @include('templates.smart-car-lover.template-parts.interlinks',['interlinking' => $interlinking, 'with_title' => false])--}}
{{--        @endif--}}
        <div class="container_with_separators">
            @if(sizeof($data) == 0)
                    <?php abort(404) ?>
            @else
                <div class="cards">
                    <div class="single_vertical_card_list">
                        @foreach($data as $car_index =>$car)
                            @include('front.template-parts.card-full', ['car_link' => '$car_link', 'car' => $car,
                            'currency'=>'$currency'])
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center pagination pagination-content">

{{--                            <?php $base_url = baseUrl();--}}
{{--                            (new \App\Models\Site)->createPaginationNEW($count, (int)$page, $site->cars_brands_slug . '/' . $brand_link, $base_url, $site->cars_per_page); ?></div>--}}
                </div>
                    @include('front.template-parts.cars-might-like',['carsMightLike' => $touched_cars])

            @endif
{{--            @if($popularBrands != null)--}}
{{--                <div class="singleCar">--}}
{{--                    @include('templates.smart-car-lover.template-parts.popular-brands', ['popularBrands' => $popularBrands])--}}
{{--                </div>--}}
{{--            @endif--}}
                    @if($faqs > 0)
                        @include('front.template-parts.faq', ['faqs' => $faqs, 'faq_slug_replacement'=>$faq_slug_replacement])
                    @endif

        </div>


    </main>

@endsection

