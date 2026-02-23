<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $bookings = \App\Models\DoctorToken::where('doctor_id', \Illuminate\Support\Facades\Auth::guard('doctor')->id())
                        ->with('user')
                        ->orderBy('booking_date', 'desc')
                        ->orderBy('booking_time', 'desc')
                        ->get();

        return view('doctor.dashboard', compact('bookings'));
    }
}
