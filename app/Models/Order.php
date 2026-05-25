<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_address',
        'phone',
        'notes',
        'payment_proof',
        'paid_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [

        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}