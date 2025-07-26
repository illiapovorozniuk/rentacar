<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Brackets\AdminListing\AdminListing;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        // Default sorting
        if (!$request->has('orderBy') && !$request->has('orderDirection')) {
            $request->merge([
                'orderBy' => 'id',
                'orderDirection' => 'desc',
            ]);
        }
        // AdminListing for Order
        $data = AdminListing::create(Order::class)->processRequestAndGet(
            $request,
            ['id', 'user_id', 'car_id', 'status', 'total_price', 'currency_id','date_from','date_to','created_at'],
            ['id', 'status']
        );
        // Eager load relations for display
        $data->load(['user', 'car.media', 'currency']);
        // Assign carInfo to each car in orders
        foreach ($data as $order) {
            if ($order->car) {
                $order->car_info = $order->car->carInfo();
            }
        }
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return response()->json(['data' => $data]);
        }
//            dd($data[0]);
        return view('admin.orders.index', compact('data'));
    }
    /**
     * Show board with orders split by status: upcoming, in progress, finished (not older than 2 days)
     */
    public function board(Request $request)
    {
        $now = now();
        $twoDaysAgo = $now->copy()->subDays(2)->startOfDay();
        // Upcoming: date_from > now
        $upcoming = \App\Models\Order::with(['car', 'user', 'currency'])
            ->where('date_from', '>', $now)
            ->whereNotNull('liqpay_payment_id')
            ->orderBy('date_from')
            ->get();
        // In progress: date_from <= now && date_to >= now
        $inProgress = \App\Models\Order::with(['car', 'user', 'currency'])
            ->where('date_from', '<=', $now)
            ->where('date_to', '>=', $now)
            ->whereNotNull('liqpay_payment_id')
            ->orderBy('date_from')
            ->get();
        // Finished: date_to < now && date_to >= twoDaysAgo
        $finished = \App\Models\Order::with(['car', 'user', 'currency'])
            ->where('date_to', '<', $now)
            ->where('date_to', '>=', $twoDaysAgo)
            ->whereNotNull('liqpay_payment_id')
            ->orderBy('date_to', 'desc')
            ->get();
        // Assign carInfo to each car in orders
        foreach([$upcoming, $inProgress, $finished] as $orders) {
            foreach ($orders as $order) {
                if ($order->car) {
                    $order->car_info = $order->car->carInfo();
                }
            }
        }
        return view('admin.orders.board', compact('upcoming', 'inProgress', 'finished'));
    }
    /**
     * Show a single order with all details and allow admin to cancel.
     */
    public function show(Request $request, $id)
    {
        $order = \App\Models\Order::with(['car', 'user', 'currency'])->findOrFail($id);
        if ($order->car) {
            $order->car_info = $order->car->carInfo();
        }
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cancel an order as admin.
     */
    public function cancel(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        if ($order->status === \App\Enums\OrderType::PAYMENT_CANCELLED->value) {
            return redirect()->back()->withErrors(['cancel' => 'Order already cancelled.']);
        }
        $order->status = \App\Enums\OrderType::PAYMENT_CANCELLED->value;
        $order->save();
        return redirect()->route('admin/orders/show', $order->id)->with('success', 'Order cancelled successfully.');
    }
}
