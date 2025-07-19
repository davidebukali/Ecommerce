@extends('layouts.app')

@section('content')
<div class="product-detail-container">
    <div class="product-image-gallery">
        {{-- Main Product Image --}}
        <div class="main-image-wrapper">
            @if ($product->mainImage)
            <img id="mainProductImage" src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                alt="{{ $product->name }}">
            @else
            <img id="mainProductImage" src="{{ asset('storage/default.webp') }}" alt="{{ $product->name }}">
            @endif
        </div>

        {{-- Image Gallery Thumbnails --}}
        @if ($product->images->count() > 0)
        <div class="thumbnail-gallery">
            @foreach ($product->images->sortByDesc('is_main') as $image) {{-- Sort to show main image first if desired
            --}}
            <div class="thumbnail-item {{ $image->is_main ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }} Thumbnail"
                    data-full-image="{{ asset('storage/' . $image->image_path) }}" onclick="changeMainImage(this)">
            </div>
            @endforeach
        </div>
        @elseif (!$product->mainImage) {{-- Only show default thumbnail if no images at all --}}
        <div class="thumbnail-gallery">
            <div class="thumbnail-item active">
                <img src="{{ asset('storage/default.webp') }}" alt="{{ $product->name }} Default Thumbnail"
                    data-full-image="{{ asset('storage/default.webp') }}" onclick="changeMainImage(this)">
            </div>
        </div>
        @endif
    </div>

    <div class="product-details-content">
        <h1 class="product-title">{{ $product->name }}</h1>
        <p class="product-description">{{ $product->description }}</p>

        <div class="product-price">
            ${{ number_format($product->price, 2) }}
        </div>

        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
            @csrf
            <div class="quantity-selector">
                <button type="button" class="quantity-button decrease" data-action="decrease">-</button>
                <input type="text" name="quantity" value="1" min="1" class="quantity-input" readonly>
                <button type="button" class="quantity-button increase" data-action="increase">+</button>
            </div>
            <input type="hidden" name="price" value="{{ $product->price }}">
            <button type="submit" class="add-to-cart-button">Add to Cart</button>
        </form>

        {{-- You can add more details here if needed, like availability, categories, etc. --}}
        <div class="product-meta">
            {{-- <p>Category: <a href="#">Fresh Produce</a></p> --}}
            {{-- <p>Availability: In Stock</p> --}}
        </div>
    </div>
</div>

<script>
    function changeMainImage(thumbnail) {
        document.getElementById('mainProductImage').src = thumbnail.dataset.fullImage;

        // Remove 'active' class from all thumbnails
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
        });
        // Add 'active' class to the clicked thumbnail's parent
        thumbnail.closest('.thumbnail-item').classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const quantityInput = document.querySelector('.quantity-input');
        const decreaseButton = document.querySelector('.quantity-button.decrease');
        const increaseButton = document.querySelector('.quantity-button.increase');

        decreaseButton.addEventListener('click', function () {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        increaseButton.addEventListener('click', function () {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });
    });
</script>
@endsection
