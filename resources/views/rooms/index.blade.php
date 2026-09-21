@extends('layouts.app')

@section('title', 'الغرف')
@section('page-title', 'إدارة الغرف')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1">
                <select name="department_id" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الأقسام</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الحالات</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>متاحة</option>
                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>مشغولة</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                    تصفية
                </button>
            </form>
            <a href="{{ route('rooms.create') }}" class="px-6 py-2.5 bg-gradient-to-l from-indigo-600 to-indigo-700 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-indigo-800 transition flex items-center gap-2">
                <i data-lucide="door-open" class="w-5 h-5"></i>
                إضافة غرفة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse($rooms as $room)
            @php
                $typeIcon = match($room->type) {
                    'private' => 'lock',
                    'icu' => 'activity',
                    'emergency' => 'siren',
                    'operating' => 'scissors',
                    'laboratory' => 'flask-conical',
                    'pharmacy' => 'cross',
                    default => 'bed-double',
                };
                $typeLabel = match($room->type) {
                    'ward' => 'عنبر', 'private' => 'غرفة خاصة', 'icu' => 'عناية مركزة',
                    'emergency' => 'طوارئ', 'operating' => 'عمليات', 'laboratory' => 'مختبر', 'pharmacy' => 'صيدلية',
                };
            @endphp
            <a href="{{ route('rooms.show', $room) }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all">
                <div class="p-5 border-b border-gray-100 flex items-start justify-between">
                    <div>
                        <p class="text-lg font-extrabold text-gray-800">{{ $room->room_number }}</p>
                        <p class="text-sm text-gray-500">{{ $room->department->name }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center
                        @if($room->status == 'available') bg-green-100 text-green-600
                        @elseif($room->status == 'occupied') bg-red-100 text-red-600
                        @else bg-yellow-100 text-yellow-600 @endif">
                        <i data-lucide="{{ $typeIcon }}" class="w-6 h-6"></i>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($room->status == 'available') bg-green-100 text-green-600
                            @elseif($room->status == 'occupied') bg-red-100 text-red-600
                            @else bg-yellow-100 text-yellow-600 @endif">
                            {{ $room->status == 'available' ? 'متاحة' : ($room->status == 'occupied' ? 'مشغولة' : 'صيانة') }}
                        </span>
                        <span class="text-sm font-semibold text-gray-700">{{ $typeLabel }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>السعة</span>
                        <span class="font-semibold text-gray-800">{{ $room->capacity }} سرير</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>الإشغال الحالي</span>
                        <span class="font-semibold {{ $room->available_beds == 0 ? 'text-red-600' : 'text-green-600' }}">{{ $room->current_occupancy }}/{{ $room->capacity }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>التكلفة اليومية</span>
                        <span class="font-semibold text-gray-800">{{ number_format($room->rate_per_day, 0) }} ر.س</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-16 text-center text-gray-400">
                <i data-lucide="door-open" class="w-14 h-14 mx-auto mb-3 opacity-30"></i>
                <p class="font-medium">لا توجد غرف</p>
            </div>
        @endforelse
    </div>

    <div class="flex justify-center">
        {{ $rooms->links() }}
    </div>
</div>
@endsection