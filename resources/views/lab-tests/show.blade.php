@extends('layouts.app')

@section('title', 'التحليل - ' . $labTest->test_number)
@section('page-title', 'تفاصيل التحليل')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-gradient-to-l from-cyan-700 to-cyan-900 p-6 text-white" data-aos="fade-down" data-aos-delay="120">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">{{ $labTest->test_number }}</h2>
                    <p class="text-cyan-200 mt-1">{{ $labTest->test_name }} • {{ $labTest->test_date->format('d/m/Y') }}</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-xl font-semibold">
                    {{ $labTest->status == 'completed' ? 'مكتمل' : ($labTest->status == 'in_progress' ? 'جاري' : 'مطلوب') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6" data-aos="fade-up" data-aos-delay="160">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">المريض</p>
                <a href="{{ route('patients.show', $labTest->patient) }}" class="font-semibold text-blue-600 hover:underline">{{ $labTest->patient->full_name }}</a>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الطبيب</p>
                <p class="font-semibold text-gray-800">د. {{ $labTest->doctor->full_name }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">الأولوية</p>
                <p class="font-semibold text-gray-800">{{ $labTest->urgency == 'stat' ? 'عاجل جداً' : ($labTest->urgency == 'urgent' ? 'عاجل' : 'عادي') }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">تاريخ النتيجة</p>
                <p class="font-semibold text-gray-800">{{ $labTest->result_date ? $labTest->result_date->format('d/m/Y') : '—' }}</p>
            </div>
        </div>

        @if($labTest->description)
            <div class="px-6" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm font-bold text-gray-700 mb-1">وصف:</p>
                    <p class="text-sm text-gray-600">{{ $labTest->description }}</p>
                </div>
            </div>
        @endif

        @if($labTest->results)
            <div class="px-6 pb-6" data-aos="fade-up" data-aos-delay="220">
                <div class="p-5 bg-white border border-cyan-200 rounded-xl">
                    <h3 class="font-bold text-cyan-700 mb-3 flex items-center gap-2">
                        <i data-lucide="flask-round" class="w-5 h-5"></i>
                        النتائج:
                    </h3>
                    <div class="prose prose-sm max-w-none">
                        {!! nl2br(e($labTest->results)) !!}
                    </div>
                    @if($labTest->reference_range)
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs font-bold text-gray-600 mb-1">المدى المرجعي:</p>
                            <p class="text-sm text-gray-700">{{ $labTest->reference_range }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @if($labTest->status !== 'completed')
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" data-aos="fade-up" data-aos-delay="240">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="clipboard-check" class="w-5 h-5 text-green-600"></i>
            تسجيل النتائج
        </h3>
        <form method="POST" action="{{ route('lab-tests.results', $labTest) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">النتائج *</label>
                <textarea name="results" rows="5" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">{{ old('results') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">المدى المرجعي</label>
                <input type="text" name="reference_range" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
            </div>
            <button type="submit" class="px-8 py-2.5 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition flex items-center gap-2">
                <i data-lucide="check-check" class="w-4 h-4"></i>
                حفظ النتائج
            </button>
        </form>
    </div>
    @endif
</div>
@endsection