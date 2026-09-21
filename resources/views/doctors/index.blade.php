@extends('layouts.app')

@section('title', 'الأطباء')
@section('page-title', 'إدارة الأطباء')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم أو التخصص..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                <select name="department_id" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الأقسام</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>في إجازة</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    بحث
                </button>
            </form>
            <a href="{{ route('doctors.create') }}" class="px-6 py-2.5 bg-gradient-to-l from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition flex items-center gap-2 shadow-lg shadow-green-600/20">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                إضافة طبيب
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($doctors as $doctor)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all">
                <div class="p-6 relative">
                    <div class="absolute top-0 left-0 right-0 h-20 bg-gradient-to-l from-blue-600 to-blue-800"></div>
                    <div class="relative flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-xl font-bold ring-4 ring-white shadow-lg">
                            {{ strtoupper(substr($doctor->first_name, 0, 1)) }}{{ strtoupper(substr($doctor->last_name, 0, 1)) }}
                        </div>
                        <h3 class="mt-3 font-bold text-gray-800 text-lg">{{ $doctor->full_name }}</h3>
                        <p class="text-sm text-blue-600 font-medium">{{ $doctor->specialization }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $doctor->department->name ?? 'بدون قسم' }}</p>

                        <span class="mt-3 px-3 py-1 rounded-full text-xs font-semibold
                            @if($doctor->status == 'active') bg-green-100 text-green-600
                            @elseif($doctor->status == 'on_leave') bg-yellow-100 text-yellow-600
                            @else bg-gray-100 text-gray-500 @endif">
                            {{ $doctor->status == 'active' ? 'نشط' : ($doctor->status == 'on_leave' ? 'في إجازة' : 'غير نشط') }}
                        </span>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>رسوم الكشف</span>
                        <span class="font-semibold text-gray-800">{{ number_format($doctor->consultation_fee, 0) }} ر.س</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>الهاتف</span>
                        <span class="font-semibold" dir="ltr">{{ $doctor->phone ?: '—' }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>المواعيد</span>
                        <span class="font-semibold text-gray-800">{{ $doctor->appointments_count ?? $doctor->appointments->count() ?? 0 }}</span>
                    </div>
                </div>
                <div class="px-6 pb-6 flex gap-2">
                    <a href="{{ route('doctors.show', $doctor) }}" class="flex-1 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-semibold text-center hover:bg-blue-100 transition">
                        عرض
                    </a>
                    <a href="{{ route('doctors.edit', $doctor) }}" class="flex-1 py-2 bg-yellow-50 text-yellow-700 rounded-xl text-sm font-semibold text-center hover:bg-yellow-100 transition">
                        تعديل
                    </a>
                    <form method="POST" action="{{ route('doctors.destroy', $doctor) }}" class="flex-1" onsubmit="return confirm('حذف الطبيب؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 bg-red-50 text-red-700 rounded-xl text-sm font-semibold hover:bg-red-100 transition">
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-16 text-center text-gray-400">
                <i data-lucide="stethoscope" class="w-14 h-14 mx-auto mb-3 opacity-30"></i>
                <p class="font-medium">لا يوجد أطباء</p>
            </div>
        @endforelse
    </div>

    <div class="flex justify-center">
        {{ $doctors->links() }}
    </div>
</div>
@endsection