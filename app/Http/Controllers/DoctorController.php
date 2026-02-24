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
        $doctors = Doctor::with(['district'])->paginate(10);
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
            'specialization_category' => 'required|string|max:255',
            'specialization_subcategory' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer',
            'consultation_fee' => 'nullable|integer|min:0',
            'available_from' => 'nullable|string',
            'available_to' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        // Create Doctor
        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
            'password_plain' => $request->password,
            'phone' => $request->phone,
            'specialization_category' => $request->specialization_category,
            'specialization_subcategory' => $request->specialization_subcategory,
            'district_id' => $request->district_id,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'available_time' => $request->available_from . ' to ' . $request->available_to,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully');
    }

    public function show($id)
    {
        $doctor = Doctor::with([
            'district', 
            'appointments' => function($query) {
                $query->with('user')->orderBy('booking_date', 'desc')->orderBy('booking_time', 'desc')->limit(5);
            }
        ])->findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::with(['district'])->findOrFail($id);
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
            'specialization_category' => 'required|string|max:255',
            'specialization_subcategory' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer',
            'consultation_fee' => 'nullable|integer|min:0',
            'available_from' => 'nullable|string',
            'available_to' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization_category' => $request->specialization_category,
            'specialization_subcategory' => $request->specialization_subcategory,
            'district_id' => $request->district_id,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'available_time' => $request->available_from . ' to ' . $request->available_to,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
            $data['password_plain'] = $request->password;
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
    public function dashboard(\Illuminate\Http\Request $request)
    {
        $doctorId = \Illuminate\Support\Facades\Auth::guard('doctor')->id();
        $query = \App\Models\DoctorToken::where('doctor_id', $doctorId)->with('user');
        
        $filter = $request->get('filter', 'upcoming');
        
        if ($filter == 'upcoming') {
            $date = $request->get('date', \Carbon\Carbon::today()->format('Y-m-d'));
            $bookings = $query->whereDate('booking_date', $date)
                              ->orderBy('booking_time', 'asc')
                              ->get();
        } else {
            $bookings = $query->orderBy('booking_date', 'desc')
                              ->orderBy('booking_time', 'desc')
                              ->paginate(10);
        }

        $allBookingDates = \App\Models\DoctorToken::where('doctor_id', $doctorId)
                            ->pluck('booking_date')
                            ->toArray();

        return view('doctor.dashboard', compact('bookings', 'allBookingDates', 'filter'));
    }

    public function profile()
    {
        $doctor = \Illuminate\Support\Facades\Auth::guard('doctor')->user();
        $districts = District::all();
        return view('doctor.profile', compact('doctor', 'districts'));
    }

    public function updateProfile(Request $request)
    {
        $doctor = \App\Models\Doctor::findOrFail(\Illuminate\Support\Facades\Auth::guard('doctor')->id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone' => 'nullable|digits:10',
            'specialization_category' => 'nullable|string|max:255',
            'specialization_subcategory' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|integer',
            'consultation_fee' => 'nullable|integer',
            'available_from' => 'nullable|string',
            'available_to' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['photo', 'password', 'available_from', 'available_to']);
        
        if ($request->filled('available_from') && $request->filled('available_to')) {
            $data['available_time'] = $request->available_from . ' to ' . $request->available_to;
        }

        if ($request->hasFile('photo')) {
            if ($doctor->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->photo);
            }
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
            $data['password_plain'] = $request->password;
        }

        $doctor->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}
