<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        \Log::info("ADMIN_LOGIN: Attempt for email: " . $request->email);

        $admin = \App\Models\Admin::where('email', $request->email)->first();

        if ($admin && ($admin->password === $request->password || \Illuminate\Support\Facades\Hash::check($request->password, $admin->password))) {
            Auth::guard('admin')->login($admin);
            \Log::info("ADMIN_LOGIN: Success for email: " . $request->email);

            $intended = session('url.intended');
            if ($intended && (str_contains($intended, '/login') || str_contains($intended, '/register') || str_contains($intended, '/notifications/'))) {
                session()->forget('url.intended');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        \Log::warning("ADMIN_LOGIN: Failed for email: " . $request->email);

        return back()->withInput($request->only('email'))->with('error', 'Invalid Email or Password');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('home');
    }

    public function showOrder($id)
    {
        $order = \App\Models\Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function dashboard()
    {
        $todayStr = \Carbon\Carbon::today()->format('Y-m-d');

        $totalDoctors = \App\Models\Doctor::count();
        $pendingDoctors = \App\Models\Doctor::where('is_active', false)->count();
        $totalPharmas = \App\Models\PharmaCompany::count();
        $totalUsers = \App\Models\User::count();
        $totalProducts = \App\Models\Product::count();
        $totalOrders = \App\Models\Order::count();
        $totalAppointments = \App\Models\DoctorToken::count();
        $pendingAppointments = \App\Models\DoctorToken::where('status', 'Pending')->count();

        // --- TODAY'S PRIORITY APPOINTMENTS ---
        $todaysBookings = \App\Models\DoctorToken::with(['doctor', 'user'])
            ->whereDate('booking_date', $todayStr)
            ->orderBy('booking_time', 'asc')
            ->get();

        $todaysPendingCount = $todaysBookings->where('status', 'Pending')->count();
        $todaysConfirmedCount = $todaysBookings->whereIn('status', ['Confirmed', 'Booked'])->count();

        // --- PAST OVERDUE PENDING BOOKINGS (Yesterday & Earlier) ---
        $pastOverdueBookings = \App\Models\DoctorToken::with(['doctor', 'user'])
            ->where('status', 'Pending')
            ->whereDate('booking_date', '<', $todayStr)
            ->orderBy('booking_date', 'desc')
            ->get();

        // --- URGENT 30-MINUTE PENDING BOOKINGS TODAY ---
        $urgentBookings = $todaysBookings->filter(function ($b) {
            if ($b->status !== 'Pending') return false;
            try {
                $start = \Carbon\Carbon::parse($b->booking_date . ' ' . $b->booking_time);
                $diffInMins = \Carbon\Carbon::now()->diffInMinutes($start, false);
                return $diffInMins <= 30;
            } catch (\Exception $e) {
                return true;
            }
        });

        // Recent Orders for Admin Dashboard Overview
        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalDoctors', 'pendingDoctors', 'totalPharmas', 'totalUsers', 
            'totalProducts', 'totalOrders', 'totalAppointments', 'pendingAppointments',
            'todaysBookings', 'todaysPendingCount', 'todaysConfirmedCount',
            'pastOverdueBookings', 'urgentBookings', 'recentOrders'
        ));
    }

    public function usersIndex()
    {
        $users = \App\Models\User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function destroyUser($id)
    {
        \App\Models\User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully');
    }

    // --- Advertisements ---
    public function advertisementsIndex()
    {
        $advertisements = \App\Models\Advertisement::orderBy('order_index')->get();
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function advertisementsCreate()
    {
        return view('admin.advertisements.create');
    }

    public function advertisementsStore(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('advertisements', 'public');

        \App\Models\Advertisement::create([
            'image_path' => $path,
            'title' => $request->title,
            'link' => $request->link,
            'is_active' => $request->has('is_active'),
            'order_index' => $request->order_index ?? 0,
        ]);

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement added successfully');
    }

    public function advertisementsEdit($id)
    {
        $advertisement = \App\Models\Advertisement::findOrFail($id);
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    public function advertisementsUpdate(Request $request, $id)
    {
        $advertisement = \App\Models\Advertisement::findOrFail($id);
        
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if (\Storage::disk('public')->exists($advertisement->image_path)) {
                \Storage::disk('public')->delete($advertisement->image_path);
            }
            $advertisement->image_path = $request->file('image')->store('advertisements', 'public');
        }

        $advertisement->title = $request->title;
        $advertisement->link = $request->link;
        $advertisement->is_active = $request->has('is_active');
        $advertisement->order_index = $request->order_index ?? 0;
        $advertisement->save();

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement updated successfully');
    }

    public function advertisementsDestroy($id)
    {
        $advertisement = \App\Models\Advertisement::findOrFail($id);
        if (\Storage::disk('public')->exists($advertisement->image_path)) {
            \Storage::disk('public')->delete($advertisement->image_path);
        }
        $advertisement->delete();
        
        return back()->with('success', 'Advertisement deleted successfully');
    }

    public function advertisementsSetPopup($id)
    {
        if ($id != 0) {
            $advertisement = \App\Models\Advertisement::findOrFail($id);
            $advertisement->is_popup = !$advertisement->is_popup;
            $advertisement->save();
            $status = $advertisement->is_popup ? 'added to' : 'removed from';
            return back()->with('success', "Advertisement {$status} popup list.");
        }

        \App\Models\Advertisement::where('is_popup', true)->update(['is_popup' => false]);
        return back()->with('success', 'All popup advertisements removed successfully.');
    }

    // --- All Appointments Management ---
    public function bookingsIndex(Request $request)
    {
        $todayStr = \Carbon\Carbon::today()->format('Y-m-d');
        
        // Determine selected single date (Default to Today)
        $selectedDate = $request->input('date');
        if (!$request->has('date') && $request->input('date_filter') !== 'all') {
            $selectedDate = $todayStr;
        } elseif ($request->input('date_filter') === 'all') {
            $selectedDate = null;
        }

        if ($selectedDate) {
            try {
                $currentDateCarbon = \Carbon\Carbon::parse($selectedDate);
            } catch (\Exception $e) {
                $selectedDate = $todayStr;
                $currentDateCarbon = \Carbon\Carbon::today();
            }
            $prevDate = (clone $currentDateCarbon)->subDay()->format('Y-m-d');
            $nextDate = (clone $currentDateCarbon)->addDay()->format('Y-m-d');
        } else {
            $prevDate = (clone \Carbon\Carbon::today())->subDay()->format('Y-m-d');
            $nextDate = (clone \Carbon\Carbon::today())->addDay()->format('Y-m-d');
        }

        $query = \App\Models\DoctorToken::with(['doctor', 'user']);

        // Strict Single-Day Date Filtering & Sorting
        if ($selectedDate) {
            $query->whereDate('booking_date', $selectedDate)
                  ->orderBy('booking_time', 'asc');
        } else {
            $query->orderBy('booking_date', 'desc')
                  ->orderBy('booking_time', 'asc');
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                       ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
                       ->orWhere('phone', 'LIKE', "%{$search}%");
                })->orWhereHas('doctor', function ($dq) use ($search) {
                    $dq->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                })->orWhere('token_number', 'LIKE', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15)->withQueryString();
        $doctors = \App\Models\Doctor::orderBy('name')->get();

        // Counts for Tab Badges & Navigation Buttons
        $todayCount = \App\Models\DoctorToken::whereDate('booking_date', $todayStr)->count();
        $tomorrowCount = \App\Models\DoctorToken::whereDate('booking_date', (clone \Carbon\Carbon::today())->addDay()->format('Y-m-d'))->count();
        $selectedDateCount = $selectedDate ? \App\Models\DoctorToken::whereDate('booking_date', $selectedDate)->count() : 0;
        $allCount = \App\Models\DoctorToken::count();

        // Urgent 30-Minute & Past Overdue Pending Appointments (Doctor inactive / forgot)
        $pastOverdueBookings = \App\Models\DoctorToken::with(['doctor', 'user'])
            ->where('status', 'Pending')
            ->whereDate('booking_date', '<', $todayStr)
            ->orderBy('booking_date', 'desc')
            ->get();

        $urgentBookings = \App\Models\DoctorToken::with(['doctor', 'user'])
            ->where('status', 'Pending')
            ->whereDate('booking_date', '=', $todayStr)
            ->get()
            ->filter(function ($b) {
                try {
                    $start = \Carbon\Carbon::parse($b->booking_date . ' ' . $b->booking_time);
                    $diffInMins = \Carbon\Carbon::now()->diffInMinutes($start, false);
                    return $diffInMins <= 30;
                } catch (\Exception $e) {
                    return true;
                }
            });

        return view('admin.bookings.index', compact(
            'bookings', 'doctors', 'selectedDate', 'prevDate', 'nextDate',
            'todayStr', 'todayCount', 'tomorrowCount', 'selectedDateCount', 'allCount',
            'urgentBookings', 'pastOverdueBookings'
        ));
    }

    public function emergencyApproveBooking(Request $request, $id)
    {
        $booking = \App\Models\DoctorToken::with(['user', 'doctor'])->findOrFail($id);

        $doctor = $booking->doctor;
        $user = $booking->user;

        $meetLink = $request->input('google_meet_link') 
            ?: ($booking->google_meet_link 
            ?: ($doctor->google_meet_link 
            ?: 'https://meet.google.com/ayur-doc-' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $doctor ? $doctor->name : 'general'))));

        $booking->update([
            'status' => 'Booked',
            'google_meet_link' => $meetLink,
        ]);

        $date = \Carbon\Carbon::parse($booking->booking_date)->format('d M Y');
        $time = \Carbon\Carbon::parse($booking->booking_time)->format('h:i A');
        $consultationType = $booking->consultation_type ?? 'Online';

        // 1. In-App Notification
        if ($user) {
            \App\Models\UserNotification::create([
                'user_id' => $user->id,
                'title'   => 'Appointment Confirmed by Admin ⚡',
                'message' => "Admin has confirmed your appointment with Dr. " . ($doctor ? $doctor->name : 'Doctor') . " for {$date} at {$time} ({$consultationType}).",
                'type'    => 'appointment_approved',
                'link'    => route('bookings.my'),
                'is_read' => false,
            ]);
        }

        // 2. Mobile SMS Notification
        $smsMessage = "⚡ APPOINTMENT CONFIRMED: Dear " . ($user ? $user->name : 'Patient') . ", your appointment with Dr. " . ($doctor ? $doctor->name : 'Doctor') . " on {$date} at {$time} has been CONFIRMED by Admin.";
        if ($consultationType === 'Online' && $meetLink) {
            $smsMessage .= " Meet Link: {$meetLink}";
        }
        $smsMessage .= " Ref: #BK-{$booking->id}. - Ayurveda App";

        if ($user && $user->phone) {
            \App\Services\SmsService::sendSms($user->phone, $smsMessage);
        }

        // 3. Email Notification
        if ($user && $user->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AppointmentStatusUpdatedMail($booking));
            } catch (\Exception $e) {
                \Log::error("Failed to send emergency approval email: " . $e->getMessage());
            }
        }

        return back()->with('success', "Emergency 30-Min approval applied for Booking #{$booking->id}! Patient notified & Google Meet link attached.");
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = \App\Models\DoctorToken::findOrFail($id);
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Booked,Completed,Cancelled'
        ]);

        $booking->update(['status' => $request->status]);
        return back()->with('success', "Appointment status updated to {$request->status} successfully.");
    }

    public function destroyBooking($id)
    {
        \App\Models\DoctorToken::findOrFail($id)->delete();
        return back()->with('success', 'Appointment deleted successfully.');
    }

    // --- All Customer Orders Management ---
    public function ordersIndex(Request $request)
    {
        $query = \App\Models\Order::with(['user', 'items.product'])->latest();

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(delivery_name) LIKE ?', ["%{$search}%"])
                   ->orWhere('delivery_phone', 'LIKE', "%{$search}%")
                   ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $request->validate([
            'order_status'   => 'nullable|in:Placed,Shipped,Delivered,Cancelled',
            'payment_status' => 'nullable|in:Pending,Received,Completed,Paid',
        ]);

        $updateData = [];
        if ($request->filled('order_status')) {
            $updateData['order_status'] = $request->order_status;
        }
        if ($request->filled('payment_status')) {
            $statusVal = $request->payment_status;
            if ($statusVal === 'Received' || $statusVal === 'Paid') {
                $statusVal = 'Completed';
            }
            $updateData['payment_status'] = $statusVal;
        }

        if (!empty($updateData)) {
            $order->update($updateData);
        }

        return back()->with('success', 'Order status updated successfully.');
    }

    // --- All Products Management ---
    public function productsIndex(Request $request)
    {
        $query = \App\Models\Product::with(['doctor', 'pharmaCompany'])->latest();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                   ->orWhereRaw('LOWER(category) LIKE ?', ["%{$search}%"])
                   ->orWhereRaw('LOWER(subcategory) LIKE ?', ["%{$search}%"]);
            });
        }

        $products = $query->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function editProduct($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\ProductCategory::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);

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
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully by Admin!');
    }

    public function destroyProduct($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function editAstrology()
    {
        $astrologer = \App\Models\Doctor::where('is_admin_astrologer', true)->first();
        if (!$astrologer) {
            $district = \App\Models\District::first();
            if (!$district) {
                $district = \App\Models\District::create(['name' => 'Thiruvananthapuram']);
            }

            $astrologer = \App\Models\Doctor::create([
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

        $districts = \App\Models\District::all();

        return view('admin.astrology.edit', compact('astrologer', 'districts'));
    }

    public function updateAstrology(Request $request)
    {
        $astrologer = \App\Models\Doctor::where('is_admin_astrologer', true)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:doctors,email,' . $astrologer->id,
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'qualification' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'consultation_fee' => 'required|integer|min:0',
            'consultation_type' => 'required|in:Online,Offline,Both',
            'available_time' => 'nullable|string|max:255',
            'online_available_time' => 'nullable|string|max:255',
            'google_meet_link' => 'nullable|url|max:255',
            'district_id' => 'required|exists:districts,id',
            'address' => 'required|string',
            'astrology_qualification' => 'required|string|max:255',
            'astrology_details' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
        ]);

        $data = $request->only([
            'name', 'email', 'phone', 'qualification', 'experience', 'consultation_fee',
            'consultation_type', 'available_time', 'online_available_time', 'google_meet_link',
            'district_id', 'address', 'astrology_qualification', 'astrology_details'
        ]);

        if ($request->filled('password')) {
            $data['password'] = \Hash::make($request->password);
            $data['password_plain'] = $request->password;
        }

        if ($request->hasFile('photo')) {
            if ($astrologer->photo && \Storage::disk('public')->exists($astrologer->photo)) {
                \Storage::disk('public')->delete($astrologer->photo);
            }
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        // Force defaults for essential flags
        $data['knows_medical_astrology'] = true;
        $data['is_active'] = true;

        $astrologer->update($data);

        return redirect()->back()->with('success', 'Medical Astrology settings updated successfully!');
    }
}
