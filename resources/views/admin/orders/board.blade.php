@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.order.actions.index'))
@section('body')
    <div class="container">
        <h1>Дошка замовлень</h1>
        <div class="orders-board">
            <div class="orders-section">
                <h2>Майбутні замовлення</h2>
                @forelse($upcoming as $order)

                    <a href="{{ route('admin/orders/show', $order->id) }}" @class([
    'order-card first_col',
    'cancelled' => $order->status == \App\Enums\OrderType::PAYMENT_CANCELLED->value
])>

                        <img src="{{ url('uploads') }}/images/brands/{{$order->car_info['brand_slug']}}.webp" alt="Icon"
                             style="max-height: 30px;">
                        <div class="info">

                            <div
                                class="name">{{$order->car_info->car_slug .' '. $order->car_info->attribute_year}}
                                [{{$order->car_info->registration_number}}] |
                                <b>{{ $order->user->name }}</b></div>
                            <div>
                                {{\Carbon\Carbon::parse($order->date_from)->locale(App::getLocale())->isoFormat('D MMMM Y')}}{{$order->date_from !==$order->date_to?' – '. \Carbon\Carbon::parse($order->date_to)->locale(App::getLocale())->isoFormat('D MMMM Y'):''}}
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Немає майбутніх замовлень.</p>
                @endforelse
            </div>
            <div class="orders-section">
                <h2>В процесі</h2>
                @forelse($inProgress as $order)
                    <a href="{{ route('admin/orders/show', $order->id) }}" @class([
    'order-card second_col',
    'cancelled' => $order->status == \App\Enums\OrderType::PAYMENT_CANCELLED->value
])>

                        <img src="{{ url('uploads') }}/images/brands/{{$order->car_info['brand_slug']}}.webp" alt="Icon"
                             style="max-height: 30px;">
                        <div class="info">

                            <div
                                class="name">{{$order->car_info->car_slug .' '. $order->car_info->attribute_year}}
                                [{{$order->car_info->registration_number}}] |
                                <b>{{ $order->user->name }}</b></div>
                            <div>
                                {{\Carbon\Carbon::parse($order->date_from)->locale(App::getLocale())->isoFormat('D MMMM Y')}}{{$order->date_from !==$order->date_to?' – '. \Carbon\Carbon::parse($order->date_to)->locale(App::getLocale())->isoFormat('D MMMM Y'):''}}
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Немає замовлень в процесі.</p>
                @endforelse
            </div>
            <div class="orders-section">
                <h2>Завершені (останні 2 дні)</h2>
                @forelse($finished as $order)
                    <a  href="{{ route('admin/orders/show', $order->id) }}" @class([
    'order-card third_col',
    'cancelled' => $order->status == \App\Enums\OrderType::PAYMENT_CANCELLED->value
])>

                        <img src="{{ url('uploads') }}/images/brands/{{$order->car_info['brand_slug']}}.webp" alt="Icon"
                             style="max-height: 30px;">
                        <div class="info">

                            <div
                                class="name">{{$order->car_info->car_slug .' '. $order->car_info->attribute_year}}
                                [{{$order->car_info->registration_number}}] |
                                <b>{{ $order->user->name }}</b></div>
                            <div>
                                {{\Carbon\Carbon::parse($order->date_from)->locale(App::getLocale())->isoFormat('D MMMM Y')}}{{$order->date_from !==$order->date_to?' – '. \Carbon\Carbon::parse($order->date_to)->locale(App::getLocale())->isoFormat('D MMMM Y'):''}}
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Немає завершених замовлень за останні 2 дні.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
<style>
    .orders-board {
        display: flex;
        gap: 30px;
        margin-top: 30px;
    }

    .orders-section {
        flex: 1;
        background: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .cancelled {
        background: rgba(255, 0, 0, 0.3) !important;
    }

    .order-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 12px;
        margin-bottom: 12px;
        display: flex;
        gap: 10px;
        text-decoration: none;
        color: #000;

        &:hover {
            text-decoration: none;
            color: #000;
        }

        .info {
            display: flex;
            flex-direction: column;
            white-space: nowrap;
        }
    }

    .first_col {
        background: rgba(255, 158, 47, 0.3);
    }
    .second_col {
        background: rgba(47, 175, 255, 0.3);
    }
    .third_col {
        background: rgba(116, 255, 47, 0.3);
    }

</style>
