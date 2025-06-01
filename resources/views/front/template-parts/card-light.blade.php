<?php
$second =  formatNumberString($car->price_1);
$first = formatNumberString($car->price_7);
$last = formatNumberString($car->price_30);
?>

<div class="card_light">
    <a href="{{$car_link}}">
        <div class="img_container">
            <img src="{{$car->main_photo}}" alt="{{$car->slug}}" class="main_img" @if($car_index??1!=0)loading="lazy"@endif/>
        </div>
        <p class="name">{{$car->car_title.' ('.$car->color_name.'), '.$car->attribute_year }}</p>
    </a>
    <ul class="parameters">
        <li>
            @if(isset($car->min_day_reservation) && $car->min_day_reservation !== null && $car->min_day_reservation >= 30)
                {{$last }} {{trans('front.site.per_month')}}
            @else
                {{ $second}} {{trans('front.site.per_day')}}
            @endif
        </li>
        @if($car->deposit == 0)
            <li class="no-dep">{{ucfirst(trans('trans_rentacar.car.no_deposit_label'))}}</li>
        @endif
    </ul>
</div>

