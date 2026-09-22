@extends('layouts.app')

@section('title', 'تعديل غرفة')
@section('page-title', 'تعديل الغرفة: {{ $room->room_number }}')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-indigo-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="door-open" class="w-5 h-5 text-indigo-600"></i>
                بيانات الغرفة
            </h3>
        </div>

        <form method="POST" action="{{ route('rooms.update', $room) }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الغرفة *</label>
                    <input type="text" value="{{ $room->room_number }}" disabled
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-500">
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">القسم *</label>
                    <input type="text" value="{{ $room->department->name ?? '—' }}" disabled
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-500">
                </div>
                <div data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">النوع *</label>
                    <select name="type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        @foreach(['ward' => 'عنبر', 'private' => 'غرفة خاصة', 'icu' => 'عناية مركزة', 'emergency' => 'طوارئ', 'operating' => 'عمليات', 'laboratory' => 'مختبر', 'pharmacy' => 'صيدلية'] as $key => $label)
                            <option value="{{ $key }}" {{ old('type', $room->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">السعة (أسرّة) *</label>
                    <input type="number" name="capacity" required min="1" value="{{ old('capacity', $room->capacity) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="260">
                    <label class="block text-sm font-medium text-gray-700 mb-2">التكلفة اليومية (ر.س) *</label>
                    <input type="number" name="rate_per_day" required min="0" step="0.01" value="{{ old('rate_per_day', $room->rate_per_day) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="280">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحالة *</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        @foreach(['available' => 'متاحة', 'occupied' => 'مشغولة', 'maintenance' => 'صيانة', 'reserved' => 'محجوزة'] as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $room->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="320">
                <a href="{{ route('rooms.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection