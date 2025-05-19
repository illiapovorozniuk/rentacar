<?php
$single_link = '';
//$monthly = formatNumberString($car->price_3_full);
//$trimmedMonthly = substr($monthly, strpos($monthly, ":") + 2);
//$last = $trimmedMonthly;
?>

<div class="card_light">
    <a href="{{ 'baseUrl()' }}/{{$car_link}}/{{$single_link}}">
        <div class="img_container">
            <img src="{{$car->main_photo}}" alt="{{$car->slug}}" class="main_img" @if($car_index??1!=0)loading="lazy"@endif/>
        </div>
        <p class="name">{{$car->car_title.' ('.tr($car->color_name).'), '.$car->attribute_year }}</p>
    </a>
    <ul class="parameters">
        <li>
{{--            @if(isset($car->min_day_reservation) && $car->min_day_reservation !== null && $car->min_day_reservation >= 30)--}}
{{--                {{$last }} {{trans('front.site.per_month')}}--}}
{{--            @else--}}
{{--                {{strtoupper($currency->sign)}} {{ formatNumberString($car->price)}} {{trans('front.site.per_day')}}--}}
{{--            @endif--}}
        </li>
        @if($car->deposit == 0)
            <li class="no-dep">{{ucfirst(trans('trans_renty.car.no_deposit_label'))}}</li>
        @endif
    </ul>
</div>

