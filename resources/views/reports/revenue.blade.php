@extends('layouts.app')

@section('title', 'تقرير الإيرادات')
@section('page-title', 'تقرير الإيرادات المالية')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">إجمالي الإيرادات</p>
            <p class="text-3xl font-extrabold text-green-600 mt-1">{{ number_format($totalRevenue, 2) }} ر.س</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">إيرادات هذا الشهر</p>
            <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ number_format($monthlyRevenue, 2) }} ر.س</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">مبالغ معلقة</p>
            <p class="text-3xl font-extrabold text-red-600 mt-1">{{ number_format($pendingAmount, 2) }} ر.س</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4">الاتجاه الشهري للإيرادات (آخر 6 أشهر)</h3>
        <div class="flex items-end gap-3 h-52">
            @php
                $maxRev = max(1, collect($monthlyTrend)->max('revenue'));
            @endphp
            @foreach($monthlyTrend as $trend)
                @php $h = round(($trend['revenue'] / $maxRev) * 100); @endphp
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                    <span class="text-xs text-gray-600 font-semibold">{{ number_format($trend['revenue']) }}</span>
                    <div class="w-full bg-gradient-to-t from-green-600 to-green-400 rounded-t-lg" style="height: {{ $h }}%"></div>
                    <span class="text-xs font-medium text-gray-500">{{ $trend['month'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4">طرق الدفع</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            @forelse($paymentMethods as $method)
                @php
                    $icons = ['cash' => 'banknote', 'card' => 'credit-card', 'insurance' => 'shield', 'bank_transfer' => 'landmark', 'online' => 'globe'];
                    $labels = ['cash' => 'نقدي', 'card' => 'بطاقة', 'insurance' => 'تأمين', 'bank_transfer' => 'تحويل بنكي', 'online' => 'إلكتروني'];
                @endphp
                <div class="p-5 bg-gray-50 rounded-xl text-center">
                    <i data-lucide="{{ $icons[$method->payment_method] ?? 'receipt' }}" class="w-8 h-8 mx-auto text-green-600 mb-2"></i>
                    <p class="font-bold text-gray-800 text-lg">{{ number_format($method->total, 0) }}</p>
                    <p class="text-xs text-gray-500">{{ $labels[$method->payment_method] ?? $method->payment_method }} ({{ $method->count }} معاملة)</p>
                </div>
            @empty
                <div class="col-span-full p-8 text-center text-gray-400">لا توجد بيانات دفع</div>
            @endforelse
        </div>
    </div>
</div>
@endsection