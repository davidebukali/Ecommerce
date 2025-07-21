<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\ProductImage; // Assuming Product has images

class CartTest extends TestCase
{
    use RefreshDatabase; // Resets the database before each test

    /**
     * Test that a product can be added to an authenticated user's cart.
     *
     * @return void
     */
    public function test_authenticated_user_can_add_product_to_cart(): void
    {
        // Arrange: Create a user and a product
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 25.00,
        ]);
        ProductImage::factory()->create(['product_id' => $product->id, 'is_main' => true]);


        $quantity = 2;

        // Act: Authenticate the user and make a POST request to add the product to cart
        $response = $this->actingAs($user)->post(route('cart.add', $product->id), [
            'price' => $product->price,
            'quantity' => $quantity,
        ]);

        // Assert:

        // 2. A success message is flashed to the session
        $response->assertSessionHas('success', 'Product added to cart!'); // Adjust message to match yours

        // 3. The cart and cart item exist in the database
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'status' => 'active', // Assuming you have a 'status' field
        ]);

        $cart = Cart::where('user_id', $user->id)->first();

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            // You might also assert the 'price_at_addition' if you store it on cart item
            // 'price' => $product->price,
        ]);

        // 4. Optionally, check that the quantity has been updated if the item was already in cart
        // (This test focuses on adding a new item, but you can add another test case for updating quantity)
        $this->assertEquals(1, $cart->items->count()); // Ensure only one unique item is in cart
        $this->assertEquals($quantity, $cart->items->first()->quantity);
    }

    /**
     * Test that adding an existing product to cart updates its quantity.
     *
     * @return void
     */
    public function test_adding_existing_product_updates_quantity_in_cart(): void
    {
        // Arrange: Create a user, a product, and an existing cart item
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 10.00,
        ]);
        ProductImage::factory()->create(['product_id' => $product->id, 'is_main' => true]);

        // Create an initial cart for the user
        $cart = Cart::factory()->create(['user_id' => $user->id, 'status' => 'active']);

        // Add the product to the cart with an initial quantity
        $initialQuantity = 1;
        CartItems::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $initialQuantity,
        ]);

        $addedQuantity = 3;

        // Act: Authenticate the user and make a POST request to add the SAME product again
        $response = $this->actingAs($user)->post(route('cart.add', $product->id), [
            'price' => $product->price,
            'quantity' => $addedQuantity,
        ]);

        // Assert:
        $response->assertSessionHas('success', 'Product added to cart!'); // Adjust message

        // The cart item's quantity should now be the sum of initial and added quantities
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $addedQuantity,
        ]);
        // 'cart_id', 'product_id', 'quantity', 'price', 'total'

        // Ensure only one unique item exists for this product in the cart
        $this->assertEquals(1, $cart->items()->where('product_id', $product->id)->count());
    }

    /**
     * Test that guest users can add products to a session-based cart.
     * (Requires your CartController to handle guest sessions)
     *
     * @return void
     */
    public function test_guest_user_can_add_product_to_session_cart(): void
    {
        // Arrange: Create a product
        $product = Product::factory()->create([
            'price' => 5.50,
        ]);
        ProductImage::factory()->create(['product_id' => $product->id, 'is_main' => true]);

        $quantity = 1;

        // Act: Make a POST request as a guest (no actingAs)
        $response = $this->withSession(['cart_id' => 123])->post(route('cart.add', $product->id), [
            'price' => $product->price,
            'quantity' => $quantity,
        ]);

        // Assert:
        $response->assertSessionHas('success', 'Product added to cart!');

        // For guest carts, you'd assert against the session directly or check if a new cart model was created
        // if your CartController creates a database cart for guests and links it to session_id
        $this->assertDatabaseHas('carts', [
            // Assuming your guest cart links to the session ID
            'session_id' => 123,
            'user_id' => null, // No user attached
            'status' => 'active',
        ]);

        $cart = Cart::where('session_id', 123)->first();
        $this->assertNotNull($cart, 'A guest cart should have been created in DB.');

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }

    /**
     * Test that validation works for adding a product to cart (e.g., missing product_id).
     *
     * @return void
     */
    public function test_add_product_to_cart_requires_price_and_quantity(): void
    {
        // Arrange: Create a product
        $product = Product::factory()->create([
            'price' => 5.50,
        ]);
        ProductImage::factory()->create(['product_id' => $product->id, 'is_main' => true]);

        $user = User::factory()->create();

        // Test missing price
        $response = $this->actingAs($user)->post(route('cart.add', $product->id), [
            'quantity' => 1,
        ]);
        $response->assertSessionHasErrors(['price']);
        $response->assertStatus(302); // Redirects back due to validation error
    }
}
