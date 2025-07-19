<!-- resources/views/components/navbar.blade.php -->
<div class="navbar">
    <a href="{{ route('products.index') }}">Home</a>
    <a href="{{ route('cart.index') }}">Cart (<livewire:cart-counter />)</a>
</div>
