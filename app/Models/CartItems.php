<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItems extends Model
{
    use HasFactory;
    
    protected $table = 'cart_items';
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'price', 'total'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
