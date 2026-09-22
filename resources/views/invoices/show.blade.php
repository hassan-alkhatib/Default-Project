@extends('layouts.app')

@section('title', 'الفاتورة - ' . $invoice->invoice_number)
@section('page-title', 'تفاصيل الفاتورة')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden print-area" data-aos="fade-up" data-aos-delay="80">
        <div class="bg-gradient-to-l from-orange-700 to-orange-900 p-6 text-white print-header" data-aos="fade-down" data-aos-delay="120">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold">{{ $invoice->invoice_number }}</h2>
                    <p class="text-orange-200 mt-1">{{ $invoice->invoice_date->format('l, d/m/Y') }}</p>
                </div>
                <div class="text-left">
                    <p class="font-bold">مستشفى النور التخصصي</p>
                    <p class="text-xs text-orange-200 mt-1">نظام إدارة المستشفى المتكامل</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6" data-aos="fade-up" data-aos-delay="160">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">المريض</p>
                <a href="{{ route('patients.show', $invoice->patient) }}" class="font-semibold text-blue-600 hover:underline">{{ $invoice->patient->full_name }}</a>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">رقم الملف</p>
                <p class="font-semibold text-gray-800">{{ $invoice->patient->patient_number }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">أنشأها</p>
                <p class="font-semibold text-gray-800">{{ $invoice->createdBy->name }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">حالة الدفع</p>
                <span class="px-3 py-1 inline-block rounded-full text-xs font-semibold
                    @if($invoice->status == 'paid') bg-green-100 text-green-600
                    @elseif($invoice->status == 'partial') bg-yellow-100 text-yellow-600
                    @elseif($invoice->status == 'overdue') bg-red-100 text-red-600
                    @else bg-blue-100 text-blue-600 @endif">
                    {{ match($invoice->status) { 'pending' => 'معلقة', 'partial' => 'جزئية', 'paid' => 'مدفوعة', 'overdue' => 'متأخرة', 'cancelled' => 'ملغاة', 'draft' => 'مسودة' } }}
                </span>
            </div>
        </div>

        <div class="px-6 pb-6" data-aos="fade-up" data-aos-delay="200">
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">الوصف</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">الكمية</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">سعر الوحدة</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($invoice->items as $item)
<tr data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 25 }}">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $item->description }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end" data-aos="fade-up" data-aos-delay="220">
                <div class="w-72 space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>المجموع الفرعي</span>
                        <span class="font-semibold">{{ number_format($invoice->subtotal, 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>الضريبة</span>
                        <span class="font-semibold">{{ number_format($invoice->tax_amount, 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>الخصم</span>
                        <span class="font-semibold text-red-500">- {{ number_format($invoice->discount_amount, 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>المدفوع</span>
                        <span class="font-semibold text-green-600">- {{ number_format($invoice->paid_amount, 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between text-base font-extrabold text-gray-800 pt-3 border-t border-gray-200">
                        <span>المتبقي</span>
                        <span class="{{ $invoice->balance > 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($invoice->balance, 2) }} ر.س</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($invoice->balance > 0)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" data-aos="fade-up" data-aos-delay="240">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="credit-card" class="w-5 h-5 text-green-600"></i>
            تسجيل دفعة
        </h3>
        <form method="POST" action="{{ route('invoices.payment', $invoice) }}" class="flex flex-col md:flex-row gap-3">
            @csrf
            <input type="number" name="paid_amount" step="0.01" min="0" max="{{ $invoice->balance }}" required
                   placeholder="المبلغ المدفوع ({{ number_format($invoice->balance, 2) }})"
                   class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl">
            <select name="payment_method" class="px-4 py-2.5 border border-gray-300 rounded-xl" required>
                <option value="cash">نقدي</option>
                <option value="card">بطاقة</option>
                <option value="insurance">تأمين</option>
                <option value="bank_transfer">تحويل بنكي</option>
                <option value="online">دفع إلكتروني</option>
            </select>
            <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                تسجيل الدفعة
            </button>
        </form>
    </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    @media print {
        .sidebar-link, header, .sidebar, form, .notification-bell { display: none !important; }
        .print-area { box-shadow: none; border: none; }
        body { background: white; }
        main { padding: 0 !important; }
    }
</style>
@endsection