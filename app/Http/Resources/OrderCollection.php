<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $delivered = $this->collection->where('status', 'delivered')->count();
        $undelivered = $this->collection->where('status', 'undelivered')->count();
        $price = $this->collection->sum('price');
        $payed = $this->collection->where('payment', 'payed')->sum('price');
        return [
            'data' => $this->collection,
            'analytics' => [
                'delivered' => round($delivered, 2),
                'undelivered' => round($undelivered, 2),
                'total_price' => round($price, 2),
                'payed' => round($payed, 2),
                'debt' => round($price - $payed, 2),
            ],
        ];
    }
}
