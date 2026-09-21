<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'department']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('appointment_number', 'like', "%{$request->search}%")
                    ->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$request->search}%")->orWhere('last_name', 'like', "%{$request->search}%"))
                    ->orWhereHas('doctor', fn($dq) => $dq->where('first_name', 'like', "%{$request->search}%")->orWhere('last_name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->where('appointment_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->where('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->latest('appointment_date')->paginate(15);
        $doctors = Doctor::where('status', 'active')->get();

        return view('appointments.index', compact('appointments', 'doctors'));
    }

    public function create()
    {
        $patients = Patient::where('status', '!=', 'inactive')->latest()->get();
        $doctors = Doctor::where('status', 'active')->get();
        $departments = Department::where('is_active', true)->get();

        return view('appointments.create', compact('patients', 'doctors', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'nullable|exists:departments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'priority' => 'required|in:low,normal,high,urgent',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $hasConflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->exists();

        if ($hasConflict) {
            return back()->withErrors(['appointment_time' => 'هذا الطبيب مشغول في هذا الوقت'])->withInput();
        }

        $validated['appointment_number'] = Appointment::generateAppointmentNumber();
        $validated['fee'] = Doctor::find($validated['doctor_id'])->consultation_fee;

        Appointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'تم حجز الموعد بنجاح');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'department']);

        return view('appointments.show', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,confirmed,in_progress,completed,cancelled,no_show',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'تم تحديث حالة الموعد بنجاح');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.index')
            ->with('success', 'تم إلغاء الموعد بنجاح');
    }
}
