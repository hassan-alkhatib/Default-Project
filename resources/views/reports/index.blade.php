@extends('layouts.app')

@section('title', 'التقارير')
@section('page-title', 'مركز التقارير')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('reports.patients') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 hover:shadow-lg transition-all group" data-aos="fade-up" data-aos-delay="80">
        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
            <i data-lucide="users" class="w-8 h-8 text-blue-600"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800">تقرير المرضى</h3>
        <p class="text-sm text-gray-500 mt-1">تحليلات وإحصائيات المرضى، الفئات العمرية، فصائل الدم</p>
        <span class="inline-flex items-center gap-1 text-blue-600 text-sm font-semibold mt-4">عرض التقرير <i data-lucide="arrow-left" class="w-4 h-4"></i></span>
    </a>

    <a href="{{ route('reports.appointments') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 hover:shadow-lg transition-all group" data-aos="fade-up" data-aos-delay="140">
        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
            <i data-lucide="calendar-check" class="w-8 h-8 text-green-600"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800">تقرير المواعيد</h3>
        <p class="text-sm text-gray-500 mt-1">تحليلات المواعيد، توزيع الحالات، أشهر الأطباء</p>
        <span class="inline-flex items-center gap-1 text-green-600 text-sm font-semibold mt-4">عرض التقرير <i data-lucide="arrow-left" class="w-4 h-4"></i></span>
    </a>

    <a href="{{ route('reports.revenue') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 hover:shadow-lg transition-all group" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
            <i data-lucide="trending-up" class="w-8 h-8 text-orange-600"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800">تقرير الإيرادات</h3>
        <p class="text-sm text-gray-500 mt-1">الإيرادات الشهرية، طرق الدفع، المبالغ المعلقة</p>
        <span class="inline-flex items-center gap-1 text-orange-600 text-sm font-semibold mt-4">عرض التقرير <i data-lucide="arrow-left" class="w-4 h-4"></i></span>
    </a>
</div>
@endsection