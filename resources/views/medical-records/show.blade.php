@extends('layouts.app')

@section('title', 'السجل الطبي')
@section('page-title', 'تفاصيل السجل الطبي')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-l from-blue-700 to-blue-900 p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">{{ $medicalRecord->record_number }}</h2>
                    <p class="text-blue-200 mt-1">{{ $medicalRecord->visit_date->format('l, d/m/Y') }}</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-xl font-semibold">
                    {{ match($medicalRecord->type) { 'visit' => 'زيارة', 'emergency' => 'طوارئ', 'surgery' => 'جراحة', 'follow_up' => 'متابعة', 'lab_result' => 'نتيجة تحليل', 'imaging' => 'تصوير' } }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">المريض</p>
                <a href="{{ route('patients.show', $medicalRecord->patient) }}" class="font-semibold text-blue-600 hover:underline">
                    {{ $medicalRecord->patient->full_name }}
                </a>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الطبيب</p>
                <p class="font-semibold text-gray-800">د. {{ $medicalRecord->doctor->full_name }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الموعد المرتبط</p>
                <p class="font-semibold text-gray-800">{{ $medicalRecord->appointment->appointment_number ?? '—' }}</p>
            </div>
        </div>

        @if($medicalRecord->temperature || $medicalRecord->blood_pressure_systolic || $medicalRecord->heart_rate)
        <div class="px-6 pb-6">
            <h3 class="font-bold text-gray-800 mb-3">العلامات الحيوية</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @if($medicalRecord->temperature)
                <div class="p-3 bg-red-50 rounded-xl text-center">
                    <p class="text-xs text-gray-500">الحرارة</p>
                    <p class="font-bold text-red-600">{{ $medicalRecord->temperature }}°C</p>
                </div>
                @endif
                @if($medicalRecord->blood_pressure_systolic)
                <div class="p-3 bg-blue-50 rounded-xl text-center">
                    <p class="text-xs text-gray-500">ضغط الدم</p>
                    <p class="font-bold text-blue-600">{{ $medicalRecord->blood_pressure_systolic }}/{{ $medicalRecord->blood_pressure_diastolic }}</p>
                </div>
                @endif
                @if($medicalRecord->heart_rate)
                <div class="p-3 bg-green-50 rounded-xl text-center">
                    <p class="text-xs text-gray-500">نبض القلب</p>
                    <p class="font-bold text-green-600">{{ $medicalRecord->heart_rate }}/دقيقة</p>
                </div>
                @endif
                @if($medicalRecord->blood_sugar)
                <div class="p-3 bg-purple-50 rounded-xl text-center">
                    <p class="text-xs text-gray-500">سكر الدم</p>
                    <p class="font-bold text-purple-600">{{ $medicalRecord->blood_sugar }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="px-6 pb-6 space-y-4">
            @if($medicalRecord->chief_complaint)
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm font-bold text-gray-700 mb-1">الشكوى:</p>
                    <p class="text-sm text-gray-600">{{ $medicalRecord->chief_complaint }}</p>
                </div>
            @endif
            @if($medicalRecord->diagnosis)
                <div class="p-4 bg-red-50 border border-red-100 rounded-xl">
                    <p class="text-sm font-bold text-red-700 mb-1">التشخيص:</p>
                    <p class="text-sm text-red-600">{{ $medicalRecord->diagnosis }}</p>
                </div>
            @endif
            @if($medicalRecord->treatment_plan)
                <div class="p-4 bg-green-50 border border-green-100 rounded-xl">
                    <p class="text-sm font-bold text-green-700 mb-1">خطة العلاج:</p>
                    <p class="text-sm text-green-600">{{ $medicalRecord->treatment_plan }}</p>
                </div>
            @endif
            @if($medicalRecord->notes)
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm font-bold text-gray-700 mb-1">ملاحظات:</p>
                    <p class="text-sm text-gray-600">{{ $medicalRecord->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">الوصفات المرتبطة</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($medicalRecord->prescriptions as $prescription)
                    <a href="{{ route('prescriptions.show', $prescription) }}" class="p-4 flex items-center gap-3 hover:bg-gray-50">
                        <div class="w-9 h-9 bg-purple-50 rounded-lg flex items-center justify-center">
                            <i data-lucide="pill" class="w-4 h-4 text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $prescription->prescription_number }}</p>
                            <p class="text-xs text-gray-500">{{ $prescription->prescription_date->format('d/m/Y') }}</p>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-400">لا توجد وصفات</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">التحاليل المرتبطة</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($medicalRecord->labTests as $labTest)
                    <a href="{{ route('lab-tests.show', $labTest) }}" class="p-4 flex items-center gap-3 hover:bg-gray-50">
                        <div class="w-9 h-9 bg-cyan-50 rounded-lg flex items-center justify-center">
                            <i data-lucide="flask-conical" class="w-4 h-4 text-cyan-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $labTest->test_name }}</p>
                            <p class="text-xs text-gray-500">{{ $labTest->test_number }} • {{ $labTest->status }}</p>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-400">لا توجد تحاليل</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection