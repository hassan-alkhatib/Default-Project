<header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-4">
        <h2 class="text-xl font-bold text-gray-800">@yield('page-title', 'لوحة التحكم')</h2>
    </div>

    <div class="flex items-center gap-4">
        <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
            <i data-lucide="bell" class="w-5 h-5"></i>
            @php
                $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $unreadCount }}</span>
            @endif
        </a>

        <div class="text-sm text-gray-500">
            {{ now()->format('l, d/m/Y') }}
        </div>
    </div>
</header>
