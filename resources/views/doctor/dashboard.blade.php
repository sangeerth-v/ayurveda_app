@extends('layouts.app')

@section('navbar')
    @include('partials.nav-doctor')
@endsection

@section('title', 'Doctor Dashboard | Ayurveda')

@section('content')
<div class="row justify-content-center">
    <!-- Welcome & Status -->
    <div class="col-md-10 mb-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="mb-1" style="font-family: 'Playfair Display', serif; font-style: italic;">Dr. {{ Auth::guard('doctor')->user()->name }}</h2>
                <p class="text-muted mb-0">Today's Schedule & Appointments</p>
            </div>
            <div class="text-end">
                <h5 class="mb-0 text-success fw-bold">{{ now()->format('l, d M Y') }}</h5>
            </div>
        </div>

        <!-- Appointment List -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-success text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-check me-2"></i> Upcoming Appointments</h5>
                <span class="badge bg-white text-success px-3 py-2 rounded-pill">{{ $bookings->count() }} Total</span>
            </div>
            
            <div class="card-body p-0">
                @if($bookings->isEmpty())
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted opacity-50">
                            <i class="fas fa-calendar-times fa-4x"></i>
                        </div>
                        <h5 class="text-muted">No appointments scheduled yet.</h5>
                        <p class="text-muted small">Relax and enjoy your day!</p>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($bookings as $booking)
                            <div class="list-group-item p-4" style="border-bottom: 1px solid #f0f0f0 !important; transition: background-color 0.2s;">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center border-end">
                                        <h5 class="mb-0 fw-bold text-dark">
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->booking_time)->format('h:i A') }}
                                        </h5>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</small>
                                    </div>
                                    <div class="col-md-5 ps-4">
                                        <h5 class="mb-1 fw-bold text-success">{{ $booking->user->name ?? 'Guest Patient' }}</h5>
                                        <p class="mb-0 text-muted small">
                                            <i class="fas fa-envelope me-1"></i> {{ $booking->user->email ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="col-md-5 text-end">
                                        @if($booking->status == 'Booked')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">Confirmed</span>
                                        @elseif($booking->status == 'Completed')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">Cancelled</span>
                                        @endif
                                        <small class="text-muted ms-2 d-block mt-1">
                                            Booked on {{ $booking->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
