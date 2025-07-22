<div class="navbar">
    <!-- Left: Logo / Links -->
    <div class="flex items-center space-x-4">
        <a href="{{route('products.index')}}" class="text-xl font-bold text-green-600">Instacart Clone</a>
    </div>

    <!-- Right: Cart and User -->
    <div class="flex">
        <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-green-600 mr-3">
            🛒
            <livewire:cart-counter />
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
