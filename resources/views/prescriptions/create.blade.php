@extends('layouts.app')

@section('title', 'وصفة طبية جديدة')
@section('page-title', 'إنشاء وصفة طبية')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-purple-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="pill" class="w-5 h-5 text-purple-600"></i>
                وصفة طبية جديدة
            </h3>
        </div>

        <form method="POST" action="{{ route('prescriptions.store') }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">المريض *</label>
                    <select name="patient_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الطبيب *</label>
                    <select name="doctor_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">د. {{ $doc->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الوصفة *</label>
                    <input type="date" name="prescription_date" value="{{ old('prescription_date', now()->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div class="p-5 border rounded-xl bg-purple-50/50" data-aos="fade-up" data-aos-delay="260">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-gray-700 flex items-center gap-2">
                        <i data-lucide="list-plus" class="w-4 h-4 text-purple-600"></i>
                        الأدوية الموصوفة
                    </h4>
                    <button type="button" id="add-item" class="px-4 py-2 bg-purple-600 text-white rounded-xl text-sm font-semibold hover:bg-purple-700 transition flex items-center gap-1">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        إضافة دواء
                    </button>
                </div>

                <div id="items-container" class="space-y-4">
                    <div class="item-row grid grid-cols-2 md:grid-cols-6 gap-3 bg-white p-4 rounded-xl border border-gray-200">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">اسم الدواء *</label>
                            <input type="text" name="items[0][medication_name]" required placeholder="اسم الدواء" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">الجرعة *</label>
                            <input type="text" name="items[0][dosage]" required placeholder="مثال: 500 ملغ" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">التكرار *</label>
                            <input type="text" name="items[0][frequency]" required placeholder="مثال: 3 مرات يومياً" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">المدة</label>
                            <input type="text" name="items[0][duration]" placeholder="مثال: 7 أيام" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">الكمية</label>
                            <input type="number" name="items[0][quantity]" value="1" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="300">
                <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="340">
                <a href="{{ route('prescriptions.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ الوصفة
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
        row.className = 'item-row grid grid-cols-2 md:grid-cols-6 gap-3 bg-white p-4 rounded-xl border border-gray-200';
        row.innerHTML = `
            <div class="md:col-span-2">
                <input type="text" name="items[${itemCount}][medication_name]" required placeholder="اسم الدواء" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <input type="text" name="items[${itemCount}][dosage]" required placeholder="الجرعة" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <input type="text" name="items[${itemCount}][frequency]" required placeholder="التكرار" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <input type="text" name="items[${itemCount}][duration]" placeholder="المدة" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="flex gap-2">
                <input type="number" name="items[${itemCount}][quantity]" value="1" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <button type="button" onclick="this.closest('.item-row').remove()" class="px-2 py-1 text-red-500 hover:bg-red-50 rounded-lg">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        itemCount++;
        lucide.createIcons();
    });
</script>
@endsection