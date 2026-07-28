@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Edit Pharma Company | Ayurveda Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="mb-1">Edit Pharma Partner</h2>
                <p class="text-muted mb-0">Update information for {{ $pharma->company_name }}</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.pharmas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <form action="{{ route('admin.pharmas.update', $pharma->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-0">
                        <!-- Sidebar Info -->
                        <div class="col-lg-4 bg-light border-end p-4 p-xl-5 text-center">
                            <div class="mb-4">
                                <div class="position-relative d-inline-block">
                                    <div id="logo-preview" class="rounded-3 d-flex align-items-center justify-content-center border border-4 border-white shadow-sm" style="width: 160px; height: 160px; background-color: #fff8e1; color: var(--accent-gold); overflow: hidden;">
                                        @if($pharma->logo)
                                            <img src="{{ asset('storage/' . $pharma->logo) }}" style="width: 100%; height: 100%; object-fit: contain; background: white;">
                                        @else
                                            <i class="fas fa-building fa-5x"></i>
                                        @endif
                                    </div>
                                    <label for="logo-input" class="btn btn-sm btn-warning rounded-circle position-absolute bottom-0 end-0 p-2 shadow" style="width: 38px; height: 38px;">
                                        <i class="fas fa-edit"></i>
                                    </label>
                                    <input type="file" name="logo" id="logo-input" class="d-none" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                                </div>
                                <h5 class="mt-3 fw-bold">Company Logo</h5>
                                <p class="small text-muted">Upload high-res brand logo to replace current one.</p>
                            </div>
                            
                            <hr class="my-4 opacity-10">
                            
                            <div class="text-start">
                                <label class="form-label fw-bold small text-uppercase text-muted">Business ID: #{{ $pharma->id }}</label>
                                <p class="small text-muted mb-0">Partner since {{ $pharma->created_at->format('M Y') }}</p>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="col-lg-8 p-4 p-xl-5">
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Company Legal Name</label>
                                    <input type="text" name="company_name" class="form-control form-control-lg @error('company_name') is-invalid @enderror" placeholder="ABC Pharmaceuticals Pvt Ltd" value="{{ old('company_name', $pharma->company_name) }}" required>
                                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Admin Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="admin@abcpharma.com" value="{{ old('email', $pharma->email) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Access Password (Leave blank to keep current)</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Support Phone</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="10 Digit Number" value="{{ old('phone', $pharma->phone) }}" maxlength="10" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Contact Person</label>
                                    <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" placeholder="Primary Contact Manager" value="{{ old('contact_person', $pharma->contact_person) }}">
                                    @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Drug License No</label>
                                    <input type="text" name="drug_license_no" class="form-control @error('drug_license_no') is-invalid @enderror" placeholder="e.g. DL-20B/12345/2025" value="{{ old('drug_license_no', $pharma->drug_license_no) }}">
                                    @error('drug_license_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">GSTIN Number</label>
                                    <input type="text" name="gst_number" class="form-control @error('gst_number') is-invalid @enderror" placeholder="e.g. 29AAAAA0000A1Z5" value="{{ old('gst_number', $pharma->gst_number) }}" maxlength="15">
                                    @error('gst_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">District</label>
                                    <select name="district_id" class="form-select @error('district_id') is-invalid @enderror">
                                        <option value="">Select District</option>
                                        @foreach($districts ?? [] as $dist)
                                            <option value="{{ $dist->id }}" {{ old('district_id', $pharma->district_id) == $dist->id ? 'selected' : '' }}>{{ $dist->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Drug License Document (PDF/Image)</label>
                                    <input type="file" name="license_document" class="form-control @error('license_document') is-invalid @enderror" accept=".pdf,image/*">
                                    @if($pharma->license_document)
                                        <div class="form-text small"><a href="{{ asset('storage/' . $pharma->license_document) }}" target="_blank" class="text-success"><i class="fas fa-file-alt me-1"></i> View Current Document</a></div>
                                    @endif
                                    @error('license_document') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Registered Office Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="Street, Building, City, Pin...">{{ old('address', $pharma->address) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 w-100 shadow-sm" style="background-color: var(--accent-gold); border-color: var(--accent-gold); color: white;">
                                    <i class="fas fa-save"></i> Save Changes
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
            preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: contain; background: white;">`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<style>
    .form-label { font-size: 0.9rem; color: #495057; }
    .form-control:focus {
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 0.25rem rgba(197, 160, 89, 0.1);
    }
</style>
@endsection
