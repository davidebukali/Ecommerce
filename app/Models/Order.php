<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\User;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'cart_id',

        'order_number',
        
        'subtotal',
        'delivery_fee',
        'total',
        
        'payment_status',
        'payment_method',
        'transaction_id',
        
        'delivery_address',
        'delivery_status',
        'delivered_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
