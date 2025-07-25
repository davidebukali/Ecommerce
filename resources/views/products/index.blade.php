<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')
@section('content')
<h1>Products</h1>
<div class="product-list">
    @if ($products->isEmpty())
    <div class="empty-state">
        <p>No products available yet.</p>
        <a href="{{ route('products.index') }}" class="button-primary">Refresh</a>
    </div>
    @else
    @foreach($products as $product)
    @include('components.product-card', ['product' => $product, 'mainImage' => $product->mainImage])
    @endforeach
    @endif
</div>
<script>
    window.userOrderIds = @json($orderIds);
</script>
@endsection
