@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Doctor Profile | Ayurveda Admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}" class="text-success text-decoration-none">Doctor Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $doctor->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="card-body text-center p-5" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 bg-white shadow-lg overflow-hidden" style="width: 120px; height: 120px;">
                    @if($doctor->photo)
                        <img src="{{ asset('storage/' . $doctor->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-user-md fa-4x" style="color: var(--primary-green);"></i>
                    @endif
                </div>
                <h3 class="text-white mb-1">{{ $doctor->name }}</h3>
                <p class="text-white opacity-75 mb-1">{{ $doctor->specialization_category ?? 'General' }}</p>
                <p class="text-white opacity-50 small mb-0">{{ $doctor->specialization_subcategory ?? '' }}</p>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">ID Number</span>
                        <span class="fw-bold">#DOC-{{ str_pad($doctor->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </li>
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">Consultation Fee</span>
                        <span class="text-success fw-bold">₹{{ $doctor->consultation_fee ?? '0' }}</span>
                    </li>
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">Experience</span>
                        <span class="fw-bold">{{ $doctor->experience ?? '0' }} Years</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-address-book me-2 text-success"></i> Contact Info</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Email Address</label>
                    <div class="text-dark">{{ $doctor->email }}</div>
                </div>
                <div class="mb-3">
                    <label class="small text-muted text-uppercase fw-bold mb-1 d-block">System Password</label>
                    <div class="text-primary fw-bold">{{ $doctor->password_plain ?? 'N/A' }}</div>
                </div>
                <div class="mb-3">
                    <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Phone Number</label>
                    <div class="text-dark">{{ $doctor->phone ?? 'Not provided' }}</div>
                </div>
                <div>
                    <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Practice Location</label>
                    <div class="text-dark">{{ $doctor->district->name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Professional Summary -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-graduation-cap me-2 text-success"></i> Professional Summary</h5>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted small text-uppercase fw-bold mb-3">Qualifications</h6>
                        <p class="text-dark fs-5">{{ $doctor->qualification ?? 'MBBS, BAMS (Ayurveda)' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted small text-uppercase fw-bold mb-3">Availability</h6>
                        <p class="text-dark fw-medium"><i class="far fa-clock me-2 text-warning"></i> {{ $doctor->available_time ?? 'Mon - Fri (9:00 AM - 5:00 PM)' }}</p>
                    </div>
                </div>
                
                <hr class="my-4 opacity-10">

                <div class="d-flex gap-3">
                    <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this doctor profile?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i> Delete Profile
                        </button>
                    </form>
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-check me-2 text-success"></i> Recent Appointments</h5>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ $doctor->appointments->count() }} Total</span>
            </div>
            <div class="card-body p-0">
                @if($doctor->appointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 border-0 small text-uppercase fw-bold text-muted">Patient</th>
                                    <th class="border-0 small text-uppercase fw-bold text-muted">Date</th>
                                    <th class="border-0 small text-uppercase fw-bold text-muted">Time</th>
                                    <th class="pe-4 border-0 small text-uppercase fw-bold text-muted text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctor->appointments as $appointment)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                    {{ substr($appointment->user->name ?? 'U', 0, 1) }}
                                                </div>
                                                <div class="fw-bold">{{ $appointment->user->name ?? 'Guest User' }}</div>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->booking_date)->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->booking_time)->format('h:i A') }}</td>
                                        <td class="pe-4 text-end">
                                            <span class="badge rounded-pill {{ $appointment->status == 'Booked' ? 'bg-primary' : 'bg-success' }} px-3">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-history fa-3x text-light mb-3"></i>
                        <p class="text-muted">No recent appointments recorded for this doctor.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
