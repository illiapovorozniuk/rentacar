<div class="long_horisontal_card_list">
    <div class="list_header">
{{--        <h3 class="title">{{trans('trans_rentacar.car.cars_you_might_like')}}</h3>--}}
    </div>
    <div class="list_content_layout">
        <div class="list_content">
            <?php
//            $currency = (new \App\Models\RcCurrency)->getCurrencyData(Config::get('services.currency'));
            ?>
            @foreach($carsMightLike as $car_index =>$car)
            <?php
                    $car_link = \App\Enums\Route::CAR->value.'/'.$car->id;
                    ?>
                @include('front.template-parts.card-light', ['car_link' => $car_link, 'car' => $car, '$currency'=>'$',  'car_index'=>$car_index])
            @endforeach
        </div>
    </div>
</div>
