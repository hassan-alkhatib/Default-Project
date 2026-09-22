@extends('layouts.app')

@section('title', 'إضافة مستخدم')
@section('page-title', 'إضافة مستخدم جديد')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-l from-blue-50 to-white" data-aos="fade-right" data-aos-delay="110">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-5 h-5 text-blue-600"></i>
                مستخدم جديد
            </h3>
        </div>

        <form method="POST" action="{{ route('users.store') }}" class="p-6 space-y-6" data-aos="fade-up" data-aos-delay="150">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="220">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الدور *</label>
                    <select name="role" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="receptionist">استقبال</option>
                        <option value="admin">مدير</option>
                        <option value="doctor">طبيب</option>
                        <option value="accountant">محاسب</option>
                        <option value="lab_technician">فني مختبر</option>
                        <option value="pharmacist">صيدلي</option>
                        <option value="nurse">ممرض</option>
                        <option value="staff">موظف</option>
                    </select>
                </div>
                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="260">
                    <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور *</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="280">
                    <label class="block text-sm font-medium text-gray-700 mb-2">تأكيد كلمة المرور *</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100" data-aos="fade-up" data-aos-delay="320">
                <a href="{{ route('users.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50">
                    إلغاء
                </a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    إنشاء المستخدم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection