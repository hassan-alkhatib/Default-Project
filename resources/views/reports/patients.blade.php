@extends('layouts.app')

@section('title', 'تقرير المرضى')
@section('page-title', 'تقرير إحصائيات المرضى')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">إجمالي المرضى</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ number_format($totalPatients) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">مرضى جدد هذا الشهر</p>
            <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ number_format($newPatientsThisMonth) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-4">توزيع الجنس</h3>
            <div class="space-y-4">
                @foreach($genderDistribution as $g)
                    @php
                        $pct = $totalPatients > 0 ? round(($g->count / $totalPatients) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700">{{ $g->gender == 'male' ? 'ذكر' : 'أنثى' }}</span>
                            <span class="text-gray-600">{{ $g->count }} ({{ $pct }}%)</span>
                        </div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $g->gender == 'male' ? 'bg-blue-500' : 'bg-pink-500' }} rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-4">الفئات العمرية</h3>
            <div class="space-y-4">
                @php
                    $totalAge = collect($ageGroups)->sum();
                @endphp
                @foreach($ageGroups as $range => $count)
                    @php $pct = $totalAge > 0 ? round(($count / $totalAge) * 100) : 0; @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700">{{ $range }} سنة</span>
                            <span class="text-gray-600">{{ $count }} ({{ $pct }}%)</span>
                        </div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-l from-teal-500 to-teal-400 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <h3 class="font-bold text-gray-800 mb-4">توزيع فصائل الدم</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($bloodTypes as $b)
                    <div class="p-4 bg-red-50 rounded-xl text-center">
                        <p class="text-2xl font-extrabold text-red-600">{{ $b->blood_type }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $b->count }} مريض</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection