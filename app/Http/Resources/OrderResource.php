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
        if ($this->recipient) {
            $recipient = [
                'recipient_id' => $this->recipient->id,
                'name' => $this->recipient->name,
                'address' => $this->recipient->address,
                'phone' => $this->recipient->phone,
                'product_name' => $this->recipient->product_name,
            ];
        }

        $client = [];
        if (Auth::user()->role_id == User::ROLE_ADMIN) {
            $client = [
                'client' => new UserResource($this->client)
            ];
        }

        return array_merge([
            'id' => $this->id,
            'delivery_interval' => [
                $this->delivery_from,
                $this->delivery_to,
            ],
            'cod' => (bool) $this->cod,
            'payment_type' => $this->payment_type,
            'courier' => new CourierResource($this->courier),
            'price' => $this->price,
            'act_id' => $this->act_id,
            'status' => $this->status,
            'type' => $this->type,
            'weight' => $this->weight,
            'comment' => $this->comment,
            'assessed_value' => $this->assessed_value,
            'created_at' => $this->created_at,

        ], $recipient, $client);
    }
}
