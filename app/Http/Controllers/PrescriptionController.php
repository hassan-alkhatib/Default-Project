<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with(['patient', 'doctor']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('prescription_number', 'like', "%{$request->search}%")
                    ->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$request->search}%")->orWhere('last_name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $prescriptions = $query->latest()->paginate(15);

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $patients = Patient::where('status', '!=', 'inactive')->latest()->get();
        $doctors = Doctor::where('status', 'active')->get();

        return view('prescriptions.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'prescription_date' => 'required|date',
            'valid_until' => 'nullable|date|after_or_equal:prescription_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medication_name' => 'required|string',
            'items.*.dosage' => 'required|string',
            'items.*.frequency' => 'required|string',
            'items.*.duration' => 'nullable|string',
            'items.*.instructions' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $validated['prescription_number'] = Prescription::generatePrescriptionNumber();

        $prescription = Prescription::create(collect($validated)->except('items')->toArray());

        foreach ($validated['items'] as $item) {
            $prescription->items()->create($item);
        }

        return redirect()->route('prescriptions.index')
            ->with('success', 'تم إنشاء الوصفة الطبية بنجاح');
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'doctor', 'items']);

        return view('prescriptions.show', compact('prescription'));
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->update(['status' => 'cancelled']);

        return redirect()->route('prescriptions.index')
            ->with('success', 'تم إلغاء الوصفة الطبية بنجاح');
    }
}
