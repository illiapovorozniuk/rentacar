@extends('front.template')

<?php

$current_locale = App::getLocale();
$current_locale = Config::get("app.current_locale");
if ($current_locale == NULL) {
    $current_locale = Config::get("app.fallback_locale");
}

//$currency = (new \App\Models\RcCurrency)->getCurrencyData(Config::get('services.currency'));

$getFilter = $_GET['sortBy'] ?? null;

?>



@section('style')
    <link rel="stylesheet" href="/css/front/plp.css" media="all">
    <link rel="stylesheet" href="/css/front/bootstrap.css" media="all">

@endsection
@section('title')
    {{ $title }}
@endsection

<?php
$car_link = Config::get('services.car_link');
?>



@section('body')

    <main class="carPage_two">
        @if($h1 !== NULL)
            <h1 class="title">{{$h1}}</h1>
        @endif

        <!-- Sorting block -->
        <form method="get" class="mb-4" id="sortForm">
            <div class="sort-block">
                <label for="sortBy">{{trans('front.sort')}}:</label>
                <select name="sortBy" id="sortBy" onchange="document.getElementById('sortForm').submit()">
                    <option value="default" {{ request('sortBy') == 'default' ? 'selected' : '' }}>{{trans('front.sort.default')}}</option>
                    <option value="price_asc" {{ request('sortBy') == 'price_asc' ? 'selected' : '' }}>{{trans('front.sort.ask')}}{{trans('front.sort.asc')}}</option>
                    <option value="price_desc" {{ request('sortBy') == 'price_desc' ? 'selected' : '' }}>{{trans('front.sort.desc')}}</option>
                </select>
            </div>
        </form>
        <!-- End Sorting block -->

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

                    <div class="pagination_container">
                        {!! $pagin_links??''!!}
                    </div>

                    @include('front.template-parts.cars-might-like',['carsMightLike' => $touched_cars])

                    @endif
                    {{--            @if($popularBrands != null)--}}
                    {{--                <div class="singleCar">--}}
                    {{--                    @include('templates.smart-car-lover.template-parts.popular-brands', ['popularBrands' => $popularBrands])--}}
                    {{--                </div>--}}
                    {{--            @endif--}}

                    @if(count($faqs) > 0)
                        @include('front.template-parts.faq', ['faqs' => $faqs, 'faq_slug_replacement'=>$faq_slug_replacement])
                    @endif

                </div>
                </div>


    </main>

@endsection
