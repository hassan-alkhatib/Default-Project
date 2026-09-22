@extends('layouts.app')

@section('title', 'إضافة غرفة')
@section('page-title', 'إضافة غرفة جديدة')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-indigo-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="door-open" class="w-5 h-5 text-indigo-600"></i>
                بيانات الغرفة
            </h3>
        </div>

        <form method="POST" action="{{ route('rooms.store') }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الغرفة *</label>
                    <input type="text" name="room_number" required value="{{ old('room_number') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">القسم *</label>
                    <select name="department_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">النوع *</label>
                    <select name="type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="ward">عنبر</option>
                        <option value="private">غرفة خاصة</option>
                        <option value="icu">عناية مركزة</option>
                        <option value="emergency">طوارئ</option>
                        <option value="operating">عمليات</option>
                        <option value="laboratory">مختبر</option>
                        <option value="pharmacy">صيدلية</option>
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">السعة (أسرّة) *</label>
                    <input type="number" name="capacity" required min="1" value="1"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div class="md:col-span-2" data-aos="fade-left" data-aos-delay="260">
                    <label class="block text-sm font-medium text-gray-700 mb-2">التكلفة اليومية (ر.س) *</label>
                    <input type="number" name="rate_per_day" required min="0" step="0.01"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('rooms.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ الغرفة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection