<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class LiqPayController extends Controller
{
    public function callback(Request $request)
    {
        $data = json_decode(base64_decode($request->input('data')), true);
        $signature = base64_encode(sha1(env('LIQPAY_PRIVATE_KEY') . $request->input('data') . env('LIQPAY_PRIVATE_KEY'), 1));

        if ($signature !== $request->input('signature')) {
            return response('Invalid signature', 403);
        }

        $order = Order::find($data['order_id'] ?? null);

        if ($order) {
            $order->liqpay_payment_id = $data['payment_id'] ?? null;
            $order->payment_status = $data['status'] === 'success' ? 'paid' : 'failed';
            $order->save();
        }

        return response('OK', 200);
    }
}
