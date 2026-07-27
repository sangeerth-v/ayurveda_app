@extends('layouts.app')

@section('title', 'Verify Email OTP | Ayurveda App')

@section('content')
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    <div class="mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto; border-radius: 50%; background: #e8f5e9;">
                        <i class="fas fa-envelope-open-text fa-2x text-success"></i>
                    </div>
                    <h2 class="h4 fw-bold mb-2 text-success">Verify Email OTP</h2>
                    <p class="text-muted mb-4">We sent a 6-digit code to <strong>{{ session('pending_registration.email') }}</strong>. Enter it below to complete registration.</p>

                    @if(session('success'))
                        <div class="alert alert-success shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.verify_otp') }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-4">
                            <input type="text" name="otp" class="form-control form-control-lg text-center fs-4 fw-bold" maxlength="6" pattern="[0-9]{6}" placeholder="------" required autofocus autocomplete="off" style="letter-spacing: 0.75rem;">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Verify & Register</button>
                    </form>

                    <div class="small text-muted">
                        Didn't receive the OTP?
                        <form action="{{ route('register.resend_otp') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 align-baseline">Resend OTP</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
