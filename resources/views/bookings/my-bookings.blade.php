@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'My Appointments | Ayurveda')

@section('content')
<div class="container page-shell py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color:#1a4d2e;"><i class="fas fa-calendar-check me-2"></i>My Appointments</h3>
            <a href="{{ route('home') }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Home
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-exclamation-circle fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted opacity-50 mb-3"></i>
                <h5 class="text-muted">No appointments booked yet.</h5>
                <a href="{{ route('doctors.index') }}" class="btn btn-success mt-2">Book a Doctor</a>
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="list-group list-group-flush">
                    @foreach($bookings as $booking)
                        <div class="list-group-item p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center border-end">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                                    </h5>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="col-md-6 ps-4">
                                    <div class="d-flex align-items-center gap-3 mb-1">
                                        <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width:45px;height:45px;background:#1a4d2e;">
                                            @if($booking->doctor && $booking->doctor->photo)
                                                <img src="{{ asset('storage/' . $booking->doctor->photo) }}" alt="Dr. {{ $booking->doctor->name }}" style="width:100%;height:100%;object-fit:cover;">
                                            @else
                                                <i class="fas fa-user-md text-white"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h5 class="mb-0 fw-bold" style="color:#1a4d2e;">
                                                Dr. {{ $booking->doctor->name ?? 'N/A' }}
                                            </h5>
                                            <p class="mb-0 text-muted small">
                                                {{ $booking->doctor->specialization_category ?? 'General' }}
                                                @if($booking->consultation_type)
                                                    <span class="badge bg-light text-dark border ms-1">{{ $booking->consultation_type }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @if($booking->status == 'Booked' && $booking->consultation_type == 'Online')
                                        @php
                                            $meetLink = $booking->google_meet_link ?: ($booking->doctor->google_meet_link ?? null);
                                        @endphp
                                        <div class="mt-2">
                                            @if(!empty($meetLink))
                                                <a href="{{ $meetLink }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                                    <i class="fas fa-video me-1"></i> Join Google Meet
                                                </a>
                                                <div class="mt-1 small text-muted">
                                                    <i class="fas fa-link me-1"></i> {{ $meetLink }}
                                                </div>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2 py-1 rounded">
                                                    <i class="fas fa-clock me-1"></i> Google Meet link will be provided by doctor
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4 text-end">
                                    @if($booking->status == 'Pending')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fas fa-clock me-1"></i>Awaiting Doctor Approval</span>
                                    @elseif($booking->status == 'Booked')
                                        <span class="badge bg-success px-3 py-2 rounded-pill mb-2"><i class="fas fa-check-circle me-1"></i>Doctor Approved</span>
                                        <!-- <div class="small text-success fw-bold"><i class="fas fa-mobile-alt me-1"></i> SMS Alert Sent to Phone</div> -->
                                    @elseif($booking->status == 'Completed')
                                        <span class="badge bg-primary px-3 py-2 rounded-pill"><i class="fas fa-check-double me-1"></i>Completed</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i>Cancelled</span>
                                    @endif

                                    @if(in_array($booking->status, ['Pending', 'Booked']))
                                        <div class="mt-3 d-flex justify-content-end gap-2">
                                            <a href="{{ route('bookings.reschedule', $booking->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                                <i class="fas fa-calendar-alt me-1"></i> Reschedule
                                            </a>
                                            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm">
                                                    <i class="fas fa-times me-1"></i> Cancel
                                                </button>
                                            </form>
                                        </div>
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
</div>
@endsection
