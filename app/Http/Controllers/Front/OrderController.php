<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LiqPay;
use App\Models\Order;

class OrderController extends Controller
{
    public function showPaymentForm(Order $order)
    {
        return view('front.template-parts.pay', compact('order'));
    }

    public function show(Order $order)
    {
        // Можна додати перевірку статусу оплати, якщо потрібно
        return view('front.orders.show', compact('order'));
    }

}
