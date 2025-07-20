<div x-data="{ open: false }" @click.away="open = false" class="relative">
    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
        {{-- User Profile Photo --}}
        <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=FFFFFF&background=1A73E8' }}"
            alt="{{ $user->name }} Profile Photo"
            class="w-8 h-8 rounded-full border border-gray-300 shadow-sm user-profile-photo">
        {{-- User Name --}}
        <span class="text-gray-800 font-medium hidden sm:inline user-profile-name">{{ $user->name }}</span>
        {{-- Dropdown Arrow Icon --}}
        <svg class="w-4 h-4 text-gray-600 dropdown-arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Dropdown Menu --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-50 user-dropdown-menu">
        {{-- Logout Form (Standard Laravel Form) --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf {{-- CSRF token is essential for POST forms in Laravel --}}
            <button type="submit"
                class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-sm text-gray-700 dropdown-item">
                Logout
            </button>
        </form>
        {{-- You can add more dropdown items here, e.g., Profile, Settings --}}
        {{-- <a href="/profile"
            class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700 dropdown-item">Profile</a> --}}
        {{-- <a href="/settings"
            class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700 dropdown-item">Settings</a> --}}
    </div>
</div>
