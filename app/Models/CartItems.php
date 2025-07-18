<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

class CartItems extends Model
{
    protected $table = 'cart_items';
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'price', 'total'];

    public function Cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
