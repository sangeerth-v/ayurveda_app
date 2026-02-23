<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorToken;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show booking form for a specific doctor.
     */
    public function create($doctorId)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to book a doctor.');
        }

        $doctor = Doctor::with(['department', 'district'])->findOrFail($doctorId);
        return view('bookings.create', compact('doctor'));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to book a doctor.');
        }

        $request->validate([
            'doctor_id'    => 'required|exists:doctors,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
        ]);

        // Prevent double booking same doctor/date/time
        $exists = DoctorToken::where('doctor_id', $request->doctor_id)
            ->where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->where('status', 'Booked')
            ->exists();

        if ($exists) {
            return back()->withErrors(['booking_time' => 'This time slot is already booked. Please choose another time.'])->withInput();
        }

        DoctorToken::create([
            'user_id'      => Auth::guard('web')->id(),
            'doctor_id'    => $request->doctor_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status'       => 'Booked',
        ]);

        return redirect()->route('home')->with('success', 'Appointment booked successfully!');
    }

    /**
     * User's own bookings list.
     */
    public function myBookings()
    {
        $bookings = DoctorToken::where('user_id', Auth::guard('web')->id())
            ->with('doctor.department')
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('bookings.my-bookings', compact('bookings'));
    }
}
