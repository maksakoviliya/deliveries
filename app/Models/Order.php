<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    protected $casts = [
        'delivery_date' => 'datetime:d.m.Y',
        'delivery_interval' => 'array',
        'today' => 'boolean'
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
        if (isset($request_data['client'])) {
            $query->whereIn('user_id', collect($request_data['client']));
        }
        if (isset($request_data['status'])) {
            $query->whereIn('status', collect($request_data['status']));
        }
        if (isset($request_data['payment'])) {
            $query->where('payment', $request_data['payment']);
        }
        if (isset($request_data['delivery_date']) && is_array($request_data['delivery_date'])) {
            $query->whereDate('delivery_date', '>=', Carbon::parse($request_data['delivery_date'][0]))
                ->whereDate('delivery_date', '<=', Carbon::parse($request_data['delivery_date'][1]));
        }
        return $query;
    }
}
