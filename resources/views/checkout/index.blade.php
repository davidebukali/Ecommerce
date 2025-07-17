<!-- resources/views/checkout/index.blade.php -->
@extends('layouts.app')
@section('content')
<h1>Checkout</h1>
<form class="checkout-form" action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <input type="text" name="address" placeholder="Shipping Address" required>
    <button type="submit">Place Order</button>
</form>
@endsection
