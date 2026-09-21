@extends('layouts.app')

@section('title', 'الإشعارات')
@section('page-title', 'الإشعارات')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center" data-aos="fade-down" data-aos-delay="80">
        <p class="text-sm text-gray-500">
            {{ auth()->user()->notifications()->where('is_read', false)->count() }} إشعار غير مقروء
        </p>
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button type="submit" data-button-glow class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                تحديد الكل كمقروء
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="120">
        <div class="divide-y divide-gray-100">
            @forelse($notifications as $notification)
                <form method="POST" action="{{ route('notifications.read', $notification) }}" class="p-5 flex items-start gap-4 hover:bg-gray-50 transition {{ $notification->is_read ? 'opacity-60' : '' }}" data-aos="fade-up" data-aos-delay="{{ 140 + $loop->index * 30 }}">
                    @csrf
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0
                        @if($notification->type == 'appointment') bg-blue-100 text-blue-600
                        @elseif($notification->type == 'patient') bg-green-100 text-green-600
                        @elseif($notification->type == 'inventory') bg-yellow-100 text-yellow-600
                        @elseif($notification->type == 'warning') bg-red-100 text-red-600
                        @else bg-gray-100 text-gray-600 @endif">
                        <i data-lucide="{{ $notification->type == 'appointment' ? 'calendar' : ($notification->type == 'inventory' ? 'package' : ($notification->type == 'warning' ? 'alert-triangle' : 'bell')) }}" class="w-5 h-5"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-gray-800 text-sm">{{ $notification->title }}</h4>
                            <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                    </div>
                    @if(!$notification->is_read)
                        <button type="submit" class="px-3 py-1.5 text-xs bg-blue-50 text-blue-700 rounded-lg font-medium hover:bg-blue-100 transition">
                            تحديد كمقروء
                        </button>
                    @endif
                </form>
            @empty
                <div class="p-16 text-center text-gray-400">
                    <i data-lucide="bell-off" class="w-14 h-14 mx-auto mb-3 opacity-30"></i>
                    <p class="font-medium">لا توجد إشعارات</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="flex justify-center">
        {{ $notifications->links() }}
    </div>
</div>
@endsection