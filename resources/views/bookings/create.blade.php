@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Book Doctor | Ayurveda')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header py-4" style="background: linear-gradient(135deg, #1a4d2e, #4f772d);">
                <h4 class="mb-0 text-white fw-bold">
                    <i class="fas fa-calendar-plus me-2"></i> Book Appointment
                </h4>
            </div>
            <div class="card-body p-4">
                {{-- Doctor Summary --}}
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="background: #f0f7f4;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:60px;height:60px;background:#1a4d2e;">
                        <i class="fas fa-user-md fa-lg text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold" style="color:#1a4d2e;">Dr. {{ $doctor->name }}</h5>
                        <p class="mb-0 text-muted small">
                            {{ $doctor->department->name ?? 'General' }} &bull; {{ $doctor->district->name ?? '' }}
                        </p>
                        <p class="mb-0 text-muted small">
                            <i class="fas fa-rupee-sign me-1"></i>{{ number_format($doctor->consultation_fee, 2) }} consultation fee
                            @if($doctor->available_time)
                             &bull; <i class="fas fa-clock me-1"></i>Available: {{ $doctor->available_time }}
                            @endif
                        </p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Appointment Date</label>
                            <input type="date"
                                   name="booking_date"
                                   class="form-control @error('booking_date') is-invalid @enderror"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('booking_date') }}"
                                   required>
                            @error('booking_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Appointment Time</label>
                            <select name="booking_time" class="form-select @error('booking_time') is-invalid @enderror" required>
                                <option value="">-- Select Time Slot --</option>
                                @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00'] as $slot)
                                    <option value="{{ $slot }}" {{ old('booking_time') == $slot ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromFormat('H:i', $slot)->format('h:i A') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('booking_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            <i class="fas fa-check-circle me-2"></i>Confirm Booking
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
