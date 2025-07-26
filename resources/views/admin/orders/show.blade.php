@extends('brackets/admin-ui::admin.layout.default')
@section('title', 'Order Details')
@section('body')
    <div class="container">
        <h1>Деталі замовлення #{{ $order->id }}</h1>
        <div class="order-details">
            <h3>Інформація про авто</h3>
            <div><b>Бренд:</b> {{ $order->car_info['brand_slug'] ?? '-' }}</div>
            <div><b>Модель:</b> {{ $order->car_info['car_slug'] ?? '-' }}</div>
            <div><b>Рік:</b> {{ $order->car_info['attribute_year'] ?? '-' }}</div>
            <div><b>Колір:</b> {{ $order->car_info['color_slug'] ?? '-' }}</div>
            <div><b>Фото:</b> @if(isset($order->car_info['main_photo'])) <img src="{{ $order->car_info['main_photo'] }}" style="max-width:120px;"> @endif</div>
            <hr>
            <h3>Інформація про замовлення</h3>
            <div><b>Статус:</b> {{ $order->status }}</div>
            <div><b>Дата з:</b> {{ $order->date_from }}</div>
            <div><b>Дата до:</b> {{ $order->date_to }}</div>
            <div><b>Адреса отримання:</b> @if($order->address_from)
                    {{$order->address_from}}
                @else
                    <a href="https://maps.google.com/maps?q={{$order->car_info->latitude}},{{$order->car_info->longitude}}"
                       target="_blank">🗺️</a>
                @endif</div>
            <div><b>Адреса повернення:</b>  @if($order->address_to)
                    {{$order->address_to}}
                @else
                    <a href="https://maps.google.com/maps?q={{$order->car_info->latitude}},{{$order->car_info->longitude}}"
                       target="_blank">🗺️</a>
                @endif</div>
            <div><b>Сума:</b> {{ $order->total_price }} {{ $order->currency->sign ?? '' }}</div>
            <div><b>Статус оплати:</b> {{ $order->payment_status }}</div>
            <div><b>LiqPay Payment ID:</b> {{ $order->liqpay_payment_id }}</div>
            <hr>
            <h3>Інформація про користувача</h3>
            <div><b>Ім'я:</b> {{ $order->user->name ?? '-' }}</div>
            <div><b>Email:</b> {{ $order->user->email ?? '-' }}</div>
            <div><b>Телефон:</b> {{ $order->user->phone ?? '-' }}</div>
            <hr>
            @if($order->status !== \App\Enums\OrderType::PAYMENT_CANCELLED->value)
                <form method="POST" action="{{ route('admin/orders/cancel', $order->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Скасувати замовлення</button>
                </form>
            @else
                <div class="alert alert-warning">Замовлення скасовано</div>
            @endif
        </div>
    </div>
@endsection
<style>
.order-details {
    background: #fff;
    border-radius: 8px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    margin-top: 30px;
}
.order-details img {
    border-radius: 6px;
    margin-top: 8px;
}
</style>

