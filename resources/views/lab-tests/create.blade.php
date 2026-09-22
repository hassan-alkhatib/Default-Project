@extends('layouts.app')

@section('title', 'طلب تحليل')
@section('page-title', 'طلب تحليل مخبري')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-cyan-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="flask-conical" class="w-5 h-5 text-cyan-600"></i>
                طلب تحليل جديد
            </h3>
        </div>

        <form method="POST" action="{{ route('lab-tests.store') }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">المريض *</label>
                    <select name="patient_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الطبيب *</label>
                    <select name="doctor_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر الطبيب</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">د. {{ $doc->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع التحليل *</label>
                    <select name="test_type" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر النوع</option>
                        <option value="blood">تحليل دم</option>
                        <option value="urine">تحليل بول</option>
                        <option value="imaging">تصوير طبي</option>
                        <option value="cardiology">قلب</option>
                        <option value="biopsy">خزعة</option>
                        <option value="hormone">هرمونات</option>
                        <option value="other">أخرى</option>
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الأولوية *</label>
                    <select name="urgency" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="normal">عادي</option>
                        <option value="urgent">عاجل</option>
                        <option value="stat">عاجل جداً</option>
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="260">
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ التحليل *</label>
                    <input type="date" name="test_date" value="{{ old('test_date', now()->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="280">
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم التحليل *</label>
                    <input type="text" name="test_name" required value="{{ old('test_name') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="320">
                <label class="block text-sm font-medium text-gray-700 mb-2">وصف</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('description') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="360">
                <a href="{{ route('lab-tests.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-cyan-600 text-white rounded-xl font-semibold hover:bg-cyan-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    إرسال الطلب
                </button>
            </div>
        </form>
    </div>
</div>
@endsection