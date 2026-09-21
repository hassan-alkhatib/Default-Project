@extends('layouts.app')

@section('title', 'حجز موعد')
@section('page-title', 'حجز موعد جديد')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-blue-50 to-white">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="calendar-plus" class="w-5 h-5 text-blue-600"></i>
                حجز موعد جديد
            </h3>
        </div>

        <form method="POST" action="{{ route('appointments.store') }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">المريض *</label>
                    <select name="patient_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->full_name }} ({{ $patient->patient_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الطبيب *</label>
                    <select name="doctor_id" required id="doctor-select" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر الطبيب</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" data-fee="{{ $doc->consultation_fee }}">
                                د. {{ $doc->full_name }} — {{ $doc->specialization }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">القسم</label>
                    <select name="department_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر القسم</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">التاريخ *</label>
                    <input type="date" name="appointment_date" required value="{{ old('appointment_date', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الوقت *</label>
                    <input type="time" name="appointment_time" required value="{{ old('appointment_time') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الأولوية *</label>
                    <select name="priority" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="normal">عادية</option>
                        <option value="low">منخفضة</option>
                        <option value="high">عالية</option>
                        <option value="urgent">عاجلة</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">سبب الزيارة</label>
                    <input type="text" name="reason" value="{{ old('reason') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-700 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4"></i>
                رسوم الكشف: <span id="fee-display">—</span> ر.س (تُضاف تلقائياً حسب الطبيب)
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('appointments.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حجز الموعد
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('doctor-select').addEventListener('change', function(e) {
        const fee = e.target.selectedOptions[0]?.dataset.fee || '—';
        document.getElementById('fee-display').textContent = fee;
    });
</script>
@endsection