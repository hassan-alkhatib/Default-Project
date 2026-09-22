@extends('layouts.app')

@section('title', 'تعديل سجل طبي')
@section('page-title', 'تعديل السجل الطبي')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-blue-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="file-edit" class="w-5 h-5 text-blue-600"></i>
                تعديل: {{ $medicalRecord->record_number }}
            </h3>
        </div>

        <form method="POST" action="{{ route('medical-records.update', $medicalRecord) }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">النوع *</label>
                    <select name="type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        @foreach(['visit' => 'زيارة', 'emergency' => 'طوارئ', 'surgery' => 'جراحة', 'follow_up' => 'متابعة', 'lab_result' => 'نتيجة تحليل', 'imaging' => 'تصوير'] as $key => $label)
                            <option value="{{ $key }}" {{ old('type', $medicalRecord->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2" data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الزيارة *</label>
                    <input type="date" name="visit_date" value="{{ old('visit_date', $medicalRecord->visit_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div class="md:col-span-3" data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الشكوى الرئيسية</label>
                    <input type="text" name="chief_complaint" value="{{ old('chief_complaint', $medicalRecord->chief_complaint) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div class="p-5 border rounded-xl bg-green-50/50" data-aos="fade-up" data-aos-delay="260">
                <h4 class="font-bold text-gray-700 mb-4">العلامات الحيوية</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">الحرارة (°C)</label>
                        <input type="number" name="temperature" step="0.1" value="{{ $medicalRecord->temperature }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">ضغط الدم (انقباضي)</label>
                        <input type="number" name="blood_pressure_systolic" value="{{ $medicalRecord->blood_pressure_systolic }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">ضغط الدم (انبساطي)</label>
                        <input type="number" name="blood_pressure_diastolic" value="{{ $medicalRecord->blood_pressure_diastolic }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">نبض القلب</label>
                        <input type="number" name="heart_rate" value="{{ $medicalRecord->heart_rate }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                </div>
            </div>

            <div class="space-y-4" data-aos="fade-up" data-aos-delay="280">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">التشخيص</label>
                    <textarea name="diagnosis" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">خطة العلاج</label>
                    <textarea name="treatment_plan" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('treatment_plan', $medicalRecord->treatment_plan) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('notes', $medicalRecord->notes) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="320">
                <a href="{{ route('medical-records.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection