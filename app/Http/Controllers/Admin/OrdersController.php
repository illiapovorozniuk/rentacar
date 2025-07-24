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
}
