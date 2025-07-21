<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product; // Import your Product model
use App\Models\ProductImage;   // Import your Image model (assuming products have images)

class ProductTest extends TestCase
{
    use RefreshDatabase; // This trait resets the database for each test method

    /**
     * Test that the product listing page loads successfully.
     *
     * @return void
     */
    public function test_product_listing_page_loads_successfully(): void
    {
        // Act: Make a GET request to the products index route
        $response = $this->get(route('products.index'));

        // Assert: The page loads successfully (HTTP 200 OK)
        $response->assertStatus(200);

        // Assert: The page contains the expected title or a key element
        // Assuming your products.index view has a title like "Our Products" or similar
        $response->assertSeeText('Products'); // Adjust this text to match your actual page title/heading
    }

    /**
     * Test that products are displayed on the listing page.
     *
     * @return void
     */
    public function test_products_are_displayed_on_listing_page(): void
    {
        // Arrange: Create some test products with images
        $product1 = Product::factory()->create([
            'name' => 'Fresh Apples',
            'price' => 1.99,
            'description' => 'Crisp and juicy red apples.'
        ]);
        // Create a main image for product1
        ProductImage::factory()->create([
            'image_path' => 'products/apples.webp',
            'is_main' => true,
            'product_id' => $product1->id,
        ]);


        $product2 = Product::factory()->create([
            'name' => 'Organic Bananas',
            'price' => 0.79,
            'description' => 'Sweet and ripe organic bananas.'
        ]);
        // Create a main image for product2
        ProductImage::factory()->create([
            'image_path' => 'products/bananas.webp',
            'is_main' => true,
            'product_id' => $product2->id,
        ]);


        // Act: Make a GET request to the products index route
        $response = $this->get(route('products.index'));

        // Assert: The page loads successfully
        $response->assertStatus(200);

        // Assert: The product names and prices are visible on the page
        $response->assertSeeText($product1->name);
        $response->assertSeeText('$' . number_format($product1->price, 2));
        $response->assertSeeText($product2->name);
        $response->assertSeeText('$' . number_format($product2->price, 2));

        // Assert: The product images are visible (by checking the image path)
        // This assumes your product listing shows the main image
        $response->assertSee(asset('storage/' . $product1->mainImage->image_path));
        $response->assertSee(asset('storage/' . $product2->mainImage->image_path));
    }
}
