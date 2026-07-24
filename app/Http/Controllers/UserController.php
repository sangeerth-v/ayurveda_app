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
use App\Mail\AppointmentRequestMail;
use App\Mail\OrderPlacedUserMail;
use App\Mail\OrderPlacedPharmaMail;

class UserController extends Controller
{
    // --- Auth Section ---
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $guards = ['web', 'admin', 'doctor', 'pharma', 'hospital'];

        \Log::info("USER_LOGIN: Attempt for email: " . $request->email);

        foreach ($guards as $guard) {
            if ($guard === 'admin') {
                $admin = \App\Models\Admin::where('email', $request->email)->first();
                if ($admin && ($admin->password === $request->password || Hash::check($request->password, $admin->password))) {
                    Auth::guard('admin')->login($admin);
                    
                    $request->session()->regenerate();
                    
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
                
                $user = $userModel::where('email', $request->email)->first();
                if ($user && ($user->password === $request->password || Auth::guard($guard)->attempt($credentials))) {
                    if ($guard === 'hospital' && isset($user->is_active) && !$user->is_active) {
                        return back()->withErrors(['email' => 'This hospital account is not active. Please contact admin.']);
                    }

                    Auth::guard($guard)->login($user);
                    \Log::info("USER_LOGIN: Success for $guard.");
                    
                    $request->session()->regenerate();

                    if ($request->filled('redirect')) {
                        return redirect($request->redirect);
                    }
                    
                    return redirect()->intended($this->redirectPath($guard));
                }
            }
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
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
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|digits:10',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        try {
            Mail::to($user->email)->send(new UserRegisteredMail($user));
        } catch (\Exception $e) {
            \Log::error("Failed to send welcome email to {$user->email}: " . $e->getMessage());
        }

        Auth::login($user);

        if ($request->filled('redirect')) {
            return redirect($request->redirect);
        }

        return redirect()->intended($this->redirectPath('web'));
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
        $popupAd = \App\Models\Advertisement::where('is_popup', true)->first();
        return view('home', compact('advertisements', 'popupAd'));
    }

    public function products(Request $request)
    {
        $query = Product::where('stock', '>', 0);
        
        if ($request->has('categories')) {
            $query->whereIn('category', $request->categories);
        }
        
        if ($request->has('subcategories')) {
            $query->whereIn('subcategory', $request->subcategories);
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
            
        return view('products.index', compact('products', 'categoryData', 'sort'));
    }

    public function doctors()
    {
        $doctors = Doctor::with(['district'])->get();
        $districts = \App\Models\District::all();
        return view('doctors.index', compact('doctors', 'districts'));
    }

    public function hospitals()
    {
        $hospitals = \App\Models\Hospital::where('is_active', true)->with('district')->latest()->get();
        return view('hospitals.index', compact('hospitals'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
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
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();

        $qtyToAdd = $request->input('quantity', 1);

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
        $cartItem = CartItem::findOrFail($id);
        if($cartItem->cart->user_id != Auth::id()) abort(403);
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
        return view('orders.show', compact('order'));
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

        // Generate dynamic time slots based on doctor's available_time
        $slots = [];
        if ($doctor->available_time && str_contains($doctor->available_time, ' to ')) {
            [$startStr, $endStr] = explode(' to ', $doctor->available_time);
            try {
                $start = \Carbon\Carbon::parse($startStr);
                $end = \Carbon\Carbon::parse($endStr);

                while ($start < $end) {
                    $slots[] = $start->format('H:i');
                    $start->addMinutes(30);
                }
            } catch (\Exception $e) {
                // Fallback to default slots if parsing fails
                $slots = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00'];
            }
        } else {
            // Default slots
            $slots = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00'];
        }

        return view('bookings.create', compact('doctor', 'bookedSlots', 'slots', 'unavailabilities'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'doctor_id'    => 'required|exists:doctors,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
        ]);

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

        $booking = DoctorToken::create([
            'user_id'      => Auth::id(),
            'doctor_id'    => $request->doctor_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status'       => 'Pending',
        ]);

        // Send appointment request email to Doctor
        try {
            Mail::to($booking->doctor->email)->send(new AppointmentRequestMail($booking));
        } catch (\Exception $e) {
            \Log::error("Failed to send appointment request email: " . $e->getMessage());
        }

        return redirect()->route('bookings.my')->with('success', 'Appointment booking request submitted! Awaiting doctor approval.');
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
}
