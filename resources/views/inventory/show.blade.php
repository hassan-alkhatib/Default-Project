@extends('layouts.app')

@section('title', 'الصنف - ' . $inventory->name)
@section('page-title', 'تفاصيل الصنف')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-gradient-to-l from-amber-700 to-amber-900 p-6 text-white" data-aos="fade-down" data-aos-delay="120">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">{{ $inventory->name }}</h2>
                    <p class="text-amber-200 mt-1">{{ $inventory->item_code }} • {{ $inventory->category }}</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-xl font-semibold">
                    {{ $inventory->status == 'in_stock' ? 'متوفر' : ($inventory->status == 'low_stock' ? 'منخفض' : ($inventory->status == 'expired' ? 'منتهي' : 'نفد')) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6" data-aos="fade-up" data-aos-delay="160">
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">الكمية</p>
                <p class="text-xl font-extrabold text-gray-800">{{ $inventory->quantity }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">الحد الأدنى</p>
                <p class="text-xl font-extrabold text-gray-800">{{ $inventory->minimum_stock }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">السعر</p>
                <p class="text-xl font-extrabold text-gray-800">{{ number_format($inventory->unit_price, 2) }} ر.س</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-500 mb-1">تاريخ الانتهاء</p>
                <p class="text-sm font-bold {{ $inventory->expiry_date && $inventory->expiry_date->isPast() ? 'text-red-600' : 'text-gray-800' }} mt-2">
                    {{ $inventory->expiry_date ? $inventory->expiry_date->format('d/m/Y') : '—' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" data-aos="fade-up" data-aos-delay="200">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="move" class="w-5 h-5 text-blue-600"></i>
                تعديل المخزون
            </h3>
            <form method="POST" action="{{ route('inventory.adjust', $inventory) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع الحركة *</label>
                    <select name="type" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                        <option value="in">إدخال (استلام)</option>
                        <option value="out">إخراج (صرف)</option>
                        <option value="adjustment">تسوية</option>
                        <option value="return">مرتجع</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الكمية *</label>
                    <input type="number" name="quantity" required min="1"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl"></textarea>
                </div>
                <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                    تنفيذ الحركة
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="240">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-purple-600"></i>
                    سجل الحركات
                </h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                @forelse($inventory->transactions as $tx)
                    <div class="p-4 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center
                            @if($tx->type == 'in' || $tx->type == 'return') bg-green-100 text-green-600
                            @else bg-red-100 text-red-600 @endif">
                            <i data-lucide="{{ $tx->type == 'in' || $tx->type == 'return' ? 'arrow-down-left' : 'arrow-up-right' }}" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">
                                {{ match($tx->type) { 'in' => 'استلام', 'out' => 'صرف', 'adjustment' => 'تسوية', 'return' => 'مرتجع' } }}
                                — {{ $tx->quantity }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $tx->performedByUser->name ?? '—' }} • {{ $tx->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">لا توجد حركات</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection