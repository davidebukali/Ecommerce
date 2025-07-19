<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\CartItems;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'status'];

    public function items()
    {
        return $this->hasMany(CartItems::class);
    }
}
