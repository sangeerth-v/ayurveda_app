<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

use App\Models\Department;
use App\Models\District;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['department', 'district'])->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer',
            'consultation_fee' => 'nullable|numeric',
            'available_time' => 'nullable|string',
        ]);

        // Find or create Department
        $department = Department::firstOrCreate(
            ['name' => $request->department]
        );

        // Find or create District
        $district = District::firstOrCreate(
            ['name' => $request->district]
        );

        // Create Doctor
        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Ideally hash the password
            'phone' => $request->phone,
            'department_id' => $department->id,
            'district_id' => $district->id,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'available_time' => $request->available_time,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully');
    }

    public function destroy($id)
    {
        Doctor::findOrFail($id)->delete();
        return back()->with('success', 'Doctor deleted successfully');
    }
}
