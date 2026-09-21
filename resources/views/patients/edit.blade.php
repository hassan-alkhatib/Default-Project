@extends('layouts.app')

@section('title', 'تعديل مريض - ' . $patient->full_name)
@section('page-title', 'تعديل بيانات المريض')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-blue-50 to-white">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="user-cog" class="w-5 h-5 text-blue-600"></i>
                تعديل: {{ $patient->full_name }} ({{ $patient->patient_number }})
            </h3>
        </div>

        <form method="POST" action="{{ route('patients.update', $patient) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الاسم الأول *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم العائلة *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الجنس *</label>
                    <select name="gender" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الميلاد *</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحالة *</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="active" {{ old('status', $patient->status) == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="critical" {{ old('status', $patient->status) == 'critical' ? 'selected' : '' }}>حرج</option>
                        <option value="inactive" {{ old('status', $patient->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $patient->email) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">العنوان</label>
                    <input type="text" name="address" value="{{ old('address', $patient->address) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">المدينة</label>
                    <input type="text" name="city" value="{{ old('city', $patient->city) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">فصيلة الدم</label>
                    <select name="blood_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="">اختر</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                            <option value="{{ $type }}" {{ old('blood_type', $patient->blood_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الرقم الوطني</label>
                    <input type="text" name="national_id" value="{{ old('national_id', $patient->national_id) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم التأمين</label>
                    <input type="text" name="insurance_number" value="{{ old('insurance_number', $patient->insurance_number) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">شركة التأمين</label>
                    <input type="text" name="insurance_provider" value="{{ old('insurance_provider', $patient->insurance_provider) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">جهة الاتصال في الطوارئ</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">هاتف الطوارئ</label>
                    <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحساسية</label>
                    <textarea name="allergies" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('allergies', $patient->allergies) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">التاريخ الطبي</label>
                    <textarea name="medical_history" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('medical_history', $patient->medical_history) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('patients.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
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