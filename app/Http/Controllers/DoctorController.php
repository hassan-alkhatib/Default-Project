<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('department');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                    ->orWhere('last_name', 'like', "%{$request->search}%")
                    ->orWhere('specialization', 'like', "%{$request->search}%")
                    ->orWhere('license_number', 'like', "%{$request->search}%");
            });
        }

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $doctors = $query->latest()->paginate(15);
        $departments = Department::where('is_active', true)->get();

        return view('doctors.index', compact('doctors', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();

        return view('doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'license_number' => 'required|string|unique:doctors,license_number',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'biography' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
            'schedule' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Doctor::create($validated);

        return redirect()->route('doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['department', 'appointments' => function ($q) {
            $q->latest()->take(10);
        }]);

        $todayAppointments = $doctor->appointments()
            ->whereDate('appointment_date', now())
            ->orderBy('appointment_time')
            ->get();

        return view('doctors.show', compact('doctor', 'todayAppointments'));
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::where('is_active', true)->get();

        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'license_number' => "required|string|unique:doctors,license_number,{$doctor->id}",
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'biography' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,on_leave,inactive',
            'schedule' => 'nullable|string',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctors.index')
            ->with('success', 'تم تحديث بيانات الطبيب بنجاح');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', 'تم حذف الطبيب بنجاح');
    }
}
