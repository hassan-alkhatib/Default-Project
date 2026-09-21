<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('department');

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $rooms = $query->latest()->paginate(15);
        $departments = Department::where('is_active', true)->get();

        return view('rooms.index', compact('rooms', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();

        return view('rooms.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number',
            'department_id' => 'required|exists:departments,id',
            'type' => 'required|in:ward,private,icu,emergency,operating,laboratory,pharmacy',
            'capacity' => 'required|integer|min:1',
            'rate_per_day' => 'required|numeric|min:0',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'تم إضافة الغرفة بنجاح');
    }

    public function show(Room $room)
    {
        $room->load(['department', 'bedAdmissions' => function ($q) {
            $q->with('patient', 'doctor')->latest();
        }]);

        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $room->load('department');

        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'type' => 'required|in:ward,private,icu,emergency,operating,laboratory,pharmacy',
            'capacity' => 'required|integer|min:1',
            'rate_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance,reserved',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'تم تحديث الغرفة بنجاح');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'تم حذف الغرفة بنجاح');
    }
}
