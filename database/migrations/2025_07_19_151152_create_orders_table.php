<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // User who placed the order (nullable for guest orders)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // A unique, human-readable order number (e.g., generated in controller/service)
            $table->string('order_number')->unique();

            // Financial details
            $table->decimal('subtotal', 10, 2); // Sum of item prices
            $table->decimal('delivery_fee', 10, 2)->default(0.00); // Shipping cost
            $table->decimal('total', 10, 2);     // Final total amount

            // Payment method chosen by the customer
            $table->string('payment_method')->nullable(); // e.g., 'cod', 'mobile_money', 'visa'
            $table->string('payment_status')->default('unpaid'); // e.g., 'unpaid', 'paid', 'refunded'
            $table->string('transaction_id')->nullable()->unique(); // For payment gateway reference

            // Delivery information
            $table->text('delivery_address');
            $table->string('delivery_status')->default('pending'); // e.g., 'pending', 'processing', 'shipped', 'delivered'
            $table->timestamp('delivered_at')->nullable(); // When the order was actually delivered

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
