<!-- resources/views/checkout/confirmed.blade.php -->
@extends('layouts.app')

@section('content')
<div class="order-confirmed-container">
    <div class="confirmation-card">
        <div class="confirmation-icon">
            {{-- Instacart-style checkmark icon (using SVG for scalability and easy styling) --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <h1 class="confirmation-title">Order Confirmed!</h1>
        <p class="confirmation-message">Thank you for your purchase. Your order has been successfully placed and is now
            being processed.</p>

        <div class="order-summary-mini">
            <h2 class="summary-mini-heading">Order Summary</h2>
            <p><strong>Order Number:</strong> #{{ $order->order_number ?? 'N/A' }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($order->total ?? 0, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method ? ucfirst(str_replace('_', ' ',
                $order->payment_method)) : 'N/A' }}</p>
            <p><strong>Delivery Address:</strong> {{ $order->delivery_address ?? 'N/A' }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at ? $order->created_at->format('M d, Y H:i') : 'N/A' }}
            </p>
        </div>

        <div class="confirmation-actions">
            <a href="{{ route('orders.details', $order->id ?? '#') }}" class="button-primary">View Order Details</a>
            <a href="{{ route('products.index') }}" class="button-secondary">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
