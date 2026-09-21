@extends('layouts.app')

@section('title', 'الملف الشخصي')
@section('page-title', 'الملف الشخصي')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-gradient-to-l from-blue-700 to-blue-900 p-8 text-white text-center" data-aos="fade-down" data-aos-delay="120">
            <div class="w-24 h-24 mx-auto rounded-full bg-white/20 flex items-center justify-center text-3xl font-extrabold ring-4 ring-white/30">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <h2 class="text-2xl font-extrabold mt-4">{{ auth()->user()->name }}</h2>
            <p class="text-blue-200 mt-1">{{ match(auth()->user()->role) { 'admin' => 'مدير النظام', 'doctor' => 'طبيب', 'receptionist' => 'استقبال', 'accountant' => 'محاسب', 'lab_technician' => 'فني مختبر', 'pharmacist' => 'صيدلي', 'nurse' => 'ممرض', 'staff' => 'موظف' } }}</p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="p-8 space-y-6" data-aos="fade-up" data-aos-delay="160">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div data-aos="fade-left" data-aos-delay="180">
                    <label class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل *</label>
                    <input type="text" name="name" required value="{{ auth()->user()->name }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div data-aos="fade-left" data-aos-delay="210">
                    <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-500">
                </div>
                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone }}" dir="ltr"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div data-aos="fade-left" data-aos-delay="270">
                    <label class="block text-sm font-medium text-gray-700 mb-2">آخر تسجيل دخول</label>
                    <input type="text" value="{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d/m/Y h:i A') : '—' }}" disabled
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-500">
                </div>
            </div>

            <div class="p-5 border rounded-xl bg-gray-50" data-aos="fade-up" data-aos-delay="260">
                <h4 class="font-bold text-gray-700 mb-4">تغيير كلمة المرور (اختياري)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الجديدة</label>
                        <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100" data-aos="zoom-in" data-aos-delay="300">
                <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection