@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'My Appointments | Ayurveda')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color:#1a4d2e;"><i class="fas fa-calendar-check me-2"></i>My Appointments</h3>
            <a href="{{ route('home') }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Home
            </a>
        </div>

        @if($bookings->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted opacity-50 mb-3"></i>
                <h5 class="text-muted">No appointments booked yet.</h5>
                <a href="{{ route('home') }}" class="btn btn-success mt-2">Book a Doctor</a>
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="list-group list-group-flush">
                    @foreach($bookings as $booking)
                        <div class="list-group-item p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center border-end">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->booking_time)->format('h:i A') }}
                                    </h5>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="col-md-6 ps-4">
                                    <h5 class="mb-1 fw-bold" style="color:#1a4d2e;">
                                        Dr. {{ $booking->doctor->name ?? 'N/A' }}
                                    </h5>
                                    <p class="mb-0 text-muted small">
                                        {{ $booking->doctor->department->name ?? 'General' }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    @if($booking->status == 'Booked')
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">Confirmed</span>
                                    @elseif($booking->status == 'Completed')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">Cancelled</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
