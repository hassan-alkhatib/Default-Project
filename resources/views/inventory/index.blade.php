@extends('layouts.app')

@section('title', 'المخزون')
@section('page-title', 'إدارة المخزون')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="80">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="package-check" class="w-5 h-5 text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">متوفر</p>
                    <p class="text-xl font-extrabold text-gray-800">{{ $inStockCount }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="120">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">مخزون منخفض</p>
                    <p class="text-xl font-extrabold text-yellow-600">{{ $lowStockCount }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="160">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="package-x" class="w-5 h-5 text-red-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">نفد من المخزون</p>
                    <p class="text-xl font-extrabold text-red-600">{{ $outOfStockCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5" data-aos="fade-down" data-aos-delay="90">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1" data-aos="fade-left" data-aos-delay="130">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث باسم أو رمز الصنف..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl">
                <select name="category" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الفئات</option>
                    <option value="medication" {{ request('category') == 'medication' ? 'selected' : '' }}>أدوية</option>
                    <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>معدات</option>
                    <option value="supplies" {{ request('category') == 'supplies' ? 'selected' : '' }}>مستلزمات</option>
                    <option value="consumable" {{ request('category') == 'consumable' ? 'selected' : '' }}>مواد استهلاكية</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                    بحث
                </button>
            </form>
            <a href="{{ route('inventory.create') }}" data-button-glow class="px-6 py-2.5 bg-gradient-to-l from-amber-600 to-amber-700 text-white rounded-xl font-semibold hover:from-amber-700 hover:to-amber-800 transition flex items-center gap-2" data-aos="zoom-in" data-aos-delay="160">
                <i data-lucide="package-plus" class="w-5 h-5"></i>
                إضافة صنف
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="180">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الرمز</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الاسم</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الفئة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الكمية</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحد الأدنى</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">السعر</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($inventory as $item)
                        <tr class="hover:bg-gray-50 transition" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 25 }}">
                            <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $item->item_code }}</td>
                            <td class="px-5 py-3 text-sm font-semibold text-gray-800">{{ $item->name }}</td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $item->category }}</td>
                            <td class="px-5 py-3 text-sm font-bold
                                @if($item->quantity <= 0) text-red-600
                                @elseif($item->quantity <= $item->minimum_stock) text-yellow-600
                                @else text-gray-800 @endif">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $item->minimum_stock }}</td>
                            <td class="px-5 py-3 text-sm font-semibold text-gray-700">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($item->status == 'in_stock') bg-green-100 text-green-600
                                    @elseif($item->status == 'low_stock') bg-yellow-100 text-yellow-600
                                    @elseif($item->status == 'expired') bg-gray-100 text-gray-500
                                    @else bg-red-100 text-red-600 @endif">
                                    {{ $item->status == 'in_stock' ? 'متوفر' : ($item->status == 'low_stock' ? 'منخفض' : ($item->status == 'expired' ? 'منتهي' : 'نفد')) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('inventory.show', $item) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('inventory.edit', $item) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-16 text-center text-gray-400">لا توجد أصناف</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">
        {{ $inventory->links() }}
    </div>
</div>
@endsection