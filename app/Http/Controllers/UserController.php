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
        $guards = ['web', 'admin', 'doctor', 'pharma'];

        \Log::info("USER_LOGIN: Attempt for email: " . $request->email);

        foreach ($guards as $guard) {
            \Log::info("USER_LOGIN: Trying guard '$guard'");
            
            if ($guard === 'admin') {
                $admin = \App\Models\Admin::where('email', $request->email)->first();
                if ($admin) {
                    \Log::info("USER_LOGIN: Admin record found.");
                    if ($admin->password === $request->password || Hash::check($request->password, $admin->password)) {
                        Auth::guard('admin')->login($admin);
                        \Log::info("USER_LOGIN: Success for admin. Check: " . (Auth::guard('admin')->check() ? 'YES' : 'NO'));
                        $request->session()->regenerate();
                        \Log::info("USER_LOGIN: After regenerate. Check: " . (Auth::guard('admin')->check() ? 'YES' : 'NO'));
                        return redirect()->intended($this->redirectPath('admin'));
                    } else {
                        \Log::warning("USER_LOGIN: Admin password mismatch.");
                    }
                }
            } else {
                $user = null;
                if ($guard === 'web') $user = \App\Models\User::where('email', $request->email)->first();
                elseif ($guard === 'doctor') $user = \App\Models\Doctor::where('email', $request->email)->first();
                elseif ($guard === 'pharma') $user = \App\Models\PharmaCompany::where('email', $request->email)->first();

                if ($user) {
                    \Log::info("USER_LOGIN: User record found in $guard guard.");
                    if (Auth::guard($guard)->attempt($credentials)) {
                        \Log::info("USER_LOGIN: Success for $guard. Check: " . (Auth::guard($guard)->check() ? 'YES' : 'NO'));
                        $request->session()->regenerate();
                        \Log::info("USER_LOGIN: After regenerate. Check: " . (Auth::guard($guard)->check() ? 'YES' : 'NO'));
                        return redirect()->intended($this->redirectPath($guard));
                    } else {
                        \Log::warning("USER_LOGIN: Password mismatch for $guard.");
                    }
                }
            }
        }

        \Log::warning("USER_LOGIN: All guards failed for: " . $request->email);
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('doctor')->logout();
        Auth::guard('pharma')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
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
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended($this->redirectPath('web'));
    }

    protected function redirectPath($role)
    {
        return match($role) {
            'admin' => route('admin.dashboard'),
            'doctor' => route('doctor.dashboard'),
            'pharma' => route('pharma.dashboard'),
            'web' => '/',
            default => '/',
        };
    }

    // --- Public Views ---
    public function index()
    {
        return view('home');
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

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
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
        $cart->items()->delete();
        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
    }

    // --- Booking Section ---
    public function createBooking($doctorId)
    {
        $doctor = Doctor::with(['district'])->findOrFail($doctorId);
        $bookedSlots = DoctorToken::where('doctor_id', $doctorId)
            ->where('status', 'Booked')
            ->where('booking_date', '>=', now()->toDateString())
            ->get(['booking_date', 'booking_time']);

        // Generate dynamic time slots based on doctor's available_time
        $slots = [];
        if ($doctor->available_time && str_contains($doctor->available_time, ' to ')) {
            [$startStr, $endStr] = explode(' to ', $doctor->available_time);
            try {
                $start = \Carbon\Carbon::createFromFormat('H:i', $startStr);
                $end = \Carbon\Carbon::createFromFormat('H:i', $endStr);

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

        return view('bookings.create', compact('doctor', 'bookedSlots', 'slots'));
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
            ->where('status', 'Booked')
            ->exists();

        if ($exists) return back()->withErrors(['booking_time' => 'This time slot is already booked.'])->withInput();

        DoctorToken::create([
            'user_id'      => Auth::id(),
            'doctor_id'    => $request->doctor_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status'       => 'Booked',
        ]);

        return redirect()->route('home')->with('success', 'Appointment booked successfully!');
    }

    public function myBookings()
    {
        $bookings = DoctorToken::where('user_id', Auth::id())->with('doctor')->orderBy('booking_date', 'desc')->get();
        return view('bookings.my-bookings', compact('bookings'));
    }
}
