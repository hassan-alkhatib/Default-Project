@extends('layouts.app')

@section('title', 'المرضى')
@section('page-title', 'إدارة المرضى')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5" data-aos="fade-down" data-aos-delay="80">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1" data-aos="fade-left" data-aos-delay="120">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم، رقم الملف، الهاتف..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <select name="gender" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الجنسين</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                </select>
                <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="critical" {{ request('status') == 'critical' ? 'selected' : '' }}>حرج</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    بحث
                </button>
            </form>
            <a href="{{ route('patients.create') }}" data-button-glow class="px-6 py-2.5 bg-gradient-to-l from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition flex items-center gap-2 shadow-lg shadow-green-600/20" data-aos="zoom-in" data-aos-delay="150">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                إضافة مريض
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="170">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">رقم الملف</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الاسم</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الجنس</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">العمر</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الهاتف</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">فصيلة الدم</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-gray-50 transition" data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 25 }}">
                            <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $patient->patient_number }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($patient->first_name, 0, 1)) }}{{ strtoupper(substr($patient->last_name, 0, 1)) }}
                                    </div>
                                    <a href="{{ route('patients.show', $patient) }}" class="font-semibold text-gray-800 hover:text-blue-600 hover:underline">
                                        {{ $patient->full_name }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $patient->gender === 'male' ? 'ذكر' : 'أنثى' }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $patient->age }} سنة</td>
                            <td class="px-5 py-3 text-sm text-gray-600" dir="ltr">{{ $patient->phone ?: '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2.5 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-bold">{{ $patient->blood_type ?: '—' }}</span>
                            </td>
                            <td class="px-5 py-3">
                                @php
                                    $statusClass = match($patient->status) {
                                        'active' => 'bg-green-100 text-green-600',
                                        'critical' => 'bg-red-100 text-red-600',
                                        'inactive' => 'bg-gray-100 text-gray-500',
                                    };
                                    $statusLabel = match($patient->status) {
                                        'active' => 'نشط',
                                        'critical' => 'حرج',
                                        'inactive' => 'غير نشط',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('patients.show', $patient) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="عرض">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('patients.edit', $patient) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="تعديل">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('patients.destroy', $patient) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا المريض؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="حذف">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-16 text-center text-gray-400">
                                <i data-lucide="users" class="w-14 h-14 mx-auto mb-3 opacity-30"></i>
                                <p class="font-medium">لا يوجد مرضى</p>
                                <p class="text-sm mt-1">ابدأ بإضافة أول مريض</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">
        {{ $patients->links() }}
    </div>
</div>
@endsection