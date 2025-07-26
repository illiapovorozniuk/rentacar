<?php

namespace App\Http\Controllers\Front;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Currency;
use App\Services\CarService;
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
        $disabledDates = CarService::getBusyDates($car);

        $h1 = ucwords($car->brand_slug) . ' ' . (json_decode($car->car_model_name)->$locale ?? '') . ' ' . $car->attribute_year . ' ' . (json_decode($car->color_name)->$locale ?? '');

        return view('front.order-create', compact('car', 'h1', 'disabledDates'));
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
        $minDays = $car->min_day_reservation ?? 1;
        if ($days_count < $minDays) {
            return response()->json([
                'error' => str_replace('{days}', $minDays, trans('front.order.min_day_limit'))
            ], 422);
        }

        $price_1 = getCurrentPrice($car->price_1);
        $price_7 = getCurrentPrice($car->price_7);
        $price_30 = getCurrentPrice($car->price_30);
        $isCarFree = CarService::isAvailable($car, $data['date_from'], $data['date_to']);
        if (!$isCarFree) {
            return response()->json(['error' => 'This car is not available for the selected dates.'], 400);
        }

        $total_price = 0;
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

        // Dispatch job to cancel unpaid order after 1 minute
        \App\Jobs\CancelUnpaidOrderJob::dispatch($order->id)->delay(now()->addMinute(10));

        return response()->json(['redirect_url' => route('orders.show', $order)]);
    }

    public function show(Order $order)
    {
        $auth_user = auth()->user();
        $user = $order->user;
        if ($user->id !== $auth_user->id) {
            abort(403, 'Unauthorized action.');
        }

        $locale = app()->getLocale();
        $car = $order->car;
        $car = $car->carInfo();


        $h1 = ucwords($car->brand_slug) . ' ' . (json_decode($car->car_model_name)->$locale ?? '') . ' ' . $car->attribute_year . ' ' . (json_decode($car->color_name)->$locale ?? '');
        // Можна додати перевірку статусу оплати, якщо потрібно
        $form = '';
        if ($order->payment_status !== OrderType::PAYMENT_PAID->value) {
            $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
            $order->load('currency');
            $form = $liqpay->cnb_form([
                'action' => 'pay',
                'amount' => $order->total_price,
                'currency' => strtoupper($order->currency->slug),
                'description' => 'Оплата замовлення №' . $order->id,
                'order_id' => $order->id,
                'version' => '3',
                'server_url' => str_replace('http://', 'https://', route('liqpay.callback')),
                'result_url' => str_replace('http://', 'https://', route('orders.show', $order)), // Після оплати
            ]);
        }

        return view('front.order', compact('order', 'car', 'h1', 'form'));
    }

    public function cancel(Request $request, Order $order)
    {
        $auth_user = auth()->user();
        if ($order->user_id !== $auth_user->id) {
            abort(403, 'Unauthorized action.');
        }
        if (!$order->canBeCancelled()) {
            return redirect()->back()->withErrors(['cancel' => trans('front.order.cannot_cancel')]);
        }
        $order->status = \App\Enums\OrderType::PAYMENT_CANCELLED->value;
        $order->save();
        return redirect()->route('orders.show', $order)->with('success', trans('front.order.cancelled_success'));
    }


}
