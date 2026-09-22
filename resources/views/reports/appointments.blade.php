@extends('layouts.app')

@section('title', 'تقرير المواعيد')
@section('page-title', 'تقرير إحصائيات المواعيد')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">إجمالي المواعيد</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1" data-counter data-value="{{ $totalAppointments }}">0</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm text-gray-500">مواعيد اليوم</p>
            <p class="text-3xl font-extrabold text-blue-600 mt-1" data-counter data-value="{{ $todayAppointments }}">0</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" data-aos="fade-up" data-aos-delay="160">
            <h3 class="font-bold text-gray-800 mb-4">توزيع حالات المواعيد</h3>
            <div class="space-y-4">
                @php $total = $statusDistribution->sum('count'); @endphp
                @foreach($statusDistribution as $s)
                    @php
                        $pct = $total > 0 ? round(($s->count / $total) * 100) : 0;
                        $color = match($s->status) {
                            'completed' => 'bg-green-500',
                            'confirmed' => 'bg-blue-500',
                            'in_progress' => 'bg-yellow-500',
                            'cancelled' => 'bg-red-500',
                            'no_show' => 'bg-orange-500',
                            default => 'bg-gray-400',
                        };
                        $label = match($s->status) {
                            'scheduled' => 'مجدول', 'confirmed' => 'مؤكد', 'in_progress' => 'جاري',
                            'completed' => 'مكتمل', 'cancelled' => 'ملغي', 'no_show' => 'لم يحضر',
                        };
                    @endphp
                    <div data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 40 }}">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700">{{ $label }}</span>
                            <span class="text-gray-600">{{ $s->count }} ({{ $pct }}%)</span>
                        </div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $color }} rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" data-aos="fade-up" data-aos-delay="200">
            <h3 class="font-bold text-gray-800 mb-4">الاتجاه الشهري (آخر 6 أشهر)</h3>
            <div class="flex items-end gap-3 h-52">
                @foreach($monthlyTrend as $trend)
                    @php
                        $max = max(1, collect($monthlyTrend)->max('count'));
                        $h = round(($trend['count'] / $max) * 100);
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 40 }}">
                        <span class="text-xs text-gray-600 font-semibold">{{ $trend['count'] }}</span>
                        <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg" style="height: {{ $h }}%"></div>
                        <span class="text-xs font-medium text-gray-500">{{ $trend['month'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2" data-aos="fade-up" data-aos-delay="240">
            <h3 class="font-bold text-gray-800 mb-4">أكثر الأطباء حجزاً</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الطبيب</th>
                            <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">التخصص</th>
                            <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">عدد المواعيد</th>
                            <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">النسبة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($topDoctors as $doctor)
                            <tr data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 30 }}">
                                <td class="px-5 py-3">د. {{ $doctor->full_name }}</td>
                                <td class="px-5 py-3 text-sm text-gray-600">{{ $doctor->specialization }}</td>
                                <td class="px-5 py-3 font-bold text-gray-800">{{ $doctor->appointments_count }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $total > 0 ? round(($doctor->appointments_count / $total) * 100) : 0 }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600">{{ $total > 0 ? round(($doctor->appointments_count / $total) * 100) : 0 }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection