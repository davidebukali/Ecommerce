<!-- resources/views/cart/index.blade.php -->
@extends('layouts.app')
@section('content')
<h1>Your Cart</h1>
@foreach($cartItems as $item)
<div class="cart-item">
    <div>{{ $item->product->name }} × {{ $item->quantity }}</div>
    <div>${{ number_format($item->product->price * $item->quantity,2) }}</div>
</div>
@endforeach
<a href="{{ route('checkout.index') }}" class="view-details">Proceed to Checkout</a>
@endsection
