<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount(['doctors', 'rooms'])->latest()->paginate(15);

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'phone' => 'nullable|string',
            'capacity' => 'required|integer|min:0',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    public function show(Department $department)
    {
        $department->load(['doctors', 'rooms']);

        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'phone' => 'nullable|string',
            'capacity' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }
}
