@extends('layouts.app')

@section('title', 'القسم - ' . $department->name)
@section('page-title', 'تفاصيل القسم')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-gradient-to-l from-teal-700 to-teal-900 p-6 text-white" data-aos="fade-down" data-aos-delay="120">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">{{ $department->name }}</h2>
                    <p class="text-teal-200 mt-1">{{ $department->name_ar }} • {{ $department->location ?: '—' }}</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-xl font-semibold">
                    {{ $department->is_active ? 'نشط' : 'غير نشط' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6" data-aos="fade-up" data-aos-delay="160">
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">الأطباء</p>
                <p class="text-xl font-extrabold text-gray-800">{{ $department->doctors->count() }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">الغرف</p>
                <p class="text-xl font-extrabold text-gray-800">{{ $department->rooms->count() }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">السعة</p>
                <p class="text-xl font-extrabold text-gray-800">{{ $department->capacity }}</p>
            </div>
        </div>

        @if($department->description)
            <div class="px-6 pb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm font-bold text-gray-700 mb-1">الوصف:</p>
                    <p class="text-sm text-gray-600">{{ $department->description }}</p>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">أطباء القسم</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($department->doctors as $doctor)
                    <div class="p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-xs font-bold">
                            {{ substr($doctor->first_name, 0, 1) }}{{ substr($doctor->last_name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">د. {{ $doctor->full_name }}</p>
                            <p class="text-xs text-gray-500">{{ $doctor->specialization }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">لا يوجد أطباء</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="240">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">غرف القسم</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($department->rooms as $room)
                    <a href="{{ route('rooms.show', $room) }}" class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center">
                                <i data-lucide="door-open" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">غرفة {{ $room->room_number }}</p>
                                <p class="text-xs text-gray-500">{{ $room->current_occupancy }}/{{ $room->capacity }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($room->status == 'available') bg-green-100 text-green-600
                            @elseif($room->status == 'occupied') bg-red-100 text-red-600
                            @else bg-yellow-100 text-yellow-600 @endif">
                            {{ $room->status }}
                        </span>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-400">لا توجد غرف</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="flex gap-3" data-aos="fade-up" data-aos-delay="280">
        <a href="{{ route('departments.edit', $department) }}" class="px-6 py-2.5 bg-yellow-600 text-white rounded-xl font-semibold hover:bg-yellow-700 transition">
            تعديل القسم
        </a>
        <form method="POST" action="{{ route('departments.destroy', $department) }}" onsubmit="return confirm('حذف هذا القسم؟')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                حذف القسم
            </button>
        </form>
    </div>
</div>
@endsection