@extends('layouts.app') {{-- Assuming you have a base layout --}}

@section('content')
<div class="cart-container">
    @if (!isset($cartItems))
    {{-- This block executes if $cartItems variable was NOT passed to the view at all --}}
    <div class="error-or-loading-state">
        <p>Cart data is currently unavailable. Please refresh the page or try again later.</p>
        {{-- You might also offer to browse products or go to homepage --}}
        <a href="{{ route('products.index') }}" class="button-primary">Browse Products</a>
    </div>
    @elseif ($cartItems->isEmpty())
    {{-- This block executes if $cartItems is defined, but it's an empty collection --}}
    <div class="empty-cart">
        <p>Your cart is empty. Start shopping!</p>
        <a href="{{ route('products.index') }}" class="button-primary">Browse Products</a>
    </div>
    @else
    {{-- This block executes if $cartItems is defined AND it is NOT empty --}}
    <div class="cart-items-list">
        @foreach ($cartItems as $item)
        <div class="cart-item">
            {{-- Your existing item display logic --}}
            <div class="item-image">
                @if ($item->product->mainImage)
                <img src="{{ asset('storage/' . $item->product->mainImage->image_path) }}"
                    alt="{{ $item->product->name }}">
                @else
                <img src="{{ asset('storage/default.webp') }}" alt="{{ $item->product->name }}">
                @endif
            </div>
            <div class="item-details">
                <h2 class="item-name">{{ $item->product->name }}</h2>
                <p class="item-price">${{ number_format($item->product->price, 2) }}</p>
                <div class="item-quantity-controls">
                    <form action="{{ route('cart.update', $item->product->id) }}" method="POST"
                        class="quantity-update-form">
                        @csrf
                        @method('PATCH')
                        <button type="button" class="quantity-button decrease" data-action="decrease"
                            data-product-id="{{ $item->product->id }}">-</button>
                        <input type="text" name="quantity" value="{{ $item->quantity }}" min="1" class="quantity-input"
                            readonly>
                        <button type="button" class="quantity-button increase" data-action="increase"
                            data-product-id="{{ $item->product->id }}">+</button>
                    </form>
                    <form action="{{ route('cart.remove', $item->product->id) }}" method="POST"
                        class="remove-item-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="remove-item-button">Remove</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- And then your summary and checkout section (only show if cart is not empty) --}}
    <div class="cart-summary-section">
        <h2 class="summary-title">Order Summary</h2>
        <div class="summary-details">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Delivery Fee:</span>
                <span>$500</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span>${{ number_format(($subtotal + 500), 2) }}</span>
            </div>
        </div>

        <div class="customer-address-section">
            <h2 class="section-title">Delivery Address</h2>
            <textarea name="delivery_address" placeholder="Enter your full delivery address..." rows="4"
                class="address-textarea">{{ old('delivery_address', $customerAddress ?? '') }}</textarea>
            @error('delivery_address')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="payment-options-section">
            <h2 class="section-title">Payment Method</h2>
            <div class="payment-option">
                <input type="radio" id="payment_cod" name="payment_method" value="cod" checked>
                <label for="payment_cod">Cash on Delivery (COD)</label>
            </div>
            <div class="payment-option">
                <input type="radio" id="payment_mobile_money" name="payment_method" value="mobile_money">
                <label for="payment_mobile_money">Mobile Money (e.g., M-Pesa, MTN MoMo)</label>
            </div>
            <div class="payment-option">
                <input type="radio" id="payment_visa" name="payment_method" value="visa">
                <label for="payment_visa">Credit/Debit Card (Visa/Mastercard)</label>
            </div>
            @error('payment_method')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="checkout-button">Proceed to Checkout</button>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.quantity-update-form').forEach(form => {
            const quantityInput = form.querySelector('.quantity-input');
            const decreaseButton = form.querySelector('.quantity-button.decrease');
            const increaseButton = form.querySelector('.quantity-button.increase');
            const productId = decreaseButton.dataset.productId; // Get product ID from button

            decreaseButton.addEventListener('click', function () {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                    // In a real application, you'd submit this change via AJAX
                    // For now, this just updates the input.
                    // Example AJAX call: updateCartItem(productId, quantityInput.value);
                }
            });

            increaseButton.addEventListener('click', function () {
                let currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
                // In a real application, you'd submit this change via AJAX
                // Example AJAX call: updateCartItem(productId, quantityInput.value);
            });
        });
    });

    // Placeholder for AJAX update function (for demonstration)
    // function updateCartItem(productId, newQuantity) {
    //     fetch(`/cart/update/${productId}`, {
    //         method: 'PATCH',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         },
    //         body: JSON.stringify({ quantity: newQuantity })
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             // Update total/subtotal on the page if returned from backend
    //             console.log('Cart updated successfully:', data);
    //         } else {
    //             console.error('Failed to update cart:', data);
    //         }
    //     })
    //     .catch(error => console.error('Error updating cart:', error));
    // }
</script>
@endsection
