<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('item_code', 'like', "%{$request->search}%")
                    ->orWhere('name', 'like', "%{$request->search}%")
                    ->orWhere('name_ar', 'like', "%{$request->search}%");
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $inventory = $query->latest()->paginate(15);
        $inStockCount = Inventory::where('status', 'in_stock')->count();
        $lowStockCount = Inventory::where('status', 'low_stock')->count();
        $outOfStockCount = Inventory::where('status', 'out_of_stock')->count();

        return view('inventory.index', compact('inventory', 'inStockCount', 'lowStockCount', 'outOfStockCount'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'category' => 'required|in:medication,equipment,supplies,consumable',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string',
            'supplier_phone' => 'nullable|string',
            'expiry_date' => 'nullable|date|after:today',
            'location' => 'nullable|string',
        ]);

        $validated['item_code'] = 'INV' . str_pad(Inventory::max('id') + 1, 6, '0', STR_PAD_LEFT);

        $item = Inventory::create($validated);
        $item->updateStatus();

        return redirect()->route('inventory.index')
            ->with('success', 'تم إضافة الصنف بنجاح');
    }

    public function show(Inventory $inventory)
    {
        $inventory->load('transactions.performedByUser');

        return view('inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'category' => 'required|in:medication,equipment,supplies,consumable',
            'description' => 'nullable|string',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string',
            'supplier_phone' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'location' => 'nullable|string',
        ]);

        $inventory->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'تم تحديث الصنف بنجاح');
    }

    public function adjustStock(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out,adjustment,return',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $newQuantity = match ($validated['type']) {
            'in', 'return' => $inventory->quantity + $validated['quantity'],
            'out', 'adjustment' => max(0, $inventory->quantity - $validated['quantity']),
        };

        InventoryTransaction::create([
            'inventory_id' => $inventory->id,
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'unit_price' => $inventory->unit_price,
            'performed_by' => auth()->id(),
            'notes' => $validated['notes'],
        ]);

        $inventory->update(['quantity' => $newQuantity]);
        $inventory->updateStatus();

        return redirect()->route('inventory.show', $inventory)
            ->with('success', 'تم تعديل المخزون بنجاح');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'تم حذف الصنف بنجاح');
    }
}
