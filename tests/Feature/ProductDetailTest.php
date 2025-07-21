<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product; // Import your Product model
use App\Models\ProductImage;   // Import your Image model (assuming products have images)

class ProductDetailTest extends TestCase
{
    use RefreshDatabase; // This trait resets the database for each test method
    
    /**
     * A basic feature test example.
     */
    public function test_product_details_are_displayed_on_details_page(): void
    {
        $test_product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 9.99,
            'description' => 'This is a test product description.'
        ]);

        ProductImage::factory()->create([
            'image_path' => 'products/test-product.webp',
            'is_main' => true,
            'product_id' => $test_product->id,
        ]);

        $response = $this->get(route('products.show', $test_product->id));

        $response->assertStatus(200);

        $response->assertSeeText($test_product->name);
        $response->assertSeeText($test_product->price);
        $response->assertSeeText($test_product->description);
    }
}
