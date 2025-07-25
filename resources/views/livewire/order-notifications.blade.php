<div class="relative" x-data="{ open: @entangle('showDropdown') }" @click.outside="open = false"
    wire:id="notification-center">
    {{-- Notification Icon and Badge --}}
    <button @click="open = ! open"
        class="relative p-2 text-gray-700 hover:text-green-600 focus:outline-none focus:text-green-600 rounded-full">
        {{-- Bell icon --}}
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a6 6 0 00-6 0M12 21a2 2 0 01-2-2h4a2 2 0 01-2 2z" />
        </svg>
        {{-- Unread count badge --}}
        @if ($unreadCount > 0)
        <span
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{
            $unreadCount }}</span>
        @endif
    </button>

    {{-- Notifications Dropdown --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-20 overflow-hidden border border-gray-200"
        style="display: none;"> {{-- Hide initially with display:none for Alpine --}}
        <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-200 flex justify-between items-center">
            <span class="font-semibold">Notifications</span>
            @if ($unreadCount > 0)
            <button wire:click="markAllAsRead" class="text-xs text-blue-500 hover:underline focus:outline-none">Mark All
                Read</button>
            @endif
        </div>

        @if ($notifications->isEmpty())
        <p class="px-4 py-3 text-sm text-gray-500">No new notifications.</p>
        @else
        <div class="max-h-60 overflow-y-auto">
            @foreach ($notifications as $notification)
            <a href="{{ $notification->data['order_url'] }}" class="flex flex-col px-4 py-3 hover:bg-gray-100 border-b border-gray-100 last:border-b-0
                              @if (is_null($notification->read_at)) bg-blue-50 @endif"
                wire:click="markAsRead('{{ $notification->id }}')">
                <p class="text-sm font-medium text-gray-800">{{ $notification->data['message'] }}</p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $notification->created_at->diffForHumans() }} ({{ $notification->created_at->format('M d, Y H:i
                    A') }})
                </p>
            </a>
            @endforeach
        </div>
        @endif

    </div>
</div>
