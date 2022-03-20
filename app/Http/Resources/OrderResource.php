<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $recipient = [];
//        if ($this->recipient) {
//            $recipient = [
//                'recipient_id' => $this->recipient->id,
//                'name' => $this->recipient->name,
//                'address' => $this->recipient->address,
//                'phone' => $this->recipient->phone,
//                'product_name' => $this->recipient->product_name,
//            ];
//        }

        return array_merge([
            'id' => $this->id,
            'delivery_date' => $this->delivery_date,
            'delivery_interval' => $this->delivery_interval,
            'cod' => (bool) $this->cod,
            'cod_price' => $this->cod_price,
            'payment_type' => $this->payment_type,
            'courier' => new CourierResource($this->courier),
            'price' => $this->price,
            'act_id' => $this->act_id,
            'status' => $this->status,
            'payment' => $this->payment,
            'type' => $this->type,
            'client' => $this->when($request->user()->isAdmin(), new UserResource($this->client)),
            'weight' => $this->weight,
            'quantity' => $this->quantity,
            'comment' => $this->comment,
            'assessed_value' => $this->assessed_value,
            'created_at' => $this->created_at,

        ], $recipient);
    }
}
