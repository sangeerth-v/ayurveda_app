<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Doctor;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DoctorToken;
use App\Models\User;
use App\Models\District;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisteredMail;
use App\Mail\RegistrationOtpMail;
use App\Mail\AppointmentRequestMail;
use App\Mail\OrderPlacedUserMail;
use App\Mail\OrderPlacedPharmaMail;

class UserController extends Controller
{
    // --- Auth Section ---
    // --- Auth Section ---
    public function showLogin()
    {
        if (Auth::guard('web')->check()) return redirect()->route('home');
        if (Auth::guard('admin')->check()) return redirect()->route('admin.dashboard');
        if (Auth::guard('doctor')->check()) return redirect()->route('doctor.dashboard');
        if (Auth::guard('pharma')->check()) return redirect()->route('pharma.dashboard');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $loginInput = $request->email;
        $password = $request->password;
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);

        $guards = ['web', 'admin', 'doctor', 'pharma', 'hospital'];

        \Log::info("USER_LOGIN: Attempt for input: " . $loginInput);

        foreach ($guards as $guard) {
            if ($guard === 'admin') {
                if ($isEmail) {
                    $admin = \App\Models\Admin::where('email', $loginInput)->first();
                } else {
                    $admin = \App\Models\Admin::where('name', $loginInput)->first();
                }
                
                if ($admin && ($admin->password === $password || Hash::check($password, $admin->password))) {
                    Auth::guard('admin')->login($admin);
                    
                    $request->session()->regenerate();
                    
                    $intended = session('url.intended');
                    if ($intended && (str_contains($intended, '/login') || str_contains($intended, '/register') || str_contains($intended, '/notifications/'))) {
                        session()->forget('url.intended');
                    }

                    if ($request->filled('redirect')) {
                        return redirect($request->redirect);
                    }
                    
                    return redirect()->intended($this->redirectPath('admin'));
                }
            } else {
                $userModel = match($guard) {
                    'web' => \App\Models\User::class,
                    'doctor' => \App\Models\Doctor::class,
                    'pharma' => \App\Models\PharmaCompany::class,
                    'hospital' => \App\Models\Hospital::class,
                };
                
                if ($isEmail) {
                    $user = $userModel::where('email', $loginInput)->first();
                } else {
                    $user = $userModel::where('name', $loginInput)->first();
                }
                
                if ($user) {
                    $passwordMatches = ($user->password === $password) || Hash::check($password, $user->password);
                    if ($passwordMatches) {
                        if (in_array($guard, ['hospital', 'doctor', 'pharma']) && isset($user->is_active) && !$user->is_active) {
                            return back()->withInput($request->only('email'))->withErrors(['email' => 'Your account is pending admin approval. Please wait for administrator verification.']);
                        }

                        Auth::guard($guard)->login($user);
                        \Log::info("USER_LOGIN: Success for $guard.");
                        
                        $request->session()->regenerate();

                        $intended = session('url.intended');
                        if ($intended && (str_contains($intended, '/login') || str_contains($intended, '/register') || str_contains($intended, '/notifications/'))) {
                            session()->forget('url.intended');
                        }

                        if ($request->filled('redirect')) {
                            return redirect($request->redirect);
                        }
                        
                        return redirect()->intended($this->redirectPath($guard));
                    }
                }
            }
        }

        return back()->withInput($request->only('email'))->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('doctor')->logout();
        Auth::guard('pharma')->logout();
        Auth::guard('hospital')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showRegister()
    {
        if (Auth::guard('web')->check()) return redirect()->route('home');
        if (Auth::guard('admin')->check()) return redirect()->route('admin.dashboard');
        if (Auth::guard('doctor')->check()) return redirect()->route('doctor.dashboard');
        if (Auth::guard('pharma')->check()) return redirect()->route('pharma.dashboard');
        return view('auth.register');
    }

    public function showDoctorRegister()
    {
        $districts = \App\Models\District::orderBy('name')->get();
        $categories = \App\Models\DoctorCategory::all();
        $hospitals = \App\Models\Hospital::orderBy('name')->get();
        return view('auth.doctor-register', compact('districts', 'categories', 'hospitals'));
    }

    public function processDoctorRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:doctors,email',
            'password' => 'required|string|min:8',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'medical_registration_no' => ['required', 'string', 'min:10', 'max:18', 'regex:/^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/'],
            'qualification' => 'required|string|min:2|max:255',
            'specialization_category' => 'required|exists:doctor_categories,id',
            'specialization_subcategory' => 'nullable|string|max:255',
            'practice_location_type' => 'nullable|in:india,outside_india',
            'state_name' => 'nullable|required_if:practice_location_type,india|string|min:2|max:100',
            'district_name' => 'nullable|required_if:practice_location_type,india|string|min:2|max:100',
            'current_location' => 'nullable|required_if:practice_location_type,outside_india|string|max:255',
            'experience' => 'required|integer|min:0|max:70',
            'consultation_fee' => 'required|numeric|min:0|max:100000',
            'consultation_type' => 'required|in:Both,Offline,Online',
            'available_from' => 'nullable|string',
            'available_to' => 'nullable|string',
            'online_available_from' => 'nullable|string',
            'online_available_to' => 'nullable|string',
            'address' => 'required|string|min:10|max:1000',
            'hospital_id' => 'nullable|exists:hospitals,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'council_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'medical_registration_no.regex' => 'Please enter a valid Medical Registration Number (e.g. KMC/12345/2020).',
            'email.email' => 'Please enter a valid email address.',
            'password.min' => 'Password must be at least 8 characters long.',
            'address.min' => 'Please enter a complete clinic address (at least 10 characters).',
            'state_name.required_if' => 'Please select your state if practicing in India.',
            'district_name.required_if' => 'Please select your working district if practicing in India.',
            'current_location.required_if' => 'Please enter your country & city if practicing outside India.',
        ]);

        // Find or create district if district_name is provided
        $districtId = null;
        if ($request->filled('district_name')) {
            $districtName = trim($request->district_name);
            $district = \App\Models\District::whereRaw('LOWER(name) = ?', [strtolower($districtName)])->first();
            if (!$district) {
                $district = \App\Models\District::create(['name' => ucwords(strtolower($districtName))]);
            }
            $districtId = $district->id;
        } else {
            $district = \App\Models\District::firstOrCreate(['name' => 'Abroad / Other']);
            $districtId = $district->id;
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

        \App\Models\Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'phone' => $request->phone,
            'medical_registration_no' => strtoupper($request->medical_registration_no),
            'specialization_category' => $category ? $category->name : $request->specialization_category,
            'specialization_subcategory' => $request->specialization_subcategory,
            'district_id' => $districtId,
            'current_location' => $request->current_location,
            'address' => $request->address,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'consultation_type' => $request->consultation_type,
            'available_time' => $availableTime,
            'online_available_time' => $onlineAvailableTime,
            'photo' => $photoPath,
            'registration_certificate' => $regCertPath,
            'council_certificate' => $councilCertPath,
            'hospital_id' => $request->hospital_id,
            'is_active' => false,
            'knows_medical_astrology' => $request->has('knows_medical_astrology') || $request->input('knows_medical_astrology') == '1',
            'astrology_details' => $request->astrology_details,
            'astrology_qualification' => $request->astrology_qualification,
        ]);

        return redirect()->route('login')->with('success', 'Doctor application submitted successfully! Your account credentials will be active after admin verification.');
    }

    public function showHospitalRegister()
    {
        $districts = \App\Models\District::orderBy('name')->get();
        return view('auth.hospital-register', compact('districts'));
    }

    public function processHospitalRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'license_number' => ['required', 'string', 'min:10', 'max:18', 'regex:/^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/'],
            'gst_number' => ['nullable', 'string', 'size:15', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/i'],
            'contact_person' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:hospitals,email',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'password' => 'required|string|min:8',
            'district_name' => 'required|string|min:2|max:100',
            'address' => 'required|string|min:10|max:1000',
            'license_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'gst_number.regex' => 'Please enter a valid 15-character GSTIN format (e.g. 29AAAAA0000A1Z5).',
            'gst_number.size' => 'GST Number must be exactly 15 characters long.',
            'license_number.regex' => 'Please enter a valid Hospital License Number format (e.g. HSP/12345/2025).',
            'email.email' => 'Please enter a valid hospital email address.',
            'password.min' => 'Password must be at least 8 characters long.',
            'address.min' => 'Please enter a complete hospital address (at least 10 characters).',
            'district_name.required' => 'Please enter the hospital district name.',
        ]);

        // Find or create the district by name (case-insensitive)
        $districtName = trim($request->district_name);
        $district = \App\Models\District::whereRaw('LOWER(name) = ?', [strtolower($districtName)])->first();
        if (!$district) {
            $district = \App\Models\District::create(['name' => ucwords(strtolower($districtName))]);
        }

        $licenseDocPath = null;
        if ($request->hasFile('license_document')) {
            $licenseDocPath = $request->file('license_document')->store('hospital_docs', 'public');
        }

        \App\Models\Hospital::create([
            'name' => $request->name,
            'license_number' => strtoupper($request->license_number),
            'gst_number' => $request->gst_number ? strtoupper($request->gst_number) : null,
            'address' => $request->address,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'district_id' => $district->id,
            'license_document' => $licenseDocPath,
            'is_active' => false,
        ]);

        return redirect()->route('login')->with('success', 'Hospital registration submitted successfully! Your account will be active after admin verification.');
    }

    public function showPharmaRegister()
    {
        $districts = \App\Models\District::orderBy('name')->get();
        return view('auth.pharma-register', compact('districts'));
    }

    public function processPharmaRegister(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|min:3|max:255',
            'drug_license_no' => ['required', 'string', 'min:10', 'max:18', 'regex:/^[A-Z]{2}-[0-9]{2}[A-Z]\/[0-9]{1,5}\/[0-9]{4}$/'],
            'gst_number' => ['required', 'string', 'size:15', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/i'],
            'contact_person' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:pharma_companies,email',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'password' => 'required|string|min:8',
            'state_name' => 'required|string|min:2|max:100',
            'district_name' => 'required|string|min:2|max:100',
            'address' => 'required|string|min:10|max:1000',
            'license_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'gst_number.regex' => 'Please enter a valid 15-character GSTIN format (e.g. 29AAAAA0000A1Z5).',
            'gst_number.size' => 'GST Number must be exactly 15 characters long.',
            'drug_license_no.regex' => 'Please enter a valid Drug License Number format (e.g. DL-20B/12345/2025).',
            'email.email' => 'Please enter a valid company email address.',
            'password.min' => 'Password must be at least 8 characters long.',
            'address.min' => 'Please enter a complete registered office address (at least 10 characters).',
            'state_name.required' => 'Please select your state.',
            'district_name.required' => 'Please select your district.',
        ]);

        // Find or create the district by name (case-insensitive)
        $districtName = trim($request->district_name);
        $district = \App\Models\District::whereRaw('LOWER(name) = ?', [strtolower($districtName)])->first();
        if (!$district) {
            $district = \App\Models\District::create(['name' => ucwords(strtolower($districtName))]);
        }

        $licenseDocPath = null;
        if ($request->hasFile('license_document')) {
            $licenseDocPath = $request->file('license_document')->store('pharma_docs', 'public');
        }

        \App\Models\PharmaCompany::create([
            'company_name' => $request->company_name,
            'drug_license_no' => $request->drug_license_no,
            'gst_number' => strtoupper($request->gst_number),
            'address' => $request->address,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'password_plain' => $request->password,
            'district_id' => $district->id,
            'is_active' => false,
        ]);

        return redirect()->route('login')->with('success', 'Pharma Company registration submitted successfully! Your account will be active after admin verification.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:users,phone'],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'phone.unique' => 'This mobile number is already registered.',
            'email.unique' => 'This email address is already registered.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $otp = sprintf("%06d", mt_rand(100000, 999999));

        session([
            'pending_registration' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'redirect' => $request->input('redirect'),
            ],
            'registration_otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        try {
            Mail::to($request->email)->send(new RegistrationOtpMail($otp, $request->name));
        } catch (\Exception $e) {
            \Log::error("Failed to send registration OTP email to {$request->email}: " . $e->getMessage());
        }

        return redirect()->route('register.verify_otp')->with('success', 'OTP code sent to your email address!');
    }

    public function showVerifyOtp()
    {
        if (!session()->has('pending_registration')) {
            return redirect()->route('register')->withErrors(['email' => 'Registration session expired. Please register again.']);
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $pending = session('pending_registration');
        $sessionOtp = session('registration_otp');
        $expiresAt = session('otp_expires_at');

        if (!$pending || !$sessionOtp) {
            return redirect()->route('register')->withErrors(['email' => 'Registration session expired. Please register again.']);
        }

        if (now()->timestamp > $expiresAt) {
            return back()->withErrors(['otp' => 'The OTP code has expired. Please click "Resend OTP" for a new code.']);
        }

        if ($request->otp !== (string)$sessionOtp) {
            return back()->withErrors(['otp' => 'Invalid OTP code. Please check your email and try again.']);
        }

        // OTP is valid - Create User
        $user = User::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'phone' => $pending['phone'],
            'password' => Hash::make($pending['password']),
        ]);

        try {
            Mail::to($user->email)->send(new UserRegisteredMail($user));
        } catch (\Exception $e) {
            \Log::error("Failed to send welcome email to {$user->email}: " . $e->getMessage());
        }

        // Clear session OTP data
        session()->forget(['pending_registration', 'registration_otp', 'otp_expires_at']);

        Auth::login($user);

        if (!empty($pending['redirect'])) {
            return redirect($pending['redirect'])->with('success', 'Email verified successfully! Welcome to Ayurveda.');
        }

        return redirect()->intended($this->redirectPath('web'))->with('success', 'Email verified successfully! Welcome to Ayurveda.');
    }

    public function resendOtp(Request $request)
    {
        $pending = session('pending_registration');

        if (!$pending) {
            return redirect()->route('register')->withErrors(['email' => 'Registration session expired. Please register again.']);
        }

        $otp = sprintf("%06d", mt_rand(100000, 999999));

        session([
            'registration_otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        try {
            Mail::to($pending['email'])->send(new RegistrationOtpMail($otp, $pending['name']));
        } catch (\Exception $e) {
            \Log::error("Failed to resend registration OTP email to {$pending['email']}: " . $e->getMessage());
        }

        return back()->with('success', 'A new OTP code has been sent to your email.');
    }

    protected function redirectPath($role)
    {
        return match($role) {
            'admin' => route('admin.dashboard'),
            'doctor' => route('doctor.dashboard'),
            'pharma' => route('pharma.dashboard'),
            'hospital' => route('hospital.dashboard'),
            'web' => '/',
            default => '/',
        };
    }

    // --- Public Views ---
    public function index()
    {
        $advertisements = \App\Models\Advertisement::where('is_active', true)
                            ->orderBy('order_index')
                            ->get();
        $popupAd = \App\Models\Advertisement::where('is_active', true)->where('is_popup', true)->first();
        return view('home', compact('advertisements', 'popupAd'));
    }

    public function products(Request $request)
    {
        $query = Product::where('stock', '>', 0)->with(['pharmaCompany', 'doctor']);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhere('subcategory', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->has('categories')) {
            $query->whereIn('category', (array)$request->categories);
        }
        
        if ($request->has('subcategories')) {
            $query->whereIn('subcategory', (array)$request->subcategories);
        }

        $sort = $request->get('sort', 'price_asc');
        switch ($sort) {
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'newest': $query->orderBy('created_at', 'desc'); break;
            default: $query->orderBy('price', 'asc'); break;
        }
        
        $products = $query->get();
        
        // Group subcategories by category
        $categoryData = Product::select('category', 'subcategory')
            ->distinct()
            ->get()
            ->groupBy('category');
            
        $search = $request->get('search', '');
            
        return view('products.index', compact('products', 'categoryData', 'sort', 'search'));
    }

    public function doctors(Request $request)
    {
        $query = Doctor::where('is_admin_astrologer', false)->with(['district']);

        // Filter by consultation type or location if requested
        if ($request->filled('type')) {
            if (in_array($request->type, ['Online', 'Offline'])) {
                $query->where(function ($q) use ($request) {
                    $q->where('consultation_type', $request->type)
                      ->orWhere('consultation_type', 'Both');
                });
            } elseif (in_array($request->type, ['Other', 'Abroad'])) {
                $query->where(function ($q) {
                    $q->whereNotNull('current_location')
                      ->where('current_location', '!=', '');
                });
            }
        }

        $doctors = $query->get();
        $districts = \App\Models\District::orderBy('name')->get();
        $activeType = $request->get('type', 'all');
        return view('doctors.index', compact('doctors', 'districts', 'activeType'));
    }

    public function hospitals()
    {
        $hospitals = \App\Models\Hospital::where('is_active', true)->with('district')->latest()->get();
        return view('hospitals.index', compact('hospitals'));
    }

    public function medicalAstrology()
    {
        $astrologer = Doctor::where('is_admin_astrologer', true)->first();
        if (!$astrologer) {
            $district = \App\Models\District::first();
            if (!$district) {
                $district = \App\Models\District::create(['name' => 'Thiruvananthapuram']);
            }

            $astrologer = Doctor::create([
                'name' => 'Chief Medical Astrologer',
                'email' => 'admin.astrology@example.com',
                'password' => \Hash::make('password123'),
                'is_admin_astrologer' => true,
                'knows_medical_astrology' => true,
                'is_active' => true,
                'specialization_category' => 'Medical Astrology',
                'qualification' => 'Vedic Astrologer & Ayurveda Expert',
                'experience' => 15,
                'consultation_fee' => 500,
                'consultation_type' => 'Both',
                'available_time' => '09:00 AM to 01:00 PM',
                'online_available_time' => '04:00 PM to 08:00 PM',
                'astrology_qualification' => 'Jyotish Acharya',
                'astrology_details' => 'Chief Medical Astrologer analyzing planetary influences on health and Tridosha imbalances.',
                'district_id' => $district->id,
                'address' => 'Ayurveda Astrology Head Office',
            ]);
        }

        return view('medical-astrology', compact('astrologer'));
    }

    public function showProduct($id)
    {
        $product = Product::with(['pharmaCompany', 'doctor', 'reviews.user'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // --- Cart Section ---
    public function cartIndex()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        $districts = District::all();
        return view('cart.index', compact('cart', 'districts'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qtyToAdd = max(1, (int) $request->input('quantity', 1));

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Sorry, ' . $product->name . ' is currently out of stock!');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();

        $existingQty = $cartItem ? $cartItem->quantity : 0;
        if ($product->stock < ($existingQty + $qtyToAdd)) {
            return redirect()->back()->with('error', 'Sorry, only ' . $product->stock . ' units available for ' . $product->name . '!');
        }

        if ($cartItem) {
            $cartItem->increment('quantity', $qtyToAdd);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $qtyToAdd,
                'price' => $product->price
            ]);
        }
        return $request->has('buy_now') ? redirect()->route('cart.index') : redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem = CartItem::with('product')->findOrFail($id);
        if($cartItem->cart->user_id != Auth::id()) abort(403);

        if ($cartItem->product && $cartItem->product->stock < $request->quantity) {
            return redirect()->route('cart.index')->with('error', 'Sorry, only ' . $cartItem->product->stock . ' units available for ' . $cartItem->product->name . '!');
        }

        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);
        if($cartItem->cart->user_id != Auth::id()) abort(403);
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    // --- Order Section ---
    public function ordersIndex()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        if ($order->user_id != Auth::id()) abort(403);

        $userReviews = \App\Models\ProductReview::where('user_id', Auth::id())
            ->where('order_id', $order->id)
            ->get()
            ->keyBy('product_id');

        return view('orders.show', compact('order', 'userReviews'));
    }

    public function storeProductReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        $product = Product::findOrFail($id);

        \App\Models\ProductReview::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'order_id' => $request->order_id,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        return back()->with('success', 'Thank you! Your product rating & review has been saved.');
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'delivery_name' => 'required|string|max:255',
            'delivery_phone' => 'required|string|max:20',
            'delivery_district' => 'required|string',
            'delivery_pincode' => 'required|string|digits:6',
            'delivery_address' => 'required|string',
            'payment_method' => 'required|in:COD',
        ]);

        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        if (!$cart || $cart->items->isEmpty()) return redirect()->route('cart.index')->with('error', 'Cart is empty!');

        foreach ($cart->items as $item) {
            $product = $item->product;
            if (!$product) {
                return redirect()->route('cart.index')->with('error', 'One of the selected products is no longer available.');
            }

            if ($product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', 'Not enough stock available for ' . $product->name . '.');
            }
        }

        $totalPrice = 0;
        foreach ($cart->items as $item) $totalPrice += $item->price * $item->quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'delivery_name' => $request->delivery_name,
            'delivery_phone' => $request->delivery_phone,
            'delivery_district' => $request->delivery_district,
            'delivery_pincode' => $request->delivery_pincode,
            'delivery_address' => $request->delivery_address,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'payment_status' => 'Pending',
            'order_status' => 'Placed',
        ]);

        foreach ($cart->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->decrement('stock', $item->quantity);
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }
        // Notify pharmaceutical companies about the new order
        $companiesToNotify = [];
        foreach ($cart->items as $item) {
            if ($item->product && $item->product->pharma_company_id) {
                $companiesToNotify[$item->product->pharma_company_id][] = $item;
            }
        }

        foreach ($companiesToNotify as $companyId => $itemsList) {
            $company = \App\Models\PharmaCompany::find($companyId);
            if ($company && $company->email) {
                try {
                    \Illuminate\Support\Facades\Mail::to($company->email)->send(new \App\Mail\NewOrderNotification($order, $company, $itemsList));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to send order email to pharma: " . $e->getMessage());
                }
            }
        }

        $cart->items()->delete();

        // Preload relationships to prevent N+1 query issues during email rendering
        $order->load(['items.product', 'user']);

        // Send order confirmation email to User
        try {
            Mail::to($order->user->email ?? Auth::user()->email)->send(new OrderPlacedUserMail($order));
        } catch (\Exception $e) {
            \Log::error("Failed to send order placed user email: " . $e->getMessage());
        }

        // Send order notification email to Pharma Companies
        try {
            $itemsByPharma = $order->items()->with('product.pharmaCompany')->get()->groupBy(function($item) {
                return $item->product->pharma_company_id;
            });

            foreach ($itemsByPharma as $pharmaId => $items) {
                $pharma = \App\Models\PharmaCompany::find($pharmaId);
                if ($pharma && $pharma->email) {
                    Mail::to($pharma->email)->send(new OrderPlacedPharmaMail($order, $pharma, $items));
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to send order placed pharma email: " . $e->getMessage());
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
    }

    // --- Booking Section ---
    public function createBooking($doctorId)
    {
        $doctor = Doctor::with(['district'])->findOrFail($doctorId);
        $bookedSlots = DoctorToken::where('doctor_id', $doctorId)
            ->whereIn('status', ['Booked', 'Pending'])
            ->where('booking_date', '>=', now()->toDateString())
            ->get(['booking_date', 'booking_time']);

        $unavailabilities = \App\Models\DoctorUnavailability::where('doctor_id', $doctorId)
            ->where('unavailable_date', '>=', now()->toDateString())
            ->pluck('unavailable_date')
            ->toArray();

        $offlineSlots = $this->parseTimeSlots($doctor->available_time);
        $onlineSlots = $this->parseTimeSlots($doctor->online_available_time);

        $defaultOffline = ['09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00'];
        $defaultOnline  = ['16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00'];

        if (empty($offlineSlots)) {
            $offlineSlots = $defaultOffline;
        }

        if (empty($onlineSlots)) {
            $onlineSlots = $defaultOnline;
        }

        $slots = $offlineSlots;

        return view('bookings.create', compact('doctor', 'bookedSlots', 'slots', 'offlineSlots', 'onlineSlots', 'unavailabilities'));
    }

    private function parseTimeSlots(?string $timeRangeStr): array
    {
        if (!$timeRangeStr) {
            return [];
        }

        $slots = [];
        $parts = preg_split('/[,;]/', $timeRangeStr);

        foreach ($parts as $part) {
            $part = trim($part);
            if (empty($part)) continue;

            // Normalize dashes or hyphens to ' to '
            $normalizedPart = preg_replace('/\s*[-–—]\s*/u', ' to ', strtolower($part));

            if (!str_contains($normalizedPart, ' to ')) continue;

            [$startStr, $endStr] = explode(' to ', $normalizedPart, 2);
            try {
                $start = \Carbon\Carbon::parse(trim($startStr));
                $end = \Carbon\Carbon::parse(trim($endStr));

                // If start >= end (e.g. 09:00 to 09:00 or invalid range), extend by 4 hours
                if ($start >= $end) {
                    $end = (clone $start)->addHours(4);
                }

                while ($start < $end) {
                    $slots[] = $start->format('H:i');
                    $start->addMinutes(15);
                }
            } catch (\Exception $e) {
                // Ignore parsing errors
            }
        }

        return array_values(array_unique($slots));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'doctor_id'         => 'required|exists:doctors,id',
            'booking_date'      => 'required|date|after_or_equal:today',
            'booking_time'      => 'required',
            'consultation_type' => 'required|in:Online,Offline',
        ]);

        // Validate that doctor supports the requested consultation type
        $doctor = Doctor::findOrFail($request->doctor_id);
        if ($doctor->consultation_type !== 'Both' && $doctor->consultation_type !== $request->consultation_type) {
            return back()->withErrors(['consultation_type' => 'This doctor does not offer ' . $request->consultation_type . ' consultations.'])->withInput();
        }

        $exists = DoctorToken::where('doctor_id', $request->doctor_id)
            ->where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->whereIn('status', ['Booked', 'Pending'])
            ->exists();

        if ($exists) return back()->withErrors(['booking_time' => 'This time slot is already booked or pending approval.'])->withInput();

        $isUnavailable = \App\Models\DoctorUnavailability::where('doctor_id', $request->doctor_id)
            ->where('unavailable_date', $request->booking_date)
            ->exists();

        if ($isUnavailable) return back()->withErrors(['booking_date' => 'The doctor is unavailable on this date.'])->withInput();

        // Prevent booking past times for today
        if ($request->booking_date == now()->toDateString()) {
            if ($request->booking_time < now()->format('H:i')) {
                return back()->withErrors(['booking_time' => 'You cannot book a past time slot for today.'])->withInput();
            }
        }

        // Calculate daily token number per doctor for the selected date (resets every day!)
        $lastToken = DoctorToken::where('doctor_id', $request->doctor_id)
            ->whereDate('booking_date', $request->booking_date)
            ->max('token_number');

        $nextTokenNumber = ($lastToken ?? 0) + 1;

        $booking = DoctorToken::create([
            'user_id'           => Auth::id(),
            'doctor_id'         => $request->doctor_id,
            'booking_date'      => $request->booking_date,
            'booking_time'      => $request->booking_time,
            'token_number'      => $nextTokenNumber,
            'status'            => 'Pending',
            'consultation_type' => $request->consultation_type,
        ]);

        $formattedDate = \Carbon\Carbon::parse($request->booking_date)->format('d M Y');
        $formattedTime = \Carbon\Carbon::parse($request->booking_time)->format('h:i A');

        // Create In-App Notification for Patient
        if (Auth::check()) {
            \App\Models\UserNotification::create([
                'user_id' => Auth::id(),
                'title'   => 'Appointment Request Sent 📅',
                'message' => "Your appointment booking request for {$formattedDate} at {$formattedTime} ({$request->consultation_type}) with Dr. {$doctor->name} was submitted.",
                'type'    => 'appointment_pending',
                'link'    => route('bookings.my'),
                'is_read' => false,
            ]);
        }

        // Send appointment request email to Doctor
        try {
            Mail::to($booking->doctor->email)->send(new AppointmentRequestMail($booking));
        } catch (\Exception $e) {
            \Log::error("Failed to send appointment request email: " . $e->getMessage());
        }

        return redirect()->route('bookings.my')->with('success', "Appointment request submitted for {$formattedDate} at {$formattedTime}! Awaiting doctor approval.");
    }

    public function myBookings()
    {
        $bookings = DoctorToken::where('user_id', Auth::id())->with('doctor')->orderBy('booking_date', 'desc')->get();
        return view('bookings.my-bookings', compact('bookings'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|digits:10',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function markNotificationsRead(Request $request)
    {
        \App\Models\UserNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function getUnreadLatestNotification()
    {
        $notif = \App\Models\UserNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($notif) {
            $notif->update(['is_read' => true]);
            return response()->json([
                'has_notification' => true,
                'title'            => $notif->title,
                'message'          => $notif->message,
                'link'             => $notif->link ?? route('bookings.my'),
            ]);
        }

        return response()->json(['has_notification' => false]);
    }

    public function cancelBooking($id)
    {
        $booking = DoctorToken::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if (!in_array($booking->status, ['Pending', 'Booked'])) {
            return back()->with('error', 'This appointment cannot be cancelled because it is already ' . strtolower($booking->status) . '.');
        }

        $booking->status = 'Cancelled';
        $booking->save();

        // Send email to the doctor
        if ($booking->doctor && $booking->doctor->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($booking->doctor->email)->send(new \App\Mail\AppointmentCancelledByPatientMail($booking));
            } catch (\Exception $e) {
                \Log::error("Failed to send appointment cancellation email to doctor: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Appointment has been cancelled successfully.');
    }

    public function getDoctorBookingDetails($id)
    {
        $doctor = Doctor::with(['district'])->find($id);
        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        $bookedSlots = DoctorToken::where('doctor_id', $id)
            ->whereIn('status', ['Booked', 'Pending'])
            ->where('booking_date', '>=', now()->toDateString())
            ->get(['booking_date', 'booking_time']);

        $unavailabilities = \App\Models\DoctorUnavailability::where('doctor_id', $id)
            ->where('unavailable_date', '>=', now()->toDateString())
            ->pluck('unavailable_date')
            ->toArray();

        $offlineSlots = $this->parseTimeSlots($doctor->available_time);
        $onlineSlots = $this->parseTimeSlots($doctor->online_available_time);

        $defaultOffline = ['09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00'];
        $defaultOnline  = ['16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00'];

        if (empty($offlineSlots)) {
            $offlineSlots = $defaultOffline;
        }

        if (empty($onlineSlots)) {
            $onlineSlots = $defaultOnline;
        }

        return response()->json([
            'doctor' => [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'photo' => $doctor->photo ? asset('storage/' . $doctor->photo) : null,
                'specialization_category' => $doctor->specialization_category ?? 'General',
                'district_name' => $doctor->district->name ?? '',
                'consultation_fee' => $doctor->consultation_fee,
                'consultation_type' => $doctor->consultation_type,
                'available_time' => $doctor->available_time,
                'online_available_time' => $doctor->online_available_time,
            ],
            'bookedSlots' => $bookedSlots,
            'unavailabilities' => $unavailabilities,
            'offlineSlots' => $offlineSlots,
            'onlineSlots' => $onlineSlots,
        ]);
    }

    public function showRescheduleForm($id)
    {
        $booking = DoctorToken::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if (!in_array($booking->status, ['Pending', 'Booked'])) {
            return redirect()->route('bookings.my')->with('error', 'This appointment cannot be rescheduled.');
        }

        $doctors = Doctor::where('is_active', true)->where('is_admin_astrologer', false)->with(['district'])->get();

        return view('bookings.reschedule', compact('booking', 'doctors'));
    }

    public function rescheduleBooking(Request $request, $id)
    {
        $booking = DoctorToken::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if (!in_array($booking->status, ['Pending', 'Booked'])) {
            return redirect()->route('bookings.my')->with('error', 'This appointment cannot be rescheduled.');
        }

        $request->validate([
            'doctor_id'         => 'required|exists:doctors,id',
            'booking_date'      => 'required|date|after_or_equal:today',
            'booking_time'      => 'required',
            'consultation_type' => 'required|in:Online,Offline',
        ]);

        $doctor = Doctor::where('is_active', true)->findOrFail($request->doctor_id);

        // Validate consultation type
        if ($doctor->consultation_type !== 'Both' && $doctor->consultation_type !== $request->consultation_type) {
            return back()->withErrors(['consultation_type' => 'This doctor does not offer ' . $request->consultation_type . ' consultations.'])->withInput();
        }

        // Validate time slot is not already booked/pending for this doctor (excluding this specific booking itself if keeping same slot!)
        $exists = DoctorToken::where('doctor_id', $request->doctor_id)
            ->where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->where('id', '!=', $id)
            ->whereIn('status', ['Booked', 'Pending'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['booking_time' => 'This time slot is already booked or pending approval.'])->withInput();
        }

        // Validate doctor is available on selected date
        $isUnavailable = \App\Models\DoctorUnavailability::where('doctor_id', $request->doctor_id)
            ->where('unavailable_date', $request->booking_date)
            ->exists();

        if ($isUnavailable) {
            return back()->withErrors(['booking_date' => 'The doctor is unavailable on this date.'])->withInput();
        }

        // Prevent booking past times for today
        if ($request->booking_date == now()->toDateString()) {
            if ($request->booking_time < now()->format('H:i')) {
                return back()->withErrors(['booking_time' => 'You cannot book a past time slot for today.'])->withInput();
            }
        }

        // Save original details to notify
        $originalDoctorName = $booking->doctor->name ?? 'N/A';
        $originalDoctorEmail = $booking->doctor->email ?? null;
        $originalDate = $booking->booking_date;
        $originalTime = $booking->booking_time;

        // Recalculate daily token number if doctor or date has changed
        if ($booking->doctor_id != $request->doctor_id || $booking->booking_date != $request->booking_date) {
            $lastToken = DoctorToken::where('doctor_id', $request->doctor_id)
                ->whereDate('booking_date', $request->booking_date)
                ->max('token_number');
            $nextTokenNumber = ($lastToken ?? 0) + 1;
            $booking->token_number = $nextTokenNumber;
        }

        // Update the booking details
        $booking->doctor_id = $request->doctor_id;
        $booking->booking_date = $request->booking_date;
        $booking->booking_time = $request->booking_time;
        $booking->consultation_type = $request->consultation_type;
        $booking->status = 'Pending'; // Needs doctor approval again
        $booking->google_meet_link = null; // Clear old link since details changed
        $booking->save();

        // Format dates/times for messages
        $formattedDate = \Carbon\Carbon::parse($request->booking_date)->format('d M Y');
        $formattedTime = \Carbon\Carbon::parse($request->booking_time)->format('h:i A');

        // Notification for Patient
        \App\Models\UserNotification::create([
            'user_id' => Auth::id(),
            'title'   => 'Appointment Rescheduled 📅',
            'message' => "Your appointment was rescheduled to {$formattedDate} at {$formattedTime} ({$request->consultation_type}) with Dr. {$doctor->name}.",
            'type'    => 'appointment_pending',
            'link'    => route('bookings.my'),
            'is_read' => false,
        ]);

        // Send cancel/update mail to old doctor if doctor changed
        if ($originalDoctorEmail && $booking->doctor_id != $request->doctor_id) {
            try {
                // Send cancellation email to old doctor
                \Illuminate\Support\Facades\Mail::to($originalDoctorEmail)->send(new \App\Mail\AppointmentCancelledByPatientMail($booking));
            } catch (\Exception $e) {
                \Log::error("Failed to notify old doctor on reschedule: " . $e->getMessage());
            }
        }

        // Send request email to new/current doctor
        if ($booking->doctor->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($booking->doctor->email)->send(
                    new \App\Mail\AppointmentRescheduledMail($booking, $originalDoctorName, $originalDate, $originalTime)
                );
            } catch (\Exception $e) {
                \Log::error("Failed to send appointment rescheduled email to doctor: " . $e->getMessage());
            }
        }

        return redirect()->route('bookings.my')->with('success', 'Appointment rescheduled successfully! Awaiting doctor approval.');
    }
}
