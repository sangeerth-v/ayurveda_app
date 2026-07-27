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
                                    <label class="form-label fw-bold">Hospital / Center</label>
                                    <select name="hospital_id" class="form-select @error('hospital_id') is-invalid @enderror">
                                        <option value="">Independent Doctor</option>
                                        @foreach($hospitals as $hospital)
                                            <option value="{{ $hospital->id }}" {{ old('hospital_id', $doctor->hospital_id) == $hospital->id ? 'selected' : '' }}>{{ $hospital->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('hospital_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Password (Leave blank to keep current)</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Specialization Category</label>
                                    <select name="specialization_category" id="specialization_category" class="form-select @error('specialization_category') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (old('specialization_category', $doctor->specialization_category) == $category->id || old('specialization_category', $doctor->specialization_category) == $category->name) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialization_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Specialization Subcategory</label>
                                    <select name="specialization_subcategory" id="specialization_subcategory" class="form-select @error('specialization_subcategory') is-invalid @enderror">
                                        <option value="">Select Subcategory</option>
                                    </select>
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
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="" value="{{ old('phone', $doctor->phone) }}" pattern="[0-9]{10}" maxlength="10" minlength="10" title="Please enter exactly 10 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Medical Registration Number</label>
                                    <input type="text" name="medical_registration_no" class="form-control @error('medical_registration_no') is-invalid @enderror" placeholder="e.g. KMC/12345/2020" value="{{ old('medical_registration_no', $doctor->medical_registration_no) }}">
                                    @error('medical_registration_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Consultation Fee (₹)</label>
                                    <input type="number" min="0" step="1" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" placeholder="" value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Qualifications</label>
                                    <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" placeholder="e.g. BAMS, MD (Ayurveda)" value="{{ old('qualification', $doctor->qualification) }}">
                                    @error('qualification') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Years of Experience</label>
                                    <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" placeholder="" value="{{ old('experience', $doctor->experience) }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Clinic / Practice Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="Full address of clinic or hospital">{{ old('address', $doctor->address) }}</textarea>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Certificates Section --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Registration Certificate (PDF / Image)</label>
                                    <input type="file" name="registration_certificate" class="form-control @error('registration_certificate') is-invalid @enderror" accept=".pdf,image/*">
                                    @if($doctor->registration_certificate)
                                        <div class="mt-1">
                                            <a href="{{ asset('storage/' . $doctor->registration_certificate) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-file-pdf me-1"></i> View Current Registration Certificate
                                            </a>
                                        </div>
                                    @endif
                                    @error('registration_certificate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Medical Council Certificate (PDF / Image)</label>
                                    <input type="file" name="council_certificate" class="form-control @error('council_certificate') is-invalid @enderror" accept=".pdf,image/*">
                                    @if($doctor->council_certificate)
                                        <div class="mt-1">
                                            <a href="{{ asset('storage/' . $doctor->council_certificate) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-file-pdf me-1"></i> View Current Council Certificate
                                            </a>
                                        </div>
                                    @endif
                                    @error('council_certificate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                @php 
                                    $times = explode(' to ', $doctor->available_time ?? ''); 
                                    $from = $times[0] ?? '09:00'; 
                                    $to = $times[1] ?? '17:00'; 
                                @endphp
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Available From</label>
                                    <select name="available_from" class="form-select @error('available_from') is-invalid @enderror">
                                        @foreach(['07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00'] as $time)
                                            <option value="{{ $time }}" {{ $from == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Available To</label>
                                    <select name="available_to" class="form-select @error('available_to') is-invalid @enderror">
                                        @foreach(['07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00'] as $time)
                                            <option value="{{ $time }}" {{ $to == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Consultation Type --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Consultation Type</label>
                                    <div class="d-flex gap-3 flex-wrap">
                                        @foreach(['Offline' => '🏥 Offline (In-Person)', 'Online' => '🎥 Online', 'Both' => '🌐 Both'] as $val => $label)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="consultation_type" id="ct_{{ $val }}" value="{{ $val }}"
                                                    {{ old('consultation_type', $doctor->consultation_type ?? 'Offline') === $val ? 'checked' : '' }}
                                                    onchange="toggleOnlineFields()">
                                                <label class="form-check-label fw-semibold" for="ct_{{ $val }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('consultation_type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                {{-- Online Availability Fields (shown when Online or Both) --}}
                                @php 
                                    $onlineTimes = explode(' to ', $doctor->online_available_time ?? ''); 
                                    $onlineFrom = $onlineTimes[0] ?? '09:00'; 
                                    $onlineTo = $onlineTimes[1] ?? '17:00'; 
                                @endphp
                                <div id="onlineFields" class="col-12" style="display:none;">
                                    <div class="row g-3 p-3 rounded-3" style="background:#e8f4fd; border:1px solid #b8d9f7;">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-primary">🎥 Online Availability Hours</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Online Available From</label>
                                            <select name="online_available_from" class="form-select">
                                                @foreach(['07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00'] as $time)
                                                    <option value="{{ $time }}" {{ $onlineFrom == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Online Available To</label>
                                            <select name="online_available_to" class="form-select">
                                                @foreach(['07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00'] as $time)
                                                    <option value="{{ $time }}" {{ $onlineTo == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Google Meet Link</label>
                                            <input type="url" name="google_meet_link" class="form-control @error('google_meet_link') is-invalid @enderror"
                                                placeholder="https://meet.google.com/xxx-xxxx-xxx" value="{{ old('google_meet_link', $doctor->google_meet_link) }}">
                                            <div class="form-text">The doctor's personal Google Meet room link that patients will use for online consultations.</div>
                                            @error('google_meet_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
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

@section('scripts')
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

function toggleOnlineFields() {
    const selected = document.querySelector('input[name="consultation_type"]:checked');
    const onlineFields = document.getElementById('onlineFields');
    if (selected && (selected.value === 'Online' || selected.value === 'Both')) {
        onlineFields.style.display = 'block';
    } else {
        onlineFields.style.display = 'none';
    }
}
// Initialize on load
toggleOnlineFields();

const specializationCategory = document.getElementById('specialization_category');
const specializationSubcategory = document.getElementById('specialization_subcategory');

function loadSubcategories(categoryId, selectedSub = null) {
    specializationSubcategory.innerHTML = '<option value="">Select Subcategory</option>';
    if (categoryId) {
        fetch(`/api/doctor-subcategories/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(sub => {
                    const isSelected = selectedSub == sub.id || selectedSub == sub.name ? 'selected' : '';
                    specializationSubcategory.innerHTML += `<option value="${sub.id}" ${isSelected}>${sub.name}</option>`;
                });
            });
    }
}

specializationCategory.addEventListener('change', function() {
    loadSubcategories(this.value);
});

// Initial load
if (specializationCategory.value) {
    loadSubcategories(specializationCategory.value, "{{ $doctor->specialization_subcategory }}");
}
</script>
@endsection

<style>
    .form-label { font-size: 0.9rem; color: #495057; }
    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(26, 77, 46, 0.1);
    }
    .bg-light { background-color: #f8faf9 !important; }
</style>
@endsection
