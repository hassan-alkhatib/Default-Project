@extends('layouts.app')

@section('title', 'إضافة سجل طبي')
@section('page-title', 'إنشاء سجل طبي')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-blue-50 to-white">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="file-plus" class="w-5 h-5 text-blue-600"></i>
                سجل طبي جديد
            </h3>
        </div>

        <form method="POST" action="{{ route('medical-records.store') }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">المريض *</label>
                    <select name="patient_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الطبيب *</label>
                    <select name="doctor_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">د. {{ $doc->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">النوع *</label>
                    <select name="type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="visit">زيارة</option>
                        <option value="emergency">طوارئ</option>
                        <option value="surgery">جراحة</option>
                        <option value="follow_up">متابعة</option>
                        <option value="lab_result">نتيجة تحليل</option>
                        <option value="imaging">تصوير</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الزيارة *</label>
                    <input type="date" name="visit_date" value="{{ old('visit_date', now()->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الشكوى الرئيسية</label>
                    <input type="text" name="chief_complaint" value="{{ old('chief_complaint') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div class="p-5 border rounded-xl bg-green-50/50">
                <h4 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4 text-green-600"></i>
                    العلامات الحيوية
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">الحرارة (°C)</label>
                        <input type="number" name="temperature" step="0.1" min="30" max="45"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">ضغط الدم الانقباضي</label>
                        <input type="number" name="blood_pressure_systolic" min="50" max="300"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">ضغط الدم الانبساطي</label>
                        <input type="number" name="blood_pressure_diastolic" min="20" max="200"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">نبض القلب</label>
                        <input type="number" name="heart_rate" min="30" max="250"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">الوزن (كجم)</label>
                        <input type="number" name="weight" step="0.01" min="1" max="500"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">الطول (سم)</label>
                        <input type="number" name="height" step="0.01" min="30" max="300"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">سكر الدم</label>
                        <input type="number" name="blood_sugar" step="0.1" min="0" max="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">التشخيص</label>
                    <textarea name="diagnosis" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('diagnosis') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">خطة العلاج</label>
                    <textarea name="treatment_plan" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('treatment_plan') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('medical-records.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ السجل
                </button>
            </div>
        </form>
    </div>
</div>
@endsection