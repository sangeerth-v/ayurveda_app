@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Hospital Details | Ayurveda Admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.hospitals.index') }}" class="text-success text-decoration-none">Hospital Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $hospital->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <!-- Hospital Profile Card -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="card-body text-center p-5" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
                <div class="rounded-3 d-inline-flex align-items-center justify-content-center mb-3 bg-white shadow-lg overflow-hidden border" style="width: 120px; height: 120px;">
                    @if($hospital->logo)
                        <img src="{{ asset('storage/' . $hospital->logo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-hospital fa-4x" style="color: var(--primary-green);"></i>
                    @endif
                </div>
                <h3 class="text-white mb-1">{{ $hospital->name }}</h3>
                <span class="badge {{ $hospital->is_active ? 'bg-white text-dark' : 'bg-warning text-dark' }} rounded-pill px-3 py-2 mt-2">
                    {{ $hospital->is_active ? 'Active Hospital' : 'Pending Approval' }}
                </span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">License Number</span>
                        <span class="fw-bold text-primary">{{ $hospital->license_number ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">GSTIN</span>
                        <span class="fw-bold text-dark">{{ $hospital->gst_number ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">District</span>
                        <span class="fw-bold">{{ $hospital->district->name ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">Portal Password</span>
                        <code class="text-primary fw-bold">{{ $hospital->password_plain ?? 'N/A' }}</code>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-success"></i> Hospital Information</h5>
                <a href="{{ route('admin.hospitals.edit', $hospital->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit Details</a>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Contact Email</label>
                        <div class="text-dark fs-5">{{ $hospital->email }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Phone Number</label>
                        <div class="text-dark fs-5">{{ $hospital->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Contact Person</label>
                        <div class="text-dark fs-5">{{ $hospital->contact_person ?? 'Not provided' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small text-muted text-uppercase fw-bold mb-1 d-block">District / Location</label>
                        <div class="text-dark fs-5">{{ $hospital->district->name ?? 'Not specified' }}</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Address</label>
                    <div class="text-dark">{{ $hospital->address ?? 'Not specified' }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-2">
                        <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Specialties</label>
                        <div class="text-dark">{{ $hospital->specialties ?: 'Not specified' }}</div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Treatments</label>
                        <div class="text-dark">{{ $hospital->treatments ?: 'Not specified' }}</div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Facilities</label>
                        <div class="text-dark">{{ $hospital->facilities ?: 'Not specified' }}</div>
                    </div>
                </div>

                <!-- Verification Document -->
                <h6 class="text-muted small text-uppercase fw-bold mb-3 pt-3 border-top">Uploaded Hospital License Document</h6>
                <div class="mb-4">
                    @if($hospital->license_document)
                        <a href="{{ asset('storage/' . $hospital->license_document) }}" target="_blank" class="btn btn-outline-success me-2">
                            <i class="fas fa-file-pdf me-2 text-danger"></i> View Hospital License Document
                        </a>
                    @else
                        <span class="badge bg-secondary p-2">No Hospital License Document Uploaded</span>
                    @endif
                </div>

                <hr class="my-4 opacity-10">

                <div class="d-flex gap-3 flex-wrap">
                    <form action="{{ route('admin.hospitals.toggle_active', $hospital->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn {{ $hospital->is_active ? 'btn-warning' : 'btn-success' }}">
                            <i class="fas {{ $hospital->is_active ? 'fa-user-slash' : 'fa-check-circle' }} me-2"></i>
                            {{ $hospital->is_active ? 'Deactivate Hospital' : 'Approve & Activate Hospital' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.hospitals.destroy', $hospital->id) }}" method="POST" onsubmit="return confirm('Delete this hospital? Doctors will become independent.');" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash-alt me-2"></i> Delete Hospital
                        </button>
                    </form>
                    <a href="{{ route('admin.hospitals.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Return to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3 fw-bold"><i class="fas fa-user-md me-2 text-success"></i> Doctors Under This Hospital</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Doctor Name</th>
                        <th>Specialization</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hospital->doctors as $doctor)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 overflow-hidden border" style="width: 36px; height: 36px; background-color: #e8f5e9;">
                                    @if($doctor->photo)
                                        <img src="{{ asset('storage/' . $doctor->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user-md text-success"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $doctor->name }}</div>
                                    <div class="small text-muted">{{ $doctor->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $doctor->specialization_category ?? 'General' }}</td>
                        <td>{{ $doctor->phone ?? 'N/A' }}</td>
                        <td>{{ $doctor->district->name ?? 'N/A' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.doctors.show', $doctor->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-eye me-1"></i> View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No doctors added under this hospital yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
