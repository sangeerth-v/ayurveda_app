@extends('layouts.app')

@section('navbar')
    @include('partials.nav-doctor')
@endsection

@section('title', 'My Profile | Doctor Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="mb-1">My Professional Profile</h2>
                <p class="text-muted mb-0">Manage your publicly visible information and credentials.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm overflow-hidden mb-5">
            <div class="card-body p-0">
                <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-0">
                        <!-- Sidebar Info -->
                        <div class="col-lg-4 bg-light border-end p-4 p-xl-5">
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <div id="photo-preview" class="rounded-circle d-flex align-items-center justify-content-center border border-4 border-white shadow-sm" style="width: 150px; height: 150px; background-color: #e8f5e9; color: var(--primary-green); overflow: hidden;">
                                        @if($doctor->photo)
                                            <img src="{{ asset('storage/' . $doctor->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="fas fa-user-md fa-5x"></i>
                                        @endif
                                    </div>
                                    <label for="photo-input" class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 p-2 shadow" style="width: 38px; height: 38px;">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" name="photo" id="photo-input" class="d-none" accept="image/*" onchange="previewImage(this, 'photo-preview')">
                                </div>
                                <h5 class="mt-3 fw-bold">Profile Photo</h5>
                                <p class="small text-muted">This will be visible to patients.</p>
                            </div>
                            
                            <hr class="my-4 opacity-10">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Account Status</label>
                                <div class="d-flex align-items-center mt-2">
                                    <span class="badge bg-success rounded-pill px-3 py-2">Active Practitioner</span>
                                </div>
                                <p class="small text-muted mt-2">Member since {{ $doctor->created_at->format('M Y') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Security</label>
                                <p class="small text-muted">To change your password, use the "New Password" field in the form.</p>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="col-lg-8 p-4 p-xl-5">
                            <h5 class="mb-4 fw-bold border-bottom pb-2 text-success">Personal Information</h5>
                            <div class="row g-4 mb-5">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Display Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $doctor->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $doctor->email) }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $doctor->phone) }}" pattern="[0-9]{10}" maxlength="10" minlength="10" title="Please enter exactly 10 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">New Password (Leave blank to keep current)</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <h5 class="mb-4 fw-bold border-bottom pb-2 text-success">Professional Details</h5>
                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Specialization Category</label>
                                    <input type="text" name="specialization_category" class="form-control @error('specialization_category') is-invalid @enderror" value="{{ old('specialization_category', $doctor->specialization_category) }}">
                                    @error('specialization_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Specialization Subcategory</label>
                                    <input type="text" name="specialization_subcategory" class="form-control @error('specialization_subcategory') is-invalid @enderror" value="{{ old('specialization_subcategory', $doctor->specialization_subcategory) }}">
                                    @error('specialization_subcategory') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Qualifications (Degrees/Certifications)</label>
                                    <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" value="{{ old('qualification', $doctor->qualification) }}">
                                    @error('qualification') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Experience (Years)</label>
                                    <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" value="{{ old('experience', $doctor->experience) }}">
                                    @error('experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Consultation Fee (₹)</label>
                                    <input type="number" step="1" min="0" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" value="{{ old('consultation_fee', (int)$doctor->consultation_fee) }}">
                                    @error('consultation_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Working District</label>
                                    <select name="district_id" class="form-select @error('district_id') is-invalid @enderror">
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id', $doctor->district_id) == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div id="offlineProfileFields" class="col-md-6" style="{{ in_array($doctor->consultation_type ?? 'Offline', ['Offline', 'Both']) ? '' : 'display:none;' }}">
                                    {{-- Time parsing --}}
                                    @php 
                                        $times = explode(' to ', $doctor->available_time ?? ''); 
                                        $from = $times[0] ?? '09:00'; 
                                        $to = $times[1] ?? '17:00'; 
                                    @endphp
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label fw-bold">Offline Available From</label>
                                            <select name="available_from" class="form-select">
                                                @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'] as $time)
                                                    <option value="{{ $time }}" {{ $from == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold">Offline Available To</label>
                                            <select name="available_to" class="form-select">
                                                @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'] as $time)
                                                    <option value="{{ $time }}" {{ $to == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Consultation Type --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Consultation Type</label>
                                    <div class="d-flex gap-3 flex-wrap">
                                        @foreach(['Offline' => '🏥 Offline (In-Person)', 'Online' => '🎥 Online', 'Both' => '🌐 Both'] as $val => $label)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="consultation_type" id="pct_{{ $val }}" value="{{ $val }}"
                                                    {{ old('consultation_type', $doctor->consultation_type ?? 'Offline') === $val ? 'checked' : '' }}
                                                    onchange="toggleOnlineProfileFields()">
                                                <label class="form-check-label fw-semibold" for="pct_{{ $val }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Online Availability and Meet Link --}}
                                @php
                                    $onTimes = explode(' to ', $doctor->online_available_time ?? '');
                                    $onFrom = $onTimes[0] ?? '09:00';
                                    $onTo = $onTimes[1] ?? '17:00';
                                @endphp
                                <div id="onlineProfileFields" class="col-12" style="{{ in_array($doctor->consultation_type ?? 'Offline', ['Online', 'Both']) ? '' : 'display:none;' }}">
                                    <div class="row g-3 p-3 rounded-3" style="background:#e8f4fd; border:1px solid #b8d9f7;">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-primary">🎥 Online Availability Hours</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Online Available From</label>
                                            <select name="online_available_from" class="form-select">
                                                @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'] as $time)
                                                    <option value="{{ $time }}" {{ $onFrom == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Online Available To</label>
                                            <select name="online_available_to" class="form-select">
                                                @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'] as $time)
                                                    <option value="{{ $time }}" {{ $onTo == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Google Meet Link</label>
                                            <input type="url" name="google_meet_link" class="form-control @error('google_meet_link') is-invalid @enderror"
                                                placeholder="https://meet.google.com/xxx-xxxx-xxx"
                                                value="{{ old('google_meet_link', $doctor->google_meet_link) }}">
                                            <div class="form-text">Your personal Google Meet room link shared with patients after you approve their online appointment.</div>
                                            @error('google_meet_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5">

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg shadow-sm">
                                    <i class="fas fa-save me-2"></i> Update My Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleOnlineProfileFields() {
    const selected = document.querySelector('input[name="consultation_type"]:checked');
    const offlineFields = document.getElementById('offlineProfileFields');
    const onlineFields = document.getElementById('onlineProfileFields');
    
    if (!selected || !offlineFields || !onlineFields) return;
    
    const val = selected.value;
    if (val === 'Offline') {
        offlineFields.style.display = 'block';
        onlineFields.style.display = 'none';
    } else if (val === 'Online') {
        offlineFields.style.display = 'none';
        onlineFields.style.display = 'block';
    } else { // 'Both'
        offlineFields.style.display = 'block';
        onlineFields.style.display = 'block';
    }
}
document.addEventListener('DOMContentLoaded', toggleOnlineProfileFields);
</script>

<style>
    .form-label { font-size: 0.9rem; color: #495057; }
    .form-control:focus, .form-select:focus {
        border-color: #1a4d2e;
        box-shadow: 0 0 0 0.25rem rgba(26, 77, 46, 0.1);
    }
    .bg-light { background-color: #f8faf9 !important; }
</style>
@endsection
