@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Edit Medical Astrology Settings | Admin Portal')

@section('content')
<div class="container py-4 px-4 px-xl-5" style="max-width: 1200px;">
    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 p-4 bg-white rounded-4 shadow-sm border">
        <div>
            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill small fw-bold mb-2">
                <i class="fas fa-star-of-life me-1"></i> Medical Astrology System
            </span>
            <h2 class="fw-bold text-dark mb-0">Configure Medical Astrology settings</h2>
            <p class="text-muted small mb-0 mt-1">Manage the details of the application's Chief Medical Astrologer profile shown to users.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark px-3 py-2 fw-bold small rounded-3 shadow-sm text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-1"></i>Please fix the following validation errors:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.astrology.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            {{-- Left Side: Main Info & Astrology Details --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-user-circle me-2 text-success"></i>Profile Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Astrologer Display Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $astrologer->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Notification Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $astrologer->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Contact Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $astrologer->phone) }}" required pattern="[6-9][0-9]{9}" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="e.g. 9876543210">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Consultation Fee (INR)</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $astrologer->consultation_fee) }}" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">General Qualifications</label>
                                <input type="text" name="qualification" class="form-control" placeholder="e.g. BAMS, MD (Ayurveda)" value="{{ old('qualification', $astrologer->qualification) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Years of Experience</label>
                                <input type="number" name="experience" class="form-control" value="{{ old('experience', $astrologer->experience) }}" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Login Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current" minlength="8">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm Login Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Required if changing password" minlength="8">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-scroll me-2 text-warning"></i>Astrological Profile details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Astrological Qualification / Title</label>
                            <input type="text" name="astrology_qualification" class="form-control" placeholder="e.g. Jyotish Acharya, Medical Astrologer" value="{{ old('astrology_qualification', $astrologer->astrology_qualification) }}" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Astrology Specialties & Biography Details</label>
                            <textarea name="astrology_details" class="form-control" rows="6" placeholder="Describe the astrologer's expertise, nadi-pariksha skills, star alignment health analysis, etc." required>{{ old('astrology_details', $astrologer->astrology_details) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Consultation Type, Timings & Photo --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-clock me-2 text-primary"></i>Consultation &amp; Schedule</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Consultation Type Offered</label>
                            <select name="consultation_type" class="form-select" required>
                                <option value="Both" {{ old('consultation_type', $astrologer->consultation_type) == 'Both' ? 'selected' : '' }}>Both (Online &amp; In-Person)</option>
                                <option value="Online" {{ old('consultation_type', $astrologer->consultation_type) == 'Online' ? 'selected' : '' }}>Online Only (Google Meet)</option>
                                <option value="Offline" {{ old('consultation_type', $astrologer->consultation_type) == 'Offline' ? 'selected' : '' }}>In-Person Clinic Only</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">In-Clinic Available Timings</label>
                            <input type="text" name="available_time" class="form-control" placeholder="e.g. 09:00 AM to 01:00 PM" value="{{ old('available_time', $astrologer->available_time) }}">
                            <div class="form-text small">Leave blank if Offline consultations are not offered.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Online Video Available Timings</label>
                            <input type="text" name="online_available_time" class="form-control" placeholder="e.g. 04:00 PM to 08:00 PM" value="{{ old('online_available_time', $astrologer->online_available_time) }}">
                            <div class="form-text small">Leave blank if Online consultations are not offered.</div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold">Google Meet Link</label>
                            <input type="url" name="google_meet_link" class="form-control" placeholder="https://meet.google.com/abc-defg-hij" value="{{ old('google_meet_link', $astrologer->google_meet_link) }}">
                            <div class="form-text small">Static room URL sent to patient after scheduling approval.</div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-map-marked-alt me-2 text-info"></i>Clinic Location</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">District</label>
                            <select name="district_id" class="form-select" required>
                                @foreach($districts as $d)
                                    <option value="{{ $d->id }}" {{ old('district_id', $astrologer->district_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Clinic Full Address</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ old('address', $astrologer->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-camera me-2 text-secondary"></i>Profile Picture</h5>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mb-3 d-flex justify-content-center">
                            <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center border" style="width: 120px; height: 120px; background: #f8f9fa;">
                                @if($astrologer->photo)
                                    <img id="preview-img" src="{{ asset('storage/' . $astrologer->photo) }}" alt="Preview" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <i id="preview-placeholder" class="fas fa-user-md fa-4x text-muted"></i>
                                    <img id="preview-img" src="" alt="Preview" class="d-none" style="width:100%; height:100%; object-fit:cover;">
                                @endif
                            </div>
                        </div>
                        <div class="mb-0">
                            <input type="file" name="photo" id="photo-upload" class="form-control form-control-sm" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 p-4 bg-white rounded-4 border shadow-sm d-flex gap-3">
            <button type="submit" class="btn btn-success px-4 py-2.5 fw-bold shadow-sm">
                <i class="fas fa-save me-2"></i>Save Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4 py-2.5">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('photo-upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview-img');
                const placeholder = document.getElementById('preview-placeholder');
                
                img.src = e.target.result;
                img.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
