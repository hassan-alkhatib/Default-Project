@extends('layouts.app')

@section('title', 'إضافة صنف')
@section('page-title', 'إضافة صنف جديد')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-amber-50 to-white">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="package-plus" class="w-5 h-5 text-amber-600"></i>
                صنف جديد
            </h3>
        </div>

        <form method="POST" action="{{ route('inventory.store') }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم الصنف *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الاسم بالعربية</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الفئة *</label>
                    <select name="category" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="medication">دواء</option>
                        <option value="equipment">معدات</option>
                        <option value="supplies">مستلزمات</option>
                        <option value="consumable">مواد استهلاكية</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الكمية الأولية *</label>
                    <input type="number" name="quantity" required min="0" value="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحد الأدنى *</label>
                    <input type="number" name="minimum_stock" required min="0" value="10"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحد الأقصى *</label>
                    <input type="number" name="maximum_stock" required min="1" value="1000"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">سعر الوحدة (ر.س) *</label>
                    <input type="number" name="unit_price" required min="0" step="0.01"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الانتهاء</label>
                    <input type="date" name="expiry_date"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">المورد</label>
                    <input type="text" name="supplier" value="{{ old('supplier') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">هاتف المورد</label>
                    <input type="text" name="supplier_phone" value="{{ old('supplier_phone') }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الموقع</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">وصف</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('inventory.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-amber-600 text-white rounded-xl font-semibold hover:bg-amber-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ الصنف
                </button>
            </div>
        </form>
    </div>
</div>
@endsection