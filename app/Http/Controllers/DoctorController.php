<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

use App\Models\Department;
use App\Models\District;
use App\Models\DoctorCategory;
use App\Models\DoctorSubcategory;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['district', 'hospital'])->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $districts = District::all();
        $categories = DoctorCategory::all();
        $hospitals = \App\Models\Hospital::orderBy('name')->get();
        return view('admin.doctors.create', compact('districts', 'categories', 'hospitals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required|string|min:6',
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
            'hospital_id' => 'nullable|exists:hospitals,id',
            'consultation_type' => 'required|in:Online,Offline,Both',
            'online_available_from' => 'nullable|string',
            'online_available_to' => 'nullable|string',
            'google_meet_link' => 'nullable|url|max:500',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        $regCertPath = null;
        if ($request->hasFile('registration_certificate')) {
            $regCertPath = $request->file('registration_certificate')->store('doctor_docs', 'public');
        }

        $councilCertPath = null;
        if ($request->hasFile('council_certificate')) {
            $councilCertPath = $request->file('council_certificate')->store('doctor_docs', 'public');
        }

        // Resolve Category Names
        $category = DoctorCategory::find($request->specialization_category);
        $subcategory = DoctorSubcategory::find($request->specialization_subcategory);

        // Create Doctor
        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_plain' => $request->password,
            'phone' => $request->phone,
            'medical_registration_no' => $request->medical_registration_no,
            'specialization_category' => $category ? $category->name : $request->specialization_category,
            'specialization_subcategory' => $subcategory ? $subcategory->name : $request->specialization_subcategory,
            'district_id' => $request->district_id,
            'address' => $request->address,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'available_time' => $request->available_from . ' to ' . $request->available_to,
            'consultation_type' => $request->consultation_type ?? 'Offline',
            'online_available_time' => ($request->filled('online_available_from') && $request->filled('online_available_to'))
                ? $request->online_available_from . ' to ' . $request->online_available_to
                : null,
            'google_meet_link' => $request->google_meet_link,
            'photo' => $photoPath,
            'registration_certificate' => $regCertPath,
            'council_certificate' => $councilCertPath,
            'hospital_id' => $request->hospital_id,
            'is_active' => true,
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
        $doctor = Doctor::with(['district', 'hospital'])->findOrFail($id);
        $districts = District::all();
        $categories = DoctorCategory::all();
        $hospitals = \App\Models\Hospital::orderBy('name')->get();
        return view('admin.doctors.edit', compact('doctor', 'districts', 'categories', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone' => 'required|digits:10',
            'medical_registration_no' => 'nullable|string|max:100',
            'specialization_category' => 'required',
            'specialization_subcategory' => 'nullable',
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
            'hospital_id' => 'nullable|exists:hospitals,id',
            'consultation_type' => 'required|in:Online,Offline,Both',
            'online_available_from' => 'nullable|string',
            'online_available_to' => 'nullable|string',
            'google_meet_link' => 'nullable|url|max:500',
        ]);

        // Resolve Category Names
        $category = DoctorCategory::find($request->specialization_category);
        $subcategory = DoctorSubcategory::find($request->specialization_subcategory);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'medical_registration_no' => $request->medical_registration_no,
            'specialization_category' => $category ? $category->name : $request->specialization_category,
            'specialization_subcategory' => $subcategory ? $subcategory->name : $request->specialization_subcategory,
            'district_id' => $request->district_id,
            'address' => $request->address,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'available_time' => $request->available_from . ' to ' . $request->available_to,
            'hospital_id' => $request->hospital_id,
            'consultation_type' => $request->consultation_type ?? 'Offline',
            'online_available_time' => ($request->filled('online_available_from') && $request->filled('online_available_to'))
                ? $request->online_available_from . ' to ' . $request->online_available_to
                : null,
            'google_meet_link' => $request->google_meet_link,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
            $data['password_plain'] = $request->password;
        }

        if ($request->hasFile('photo')) {
            if ($doctor->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->photo);
            }
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        if ($request->hasFile('registration_certificate')) {
            if ($doctor->registration_certificate && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->registration_certificate)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->registration_certificate);
            }
            $data['registration_certificate'] = $request->file('registration_certificate')->store('doctor_docs', 'public');
        }

        if ($request->hasFile('council_certificate')) {
            if ($doctor->council_certificate && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->council_certificate)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->council_certificate);
            }
            $data['council_certificate'] = $request->file('council_certificate')->store('doctor_docs', 'public');
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

    public function toggleActive($id)
    {
        $doctor = Doctor::findOrFail($id);
        $newStatus = !$doctor->is_active;
        $doctor->update(['is_active' => $newStatus]);

        return back()->with('success', 'Doctor account has been ' . ($newStatus ? 'approved' : 'deactivated') . ' successfully.');
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

        $unavailabilities = \App\Models\DoctorUnavailability::where('doctor_id', $doctorId)
                            ->pluck('unavailable_date')
                            ->toArray();

        return view('doctor.dashboard', compact('bookings', 'allBookingDates', 'unavailabilities', 'filter'));
    }

    public function toggleAvailability(Request $request)
    {
        $doctorId = \Illuminate\Support\Facades\Auth::guard('doctor')->id();
        $date = $request->date;

        $unavailability = \App\Models\DoctorUnavailability::where('doctor_id', $doctorId)
                            ->where('unavailable_date', $date)
                            ->first();

        if ($unavailability) {
            $unavailability->delete();
            return back()->with('success', 'Marked as available for ' . $date);
        } else {
            \App\Models\DoctorUnavailability::create([
                'doctor_id' => $doctorId,
                'unavailable_date' => $date,
            ]);
            return back()->with('success', 'Marked as unavailable for ' . $date);
        }
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
            'consultation_type' => 'nullable|in:Online,Offline,Both',
            'online_available_from' => 'nullable|string',
            'online_available_to' => 'nullable|string',
            'google_meet_link' => 'nullable|url|max:500',
        ]);

        $data = $request->except(['photo', 'password', 'available_from', 'available_to', 'online_available_from', 'online_available_to']);
        
        if ($request->filled('available_from') && $request->filled('available_to')) {
            $data['available_time'] = $request->available_from . ' to ' . $request->available_to;
        }

        if ($request->filled('online_available_from') && $request->filled('online_available_to')) {
            $data['online_available_time'] = $request->online_available_from . ' to ' . $request->online_available_to;
        }

        if ($request->has('consultation_type')) {
            $data['consultation_type'] = $request->consultation_type;
        }
        if ($request->has('google_meet_link')) {
            $data['google_meet_link'] = $request->google_meet_link;
        }

        if ($request->hasFile('photo')) {
            if ($doctor->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->photo);
            }
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = $request->password;
            $data['password_plain'] = $request->password;
        }

        $doctor->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Booked,Cancelled,Completed'
        ]);

        $booking = \App\Models\DoctorToken::where('doctor_id', \Illuminate\Support\Facades\Auth::guard('doctor')->id())
            ->with(['user', 'doctor'])
            ->findOrFail($id);

        $booking->update(['status' => $request->status]);

        $user = $booking->user;
        $doctor = $booking->doctor;
        $date = \Carbon\Carbon::parse($booking->booking_date)->format('d M Y');
        $time = \Carbon\Carbon::parse($booking->booking_time)->format('h:i A');

        // Send appointment status update email to User
        if ($user && $user->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AppointmentStatusUpdatedMail($booking));
            } catch (\Exception $e) {
                \Log::error("Failed to send appointment status update email: " . $e->getMessage());
            }
        }

        // --- MOBILE NOTIFICATION ON APPROVAL / ACCEPTANCE ---
        if ($request->status === 'Booked') {
            $consultationType = $booking->consultation_type ?? 'Offline';
            $smsMessage = "✅ APPOINTMENT APPROVED: Dear {$user->name}, your appointment with Dr. {$doctor->name} on {$date} at {$time} ({$consultationType}) has been APPROVED by the doctor. Ref: #BK-{$booking->id}. - Ayurveda App";

            if ($user && $user->phone) {
                // Send Mobile SMS Notification
                \App\Services\SmsService::sendSms($user->phone, $smsMessage);
            }

            // Additional WhatsApp Meet Link if Online
            if ($booking->consultation_type === 'Online') {
                $meetLink = $doctor->google_meet_link ?? 'Link will be shared shortly';
                $waMessage = "✅ *Appointment Confirmed!*\n\n";
                $waMessage .= "Dear {$user->name},\n";
                $waMessage .= "Your online consultation with *Dr. {$doctor->name}* has been confirmed.\n\n";
                $waMessage .= "📅 *Date:* {$date}\n";
                $waMessage .= "⏰ *Time:* {$time}\n\n";
                $waMessage .= "🎥 *Google Meet Link:* {$meetLink}\n\n";
                $waMessage .= "Please join on time. - Ayurveda App";

                if ($user && $user->phone) {
                    \App\Services\WhatsAppService::send($user->phone, $waMessage);
                }
            }
        } elseif ($request->status === 'Cancelled') {
            $smsMessage = "❌ APPOINTMENT CANCELLED: Dear {$user->name}, your appointment with Dr. {$doctor->name} scheduled for {$date} at {$time} has been cancelled. - Ayurveda App";
            if ($user && $user->phone) {
                \App\Services\SmsService::sendSms($user->phone, $smsMessage);
            }
        }

        return back()->with('success', 'Appointment status updated and mobile notification sent to patient!');
    }
}
