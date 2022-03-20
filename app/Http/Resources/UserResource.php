<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'isAdmin' => $this->isAdmin(),
            'emailVerified' => $this->email_verified_at,
            'orders_count' => $this->orders->count(),
            'company' => $this->when('company', new CompanyResource($this->company)),
            'tarif' => $this->company ? new TarifResource($this->company->tarif) : null
        ];
    }
}
