@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Edit Doctor | Ayurveda Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="mb-1">Edit Doctor Profile</h2>
                <p class="text-muted mb-0">Update information for Dr. {{ $doctor->name }}</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
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
                                <h5 class="mt-3 fw-bold">Update Profile Photo</h5>
                                <p class="small text-muted">Upload a new headshot to change the current one.</p>
                            </div>
                            
                            <hr class="my-4 opacity-10">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">ID: #{{ $doctor->id }}</label>
                                <p class="small text-muted">Registered on {{ $doctor->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="col-lg-8 p-4 p-xl-5">
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="" value="{{ old('name', $doctor->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="" value="{{ old('email', $doctor->email) }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Password (Leave blank to keep current)</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Specialization Category</label>
                                    <input type="text" name="specialization_category" class="form-control @error('specialization_category') is-invalid @enderror" placeholder="" value="{{ old('specialization_category', $doctor->specialization_category) }}" required>
                                    @error('specialization_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Specialization Subcategory</label>
                                    <input type="text" name="specialization_subcategory" class="form-control @error('specialization_subcategory') is-invalid @enderror" placeholder="" value="{{ old('specialization_subcategory', $doctor->specialization_subcategory) }}">
                                    @error('specialization_subcategory') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Working District</label>
                                    <select name="district_id" class="form-select @error('district_id') is-invalid @enderror" required>
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id', $doctor->district_id) == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="" value="{{ old('phone', $doctor->phone) }}" pattern="[0-9]{10}" maxlength="10" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Consultation Fee (₹)</label>
                                    <input type="number" min="0" step="1" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" placeholder="" value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Qualifications</label>
                                    <input type="text" name="qualification" class="form-control" placeholder="" value="{{ old('qualification', $doctor->qualification) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Experience (Years)</label>
                                    <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" placeholder="" value="{{ old('experience', $doctor->experience) }}">
                                </div>

                                @php 
                                    $times = explode(' to ', $doctor->available_time ?? ''); 
                                    $from = $times[0] ?? '09:00'; 
                                    $to = $times[1] ?? '17:00'; 
                                @endphp
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Available From</label>
                                    <select name="available_from" class="form-select @error('available_from') is-invalid @enderror">
                                        @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'] as $time)
                                            <option value="{{ $time }}" {{ $from == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Available To</label>
                                    <select name="available_to" class="form-select @error('available_to') is-invalid @enderror">
                                        @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'] as $time)
                                            <option value="{{ $time }}" {{ $to == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                                    <i class="fas fa-save me-2"></i> Update Practitioner
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
</script>

<style>
    .form-label { font-size: 0.9rem; color: #495057; }
    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(26, 77, 46, 0.1);
    }
    .bg-light { background-color: #f8faf9 !important; }
</style>
@endsection
