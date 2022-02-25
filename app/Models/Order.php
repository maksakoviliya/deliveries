<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    protected $casts = [
        'delivery_from' => 'date',
        'delivery_to' => 'date'
    ];

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }
}
