@extends('layouts.app')

@section('title', 'تفاصيل المستخدم')
@section('page-title', 'ملف المستخدم')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-gradient-to-l from-blue-700 to-blue-900 p-8 text-white text-center" data-aos="fade-down" data-aos-delay="120">
            <div class="w-24 h-24 mx-auto rounded-full bg-white/20 flex items-center justify-center text-3xl font-extrabold ring-4 ring-white/30">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <h2 class="text-2xl font-extrabold mt-4">{{ $user->name }}</h2>
            <span class="inline-block px-4 py-1.5 mt-3 rounded-full text-sm font-semibold
                @if($user->is_active) bg-green-500/20 text-green-200 @else bg-red-500/20 text-red-200 @endif">
                {{ $user->is_active ? 'نشط' : 'معطل' }}
            </span>
        </div>

        <div class="p-6" data-aos="fade-up" data-aos-delay="160">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="p-4 border rounded-xl bg-gray-50">
                    <p class="text-xs text-gray-500 font-medium mb-1">الدور</p>
                    <p class="font-bold text-gray-800">{{ match($user->role) { 'admin' => 'مدير النظام', 'doctor' => 'طبيب', 'receptionist' => 'استقبال', 'accountant' => 'محاسب', 'lab_technician' => 'فني مختبر', 'pharmacist' => 'صيدلي', 'nurse' => 'ممرض', 'staff' => 'موظف' } }}</p>
                </div>
                <div class="p-4 border rounded-xl bg-gray-50">
                    <p class="text-xs text-gray-500 font-medium mb-1">البريد الإلكتروني</p>
                    <p class="font-bold text-gray-800" dir="ltr">{{ $user->email }}</p>
                </div>
                <div class="p-4 border rounded-xl bg-gray-50">
                    <p class="text-xs text-gray-500 font-medium mb-1">رقم الهاتف</p>
                    <p class="font-bold text-gray-800" dir="ltr">{{ $user->phone ?? '—' }}</p>
                </div>
                <div class="p-4 border rounded-xl bg-gray-50">
                    <p class="text-xs text-gray-500 font-medium mb-1">آخر تسجيل دخول</p>
                    <p class="font-bold text-gray-800">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y h:i A') : '—' }}</p>
                </div>
            </div>

            <div class="flex justify-between pt-5 mt-5 border-t border-gray-100" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('users.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 flex items-center gap-2">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    عودة للقائمة
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('users.edit', $user) }}" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        تعديل
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection