<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor', 'appointment']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('record_number', 'like', "%{$request->search}%")
                    ->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$request->search}%")->orWhere('last_name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $records = $query->latest('visit_date')->paginate(15);

        return view('medical-records.index', compact('records'));
    }

    public function create()
    {
        $patients = Patient::where('status', '!=', 'inactive')->latest()->get();
        $doctors = Doctor::where('status', 'active')->get();

        return view('medical-records.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'type' => 'required|in:visit,emergency,surgery,follow_up,lab_result,imaging',
            'visit_date' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'notes' => 'nullable|string',
            'temperature' => 'nullable|numeric|min:30|max:45',
            'blood_pressure_systolic' => 'nullable|integer|min:50|max:300',
            'blood_pressure_diastolic' => 'nullable|integer|min:20|max:200',
            'heart_rate' => 'nullable|integer|min:30|max:250',
            'weight' => 'nullable|numeric|min:0.5|max:500',
            'height' => 'nullable|numeric|min:20|max:300',
            'blood_sugar' => 'nullable|numeric|min:0|max:1000',
        ]);

        $validated['record_number'] = MedicalRecord::generateRecordNumber();

        MedicalRecord::create($validated);

        return redirect()->route('medical-records.index')
            ->with('success', 'تم إنشاء السجل الطبي بنجاح');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'appointment', 'prescriptions', 'labTests']);

        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $patients = Patient::where('status', '!=', 'inactive')->latest()->get();
        $doctors = Doctor::where('status', 'active')->get();

        return view('medical-records.edit', compact('medicalRecord', 'patients', 'doctors'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'type' => 'required|in:visit,emergency,surgery,follow_up,lab_result,imaging',
            'visit_date' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'notes' => 'nullable|string',
            'temperature' => 'nullable|numeric|min:30|max:45',
            'blood_pressure_systolic' => 'nullable|integer|min:50|max:300',
            'blood_pressure_diastolic' => 'nullable|integer|min:20|max:200',
            'heart_rate' => 'nullable|integer|min:30|max:250',
            'weight' => 'nullable|numeric|min:0.5|max:500',
            'height' => 'nullable|numeric|min:20|max:300',
            'blood_sugar' => 'nullable|numeric|min:0|max:1000',
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('medical-records.index')
            ->with('success', 'تم تحديث السجل الطبي بنجاح');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
            ->with('success', 'تم حذف السجل الطبي بنجاح');
    }
}
