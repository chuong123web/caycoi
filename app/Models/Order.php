<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'total_amount',
        'discount_amount',
        'gift_code_id',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function giftCode()
    {
        return $this->belongsTo(GiftCode::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
