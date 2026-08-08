<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-bold">Full Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $doctor->name ?? '') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Email Address</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $doctor->email ?? '') }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Password {{ isset($doctor) ? '(leave blank to keep current)' : '' }}</label>
        <div class="input-group">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" {{ isset($doctor) ? '' : 'required' }}>
            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)"><i class="fas fa-eye"></i></button>
        </div>
        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Phone Number</label>
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $doctor->phone ?? '') }}" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Specialization Category</label>
        <select name="specialization_category" id="specialization_category" class="form-select @error('specialization_category') is-invalid @enderror" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (old('specialization_category', $doctor->specialization_category ?? '') == $category->id || old('specialization_category', $doctor->specialization_category ?? '') == $category->name) ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('specialization_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Specialization Subcategory</label>
        <select name="specialization_subcategory" id="specialization_subcategory" class="form-select @error('specialization_subcategory') is-invalid @enderror">
            <option value="{{ old('specialization_subcategory', $doctor->specialization_subcategory ?? '') }}">{{ old('specialization_subcategory', $doctor->specialization_subcategory ?? 'Select Subcategory') }}</option>
        </select>
        @error('specialization_subcategory') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Working District</label>
        <select name="district_id" class="form-select @error('district_id') is-invalid @enderror" required>
            <option value="">Select District</option>
            @foreach($districts as $district)
                <option value="{{ $district->id }}" {{ old('district_id', $doctor->district_id ?? '') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Medical Registration Number</label>
        <input type="text" name="medical_registration_no" class="form-control @error('medical_registration_no') is-invalid @enderror" value="{{ old('medical_registration_no', $doctor->medical_registration_no ?? '') }}" placeholder="e.g. KMC/12345/2020">
        @error('medical_registration_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Photo</label>
        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Consultation Fee (₹)</label>
        <input type="number" min="0" step="1" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Experience (Years)</label>
        <input type="number" name="experience" class="form-control" value="{{ old('experience', $doctor->experience ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label fw-bold">Qualifications</label>
        <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $doctor->qualification ?? '') }}" placeholder="e.g. BAMS, MD (Ayurveda)">
    </div>
    <div class="col-12">
        <label class="form-label fw-bold">Clinic / Practice Address</label>
        <textarea name="address" class="form-control" rows="2" placeholder="Full practice address">{{ old('address', $doctor->address ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Registration Certificate (PDF / Image)</label>
        <input type="file" name="registration_certificate" class="form-control" accept=".pdf,image/*">
        @if(isset($doctor) && $doctor->registration_certificate)
            <div class="mt-1"><a href="{{ asset('storage/' . $doctor->registration_certificate) }}" target="_blank" class="small text-success"><i class="fas fa-file-pdf"></i> View Certificate</a></div>
        @endif
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Medical Council Certificate (PDF / Image)</label>
        <input type="file" name="council_certificate" class="form-control" accept=".pdf,image/*">
        @if(isset($doctor) && $doctor->council_certificate)
            <div class="mt-1"><a href="{{ asset('storage/' . $doctor->council_certificate) }}" target="_blank" class="small text-success"><i class="fas fa-file-pdf"></i> View Certificate</a></div>
        @endif
    </div>
    @php
        $parts = preg_split('/\s*to\s*|\s*[-–—]\s*/i', $doctor->available_time ?? '');
        $fromRaw = trim($parts[0] ?? '');
        $toRaw = trim($parts[1] ?? '');
        $from = $fromRaw ? date('H:i', strtotime($fromRaw)) : '09:00';
        $to = $toRaw ? date('H:i', strtotime($toRaw)) : '17:00';
    @endphp
    <div class="col-md-6">
        <label class="form-label fw-bold">Available From</label>
        <input type="time" name="available_from" class="form-control" value="{{ old('available_from', $from) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Available To</label>
        <input type="time" name="available_to" class="form-control" value="{{ old('available_to', $to) }}">
    </div>

    {{-- Consultation Type --}}
    <div class="col-12">
        <label class="form-label fw-bold">Consultation Type</label>
        <div class="d-flex gap-3 flex-wrap">
            @foreach(['Offline' => '🏥 Offline (In-Person)', 'Online' => '🎥 Online', 'Both' => '🌐 Both'] as $val => $label)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="consultation_type" id="ct_hosp_{{ $val }}" value="{{ $val }}"
                        {{ old('consultation_type', $doctor->consultation_type ?? 'Offline') === $val ? 'checked' : '' }}
                        onchange="togglePortalOnlineFields()">
                    <label class="form-check-label fw-semibold" for="ct_hosp_{{ $val }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>
        @error('consultation_type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>

    {{-- Online Availability Fields --}}
    @php 
        $onlineTimes = preg_split('/\s*to\s*|\s*[-–—]\s*/i', $doctor->online_available_time ?? ''); 
        $onlineFromRaw = trim($onlineTimes[0] ?? '');
        $onlineToRaw = trim($onlineTimes[1] ?? '');
        $onlineFrom = $onlineFromRaw ? date('H:i', strtotime($onlineFromRaw)) : '16:00'; 
        $onlineTo = $onlineToRaw ? date('H:i', strtotime($onlineToRaw)) : '20:00'; 
    @endphp
    <div id="portalOnlineFields" class="col-12" style="display:none;">
        <div class="row g-3 p-3 rounded-3" style="background:#e8f4fd; border:1px solid #b8d9f7;">
            <div class="col-12">
                <label class="form-label fw-bold text-primary">🎥 Online Availability Hours</label>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Online Available From</label>
                <input type="time" name="online_available_from" class="form-control" value="{{ old('online_available_from', $onlineFrom) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Online Available To</label>
                <input type="time" name="online_available_to" class="form-control" value="{{ old('online_available_to', $onlineTo) }}">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Google Meet Link</label>
                <input type="url" name="google_meet_link" class="form-control @error('google_meet_link') is-invalid @enderror"
                    placeholder="https://meet.google.com/xxx-xxxx-xxx" value="{{ old('google_meet_link', $doctor->google_meet_link ?? '') }}">
                <div class="form-text">Doctor's Google Meet link for video consultations.</div>
                @error('google_meet_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function togglePortalOnlineFields() {
    const selected = document.querySelector('input[name="consultation_type"]:checked');
    const onlineFields = document.getElementById('portalOnlineFields');
    if (selected && (selected.value === 'Online' || selected.value === 'Both')) {
        onlineFields.style.display = 'block';
    } else {
        onlineFields.style.display = 'none';
    }
}
togglePortalOnlineFields();

document.getElementById('specialization_category').addEventListener('change', function() {
    const categoryId = this.value;
    const subSelect = document.getElementById('specialization_subcategory');
    subSelect.innerHTML = '<option value="">Select Subcategory</option>';

    if (categoryId) {
        fetch(`/api/doctor-subcategories/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(sub => {
                    subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            });
    }
});
</script>
@endsection
