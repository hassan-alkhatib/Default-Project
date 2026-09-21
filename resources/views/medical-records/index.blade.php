@extends('layouts.app')

@section('title', 'السجلات الطبية')
@section('page-title', 'السجلات الطبية')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث برقم السجل أو اسم المريض..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                <select name="type" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الأنواع</option>
                    <option value="visit" {{ request('type') == 'visit' ? 'selected' : '' }}>زيارة</option>
                    <option value="emergency" {{ request('type') == 'emergency' ? 'selected' : '' }}>طوارئ</option>
                    <option value="surgery" {{ request('type') == 'surgery' ? 'selected' : '' }}>جراحة</option>
                    <option value="follow_up" {{ request('type') == 'follow_up' ? 'selected' : '' }}>متابعة</option>
                    <option value="lab_result" {{ request('type') == 'lab_result' ? 'selected' : '' }}>نتيجة تحليل</option>
                    <option value="imaging" {{ request('type') == 'imaging' ? 'selected' : '' }}>تصوير</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    بحث
                </button>
            </form>
            <a href="{{ route('medical-records.create') }}" class="px-6 py-2.5 bg-gradient-to-l from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition flex items-center gap-2 shadow-lg shadow-green-600/20">
                <i data-lucide="file-plus" class="w-5 h-5"></i>
                إضافة سجل طبي
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">رقم السجل</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الطبيب</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">النوع</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">التشخيص</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">التاريخ</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($records as $record)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $record->record_number }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('patients.show', $record->patient) }}" class="text-sm font-medium text-gray-800 hover:text-blue-600 hover:underline">
                                    {{ $record->patient->full_name }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">د. {{ $record->doctor->full_name }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($record->type == 'emergency') bg-red-100 text-red-600
                                    @elseif($record->type == 'surgery') bg-purple-100 text-purple-600
                                    @elseif($record->type == 'follow_up') bg-blue-100 text-blue-600
                                    @elseif($record->type == 'lab_result') bg-cyan-100 text-cyan-600
                                    @elseif($record->type == 'imaging') bg-orange-100 text-orange-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ match($record->type) { 'visit' => 'زيارة', 'emergency' => 'طوارئ', 'surgery' => 'جراحة', 'follow_up' => 'متابعة', 'lab_result' => 'نتيجة تحليل', 'imaging' => 'تصوير' } }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-700 max-w-xs truncate">{{ $record->diagnosis ?: '—' }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $record->visit_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('medical-records.show', $record) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('medical-records.edit', $record) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('medical-records.destroy', $record) }}" onsubmit="return confirm('حذف هذا السجل؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-16 text-center text-gray-400">لا توجد سجلات طبية</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">
        {{ $records->links() }}
    </div>
</div>
@endsection