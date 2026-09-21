@extends('layouts.app')

@section('title', 'تعديل قسم')
@section('page-title', 'تعديل بيانات القسم')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-teal-50 to-white">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="building-2" class="w-5 h-5 text-teal-600"></i>
                تعديل: {{ $department->name }}
            </h3>
        </div>

        <form method="POST" action="{{ route('departments.update', $department) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم القسم (إنجليزي) *</label>
                    <input type="text" name="name" required value="{{ old('name', $department->name) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم القسم (عربي) *</label>
                    <input type="text" name="name_ar" required value="{{ old('name_ar', $department->name_ar) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الموقع</label>
                    <input type="text" name="location" value="{{ old('location', $department->location) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $department->phone) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">السعة *</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $department->capacity) }}" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                    <select name="is_active" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="1" {{ old('is_active', $department->is_active) ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ !old('is_active', $department->is_active) ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('description', $department->description) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('departments.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-teal-600 text-white rounded-xl font-semibold hover:bg-teal-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection