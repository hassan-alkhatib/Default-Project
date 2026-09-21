@extends('layouts.app')

@section('title', 'ملف المريض - ' . $patient->full_name)
@section('page-title', 'ملف المريض')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-l from-blue-700 to-blue-900 p-6 text-white relative">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($patient->first_name, 0, 1)) }}{{ strtoupper(substr($patient->last_name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-extrabold">{{ $patient->full_name }}</h2>
                    <p class="text-blue-200 mt-1">{{ $patient->patient_number }} • {{ $patient->gender === 'male' ? 'ذكر' : 'أنثى' }} • {{ $patient->age }} سنة</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('patients.edit', $patient) }}" class="px-4 py-2 bg-white/20 text-white rounded-xl font-medium hover:bg-white/30 transition">
                        تعديل
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 p-6">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">رقم الهاتف</p>
                <p class="font-semibold text-gray-800" dir="ltr">{{ $patient->phone ?: '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">البريد الإلكتروني</p>
                <p class="font-semibold text-gray-800 truncate">{{ $patient->email ?: '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">العنوان</p>
                <p class="font-semibold text-gray-800">{{ $patient->city ?: '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">فصيلة الدم</p>
                <p class="font-semibold text-red-600">{{ $patient->blood_type ?: '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">رقم التأمين</p>
                <p class="font-semibold text-gray-800">{{ $patient->insurance_number ?: '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">شركة التأمين</p>
                <p class="font-semibold text-gray-800">{{ $patient->insurance_provider ?: '—' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الحالة</p>
                <span class="px-3 py-1 inline-block rounded-full text-xs font-semibold {{ $patient->status == 'critical' ? 'bg-red-100 text-red-600' : ($patient->status == 'active' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500') }}">
                    {{ $patient->status == 'critical' ? 'حرج' : ($patient->status == 'active' ? 'نشط' : 'غير نشط') }}
                </span>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">جهة الطوارئ</p>
                <p class="font-semibold text-gray-800">{{ $patient->emergency_contact_name ?: '—' }}</p>
            </div>
        </div>

        @if($patient->allergies)
            <div class="mx-6 mb-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-sm font-bold text-red-700 mb-1 flex items-center gap-2"><i data-lucide="alert-triangle" class="w-4 h-4"></i> الحساسية:</p>
                <p class="text-sm text-red-600">{{ $patient->allergies }}</p>
            </div>
        @endif

        @if($patient->medical_history)
            <div class="mx-6 mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <p class="text-sm font-bold text-blue-700 mb-1 flex items-center gap-2"><i data-lucide="file-text" class="w-4 h-4"></i> التاريخ الطبي:</p>
                <p class="text-sm text-blue-600">{{ $patient->medical_history }}</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Appointments -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                    المواعيد
                </h3>
                <a href="{{ route('appointments.create') }}?patient_id={{ $patient->id }}" class="text-sm text-blue-600 font-medium">حجز موعد</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($patient->appointments as $appointment)
                    <div class="p-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5 text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $appointment->appointment_date->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                            <p class="text-xs text-gray-500">د. {{ $appointment->doctor->full_name ?? '—' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            bg-{{ $appointment->status == 'completed' ? 'green' : ($appointment->status == 'cancelled' ? 'red' : 'blue') }}-100
                            text-{{ $appointment->status == 'completed' ? 'green' : ($appointment->status == 'cancelled' ? 'red' : 'blue') }}-600">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">لا توجد مواعيد</div>
                @endforelse
            </div>
        </div>

        <!-- Medical Records -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-green-600"></i>
                    السجلات الطبية
                </h3>
                <a href="{{ route('medical-records.create') }}?patient_id={{ $patient->id }}" class="text-sm text-blue-600 font-medium">إضافة سجل</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($patient->medicalRecords as $record)
                    <a href="{{ route('medical-records.show', $record) }}" class="p-4 flex items-center gap-3 hover:bg-gray-50 transition">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                            <i data-lucide="clipboard-list" class="w-5 h-5 text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $record->diagnosis ?: 'بدون تشخيص' }}</p>
                            <p class="text-xs text-gray-500">{{ $record->record_number }} • {{ $record->visit_date->format('d/m/Y') }}</p>
                        </div>
                        <i data-lucide="chevron-left" class="w-4 h-4 text-gray-400"></i>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-400">لا توجد سجلات طبية</div>
                @endforelse
            </div>
        </div>

        <!-- Prescriptions -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i data-lucide="pill" class="w-5 h-5 text-purple-600"></i>
                    الوصفات الطبية
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($patient->prescriptions as $prescription)
                    <a href="{{ route('prescriptions.show', $prescription) }}" class="p-4 flex items-center gap-3 hover:bg-gray-50 transition">
                        <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                            <i data-lucide="pill" class="w-5 h-5 text-purple-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $prescription->prescription_number }} • {{ $prescription->items_count ?? $prescription->items->count() }} أدوية</p>
                            <p class="text-xs text-gray-500">{{ $prescription->prescription_date->format('d/m/Y') }}</p>
                        </div>
                        <i data-lucide="chevron-left" class="w-4 h-4 text-gray-400"></i>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-400">لا توجد وصفات طبية</div>
                @endforelse
            </div>
        </div>

        <!-- Invoices -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i data-lucide="receipt" class="w-5 h-5 text-orange-600"></i>
                    الفواتير
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($patient->invoices as $invoice)
                    <a href="{{ route('invoices.show', $invoice) }}" class="p-4 flex items-center gap-3 hover:bg-gray-50 transition">
                        <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                            <i data-lucide="receipt" class="w-5 h-5 text-orange-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $invoice->invoice_number }}</p>
                            <p class="text-xs text-gray-500">{{ $invoice->invoice_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold @if($invoice->status == 'paid') text-green-600 @else text-red-600 @endif">
                                {{ number_format($invoice->total_amount, 2) }}
                            </p>
                            <span class="text-xs text-gray-400">{{ $invoice->status }}</span>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-400">لا توجد فواتير</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection