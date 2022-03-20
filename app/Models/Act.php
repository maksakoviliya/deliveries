<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function totalPrice(): Attribute
    {
        return new Attribute(
            get: function() {
                return $this->orders()->sum('assessed_value');
            }
        );
    }

    public function totalWeight(): Attribute
    {
        return new Attribute(
            get: function() {
                return $this->orders()->sum('weight');
            }
        );
    }

    public function totalQuantity(): Attribute
    {
        return new Attribute(
            get: function() {
                return $this->orders()->sum('quantity');
            }
        );
    }

    public function totalCodPrice(): Attribute
    {
        return new Attribute(
            get: function() {
                return $this->orders()->sum('cod_price');
            }
        );
    }
}
