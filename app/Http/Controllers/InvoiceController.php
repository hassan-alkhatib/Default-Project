<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['patient', 'createdBy']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', "%{$request->search}%")
                    ->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$request->search}%")->orWhere('last_name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->where('invoice_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->where('invoice_date', '<=', $request->date_to);
        }

        $invoices = $query->latest()->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::where('status', '!=', 'inactive')->latest()->get();

        return view('invoices.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $validated['invoice_number'] = Invoice::generateInvoiceNumber();
        $validated['created_by_user_id'] = auth()->id();

        $subtotal = collect($validated['items'])->sum(fn($item) => $item['quantity'] * $item['unit_price']);
        $taxAmount = $subtotal * (($validated['tax_rate'] ?? 0) / 100);
        $discountAmount = $validated['discount_amount'] ?? 0;

        $invoiceData = collect($validated)->except(['items', 'tax_rate'])->toArray();
        $invoiceData['subtotal'] = $subtotal;
        $invoiceData['tax_amount'] = $taxAmount;
        $invoiceData['discount_amount'] = $discountAmount;
        $invoiceData['total_amount'] = $subtotal + $taxAmount - $discountAmount;
        $invoiceData['status'] = 'pending';

        $invoice = Invoice::create($invoiceData);

        foreach ($validated['items'] as $item) {
            $item['total'] = $item['quantity'] * $item['unit_price'];
            $invoice->items()->create($item);
        }

        return redirect()->route('invoices.index')
            ->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'items', 'createdBy', 'appointment']);

        return view('invoices.show', compact('invoice'));
    }

    public function updatePayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,insurance,bank_transfer,online',
        ]);

        $invoice->update([
            'paid_amount' => $validated['paid_amount'],
            'payment_method' => $validated['payment_method'],
            'status' => $validated['paid_amount'] >= $invoice->total_amount ? 'paid' : 'partial',
        ]);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'تم تسجيل الدفع بنجاح');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->update(['status' => 'cancelled']);

        return redirect()->route('invoices.index')
            ->with('success', 'تم إلغاء الفاتورة بنجاح');
    }
}
