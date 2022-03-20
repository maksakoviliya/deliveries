<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CourierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $is_admin = $request->user()->role_id == User::ROLE_ADMIN;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'comment' => $this->when($is_admin, $this->comment),
            'orders_count' => $this->when($is_admin, $this->orders_count)
        ];
    }
}
