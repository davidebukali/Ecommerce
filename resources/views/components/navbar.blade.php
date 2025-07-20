<div class="navbar">
    <!-- Left: Logo / Links -->
    <div class="flex items-center space-x-4">
        <a href="{{route('products.index')}}" class="text-xl font-bold text-green-600">Instacart Clone</a>
    </div>

    <!-- Right: Cart and User -->
    <div class="flex">
        <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-green-600">
            🛒
            <span
                class="absolute -top-2 -right-2 bg-green-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                <livewire:cart-counter />
            </span>
        </a>
        @auth
        {{-- This is how you call your new Blade component --}}
        <x-user-profile-dropdown :user="Auth::user()" />
        @else
        <a href="{{ route('login') }}" class="nav-link">Login</a>
        <a>|</a>
        <a href="{{ route('register') }}" class="nav-link button-primary-small">Register</a>
        @endauth
    </div>
</div>
