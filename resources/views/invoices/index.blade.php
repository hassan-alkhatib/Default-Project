@extends('layouts.app')

@section('title', 'الفواتير')
@section('page-title', 'إدارة الفواتير')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5" data-aos="fade-down" data-aos-delay="80">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1" data-aos="fade-left" data-aos-delay="120">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث برقم الفاتورة أو المريض..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلقة</option>
                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>مدفوعة جزئياً</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مدفوعة</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>متأخرة</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    بحث
                </button>
            </form>
            <a href="{{ route('invoices.create') }}" data-button-glow class="px-6 py-2.5 bg-gradient-to-l from-orange-600 to-orange-700 text-white rounded-xl font-semibold hover:from-orange-700 hover:to-orange-800 transition flex items-center gap-2 shadow-lg shadow-orange-600/20" data-aos="zoom-in" data-aos-delay="150">
                <i data-lucide="file-plus" class="w-5 h-5"></i>
                إنشاء فاتورة
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="170">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">رقم الفاتورة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المريض</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">التاريخ</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المبلغ</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المدفوع</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المتبقي</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50 transition" data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 25 }}">
                            <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $invoice->invoice_number }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('patients.show', $invoice->patient) }}" class="text-sm font-medium text-gray-800 hover:text-blue-600 hover:underline">
                                    {{ $invoice->patient->full_name }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-sm font-bold text-gray-800">{{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="px-5 py-3 text-sm font-semibold text-green-600">{{ number_format($invoice->paid_amount, 2) }}</td>
                            <td class="px-5 py-3 text-sm font-semibold text-red-600">{{ number_format($invoice->balance, 2) }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($invoice->status == 'paid') bg-green-100 text-green-600
                                    @elseif($invoice->status == 'partial') bg-yellow-100 text-yellow-600
                                    @elseif($invoice->status == 'overdue') bg-red-100 text-red-600
                                    @elseif($invoice->status == 'cancelled') bg-gray-100 text-gray-500
                                    @else bg-blue-100 text-blue-600 @endif">
                                    {{ match($invoice->status) { 'pending' => 'معلقة', 'partial' => 'جزئية', 'paid' => 'مدفوعة', 'overdue' => 'متأخرة', 'cancelled' => 'ملغاة', 'draft' => 'مسودة' } }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <button onclick="window.print()" class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition" title="طباعة">
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-16 text-center text-gray-400">لا توجد فواتير</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center" data-aos="fade-up" data-aos-delay="220">
        {{ $invoices->links() }}
    </div>
</div>
@endsection