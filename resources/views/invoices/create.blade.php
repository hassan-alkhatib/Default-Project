@extends('layouts.app')

@section('title', 'إنشاء فاتورة')
@section('page-title', 'إنشاء فاتورة جديدة')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-orange-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-orange-600"></i>
                فاتورة جديدة
            </h3>
        </div>

        <form method="POST" action="{{ route('invoices.store') }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">المريض *</label>
                    <select name="patient_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الفاتورة *</label>
                    <input type="date" name="invoice_date" value="{{ old('invoice_date', now()->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الاستحقاق</label>
                    <input type="date" name="due_date"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">نسبة الضريبة (%)</label>
                    <input type="number" name="tax_rate" value="{{ old('tax_rate', 0) }}" min="0" max="100" step="0.01"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="260">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الخصم (ر.س)</label>
                    <input type="number" name="discount_amount" value="{{ old('discount_amount', 0) }}" min="0" step="0.01"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div class="p-5 border rounded-xl bg-orange-50/50" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-gray-700 flex items-center gap-2">
                        <i data-lucide="list-plus" class="w-4 h-4 text-orange-600"></i>
                        بنود الفاتورة
                    </h4>
                    <button type="button" id="add-item" class="px-4 py-2 bg-orange-600 text-white rounded-xl text-sm font-semibold hover:bg-orange-700 transition flex items-center gap-1">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        إضافة بند
                    </button>
                </div>

                <div id="items-container" class="space-y-4">
                    <div class="item-row grid grid-cols-1 md:grid-cols-8 gap-3 bg-white p-4 rounded-xl border border-gray-200">
                        <div class="md:col-span-4">
                            <input type="text" name="items[0][description]" required placeholder="وصف البند (استشارة، فحص، دواء...)"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                        <div>
                            <input type="number" name="items[0][quantity]" required value="1" min="1" placeholder="الكمية"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <input type="number" name="items[0][unit_price]" required value="0" min="0" step="0.01" placeholder="سعر الوحدة"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="340">
                <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="380">
                <a href="{{ route('invoices.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-orange-600 text-white rounded-xl font-semibold hover:bg-orange-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    إنشاء الفاتورة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let itemCount = 1;
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'item-row grid grid-cols-1 md:grid-cols-8 gap-3 bg-white p-4 rounded-xl border border-gray-200';
        row.innerHTML = `
            <div class="md:col-span-4">
                <input type="text" name="items[${itemCount}][description]" required placeholder="وصف البند"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <input type="number" name="items[${itemCount}][quantity]" required value="1" min="1" placeholder="الكمية"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="md:col-span-2">
                <input type="number" name="items[${itemCount}][unit_price]" required value="0" min="0" step="0.01" placeholder="سعر الوحدة"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <button type="button" onclick="this.closest('.item-row').remove()" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
        `;
        container.appendChild(row);
        itemCount++;
        lucide.createIcons();
    });
</script>
@endsection