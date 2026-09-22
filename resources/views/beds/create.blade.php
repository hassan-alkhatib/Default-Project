@extends('layouts.app')

@section('title', 'تسجيل إقامة')
@section('page-title', 'تسجيل إقامة جديدة')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-green-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="bed-double" class="w-5 h-5 text-green-600"></i>
                تسجيل إقامة جديدة
            </h3>
        </div>

        <form method="POST" action="{{ route('beds.store') }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">المريض *</label>
                    <select name="patient_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الطبيب المسؤول *</label>
                    <select name="doctor_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر الطبيب</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">د. {{ $doc->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2" data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الغرفة *</label>
                    <select name="room_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر الغرفة</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->room_number }} — {{ $room->department->name }} ({{ $room->available_beds }} متاح)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الدخول *</label>
                    <input type="date" name="admission_date" value="{{ old('admission_date', now()->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="260">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الخروج المتوقع</label>
                    <input type="date" name="expected_discharge_date"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div class="md:col-span-2" data-aos="fade-left" data-aos-delay="280">
                    <label class="block text-sm font-medium text-gray-700 mb-2">سبب الإقامة</label>
                    <textarea name="reason" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('reason') }}</textarea>
                </div>
                <div class="md:col-span-2" data-aos="fade-left" data-aos-delay="300">
                    <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="340">
                <a href="{{ route('beds.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    تسجيل الإقامة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection