@extends('layouts.app')

@section('title', 'التحاليل المخبرية')
@section('page-title', 'التحاليل المخبرية')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث برقم التحليل أو المريض..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الحالات</option>
                    <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>مطلوب</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>جاري</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    بحث
                </button>
            </form>
            <a href="{{ route('lab-tests.create') }}" class="px-6 py-2.5 bg-gradient-to-l from-cyan-600 to-cyan-700 text-white rounded-xl font-semibold hover:from-cyan-700 hover:to-cyan-800 transition flex items-center gap-2 shadow-lg shadow-cyan-600/20">
                <i data-lucide="flask-conical" class="w-5 h-5"></i>
                طلب تحليل
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">رقم التحليل</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">اسم التحليل</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الطبيب</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">التاريخ</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الأولوية</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($labTests as $labTest)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $labTest->test_number }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('patients.show', $labTest->patient) }}" class="text-sm font-medium text-gray-800 hover:text-blue-600 hover:underline">
                                    {{ $labTest->patient->full_name }}
                                </a>
                            </td>
                            <td class="px-5 py-3">
                                <p class="text-sm font-semibold text-gray-800">{{ $labTest->test_name }}</p>
                                <p class="text-xs text-gray-400">{{ $labTest->test_type }}</p>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">د. {{ $labTest->doctor->full_name }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $labTest->test_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($labTest->urgency == 'stat') bg-red-100 text-red-600
                                    @elseif($labTest->urgency == 'urgent') bg-orange-100 text-orange-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ $labTest->urgency == 'stat' ? 'عاجل جداً' : ($labTest->urgency == 'urgent' ? 'عاجل' : 'عادي') }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($labTest->status == 'completed') bg-green-100 text-green-600
                                    @elseif($labTest->status == 'in_progress') bg-yellow-100 text-yellow-600
                                    @else bg-blue-100 text-blue-600 @endif">
                                    {{ $labTest->status == 'completed' ? 'مكتمل' : ($labTest->status == 'in_progress' ? 'جاري' : 'مطلوب') }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ route('lab-tests.show', $labTest) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-16 text-center text-gray-400">لا توجد تحاليل مخبرية</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">
        {{ $labTests->links() }}
    </div>
</div>
@endsection