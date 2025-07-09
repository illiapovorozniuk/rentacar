<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LiqPay;
use App\Models\Order;

class LiqPayController extends Controller
{
    public function generateForm(Order $order)
    {
        $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));

        $form = $liqpay->cnb_form([
            'action'       => 'pay',
            'amount'       => $order->total_price,
            'currency'     => 'UAH',
            'description'  => 'Оплата замовлення №' . $order->id,
            'order_id'     => $order->id,
            'version'      => '3',
            'server_url'   => str_replace('http://','https://',route('liqpay.callback')),
            'result_url'   => str_replace('http://','https://',route('orders.show', $order)), // Після оплати
        ]);
       
        return view('front.template-parts.liqpay_form', compact('form'));
    }
}
