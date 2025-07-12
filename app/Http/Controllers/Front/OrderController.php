<?php

namespace App\Http\Controllers\Front;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Services\LiqPay;
use App\Models\Order;
use Illuminate\Support\Facades\Config;

class OrderController extends Controller
{
    public function showPaymentForm(Order $order)
    {
        return view('front.template-parts.pay', compact('order'));
    }

    public function createOrder(string $car)
    {
        $car = \App\Models\Car::findOrFail($car);
        $locale = app()->getLocale();

        $car = $car->carInfo();

        $h1 = ucwords($car->brand_slug) . ' ' . (json_decode($car->car_model_name)->$locale ?? '') . ' ' . $car->attribute_year . ' ' . (json_decode($car->color_name)->$locale ?? '');

        return view('front.order-create', compact('car', 'h1'));
    }

    public function store(Request $request, Car $car)
    {
        $data = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'pickup_address' => 'nullable|string|max:255',
            'dropoff_address' => 'nullable|string|max:255',
            'currency' => 'required:string:in:uah,usd,eur',
        ]);

        $currency = Currency::where('slug', $data['currency'])->first();
        Config::set('site.current_currency', $currency);
        $days_count = (strtotime($data['date_to']) - strtotime($data['date_from'])) / 86400 + 1;
        $car = $car->carInfo();

        $price_1 = getCurrentPrice($car->price_1);
        $price_7 = getCurrentPrice($car->price_7);
        $price_30 = getCurrentPrice($car->price_30);

        $total_price =0;
        if ($days_count >= 30) {
            $total_price = $price_30;
        } elseif ($days_count >= 7) {
            $total_price = $price_7;
        } else {
            $total_price = $price_1;
        }

        $user = auth()->user();
            $order_data = [
                'user_id' => $user->id,
                'car_id' => $car->id,
                'date_from' => $data['date_from'],
                'date_to' => $data['date_to'],
                'address_from' => $user->address ?? null,
                'address_to' => $user->address ?? null,
                'status' => OrderType::PAYMENT_PENDING->value,
                'total_price' => $total_price * $days_count,
                'currency_id' => $currency->id,
            ];
        $order = Order::create($order_data);

        return response()->json(['redirect_url' => route('orders.pay', $order)]);
    }

    public function show(Order $order)
    {
        // Можна додати перевірку статусу оплати, якщо потрібно
        return view('front.orders.show', compact('order'));
    }


}
