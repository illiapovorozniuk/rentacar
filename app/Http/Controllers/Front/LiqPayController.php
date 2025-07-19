<?php

namespace App\Http\Controllers\Front;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LiqPay;
use App\Models\Order;

class LiqPayController extends Controller
{
    public function generateForm(Order $order)
    {
        $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
        $order->load('currency');
        $form = $liqpay->cnb_form([
            'action'       => 'pay',
            'amount'       => $order->total_price,
            'currency'     =>  strtoupper($order->currency->slug),
            'description'  => 'Оплата замовлення №' . $order->id,
            'order_id'     => $order->id,
            'version'      => '3',
            'server_url'   => str_replace('http://','https://',route('liqpay.callback')),
            'result_url'   => str_replace('http://','https://',route('orders.show', $order)), // Після оплати
        ]);

        return view('front.template-parts.liqpay_form', compact('form'));
    }
    public function callback(Request $request)
    {
        \Log::info('LiqPay callback received', [
            'data' => $request->input('data'),
            'signature' => $request->input('signature'),
            'all' => $request->all(),
        ]);
        $liqpay = new LiqPay(env('LIQPAY_PUBLIC_KEY'), env('LIQPAY_PRIVATE_KEY'));
        $data = $request->input('data');
        $signature = $request->input('signature');

        // Перевірка підпису
        $generatedSignature = base64_encode(sha1(
            env('LIQPAY_PRIVATE_KEY') . $data . env('LIQPAY_PRIVATE_KEY'),
            true
        ));

        if ($signature !== $generatedSignature) {
            return response('Invalid signature', 403);
        }

        $decodedData = json_decode(base64_decode($data), true);

        if (!$decodedData || !isset($decodedData['order_id'])) {
            return response('Invalid data', 400);
        }

        $order = Order::find($decodedData['order_id']);
        if (!$order) {
            return response('Order not found', 404);
        }

        // Оновлення статусу замовлення та збереження liqpay_payment_id і payment_status
        if ($decodedData['status'] === 'success' || $decodedData['status'] === 'sandbox') {
            $order->payment_status = 'paid'; // або ваш статус
            $order->status = OrderType::STATUS_CONFIRMED->value; // або ваш статус
            $order->liqpay_payment_id = $decodedData['payment_id'] ?? null;
            $order->save();
        } elseif ($decodedData['status'] === 'failure') {
            $order->payment_status = 'failed'; // або ваш статус
            $order->liqpay_payment_id = $decodedData['payment_id'] ?? null;
            $order->save();
        }

        return response('OK', 200);
    }
}
