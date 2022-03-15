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

//    public function name(): Attribute
//    {
//        return new Attribute(
//            get: fn ($value) => strtoupper($value),
//        );
//    }
}
