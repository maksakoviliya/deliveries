<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Recipient;
use App\Models\User;
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

    public function allOrders(Request $request)
    {
        return OrderResource::collection(Order::orderBy('created_at', 'desc')->paginate(10));
    }


    public function store(Request $request)
    {
        $request->validate([
            "recipient_id" => "nullable",
            "type" => "required|in:foot,car",
            "delivery_interval" => "required|array",
            "assessed_value" => "nullable",
            "cod" => "nullable|boolean",
            "cod_price" => "required_with:cod",
            "payment_type" => "required|in:cash,card",
            "price" => "required",
            "comment" => "nullable",
            "weight" => "required",
            "quantity" => "required|alpha_num|min:0",
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
            'cod_price' => $request->input('cod_price'),
            'cod' => $request->input('cod') ? $request->input('cod') : false,
            'payment_type' => $request->input('payment_type'),
            'user_id' => Auth::user()->id,
            'comment' => $request->input('comment'),
            'quantity' => $request->input('quantity'),
        ]);
        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(Order $order, Request $request)
    {
        $request->validate([
            "recipient_id" => "nullable",
            "type" => "required|in:foot,car",
            "delivery_interval" => "required|array",
            "assessed_value" => "nullable",
            "cod" => "nullable|boolean",
            "cod_price" => "required_with:cod",
            "payment_type" => "required|in:cash,card",
            "price" => "required",
            "comment" => "nullable",
            "weight" => "nullable",
            "status" => "required|in:processing,work,delivered,undelivered",
            "quantity" => "required|alpha_num|min:0",
        ]);

        $recipient_data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'product_name' => $request->input('product_name'),
            'user_id' => $order->user_id,
        ];

        if ($order->recipient) {
            $order->recipient->update($recipient_data);
            $recipient = $order->recipient;
        } else {
            $recipient = Recipient::create($recipient_data);
        }


        $order->update([
            'type' => $request->input('type'),
            'recipient_id' => $recipient->id,
            'delivery_from' => Carbon::parse($request->input('delivery_interval')[0]),
            'delivery_to' => Carbon::parse($request->input('delivery_interval')[1]),
            'assessed_value' => $request->input('assessed_value'),
            'weight' => $request->input('weight'),
            'price' => $request->input('price'),
            'cod' => $request->input('cod') ? $request->input('cod') : false,
            'cod_price' => $request->input('cod_price'),
            'payment_type' => $request->input('payment_type'),
            'comment' => $request->input('comment'),
            'status' => $request->input('status'),
            'courier_id' => $request->input('courier_id'),
            'quantity' => $request->input('quantity'),
        ]);
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        if (Auth::user()->role_id == User::ROLE_ADMIN || $order->status == 'processing') {
            return $order->delete();
        }
        abort(403);
    }

    public function setOrderStatus(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->input('status')
        ]);

        return new OrderResource($order);
    }

    public function setOrderCourier(Request $request, Order $order)
    {
        $order->update([
            'courier_id' => $request->input('courier_id')
        ]);

        return new OrderResource($order);
    }

    public function setOrderPayment(Request $request, Order $order)
    {
        $order->update([
            'payment' => $request->input('payment')
        ]);

        return new OrderResource($order);
    }
}
