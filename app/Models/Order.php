<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

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

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }   

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}