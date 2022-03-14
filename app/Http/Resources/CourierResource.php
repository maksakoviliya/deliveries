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
        $comment = [];
        if (Auth::user()->role_id == User::ROLE_ADMIN) {
            $comment = [
                'comment' => $this->comment,
                'orders_count' => count($this->orders)
            ];
        }

        return array_merge(
            [
                'id' => $this->id,
                'name' => $this->name,
                'phone' => $this->phone,
            ],
            $comment
        );
    }
}
