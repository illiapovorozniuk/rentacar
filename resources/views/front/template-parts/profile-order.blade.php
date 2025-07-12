<?php
$order_car = $order->car;
$order_car = $order_car->carInfo();
$order_currency = $order->currency;

?>
<div class="order_item">
    <div class="oder_img" style="background: url('{{$order_car->main_photo}}')">
        @php
            $now = \Carbon\Carbon::now()->toDateString();
            $from = \Carbon\Carbon::parse($order->date_from)->toDateString();
            $to = \Carbon\Carbon::parse($order->date_to)->toDateString();

            if ($now < $from) {
                $label = __('front.order.waiting');
                $class = 'label-waiting';
            } elseif ($now >= $from && $now <= $to) {
                $label = __('front.order.in_process');
                $class = 'label-process';
            } else {
                $label = __('front.order.done');
                $class = 'label-done';
            }
        @endphp
        <span class="order-status-label {{$class}}">{{$label}}</span>
    </div>
    <div class="order_item_info">
        <p class="order_name">
            {{ucwords($order_car->brand_slug) . ' ' . (json_decode($order_car->car_model_name)->$locale ?? '') . ' ' . $order_car->attribute_year . ' ' . (json_decode($order_car->color_name)->$locale ?? '')}}
        </p>
        <p class="price"> {{trans('front.car.price').': ' . $order->total_price. ' ' . $order_currency->sign}}</p>
        <p class="order_date">
            {{ \Carbon\Carbon::parse($order->date_from)->locale(App::getLocale())->isoFormat('D MMMM Y') }}
            @if($order->date_from !== $order->date_to)
             {{ \Carbon\Carbon::parse($order->date_to)->locale(App::getLocale())->isoFormat('D MMMM Y') }}
            @endif
        </p>
    </div>
</div>
