<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Doctor;
use App\Models\DoctorCategory;
use App\Models\DoctorSubcategory;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::with(['district'])->withCount('doctors')->latest()->paginate(10);
        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        $districts = District::all();
        return view('admin.hospitals.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $data = $this->validateHospital($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('hospitals', 'public');
        }

        $data['password_plain'] = $request->password;
        $data['is_active'] = $request->has('is_active');

        Hospital::create($data);

        return redirect()->route('admin.hospitals.index')->with('success', 'Hospital registered successfully');
    }

    public function show($id)
    {
        $hospital = Hospital::with(['district', 'doctors.district'])->withCount('doctors')->findOrFail($id);
        return view('admin.hospitals.show', compact('hospital'));
    }

    public function edit($id)
    {
        $hospital = Hospital::findOrFail($id);
        $districts = District::all();
        return view('admin.hospitals.edit', compact('hospital', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $hospital = Hospital::findOrFail($id);
        $data = $this->validateHospital($request, $hospital->id);

        if (!$request->filled('password')) {
            unset($data['password']);
        } else {
            $data['password_plain'] = $request->password;
        }

        if ($request->hasFile('logo')) {
            $this->deleteLogo($hospital);
            $data['logo'] = $request->file('logo')->store('hospitals', 'public');
        }

        $data['is_active'] = $request->has('is_active');
        $hospital->update($data);

        return redirect()->route('admin.hospitals.index')->with('success', 'Hospital updated successfully');
    }

    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        $this->deleteLogo($hospital);
        $hospital->delete();

        return back()->with('success', 'Hospital deleted successfully');
    }

    public function toggleActive($id)
    {
        $hospital = Hospital::findOrFail($id);
        $newStatus = !$hospital->is_active;
        $hospital->update(['is_active' => $newStatus]);

        return back()->with('success', 'Hospital account has been ' . ($newStatus ? 'approved' : 'deactivated') . ' successfully.');
    }

    public function dashboard()
    {
        $hospital = Auth::guard('hospital')->user()->load(['district', 'doctors.district']);
        return view('admin.hospitals.portal-dashboard', compact('hospital'));
    }

    public function profile()
    {
        $hospital = Auth::guard('hospital')->user();
        $districts = District::all();
        return view('admin.hospitals.portal-profile', compact('hospital', 'districts'));
    }

    public function updateProfile(Request $request)
    {
        $hospital = Hospital::findOrFail(Auth::guard('hospital')->id());
        $data = $this->validateHospital($request, $hospital->id, false);

        if ($request->filled('password')) {
            $data['password_plain'] = $request->password;
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('logo')) {
            $this->deleteLogo($hospital);
            $data['logo'] = $request->file('logo')->store('hospitals', 'public');
        }

        $hospital->update($data);

        return redirect()->route('hospital.profile')->with('success', 'Hospital profile updated successfully');
    }

    public function doctorsCreate()
    {
        $districts = District::all();
        $categories = DoctorCategory::all();
        return view('admin.hospitals.portal-doctor-create', compact('districts', 'categories'));
    }

    public function doctorsStore(Request $request)
    {
        $data = $this->validateDoctor($request);
        $data = $this->prepareDoctorData($request, $data);
        $data['hospital_id'] = Auth::guard('hospital')->id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        Doctor::create($data);

        return redirect()->route('hospital.dashboard')->with('success', 'Doctor added successfully');
    }

    public function doctorsEdit($id)
    {
        $doctor = $this->hospitalDoctor($id);
        $districts = District::all();
        $categories = DoctorCategory::all();
        return view('admin.hospitals.portal-doctor-edit', compact('doctor', 'districts', 'categories'));
    }

    public function doctorsUpdate(Request $request, $id)
    {
        $doctor = $this->hospitalDoctor($id);
        $data = $this->validateDoctor($request, $doctor->id);
        $data = $this->prepareDoctorData($request, $data);

        if (!$request->filled('password')) {
            unset($data['password'], $data['password_plain']);
        }

        if ($request->hasFile('photo')) {
            if ($doctor->photo && Storage::disk('public')->exists($doctor->photo)) {
                Storage::disk('public')->delete($doctor->photo);
            }
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $doctor->update($data);

        return redirect()->route('hospital.dashboard')->with('success', 'Doctor updated successfully');
    }

    public function doctorsDestroy($id)
    {
        $doctor = $this->hospitalDoctor($id);
        if ($doctor->photo && Storage::disk('public')->exists($doctor->photo)) {
            Storage::disk('public')->delete($doctor->photo);
        }
        $doctor->delete();

        return back()->with('success', 'Doctor removed successfully');
    }

    protected function validateHospital(Request $request, $id = null, $requirePassword = true)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email' . ($id ? ',' . $id : ''),
            'password' => ($requirePassword ? 'required' : 'nullable') . '|string|min:6',
            'phone' => 'required|digits:10',
            'address' => 'nullable|string',
            'district_id' => 'nullable|exists:districts,id',
            'specialties' => 'nullable|string',
            'treatments' => 'nullable|string',
            'facilities' => 'nullable|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }

    protected function validateDoctor(Request $request, $id = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email' . ($id ? ',' . $id : ''),
            'password' => ($id ? 'nullable' : 'required') . '|string|min:6',
            'phone' => 'required|digits:10',
            'medical_registration_no' => 'nullable|string|max:100',
            'specialization_category' => 'required|string|max:255',
            'specialization_subcategory' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer',
            'consultation_fee' => 'nullable|integer|min:0',
            'available_from' => 'nullable|string',
            'available_to' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'registration_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'council_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'consultation_type' => 'required|in:Online,Offline,Both',
            'online_available_from' => 'nullable|string',
            'online_available_to' => 'nullable|string',
            'google_meet_link' => 'nullable|url|max:500',
        ]);
    }

    protected function prepareDoctorData(Request $request, array $data)
    {
        $category = DoctorCategory::find($request->specialization_category);
        $subcategory = DoctorSubcategory::find($request->specialization_subcategory);

        $data['specialization_category'] = $category ? $category->name : $request->specialization_category;
        $data['specialization_subcategory'] = $subcategory ? $subcategory->name : $request->specialization_subcategory;
        $data['password_plain'] = $request->password;
        $data['available_time'] = trim(($request->available_from ?? '') . ' to ' . ($request->available_to ?? ''));
        $data['consultation_type'] = $request->consultation_type ?? 'Offline';

        if ($request->filled('online_available_from') && $request->filled('online_available_to')) {
            $data['online_available_time'] = $request->online_available_from . ' to ' . $request->online_available_to;
        }

        $data['google_meet_link'] = $request->google_meet_link;

        if ($request->hasFile('registration_certificate')) {
            $data['registration_certificate'] = $request->file('registration_certificate')->store('doctor_docs', 'public');
        }

        if ($request->hasFile('council_certificate')) {
            $data['council_certificate'] = $request->file('council_certificate')->store('doctor_docs', 'public');
        }

        unset($data['available_from'], $data['available_to'], $data['online_available_from'], $data['online_available_to']);

        return $data;
    }

    protected function hospitalDoctor($id)
    {
        return Doctor::where('hospital_id', Auth::guard('hospital')->id())->findOrFail($id);
    }

    protected function deleteLogo(Hospital $hospital)
    {
        if ($hospital->logo && Storage::disk('public')->exists($hospital->logo)) {
            Storage::disk('public')->delete($hospital->logo);
        }
    }
}
