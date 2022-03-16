<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ActResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $client = [];
        if (Auth::user()->isAdmin()) {
            $client = [
                'client' => new UserResource($this->client)
            ];
        }
        return array_merge([
            'id' => $this->id,
            'totalPrice' => $this->totalPrice,
            'totalQuantity' => $this->totalQuantity,
            'totalWeight' => $this->totalWeight,
            'totalCodPrice' => $this->totalCodPrice,
            'orders_count' => count($this->orders),
            'created_at' => $this->created_at
        ], $client);
    }
}
