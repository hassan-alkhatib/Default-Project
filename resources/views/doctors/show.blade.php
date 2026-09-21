@extends('layouts.app')

@section('title', 'الطبيب - ' . $doctor->full_name)
@section('page-title', 'ملف الطبيب')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-l from-blue-700 to-blue-900 p-6 text-white">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($doctor->first_name, 0, 1)) }}{{ strtoupper(substr($doctor->last_name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-extrabold">{{ $doctor->full_name }}</h2>
                    <p class="text-blue-200 mt-1">{{ $doctor->specialization }} • {{ $doctor->department->name ?? 'بدون قسم' }}</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-xl font-medium">رسوم الكشف: {{ number_format($doctor->consultation_fee, 0) }} ر.س</span>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 p-6">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">رقم الرخصة</p>
                <p class="font-semibold text-gray-800" dir="ltr">{{ $doctor->license_number }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الهاتف</p>
                <p class="font-semibold text-gray-800" dir="ltr">{{ $doctor->phone ?: '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الحالة</p>
                <span class="px-3 py-1 inline-block rounded-full text-xs font-semibold
                    @if($doctor->status == 'active') bg-green-100 text-green-600
                    @elseif($doctor->status == 'on_leave') bg-yellow-100 text-yellow-600
                    @else bg-gray-100 text-gray-500 @endif">
                    {{ $doctor->status == 'active' ? 'نشط' : ($doctor->status == 'on_leave' ? 'في إجازة' : 'غير نشط') }}
                </span>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">أوقات العمل</p>
                <p class="font-semibold text-gray-800 text-sm">{{ $doctor->schedule ?: '—' }}</p>
            </div>
        </div>

        @if($doctor->biography)
            <div class="mx-6 mb-6 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                <p class="text-sm font-bold text-gray-700 mb-2 flex items-center gap-2"><i data-lucide="info" class="w-4 h-4"></i> السيرة الذاتية:</p>
                <p class="text-sm text-gray-600">{{ $doctor->biography }}</p>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                مواعيد اليوم
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الوقت</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">السبب</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($todayAppointments as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-semibold text-gray-700">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            <td class="px-5 py-3 text-sm text-blue-600 hover:underline">
                                <a href="{{ route('patients.show', $appointment->patient) }}">{{ $appointment->patient->full_name }}</a>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $appointment->reason ?: '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $appointment->status == 'completed' ? 'bg-green-100 text-green-600' : ($appointment->status == 'cancelled' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600') }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">لا توجد مواعيد اليوم</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection