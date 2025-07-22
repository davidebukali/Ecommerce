<div>
    @if($cartCount > 0)
    {{-- This content will only be rendered if cartCount is greater than 0 --}}
    <span
        class="absolute -top-2 -right-2 bg-green-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
        <span id="cart-counter">{{ $cartCount }}</span>
    </span>
    @endif
</div>
