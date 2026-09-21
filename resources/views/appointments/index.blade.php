@extends('layouts.app')

@section('title', 'المواعيد')
@section('page-title', 'إدارة المواعيد')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث برقم الموعد أو اسم المريض..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                <select name="doctor_id" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الأطباء</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الحالات</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>مجدول</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>جاري</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    بحث
                </button>
            </form>
            <a href="{{ route('appointments.create') }}" class="px-6 py-2.5 bg-gradient-to-l from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition flex items-center gap-2 shadow-lg shadow-green-600/20">
                <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                حجز موعد
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">رقم الموعد</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الطبيب</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">التاريخ</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الوقت</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الأولوية</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($appointments as $appointment)
                        @php
                            $statusClass = match($appointment->status) {
                                'scheduled' => 'bg-gray-100 text-gray-600',
                                'confirmed' => 'bg-blue-100 text-blue-600',
                                'in_progress' => 'bg-yellow-100 text-yellow-600',
                                'completed' => 'bg-green-100 text-green-600',
                                'cancelled' => 'bg-red-100 text-red-600',
                                'no_show' => 'bg-orange-100 text-orange-600',
                            };
                            $statusLabel = match($appointment->status) {
                                'scheduled' => 'مجدول',
                                'confirmed' => 'مؤكد',
                                'in_progress' => 'جاري',
                                'completed' => 'مكتمل',
                                'cancelled' => 'ملغي',
                                'no_show' => 'لم يحضر',
                            };
                            $priorityClass = $appointment->priority == 'urgent' ? 'bg-red-100 text-red-700' : ($appointment->priority == 'high' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600');
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $appointment->appointment_number }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('patients.show', $appointment->patient) }}" class="text-sm font-medium text-gray-800 hover:text-blue-600 hover:underline">
                                    {{ $appointment->patient->full_name }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">د. {{ $appointment->doctor->full_name }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-sm font-semibold text-gray-700">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $priorityClass }}">
                                    {{ match($appointment->priority) { 'low' => 'منخفضة', 'normal' => 'عادية', 'high' => 'عالية', 'urgent' => 'عاجلة' } }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="عرض">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('إلغاء هذا الموعد؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="إلغاء">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-16 text-center text-gray-400">
                                <i data-lucide="calendar-x" class="w-14 h-14 mx-auto mb-3 opacity-30"></i>
                                <p class="font-medium">لا توجد مواعيد</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">
        {{ $appointments->links() }}
    </div>
</div>
@endsection