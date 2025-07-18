<!-- resources/views/components/product-card.blade.php -->
<div class="product-card">
    @if ($mainImage)
    <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $product->name }}">
    @else
    <img src="{{ asset('storage/default.webp') }}" alt="{{ $product->name }}">
    @endif
    <div class="product-info">
        <h2>{{ $product->name }}</h2>
        <div class="price">${{ number_format($product->price,2) }}</div>
        <a class="view-details" href="{{ route('products.show', $product->id) }}">View Details</a>
    </div>
</div>
