@extends('layouts.app')

@section('title', 'إدارة الأسرّة')
@section('page-title', 'إدارة الأسرّة والإقامات')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="80">
            <p class="text-sm text-gray-500">إجمالي الأسرّة</p>
            <p class="text-2xl font-extrabold text-gray-800 mt-1" data-counter data-value="{{ $stats['total_beds'] }}">0</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="120">
            <p class="text-sm text-gray-500">أسرّة مشغولة</p>
            <p class="text-2xl font-extrabold text-red-600 mt-1" data-counter data-value="{{ $stats['occupied_beds'] }}">0</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="160">
            <p class="text-sm text-gray-500">أسرّة متاحة</p>
            <p class="text-2xl font-extrabold text-green-600 mt-1" data-counter data-value="{{ $stats['available_beds'] }}">0</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="200">
            <p class="text-sm text-gray-500">إقامات نشطة</p>
            <p class="text-2xl font-extrabold text-blue-600 mt-1" data-counter data-value="{{ $stats['active_admissions'] }}">0</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5" data-aos="fade-down" data-aos-delay="80">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1" data-aos="fade-left" data-aos-delay="120">
                <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>قيد العلاج</option>
                    <option value="discharged" {{ request('status') == 'discharged' ? 'selected' : '' }}>خرج</option>
                    <option value="critical" {{ request('status') == 'critical' ? 'selected' : '' }}>حرج</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                    تصفية
                </button>
            </form>
            <a href="{{ route('beds.create') }}" data-button-glow class="px-6 py-2.5 bg-gradient-to-l from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition flex items-center gap-2" data-aos="zoom-in" data-aos-delay="150">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                تسجيل إقامة
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="170">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الغرفة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الطبيب المعالج</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">تاريخ الدخول</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الخروج المتوقع</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($admissions as $admission)
                        <tr class="hover:bg-gray-50 transition" data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 25 }}">
                            <td class="px-5 py-3">
                                <a href="{{ route('patients.show', $admission->patient) }}" class="text-sm font-medium text-gray-800 hover:text-blue-600 hover:underline">
                                    {{ $admission->patient->full_name }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $admission->room->room_number }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">د. {{ $admission->doctor->full_name }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $admission->admission_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $admission->expected_discharge_date ? $admission->expected_discharge_date->format('d/m/Y') : '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($admission->status == 'active') bg-green-100 text-green-600
                                    @elseif($admission->status == 'critical') bg-red-100 text-red-600
                                    @elseif($admission->status == 'transferred') bg-blue-100 text-blue-600
                                    @else bg-gray-100 text-gray-500 @endif">
                                    {{ $admission->status == 'active' ? 'قيد العلاج' : ($admission->status == 'critical' ? 'حرج' : ($admission->status == 'transferred' ? 'تم النقل' : 'خرج')) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('beds.show', $admission) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    @if($admission->status == 'active')
                                    <form method="POST" action="{{ route('beds.discharge', $admission) }}" onsubmit="return confirm('تسجيل خروج هذا المريض؟')">
                                        @csrf
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="تسجيل خروج">
                                            <i data-lucide="log-out" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-16 text-center text-gray-400">لا توجد إقامات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center" data-aos="fade-up" data-aos-delay="220">
        {{ $admissions->links() }}
    </div>
</div>
@endsection