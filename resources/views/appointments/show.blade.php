@extends('layouts.app')

@section('title', 'الموعد - ' . $appointment->appointment_number)
@section('page-title', 'تفاصيل الموعد')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-l from-blue-700 to-blue-900 p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">{{ $appointment->appointment_number }}</h2>
                    <p class="text-blue-200 mt-1">{{ $appointment->appointment_date->format('l, d/m/Y') }} • {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                </div>
                @php
                    $statusClass = match($appointment->status) {
                        'scheduled' => 'bg-white/20',
                        'confirmed' => 'bg-green-500/30',
                        'in_progress' => 'bg-yellow-500/30',
                        'completed' => 'bg-emerald-500/30',
                        'cancelled' => 'bg-red-500/30',
                        'no_show' => 'bg-orange-500/30',
                    };
                    $statusLabel = match($appointment->status) {
                        'scheduled' => 'مجدول', 'confirmed' => 'مؤكد', 'in_progress' => 'جاري',
                        'completed' => 'مكتمل', 'cancelled' => 'ملغي', 'no_show' => 'لم يحضر',
                    };
                @endphp
                <span class="px-4 py-2 rounded-xl font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 p-6">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">المريض</p>
                <a href="{{ route('patients.show', $appointment->patient) }}" class="font-semibold text-gray-800 hover:text-blue-600 hover:underline">
                    {{ $appointment->patient->full_name }}
                </a>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الطبيب</p>
                <a href="{{ route('doctors.show', $appointment->doctor) }}" class="font-semibold text-gray-800 hover:text-blue-600 hover:underline">
                    د. {{ $appointment->doctor->full_name }} ({{ $appointment->doctor->specialization }})
                </a>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">القسم</p>
                <p class="font-semibold text-gray-800">{{ $appointment->department->name ?? '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الأولوية</p>
                <p class="font-semibold text-gray-800">
                    {{ match($appointment->priority) { 'low' => 'منخفضة', 'normal' => 'عادية', 'high' => 'عالية', 'urgent' => 'عاجلة' } }}
                </p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الرسوم</p>
                <p class="font-semibold text-gray-800">{{ number_format($appointment->fee, 2) }} ر.س</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">حالة الدفع</p>
                <p class="font-semibold text-gray-800">
                    {{ match($appointment->payment_status) { 'unpaid' => 'غير مدفوع', 'paid' => 'مدفوع', 'partial' => 'جزئي', 'insurance' => 'تأمين' } }}
                </p>
            </div>
            @if($appointment->reason)
            <div class="p-4 bg-blue-50 rounded-xl md:col-span-2">
                <p class="text-xs text-blue-500 mb-1">سبب الزيارة</p>
                <p class="text-sm text-blue-800">{{ $appointment->reason }}</p>
            </div>
            @endif
            @if($appointment->notes)
            <div class="p-4 bg-gray-50 rounded-xl md:col-span-2">
                <p class="text-xs text-gray-500 mb-1">ملاحظات</p>
                <p class="text-sm text-gray-700">{{ $appointment->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="settings-2" class="w-5 h-5 text-blue-600"></i>
            تحديث حالة الموعد
        </h3>
        <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="flex flex-col md:flex-row gap-3">
            @csrf
            @method('PUT')
            <select name="status" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl">
                <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>مجدول</option>
                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                <option value="in_progress" {{ $appointment->status == 'in_progress' ? 'selected' : '' }}>جاري</option>
                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                <option value="no_show" {{ $appointment->status == 'no_show' ? 'selected' : '' }}>لم يحضر</option>
            </select>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                تحديث الحالة
            </button>
        </form>
    </div>

    @if($appointment->status == 'completed')
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="clipboard-list" class="w-5 h-5 text-green-600"></i>
            إجراءات إضافية
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <a href="{{ route('medical-records.create') }}?appointment_id={{ $appointment->id }}&patient_id={{ $appointment->patient_id }}" class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-semibold text-center hover:bg-green-100 transition">
                إنشاء سجل طبي
            </a>
            <a href="{{ route('prescriptions.create') }}?patient_id={{ $appointment->patient_id }}" class="p-4 bg-purple-50 border border-purple-200 rounded-xl text-purple-700 font-semibold text-center hover:bg-purple-100 transition">
                إنشاء وصفة طبية
            </a>
            <a href="{{ route('lab-tests.create') }}?patient_id={{ $appointment->patient_id }}" class="p-4 bg-cyan-50 border border-cyan-200 rounded-xl text-cyan-700 font-semibold text-center hover:bg-cyan-100 transition">
                طلب تحليل
            </a>
        </div>
    </div>
    @endif
</div>
@endsection