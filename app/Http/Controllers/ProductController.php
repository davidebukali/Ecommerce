<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Create a sample array of products for demonstration
        // add a random image_url to each product
        $products = collect(range(1, 10))->map(function ($id) {
            return (object) [
                'id' => $id,
                'name' => 'Product ' . $id,
                'description' => 'Description for Product ' . $id,
                'price' => 10.00 * $id,
                'image_url' => 'https://picsum.photos/200/300',
            ];
        });
        
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // For demonstration, we'll create a sample product
        $product = (object) ['id' => $id, 'name' => 'Product ' . $id, 'description' => 'Description for Product ' . $id, 'price' => 10.00 * $id, 'image_url' => 'https://picsum.photos/50/50'];
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
