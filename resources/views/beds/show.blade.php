@extends('layouts.app')

@section('title', 'الإقامة - ' . $bedAdmission->patient->full_name)
@section('page-title', 'تفاصيل الإقامة')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-gradient-to-l from-green-700 to-green-900 p-6 text-white" data-aos="fade-down" data-aos-delay="120">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">{{ $bedAdmission->patient->full_name }}</h2>
                    <p class="text-green-200 mt-1">غرفة {{ $bedAdmission->room->room_number }}</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-xl font-semibold">
                    {{ $bedAdmission->status == 'active' ? 'قيد العلاج' : ($bedAdmission->status == 'critical' ? 'حرج' : 'خرج') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6" data-aos="fade-up" data-aos-delay="160">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">المريض</p>
                <a href="{{ route('patients.show', $bedAdmission->patient) }}" class="font-semibold text-blue-600 hover:underline">{{ $bedAdmission->patient->full_name }}</a>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الطبيب المسؤول</p>
                <p class="font-semibold text-gray-800">د. {{ $bedAdmission->doctor->full_name }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">تاريخ الدخول</p>
                <p class="font-semibold text-gray-800">{{ $bedAdmission->admission_date->format('d/m/Y') }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الخروج المتوقع</p>
                <p class="font-semibold text-gray-800">{{ $bedAdmission->expected_discharge_date ? $bedAdmission->expected_discharge_date->format('d/m/Y') : '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">تاريخ الخروج</p>
                <p class="font-semibold text-gray-800">{{ $bedAdmission->actual_discharge_date ? $bedAdmission->actual_discharge_date->format('d/m/Y') : '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">عدد الأيام</p>
                <p class="font-semibold text-gray-800">
                    {{ $bedAdmission->actual_discharge_date
                        ? $bedAdmission->actual_discharge_date->diffInDays($bedAdmission->admission_date)
                        : now()->diffInDays($bedAdmission->admission_date) }} يوم
                </p>
            </div>
        </div>

        @if($bedAdmission->reason)
            <div class="mx-6 mb-4 p-4 bg-gray-50 rounded-xl" data-aos="fade-up" data-aos-delay="200">
                <p class="text-sm font-bold text-gray-700 mb-1">سبب الإقامة:</p>
                <p class="text-sm text-gray-600">{{ $bedAdmission->reason }}</p>
            </div>
        @endif
        @if($bedAdmission->notes)
            <div class="mx-6 mb-6 p-4 bg-gray-50 rounded-xl" data-aos="fade-up" data-aos-delay="220">
                <p class="text-sm font-bold text-gray-700 mb-1">ملاحظات:</p>
                <p class="text-sm text-gray-600">{{ $bedAdmission->notes }}</p>
            </div>
        @endif

        @if($bedAdmission->status == 'active')
            <div class="px-6 pb-6" data-aos="fade-up" data-aos-delay="240">
                <form method="POST" action="{{ route('beds.discharge', $bedAdmission) }}" onsubmit="return confirm('تأكيد تسجيل خروج المريض؟')">
                    @csrf
                    <button type="submit" class="w-full px-8 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                        تسجيل خروج المريض
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection