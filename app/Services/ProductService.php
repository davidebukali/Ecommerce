<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getProducts()
    {
        $products = Product::with(['images', 'mainImage'])->get();
        return $products;
    }

    public function getProductById($id)
    {
        return Product::with(['images', 'mainImage'])->findOrFail($id);
    }
}
