@extends('layouts.app')

@section('title', 'الوصفة - ' . $prescription->prescription_number)
@section('page-title', 'تفاصيل الوصفة الطبية')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-gradient-to-l from-purple-700 to-purple-900 p-6 text-white" data-aos="fade-down" data-aos-delay="120">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">{{ $prescription->prescription_number }}</h2>
                    <p class="text-purple-200 mt-1">{{ $prescription->prescription_date->format('l, d/m/Y') }}</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-xl font-semibold">
                    {{ $prescription->status == 'active' ? 'نشطة' : ($prescription->status == 'completed' ? 'مكتملة' : 'ملغاة') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6" data-aos="fade-up" data-aos-delay="160">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">المريض</p>
                <a href="{{ route('patients.show', $prescription->patient) }}" class="font-semibold text-blue-600 hover:underline">
                    {{ $prescription->patient->full_name }}
                </a>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الطبيب</p>
                <p class="font-semibold text-gray-800">د. {{ $prescription->doctor->full_name }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">صالح حتى</p>
                <p class="font-semibold text-gray-800">{{ $prescription->valid_until ? $prescription->valid_until->format('d/m/Y') : '—' }}</p>
            </div>
        </div>

        <div class="px-6 pb-6" data-aos="fade-up" data-aos-delay="200">
            <h3 class="font-bold text-gray-800 mb-4">الأدوية الموصوفة</h3>
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">الدواء</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">الجرعة</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">التكرار</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">المدة</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">الكمية</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($prescription->items as $item)
                            <tr class="hover:bg-gray-50" data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 25 }}">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-semibold text-gray-800">{{ $item->medication_name }}</p>
                                    @if($item->instructions)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->instructions }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $item->dosage }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $item->frequency }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $item->duration ?: '—' }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-700">{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($prescription->notes)
            <div class="mx-6 mb-6 p-4 bg-gray-50 rounded-xl" data-aos="fade-up" data-aos-delay="220">
                <p class="text-sm font-bold text-gray-700 mb-1">ملاحظات:</p>
                <p class="text-sm text-gray-600">{{ $prescription->notes }}</p>
            </div>
        @endif
    </div>
</div>
@endsection