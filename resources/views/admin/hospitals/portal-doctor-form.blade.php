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
        <label class="form-label fw-bold">Photo</label>
        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Consultation Fee</label>
        <input type="number" min="0" step="1" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Experience (Years)</label>
        <input type="number" name="experience" class="form-control" value="{{ old('experience', $doctor->experience ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label fw-bold">Qualifications</label>
        <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $doctor->qualification ?? '') }}">
    </div>
    @php
        $parts = explode(' to ', $doctor->available_time ?? '');
        $from = old('available_from', $parts[0] ?? '09:00');
        $to = old('available_to', $parts[1] ?? '17:00');
        $timeOptions = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'];
    @endphp
    <div class="col-md-6">
        <label class="form-label fw-bold">Available From</label>
        <select name="available_from" class="form-select">
            @foreach($timeOptions as $time)
                <option value="{{ $time }}" {{ $from == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Available To</label>
        <select name="available_to" class="form-select">
            @foreach($timeOptions as $time)
                <option value="{{ $time }}" {{ $to == $time ? 'selected' : '' }}>{{ date('h:i A', strtotime($time)) }}</option>
            @endforeach
        </select>
    </div>
</div>

@section('scripts')
<script>
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
