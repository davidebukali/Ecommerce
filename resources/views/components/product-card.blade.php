<!-- resources/views/components/product-card.blade.php -->
<div class="product-card">
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
    <div class="product-info">
        <h2>{{ $product->name }}</h2>
        <div class="price">${{ number_format($product->price,2) }}</div>
        <a class="view-details" href="{{ route('products.show', $product->id) }}">View Details</a>
    </div>
</div>
