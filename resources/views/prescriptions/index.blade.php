@extends('layouts.app')

@section('title', 'الوصفات الطبية')
@section('page-title', 'الوصفات الطبية')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5" data-aos="fade-down" data-aos-delay="80">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1" data-aos="fade-left" data-aos-delay="120">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث برقم الوصفة أو اسم المريض..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشطة</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    بحث
                </button>
            </form>
            <a href="{{ route('prescriptions.create') }}" data-button-glow class="px-6 py-2.5 bg-gradient-to-l from-purple-600 to-purple-700 text-white rounded-xl font-semibold hover:from-purple-700 hover:to-purple-800 transition flex items-center gap-2 shadow-lg shadow-purple-600/20" data-aos="zoom-in" data-aos-delay="150">
                <i data-lucide="pill" class="w-5 h-5"></i>
                وصفة جديدة
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="170">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">رقم الوصفة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الطبيب</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">التاريخ</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الأدوية</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($prescriptions as $prescription)
                        <tr class="hover:bg-gray-50 transition" data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 25 }}">
                            <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $prescription->prescription_number }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('patients.show', $prescription->patient) }}" class="text-sm font-medium text-gray-800 hover:text-blue-600 hover:underline">
                                    {{ $prescription->patient->full_name }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">د. {{ $prescription->doctor->full_name }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $prescription->prescription_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-sm text-gray-700">{{ $prescription->items_count ?? $prescription->items()->count() }} عنصر</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($prescription->status == 'active') bg-green-100 text-green-600
                                    @elseif($prescription->status == 'completed') bg-blue-100 text-blue-600
                                    @else bg-red-100 text-red-600 @endif">
                                    {{ $prescription->status == 'active' ? 'نشطة' : ($prescription->status == 'completed' ? 'مكتملة' : 'ملغاة') }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('prescriptions.show', $prescription) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('prescriptions.destroy', $prescription) }}" onsubmit="return confirm('إلغاء هذه الوصفة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-16 text-center text-gray-400">لا توجد وصفات طبية</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center" data-aos="fade-up" data-aos-delay="220">
        {{ $prescriptions->links() }}
    </div>
</div>
@endsection