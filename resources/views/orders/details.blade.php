@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1 class="page-title">Order #{{ $order->order_number }}</h1>
    <a href="{{ route('orders.index') }}" class="back-link">&larr; Back to all orders</a>

    <div class="order-details-grid">
        {{-- Order Summary Card --}}
        <div class="details-card">
            <h2 class="card-title">Order Summary</h2>
            <div class="summary-row">
                <span>Order Number:</span>
                <strong>#{{ $order->order_number }}</strong>
            </div>
            <div class="summary-row">
                <span>Order Date:</span>
                <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
            </div>
            <div class="summary-row">
                <span>Payment Method:</span>
                <span>{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</span>
            </div>
            <div class="summary-row">
                <span>Payment Status:</span>
                <span class="status-badge status-{{ strtolower($order->payment_status ?? 'unpaid') }}">
                    {{ ucfirst($order->payment_status ?? 'Unpaid') }}
                </span>
            </div>
            @if ($order->transaction_id)
            <div class="summary-row">
                <span>Transaction ID:</span>
                <span>{{ $order->transaction_id }}</span>
            </div>
            @endif
        </div>

        {{-- Delivery Details Card --}}
        <div class="details-card">
            <h2 class="card-title">Delivery Details</h2>
            <div class="summary-row">
                <span>Delivery Status:</span>
                <span class="status-badge status-{{ strtolower($order->delivery_status ?? 'pending') }}">
                    {{ ucfirst($order->delivery_status ?? 'Pending') }}
                </span>
            </div>
            <div class="summary-row">
                <span>Delivery Address:</span>
                <span>{{ $order->delivery_address }}</span>
            </div>
            @if ($order->delivered_at)
            <div class="summary-row">
                <span>Delivered At:</span>
                <span>{{ $order->delivered_at->format('M d, Y H:i') }}</span>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
