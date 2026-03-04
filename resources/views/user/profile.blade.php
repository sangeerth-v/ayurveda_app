@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'My Profile | Ayurveda')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="mb-1" style="color: #1a4d2e; font-family: 'Playfair Display', serif;">My Profile</h2>
                <p class="text-muted mb-0">Manage your personal information and account settings.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ url('/') }}" class="btn btn-outline-success rounded-pill px-4">
                    <i class="fas fa-home me-2"></i> Back to Home
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3 fa-lg"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
            <div class="card-body p-0">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-0">
                        <!-- Sidebar Info -->
                        <div class="col-lg-4 bg-light border-end p-4 p-xl-5 text-center">
                            <div class="mb-4">
                                <div class="rounded-circle d-flex align-items-center justify-content-center border border-4 border-white shadow-sm mx-auto mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #1a4d2e, #4f772d); color: white;">
                                    <span class="display-3 fw-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                                <p class="text-muted small">Registered User</p>
                            </div>
                            
                            <hr class="my-4 opacity-10">
                            
                            <div class="text-start">
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Account Activity</label>
                                    <p class="small text-muted mb-1">
                                        <i class="far fa-calendar-alt me-2"></i>Joined {{ $user->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                
                                <div class="mb-0">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Security Tips</label>
                                    <p class="x-small text-muted">Use a strong password to keep your account safe.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="col-lg-8 p-4 p-xl-5">
                            <h5 class="mb-4 fw-bold text-success d-flex align-items-center">
                                <i class="fas fa-user-circle me-2"></i> Personal Details
                            </h5>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control rounded-3 @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" pattern="[0-9]{10}" maxlength="10" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <h5 class="mb-4 mt-5 fw-bold text-success d-flex align-items-center">
                                <i class="fas fa-lock me-2"></i> Update Password
                            </h5>
                            <p class="text-muted small mb-4">Leave both fields empty if you don't want to change your password.</p>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" placeholder="••••••••">
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="••••••••">
                                </div>
                            </div>

                            <hr class="my-5 opacity-10">

                            <div class="d-grid shadow-sm">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill py-3 fw-bold">
                                    <i class="fas fa-save me-2"></i> Update Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #1a4d2e;
        box-shadow: 0 0 0 0.25rem rgba(26, 77, 46, 0.1);
    }
    .bg-light { background-color: #f8fafb !important; }
    .x-small { font-size: 0.75rem; }
    .hover-lift { transition: transform 0.2s; }
    .hover-lift:hover { transform: translateY(-3px); }
</style>
@endsection
