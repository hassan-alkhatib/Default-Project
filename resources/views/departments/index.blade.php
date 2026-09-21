@extends('layouts.app')

@section('title', 'الأقسام')
@section('page-title', 'أقسام المستشفى')

@section('content')
<div class="space-y-6">
    <div class="flex justify-end" data-aos="fade-down" data-aos-delay="80">
        <a href="{{ route('departments.create') }}" data-button-glow class="px-6 py-2.5 bg-gradient-to-l from-teal-600 to-teal-700 text-white rounded-xl font-semibold hover:from-teal-700 hover:to-teal-800 transition flex items-center gap-2">
            <i data-lucide="building-2" class="w-5 h-5"></i>
            إضافة قسم
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($departments as $dept)
            <a href="{{ route('departments.show', $dept) }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all" data-aos="fade-up" data-aos-delay="{{ 120 + $loop->index * 50 }}">
                <div class="p-5 border-b border-gray-100 flex items-start justify-between">
                    <div>
                        <p class="font-extrabold text-gray-800 text-lg">{{ $dept->name }}</p>
                        <p class="text-sm text-gray-500">{{ $dept->name_ar }}</p>
                    </div>
                    <div class="w-11 h-11 bg-teal-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="building-2" class="w-6 h-6 text-teal-600"></i>
                    </div>
                </div>
                <div class="p-5 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>الأطباء</span>
                        <span class="font-bold text-gray-800">{{ $dept->doctors_count }} طبيب</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>الغرف</span>
                        <span class="font-bold text-gray-800">{{ $dept->rooms_count }} غرفة</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>الموقع</span>
                        <span class="font-semibold">{{ $dept->location ?: '—' }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-16 text-center text-gray-400">
                <i data-lucide="building-2" class="w-14 h-14 mx-auto mb-3 opacity-30"></i>
                <p class="font-medium">لا توجد أقسام</p>
            </div>
        @endforelse
    </div>

    <div class="flex justify-center">
        {{ $departments->links() }}
    </div>
</div>
@endsection