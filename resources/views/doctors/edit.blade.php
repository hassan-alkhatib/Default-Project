@extends('layouts.app')

@section('title', 'تعديل طبيب - ' . $doctor->full_name)
@section('page-title', 'تعديل بيانات الطبيب')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-blue-50 to-white">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="user-cog" class="w-5 h-5 text-blue-600"></i>
                تعديل: {{ $doctor->full_name }}
            </h3>
        </div>

        <form method="POST" action="{{ route('doctors.update', $doctor) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الاسم الأول *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $doctor->first_name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم العائلة *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $doctor->last_name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">التخصص *</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">القسم *</label>
                    <select name="department_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الرخصة *</label>
                    <input type="text" name="license_number" value="{{ old('license_number', $doctor->license_number) }}" required dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رسوم الكشف (ر.س) *</label>
                    <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" min="0" step="0.01"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $doctor->phone) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $doctor->email) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحالة *</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="active" {{ old('status', $doctor->status) == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="on_leave" {{ old('status', $doctor->status) == 'on_leave' ? 'selected' : '' }}>في إجازة</option>
                        <option value="inactive" {{ old('status', $doctor->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">أوقات العمل</label>
                    <input type="text" name="schedule" value="{{ old('schedule', $doctor->schedule) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">السيرة الذاتية</label>
                    <textarea name="biography" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('biography', $doctor->biography) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('doctors.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection