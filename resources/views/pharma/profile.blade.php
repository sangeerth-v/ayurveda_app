@extends('layouts.app')

@section('navbar')
    @include('partials.nav-pharma')
@endsection

@section('title', 'Pharma Profile | Ayurveda')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white py-4 text-center">
                    <h3 class="fw-bold mb-0 text-white" style="font-family: 'Playfair Display', serif;">Edit Company Profile</h3>
                </div>

                <div class="card-body p-5">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pharma.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-12 text-center mb-3">
                                <div class="position-relative d-inline-block">
                                    @if($pharma->logo)
                                        <img src="{{ asset('storage/' . $pharma->logo) }}" id="logoPreview" class="rounded-circle border shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div id="logoPreviewPlaceholder" class="rounded-circle bg-light border d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                            <i class="fas fa-building fa-4x text-muted opacity-25"></i>
                                        </div>
                                    @endif
                                    <label for="logo" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 rounded-circle shadow" style="width: 35px; height: 35px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" id="logo" name="logo" class="d-none" onchange="previewImage(this)">
                                </div>
                                <div class="mt-2 small text-muted">Update Company Logo</div>
                            </div>

                            <div class="col-md-6">
                                <label for="company_name" class="form-label fw-bold">Company Name</label>
                                <input type="text" class="form-control form-control-lg @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $pharma->company_name) }}" required>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $pharma->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold">Phone Number</label>
                                <input type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $pharma->phone) }}" pattern="[0-9]{10}" maxlength="10" minlength="10" title="Please enter exactly 10 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold">New Password (Leave blank to keep current)</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label fw-bold">Office Address</label>
                                <textarea class="form-control form-control-lg @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $pharma->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm fw-bold">
                                <i class="fas fa-save me-2"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById('logoPreview');
            if(preview) {
                preview.src = e.target.result;
            } else {
                // Handle placeholder transition if needed
                location.reload(); // Simplest way to show new image after upload
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
