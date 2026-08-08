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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:doctors,email',
            'password' => 'required|string|min:8',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'medical_registration_no' => ['nullable', 'string', 'min:10', 'max:18', 'regex:/^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/'],
            'specialization_category' => 'required|string|max:255',
            'specialization_subcategory' => 'nullable|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer|min:0|max:70',
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
            'current_location' => 'nullable|string|max:255',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'medical_registration_no.regex' => 'Please enter a valid Medical Registration Number format (e.g. KMC/12345/2020).',
        ]);

        // Resolve Category Names
        $category = \App\Models\DoctorCategory::find($request->specialization_category);
        $subcategory = \App\Models\DoctorSubcategory::find($request->specialization_subcategory);

        $availableTime = null;
        if ($request->filled('available_from') && $request->filled('available_to')) {
            $availableTime = \Carbon\Carbon::parse($request->available_from)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($request->available_to)->format('h:i A');
        }

        $onlineAvailableTime = null;
        if ($request->filled('online_available_from') && $request->filled('online_available_to')) {
            $onlineAvailableTime = \Carbon\Carbon::parse($request->online_available_from)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($request->online_available_to)->format('h:i A');
        }

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

        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_plain' => $request->password,
            'phone' => $request->phone,
            'medical_registration_no' => $request->medical_registration_no ? strtoupper($request->medical_registration_no) : null,
            'specialization_category' => $category ? $category->name : $request->specialization_category,
            'specialization_subcategory' => $subcategory ? $subcategory->name : $request->specialization_subcategory,
            'district_id' => $request->district_id,
            'current_location' => $request->current_location,
            'address' => $request->address,
            'qualification' => $request->qualification,
            'experience' => $request->experience ?? 0,
            'consultation_fee' => $request->consultation_fee ?? 0,
            'consultation_type' => $request->consultation_type,
            'available_time' => $availableTime,
            'online_available_time' => $onlineAvailableTime,
            'photo' => $photoPath,
            'registration_certificate' => $regCertPath,
            'council_certificate' => $councilCertPath,
            'hospital_id' => $request->hospital_id,
            'google_meet_link' => $request->google_meet_link,
            'is_active' => true,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully.');
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
        $doctor = Doctor::findOrFail($id);
        $districts = \App\Models\District::orderBy('name')->get();
        $categories = \App\Models\DoctorCategory::orderBy('name')->get();
        $hospitals = \App\Models\Hospital::orderBy('name')->get();
        return view('admin.doctors.edit', compact('doctor', 'districts', 'categories', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:doctors,email,' . $id,
            'password' => 'nullable|string|min:8',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'medical_registration_no' => ['nullable', 'string', 'min:10', 'max:18', 'regex:/^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/'],
            'specialization_category' => 'required',
            'specialization_subcategory' => 'nullable',
            'district_id' => 'required|exists:districts,id',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer|min:0|max:70',
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
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'medical_registration_no.regex' => 'Please enter a valid Medical Registration Number format (e.g. KMC/12345/2020).',
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
            'current_location' => $request->current_location,
            'address' => $request->address,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'available_time' => ($request->filled('available_from') && $request->filled('available_to'))
                ? (\Carbon\Carbon::parse($request->available_from)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($request->available_to)->format('h:i A'))
                : null,
            'hospital_id' => $request->hospital_id,
            'consultation_type' => $request->consultation_type ?? 'Offline',
            'online_available_time' => ($request->filled('online_available_from') && $request->filled('online_available_to'))
                ? (\Carbon\Carbon::parse($request->online_available_from)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($request->online_available_to)->format('h:i A'))
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

        // Get detailed booking info per date (total bookings and pending count)
        $bookedDatesSummary = \App\Models\DoctorToken::where('doctor_id', $doctorId)
            ->selectRaw('booking_date, COUNT(*) as total_count, SUM(CASE WHEN status = "Pending" THEN 1 ELSE 0 END) as pending_count')
            ->groupBy('booking_date')
            ->get()
            ->keyBy('booking_date');

        $pendingTotal = \App\Models\DoctorToken::where('doctor_id', $doctorId)
            ->where('status', 'Pending')
            ->count();

        $unavailabilities = \App\Models\DoctorUnavailability::where('doctor_id', $doctorId)
                            ->pluck('unavailable_date')
                            ->toArray();

        return view('doctor.dashboard', compact('bookings', 'allBookingDates', 'bookedDatesSummary', 'pendingTotal', 'unavailabilities', 'filter'));
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
            'current_location' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['photo', 'password', 'available_from', 'available_to', 'online_available_from', 'online_available_to']);
        
        if ($request->filled('available_from') && $request->filled('available_to')) {
            try {
                $fromFmt = \Carbon\Carbon::parse($request->available_from)->format('h:i A');
                $toFmt   = \Carbon\Carbon::parse($request->available_to)->format('h:i A');
                $data['available_time'] = $fromFmt . ' to ' . $toFmt;
            } catch (\Exception $e) {
                $data['available_time'] = $request->available_from . ' to ' . $request->available_to;
            }
        }

        if ($request->filled('online_available_from') && $request->filled('online_available_to')) {
            try {
                $onFromFmt = \Carbon\Carbon::parse($request->online_available_from)->format('h:i A');
                $onToFmt   = \Carbon\Carbon::parse($request->online_available_to)->format('h:i A');
                $data['online_available_time'] = $onFromFmt . ' to ' . $onToFmt;
            } catch (\Exception $e) {
                $data['online_available_time'] = $request->online_available_from . ' to ' . $request->online_available_to;
            }
        }

        if ($request->has('consultation_type')) {
            $data['consultation_type'] = $request->consultation_type;
        }
        if ($request->has('google_meet_link')) {
            $data['google_meet_link'] = $request->google_meet_link;
        }
        if ($request->has('current_location')) {
            $data['current_location'] = $request->current_location;
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
            'status'           => 'required|in:Booked,Cancelled,Completed',
            'google_meet_link' => 'nullable|string|max:500',
        ]);

        $booking = \App\Models\DoctorToken::where('doctor_id', \Illuminate\Support\Facades\Auth::guard('doctor')->id())
            ->with(['user', 'doctor'])
            ->findOrFail($id);

        $updateData = ['status' => $request->status];
        if ($request->has('google_meet_link')) {
            $updateData['google_meet_link'] = $request->google_meet_link;
        }

        $booking->update($updateData);

        $user = $booking->user;
        $doctor = $booking->doctor;
        $date = \Carbon\Carbon::parse($booking->booking_date)->format('d M Y');
        $time = \Carbon\Carbon::parse($booking->booking_time)->format('h:i A');
        $meetLink = $booking->google_meet_link ?: ($doctor->google_meet_link ?? null);

        // Send appointment status update email to User
        if ($user && $user->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AppointmentStatusUpdatedMail($booking));
            } catch (\Exception $e) {
                \Log::error("Failed to send appointment status update email: " . $e->getMessage());
            }
        }

        // --- MOBILE & IN-APP NOTIFICATIONS ON STATUS UPDATE ---
        if ($request->status === 'Booked') {
            $consultationType = $booking->consultation_type ?? 'Offline';

            // 1. In-App Notification
            if ($user) {
                \App\Models\UserNotification::create([
                    'user_id' => $user->id,
                    'title'   => 'Appointment Approved! ✅',
                    'message' => "Dr. {$doctor->name} has approved your appointment for {$date} at {$time} ({$consultationType}).",
                    'type'    => 'appointment_approved',
                    'link'    => route('bookings.my'),
                    'is_read' => false,
                ]);
            }

            // 2. Mobile SMS Notification
            $smsMessage = "✅ APPOINTMENT APPROVED: Dear {$user->name}, your appointment with Dr. {$doctor->name} on {$date} at {$time} ({$consultationType}) has been APPROVED by the doctor.";
            if ($booking->consultation_type === 'Online' && $meetLink) {
                $smsMessage .= " Meet Link: {$meetLink}";
            }
            $smsMessage .= " Ref: #BK-{$booking->id}. - Ayurveda App";

            if ($user && $user->phone) {
                \App\Services\SmsService::sendSms($user->phone, $smsMessage);
            }

            // 3. Additional WhatsApp Meet Link if Online
            if ($booking->consultation_type === 'Online') {
                $waMeetLink = $meetLink ?? 'Link will be shared shortly';
                $waMessage = "✅ *Appointment Confirmed!*\n\n";
                $waMessage .= "Dear {$user->name},\n";
                $waMessage .= "Your online consultation with *Dr. {$doctor->name}* has been confirmed.\n\n";
                $waMessage .= "📅 *Date:* {$date}\n";
                $waMessage .= "⏰ *Time:* {$time}\n\n";
                $waMessage .= "🎥 *Google Meet Link:* {$waMeetLink}\n\n";
                $waMessage .= "Please join on time. - Ayurveda App";

                if ($user && $user->phone) {
                    \App\Services\WhatsAppService::send($user->phone, $waMessage);
                }
            }
        } elseif ($request->status === 'Cancelled') {
            if ($user) {
                \App\Models\UserNotification::create([
                    'user_id' => $user->id,
                    'title'   => 'Appointment Cancelled ❌',
                    'message' => "Your appointment with Dr. {$doctor->name} scheduled for {$date} at {$time} was cancelled.",
                    'type'    => 'appointment_cancelled',
                    'link'    => route('bookings.my'),
                    'is_read' => false,
                ]);
            }

            $smsMessage = "❌ APPOINTMENT CANCELLED: Dear {$user->name}, your appointment with Dr. {$doctor->name} scheduled for {$date} at {$time} has been cancelled. - Ayurveda App";
            if ($user && $user->phone) {
                \App\Services\SmsService::sendSms($user->phone, $smsMessage);
            }
        } elseif ($request->status === 'Completed') {
            if ($user) {
                \App\Models\UserNotification::create([
                    'user_id' => $user->id,
                    'title'   => 'Consultation Completed 🌟',
                    'message' => "Your consultation with Dr. {$doctor->name} has been completed. Thank you!",
                    'type'    => 'appointment_completed',
                    'link'    => route('bookings.my'),
                    'is_read' => false,
                ]);
            }
        }

        return back()->with('success', 'Appointment status updated and in-app/mobile notification sent to patient!');
    }

    // --- Doctor Products Management ---
    public function productsIndex()
    {
        $doctorId = \Illuminate\Support\Facades\Auth::guard('doctor')->id();
        $products = \App\Models\Product::where('doctor_id', $doctorId)->latest()->paginate(10);
        return view('doctor.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = \App\Models\ProductCategory::all();
        return view('doctor.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'subcategory' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $cat = \App\Models\ProductCategory::find($request->category);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        \App\Models\Product::create([
            'doctor_id' => \Illuminate\Support\Facades\Auth::guard('doctor')->id(),
            'pharma_company_id' => null,
            'name' => $request->name,
            'category' => $cat ? $cat->name : $request->category,
            'subcategory' => $request->subcategory,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('doctor.products.index')->with('success', 'Product added successfully! It is now live on the store page.');
    }

    public function editProduct($id)
    {
        $doctorId = \Illuminate\Support\Facades\Auth::guard('doctor')->id();
        $product = \App\Models\Product::where('doctor_id', $doctorId)->findOrFail($id);
        $categories = \App\Models\ProductCategory::all();
        return view('doctor.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $doctorId = \Illuminate\Support\Facades\Auth::guard('doctor')->id();
        $product = \App\Models\Product::where('doctor_id', $doctorId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'subcategory' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $cat = \App\Models\ProductCategory::find($request->category);

        $data = $request->only(['name', 'description', 'price', 'stock', 'expiry_date']);
        $data['category'] = $cat ? $cat->name : $request->category;
        $data['subcategory'] = $request->subcategory;

        if ($request->hasFile('image')) {
            if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('doctor.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct($id)
    {
        $doctorId = \Illuminate\Support\Facades\Auth::guard('doctor')->id();
        $product = \App\Models\Product::where('doctor_id', $doctorId)->findOrFail($id);
        if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('doctor.products.index')->with('success', 'Product deleted successfully!');
    }
}
