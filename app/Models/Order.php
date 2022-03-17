<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    protected $casts = [
        'delivery_date' => 'date',
        'delivery_interval' => 'array'
    ];

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function act()
    {
        return $this->belongsTo(Act::class);
    }

    public function scopeFilter($query, $request_data)
    {
        if (!$request_data) {
            return $query;
        }
        if (isset($request_data['status'])) {
            $query->whereIn('status', collect($request_data['status']));
        }
        if (isset($request_data['cod'])) {
            $query->where('cod', $request_data['cod'] === 'yes');
        }
        return $query;
    }
}
