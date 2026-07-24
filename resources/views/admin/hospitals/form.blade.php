<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-bold">Hospital / Center Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $hospital->name ?? '') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Email Address</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $hospital->email ?? '') }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Password {{ isset($hospital) ? '(leave blank to keep current)' : '' }}</label>
        <div class="input-group">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" {{ isset($hospital) ? '' : 'required' }}>
            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)"><i class="fas fa-eye"></i></button>
        </div>
        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Phone Number</label>
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $hospital->phone ?? '') }}" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">District</label>
        <select name="district_id" class="form-select @error('district_id') is-invalid @enderror">
            <option value="">Select District</option>
            @foreach($districts as $district)
                <option value="{{ $district->id }}" {{ old('district_id', $hospital->district_id ?? '') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Logo</label>
        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
        @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label fw-bold">Address</label>
        <textarea name="address" rows="2" class="form-control">{{ old('address', $hospital->address ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold">Specialties</label>
        <textarea name="specialties" rows="5" class="form-control" placeholder="Panchakarma&#10;Skin care&#10;Pain management">{{ old('specialties', $hospital->specialties ?? '') }}</textarea>
        <div class="small text-muted mt-1">One item per line or comma separated.</div>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold">Treatments</label>
        <textarea name="treatments" rows="5" class="form-control" placeholder="Abhyanga&#10;Shirodhara">{{ old('treatments', $hospital->treatments ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold">Facilities</label>
        <textarea name="facilities" rows="5" class="form-control" placeholder="In-patient rooms&#10;Pharmacy">{{ old('facilities', $hospital->facilities ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label fw-bold">Description</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description', $hospital->description ?? '') }}</textarea>
    </div>
    @if(request()->routeIs('admin.*'))
    <div class="col-12">
        <div class="form-check form-switch">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $hospital->is_active ?? true) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Allow this hospital to login</label>
        </div>
    </div>
    @endif
</div>
