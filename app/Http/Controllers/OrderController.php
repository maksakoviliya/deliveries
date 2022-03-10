<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Recipient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', Auth::user()->id);
        return OrderResource::collection($orders->orderBy('created_at', 'desc')->paginate(10));
    }


    public function store(Request $request)
    {
        $request->validate([
            "recipient_id" => "nullable",
            "type" => "required|in:foot,car",
            "delivery_interval" => "required|array",
            "assessed_value" => "nullable",
            "cod" => "nullable|boolean",
            "payment_type" => "required|in:cash,card",
            "price" => "required",
            "comment" => "nullable",
            "weight" => "nullable",
        ]);

        $recipient = Recipient::updateOrCreate([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'product_name' => $request->input('product_name'),
            'user_id' => Auth::user()->id,
        ]);


        $order = Order::create([
            'type' => $request->input('type'),
            'recipient_id' => $recipient->id,
            'delivery_from' => Carbon::parse($request->input('delivery_interval')[0]),
            'delivery_to' => Carbon::parse($request->input('delivery_interval')[1]),
            'assessed_value' => $request->input('assessed_value'),
            'weight' => $request->input('weight'),
            'price' => $request->input('price'),
            'cod' => $request->input('cod') ? $request->input('cod') : false,
            'payment_type' => $request->input('payment_type'),
            'user_id' => Auth::user()->id,
            'comment' => $request->input('comment'),
        ]);
        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
