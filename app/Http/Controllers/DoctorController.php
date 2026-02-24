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
        $districts = District::all();
        return view('admin.doctors.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|digits:10',
            'department' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer',
            'consultation_fee' => 'nullable|integer|min:0',
            'available_time' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find or create Department
        $department = \App\Models\Department::firstOrCreate(
            ['name' => $request->department]
        );

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        // Create Doctor
        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
            'phone' => $request->phone,
            'department_id' => $department->id,
            'district_id' => $request->district_id,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'available_time' => $request->available_time,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully');
    }

    public function show($id)
    {
        $doctor = Doctor::with([
            'department', 
            'district', 
            'appointments' => function($query) {
                $query->with('user')->orderBy('booking_date', 'desc')->orderBy('booking_time', 'desc')->limit(5);
            }
        ])->findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::with(['department', 'district'])->findOrFail($id);
        $districts = District::all();
        return view('admin.doctors.edit', compact('doctor', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone' => 'required|digits:10',
            'department' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer',
            'consultation_fee' => 'nullable|integer|min:0',
            'available_time' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find or create Department
        $department = \App\Models\Department::firstOrCreate(
            ['name' => $request->department]
        );

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department_id' => $department->id,
            'district_id' => $request->district_id,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'available_time' => $request->available_time,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($doctor->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->photo);
            }
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $doctor->update($data);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        // Delete photo if exists
        if ($doctor->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->photo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->photo);
        }
        $doctor->delete();
        return back()->with('success', 'Doctor deleted successfully');
    }

    // --- Doctor Role Functions ---
    public function dashboard()
    {
        $bookings = \App\Models\DoctorToken::where('doctor_id', \Illuminate\Support\Facades\Auth::guard('doctor')->id())
                        ->with('user')
                        ->orderBy('booking_date', 'desc')
                        ->orderBy('booking_time', 'desc')
                        ->get();

        return view('doctor.dashboard', compact('bookings'));
    }
}
