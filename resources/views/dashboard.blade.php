@extends('layouts.app')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم الرئيسية')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">إجمالي المرضى</p>
                    <p class="text-2xl font-extrabold text-gray-800 mt-1">{{ number_format($stats['total_patients']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">الأطباء النشطون</p>
                    <p class="text-2xl font-extrabold text-gray-800 mt-1">{{ number_format($stats['total_doctors']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="stethoscope" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">مواعيد اليوم</p>
                    <p class="text-2xl font-extrabold text-gray-800 mt-1">{{ number_format($stats['today_appointments']) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="calendar-check" class="w-6 h-6 text-orange-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">إيرادات الشهر</p>
                    <p class="text-2xl font-extrabold text-green-600 mt-1">{{ number_format($monthlyRevenue, 2) }} ر.س</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-6 h-6 text-emerald-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i data-lucide="clock" class="w-5 h-5 text-purple-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500">مواعيد قادمة</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($stats['pending_appointments']) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i data-lucide="bed-double" class="w-5 h-5 text-red-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500">مرضى منومون</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($stats['admitted_patients']) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500">حالات حرجة</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($stats['critical_patients']) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                <i data-lucide="receipt" class="w-5 h-5 text-cyan-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500">مدفوعات معلقة</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($stats['pending_payments'], 2) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's Appointments -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                    مواعيد اليوم
                </h3>
                <a href="{{ route('appointments.create') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">إضافة موعد</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الوقت</th>
                            <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                            <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الطبيب</th>
                            <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($todayAppointments as $appointment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3 text-sm font-semibold text-gray-700">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('patients.show', $appointment->patient) }}" class="text-sm text-blue-600 hover:underline">
                                        {{ $appointment->patient->full_name }}
                                    </a>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">د. {{ $appointment->doctor->full_name }}</td>
                                <td class="px-5 py-3">
                                    @php
                                        $statusColors = [
                                            'scheduled' => 'bg-gray-100 text-gray-600',
                                            'confirmed' => 'bg-blue-100 text-blue-600',
                                            'in_progress' => 'bg-yellow-100 text-yellow-600',
                                            'completed' => 'bg-green-100 text-green-600',
                                            'cancelled' => 'bg-red-100 text-red-600',
                                            'no_show' => 'bg-orange-100 text-orange-600',
                                        ];
                                        $statusLabels = [
                                            'scheduled' => 'مجدول',
                                            'confirmed' => 'مؤكد',
                                            'in_progress' => 'جاري',
                                            'completed' => 'مكتمل',
                                            'cancelled' => 'ملغي',
                                            'no_show' => 'لم يحضر',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$appointment->status] }}">
                                        {{ $statusLabels[$appointment->status] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-gray-400">
                                    <i data-lucide="calendar-x" class="w-10 h-10 mx-auto mb-2 opacity-40"></i>
                                    لا توجد مواعيد اليوم
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Patients -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-5 h-5 text-green-600"></i>
                    أحدث المرضى
                </h3>
                <a href="{{ route('patients.create') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">إضافة</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentPatients as $patient)
                    <a href="{{ route('patients.show', $patient) }}" class="flex items-center gap-3 p-4 hover:bg-gray-50 transition">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr($patient->first_name, 0, 1)) }}{{ strtoupper(substr($patient->last_name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $patient->full_name }}</p>
                            <p class="text-xs text-gray-500">{{ $patient->patient_number }} • {{ $patient->gender === 'male' ? 'ذكر' : 'أنثى' }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $patient->created_at->diffForHumans() }}</span>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-400">لا يوجد مرضى بعد</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Weekly Chart -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="bar-chart-3" class="w-5 h-5 text-blue-600"></i>
            نشاط الأسبوع الماضي
        </h3>
        <div class="grid grid-cols-7 gap-3 items-end h-52">
            @foreach($weeklyData as $data)
                <div class="flex flex-col items-center gap-2 h-full justify-end">
                    <span class="text-xs text-gray-500">{{ $data['revenue'] > 0 ? number_format($data['revenue']) . ' ر.س' : '' }}</span>
                    <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg transition-all hover:from-blue-700 hover:to-blue-500"
                         style="height: {{ max(5, min(100, ($data['appointments'] / max(1, collect($weeklyData)->max('appointments'))) * 100)) }}%; min-height: 5px;">
                        <span class="block text-center text-white text-xs font-bold pt-1">{{ $data['appointments'] }}</span>
                    </div>
                    <span class="text-xs font-semibold text-gray-600">{{ $data['day'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="list-ordered" class="w-5 h-5 text-purple-600"></i>
                أحدث المواعيد
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">رقم الموعد</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الطبيب</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">التاريخ</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentAppointments as $appointment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $appointment->appointment_number }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('patients.show', $appointment->patient) }}" class="text-sm text-blue-600 hover:underline">
                                    {{ $appointment->patient->full_name }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">د. {{ $appointment->doctor->full_name }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-400">لا توجد مواعيد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection