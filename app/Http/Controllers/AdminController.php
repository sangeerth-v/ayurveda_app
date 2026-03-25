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
        \App\Models\Advertisement::where('is_popup', true)->update(['is_popup' => false]);
        
        if ($id != 0) {
            $advertisement = \App\Models\Advertisement::findOrFail($id);
            $advertisement->is_popup = true;
            $advertisement->save();
            return back()->with('success', 'Popup advertisement set successfully.');
        }

        return back()->with('success', 'Popup advertisement removed successfully.');
    }
}
