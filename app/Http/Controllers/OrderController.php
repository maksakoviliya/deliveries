<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return OrderResource::collection(Order::paginate(10));
    }


    public function store(Request $request)
    {
        $request->validate([
            "recipient_id" => "nullable",
            "type" => "required|in:foot,car",
            "delivery_interval" => "required|array",
            "assessed_value" => "nullable",
            "cod" => "boolean",
            "payment_type" => "required|in:cash,card",
            "comment" => "nullable",
            "weight" => "nullable",
        ]);
        $order = Order::create([
            'type' => $request->input('type'),
            'recipient_id' => $request->input('recipient_id'),
            'delivery_from' => Carbon::parse($request->input('delivery_interval')[0]),
            'delivery_to' => Carbon::parse($request->input('delivery_interval')[1]),
            'assessed_value' => $request->input('assessed_value'),
            'weight' => $request->input('weight'),
            'cod' => $request->input('cod'),
            'payment_type' => $request->input('payment_type'),
            'comment' => $request->input('comment'),
        ]);
        return new OrderResource($order);
    }
}
