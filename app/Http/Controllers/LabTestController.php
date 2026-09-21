<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\LabTest;
use App\Models\Patient;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    public function index(Request $request)
    {
        $query = LabTest::with(['patient', 'doctor']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('test_number', 'like', "%{$request->search}%")
                    ->orWhere('test_name', 'like', "%{$request->search}%")
                    ->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$request->search}%")->orWhere('last_name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $labTests = $query->latest()->paginate(15);

        return view('lab-tests.index', compact('labTests'));
    }

    public function create()
    {
        $patients = Patient::where('status', '!=', 'inactive')->latest()->get();
        $doctors = Doctor::where('status', 'active')->get();

        return view('lab-tests.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'test_type' => 'required|string',
            'test_name' => 'required|string',
            'description' => 'nullable|string',
            'test_date' => 'required|date',
            'urgency' => 'required|in:normal,urgent,stat',
        ]);

        $validated['test_number'] = LabTest::generateTestNumber();

        LabTest::create($validated);

        return redirect()->route('lab-tests.index')
            ->with('success', 'تم طلب التحليل بنجاح');
    }

    public function show(LabTest $labTest)
    {
        $labTest->load(['patient', 'doctor', 'medicalRecord']);

        return view('lab-tests.show', compact('labTest'));
    }

    public function updateResults(Request $request, LabTest $labTest)
    {
        $validated = $request->validate([
            'results' => 'required|string',
            'reference_range' => 'nullable|string',
        ]);

        $labTest->update([
            ...$validated,
            'result_date' => now(),
            'status' => 'completed',
        ]);

        return redirect()->route('lab-tests.show', $labTest)
            ->with('success', 'تم تسجيل النتائج بنجاح');
    }

    public function destroy(LabTest $labTest)
    {
        $labTest->update(['status' => 'cancelled']);

        return redirect()->route('lab-tests.index')
            ->with('success', 'تم إلغاء التحليل بنجاح');
    }
}
