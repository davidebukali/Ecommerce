<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')
@section('content')
<h1>Products</h1>
<div class="product-list">
    @foreach($products as $product)
    @include('components.product-card', ['product' => $product])
    @endforeach
</div>
@endsection
