<!-- resources/views/products/show.blade.php -->
@extends('layouts.app')
@section('content')
<div class="product-detail">
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
    <div class="detail-info">
        <h1>{{ $product->name }}</h1>
        <p>{{ $product->description }}</p>
        <div class="price">${{ number_format($product->price,2) }}</div>
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <input type="number" name="quantity" value="1" min="1" class="quantity-input">
            <button type="submit" class="view-details">Add to Cart</button>
        </form>
    </div>
</div>
@endsection
