<?php

namespace App\Http\Controllers;

use App\Models\BedAdmission;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function index(Request $request)
    {
        $query = BedAdmission::with(['patient', 'room', 'doctor']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $admissions = $query->latest()->paginate(15);
        $availableRooms = Room::where('status', 'available')
            ->whereColumn('current_occupancy', '<', 'capacity')
            ->get();

        $stats = [
            'total_beds' => Room::sum('capacity'),
            'occupied_beds' => Room::sum('current_occupancy'),
            'available_beds' => Room::sum('capacity') - Room::sum('current_occupancy'),
            'active_admissions' => BedAdmission::where('status', 'active')->count(),
        ];

        return view('beds.index', compact('admissions', 'availableRooms', 'stats'));
    }

    public function create()
    {
        $patients = Patient::where('status', '!=', 'inactive')->latest()->get();
        $doctors = Doctor::where('status', 'active')->get();
        $rooms = Room::where('status', 'available')
            ->whereColumn('current_occupancy', '<', 'capacity')
            ->with('department')
            ->get();

        return view('beds.create', compact('patients', 'doctors', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:rooms,id',
            'doctor_id' => 'required|exists:doctors,id',
            'admission_date' => 'required|date|after_or_equal:today',
            'expected_discharge_date' => 'nullable|date|after_or_equal:admission_date',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $room = Room::find($validated['room_id']);

        if ($room->current_occupancy >= $room->capacity) {
            return back()->withErrors(['room_id' => 'الغرفة ممتلئة'])->withInput();
        }

        BedAdmission::create($validated);
        $room->increment('current_occupancy');
        $room->updateStatus();

        return redirect()->route('beds.index')
            ->with('success', 'تم تسجيل الدخول بنجاح');
    }

    public function show(BedAdmission $bedAdmission)
    {
        $bedAdmission->load(['patient', 'room.department', 'doctor']);

        return view('beds.show', compact('bedAdmission'));
    }

    public function discharge(BedAdmission $bedAdmission)
    {
        $bedAdmission->update([
            'status' => 'discharged',
            'actual_discharge_date' => now(),
        ]);

        $room = $bedAdmission->room;
        $room->decrement('current_occupancy');
        $room->updateStatus();

        return redirect()->route('beds.index')
            ->with('success', 'تم تسجيل الخروج بنجاح');
    }

    public function destroy(BedAdmission $bedAdmission)
    {
        $room = $bedAdmission->room;
        $room->decrement('current_occupancy');
        $room->updateStatus();

        $bedAdmission->delete();

        return redirect()->route('beds.index')
            ->with('success', 'تم حذف السجل بنجاح');
    }
}
