@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1 class="page-title">My Orders</h1>

    @if ($orders->isEmpty())
    <div class="empty-state-card">
        <p class="empty-message">You haven't placed any orders yet.</p>
        <a href="{{ route('products.index') }}" class="button-primary">Start Shopping</a>
    </div>
    @else
    <div class="orders-list-grid">
        @foreach ($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <span class="order-number">Order #{{ $order->order_number }}</span>
                <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
            </div>
            <div class="order-footer">
                <span class="order-total">Total: ${{ number_format($order->total, 2) }}</span>
                <a href="{{ route('orders.details', $order->id) }}" class="button-secondary button-small">View
                    Details</a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination Links --}}
    <div class="pagination-links">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
