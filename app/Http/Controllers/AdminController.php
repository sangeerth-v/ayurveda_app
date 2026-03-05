<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
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

        if ($admin && $admin->password === $request->password) {
            Auth::guard('admin')->login($admin);
            \Log::info("ADMIN_LOGIN: Success for email: " . $request->email);
            return redirect()->route('admin.dashboard');
        }

        \Log::warning("ADMIN_LOGIN: Failed for email: " . $request->email);

        return back()->with('error', 'Invalid Email or Password');
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
        return view('admin.dashboard');
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
}
