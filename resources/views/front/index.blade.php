@extends('front.template')
<?php
$currency = 'uah';
$current_locale = app()->getLocale();
$bodies = Config::get('site.bodies');

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
                {{-- Brand slider --}}
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
                {{-- End Brand slider --}}
                <div class="types_layout_overflow">
                    <div class="types_layout">
                        <div class="types_content">
                            <?php $value = 1; ?>
                            @foreach($bodies as $body)
                                @if($value <= 6)

                                            <a href="/{{$body['link']}}">
                                                <p>{{ $body['name']}}</p>
                                                <img src="{{getBodyTypeImgPath($body['slug'])}}" alt="{{$body['name']}}">
                                            </a>
                                        <?php $value = $value + 1; ?>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main_content">
            <div class="cars_home_content">

                <div class="card_list_default">
                    <div class="list_content_layout">
                        <div class="list_content">

                            @foreach($cars as $car_index =>$car)
                                    <?php
                                    $car_link = \App\Enums\Route::CAR->value.'/'.$car->id;
                                    ?>
                                @include('front.template-parts.card-light', ['car_link' => $car_link, 'car' => $car, $currency, 'card' => 1, 'car_index'=>$car_index])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="text_content">{!! $content !!}</div>
            @if($faqs > 0)
                @include('front.template-parts.faq', ['faqs' => $faqs])
            @endif
        </div>
    </main>
@endsection
