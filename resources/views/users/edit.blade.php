@extends('layouts.app')

@section('title', 'تعديل مستخدم')
@section('page-title', 'تعديل بيانات المستخدم')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-blue-50 to-white">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="user-cog" class="w-5 h-5 text-blue-600"></i>
                تعديل: {{ $user->name }}
            </h3>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل *</label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني *</label>
                    <input type="email" name="email" required value="{{ old('email', $user->email) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الدور *</label>
                    <select name="role" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        @foreach(['admin' => 'مدير', 'doctor' => 'طبيب', 'receptionist' => 'استقبال', 'accountant' => 'محاسب', 'lab_technician' => 'فني مختبر', 'pharmacist' => 'صيدلي', 'nurse' => 'ممرض', 'staff' => 'موظف'] as $key => $label)
                            <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                    <select name="is_active" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>معطل</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('users.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
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