@extends('layouts.app')

@section('title', 'تعديل صنف - ' . $inventory->name)
@section('page-title', 'تعديل صنف المخزون')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-amber-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="box" class="w-5 h-5 text-amber-600"></i>
                {{ $inventory->name }} ({{ $inventory->item_code }})
            </h3>
        </div>

        <form method="POST" action="{{ route('inventory.update', $inventory) }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الاسم *</label>
                    <input type="text" name="name" required value="{{ old('name', $inventory->name) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الاسم بالعربية</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar', $inventory->name_ar) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الفئة *</label>
                    <select name="category" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="medication" {{ old('category', $inventory->category) == 'medication' ? 'selected' : '' }}>أدوية</option>
                        <option value="equipment" {{ old('category', $inventory->category) == 'equipment' ? 'selected' : '' }}>معدات</option>
                        <option value="supplies" {{ old('category', $inventory->category) == 'supplies' ? 'selected' : '' }}>مستلزمات</option>
                        <option value="consumable" {{ old('category', $inventory->category) == 'consumable' ? 'selected' : '' }}>مواد استهلاكية</option>
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الكمية الحالية</label>
                    <input type="text" value="{{ $inventory->quantity }}" disabled
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-500">
                    <p class="text-xs text-gray-400 mt-1">للتعديل على الكمية استخدم "تعديل المخزون" في صفحة التفاصيل</p>
                </div>
                <div data-aos="fade-left" data-aos-delay="260">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحد الأدنى *</label>
                    <input type="number" name="minimum_stock" required min="0" value="{{ old('minimum_stock', $inventory->minimum_stock) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="280">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحد الأقصى *</label>
                    <input type="number" name="maximum_stock" required min="1" value="{{ old('maximum_stock', $inventory->maximum_stock) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="300">
                    <label class="block text-sm font-medium text-gray-700 mb-2">سعر الوحدة (ر.س) *</label>
                    <input type="number" name="unit_price" required min="0" step="0.01" value="{{ old('unit_price', $inventory->unit_price) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="320">
                    <label class="block text-sm font-medium text-gray-700 mb-2">المورد</label>
                    <input type="text" name="supplier" value="{{ old('supplier', $inventory->supplier) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="340">
                    <label class="block text-sm font-medium text-gray-700 mb-2">هاتف المورد</label>
                    <input type="text" name="supplier_phone" value="{{ old('supplier_phone', $inventory->supplier_phone) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="360">
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الانتهاء</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', $inventory->expiry_date?->format('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="380">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الموقع</label>
                    <input type="text" name="location" value="{{ old('location', $inventory->location) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div class="md:col-span-2" data-aos="fade-left" data-aos-delay="400">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('description', $inventory->description) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="440">
                <a href="{{ route('inventory.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-amber-600 text-white rounded-xl font-semibold hover:bg-amber-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection