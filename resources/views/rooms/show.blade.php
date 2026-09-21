@extends('layouts.app')

@section('title', 'الغرفة ' . $room->room_number)
@section('page-title', 'تفاصيل الغرفة')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-l from-indigo-700 to-indigo-900 p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">الغرفة {{ $room->room_number }}</h2>
                    <p class="text-indigo-200 mt-1">{{ $room->department->name }} • {{ ucfirst($room->type) }}</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-xl font-semibold">
                    {{ $room->status == 'available' ? 'متاحة' : ($room->status == 'occupied' ? 'مشغولة' : 'صيانة') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6">
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">السعة</p>
                <p class="text-xl font-extrabold text-gray-800">{{ $room->capacity }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">الحالي</p>
                <p class="text-xl font-extrabold text-gray-800">{{ $room->current_occupancy }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">المتاح</p>
                <p class="text-xl font-extrabold {{ $room->available_beds > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $room->available_beds }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">التكلفة/يوم</p>
                <p class="text-xl font-extrabold text-gray-800">{{ number_format($room->rate_per_day, 0) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">سجل الإقامات</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">تاريخ الدخول</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">تاريخ الخروج</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($room->bedAdmissions as $admission)
                        <tr>
                            <td class="px-5 py-3 text-sm text-gray-700">{{ $admission->patient->full_name }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $admission->admission_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $admission->actual_discharge_date ? $admission->actual_discharge_date->format('d/m/Y') : '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($admission->status == 'active') bg-green-100 text-green-600
                                    @else bg-gray-100 text-gray-500 @endif">
                                    {{ $admission->status == 'active' ? 'قيد العلاج' : 'خرج' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">لا توجد إقامات سابقة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($room->status == 'available' && $room->available_beds > 0)
        <a href="{{ route('beds.create') }}?room_id={{ $room->id }}" class="block text-center px-8 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition">
            تسجيل مريض في هذه الغرفة
        </a>
    @endif
</div>
@endsection