@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Hospital Details | Ayurveda Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ $hospital->name }}</h2>
        <p class="text-muted mb-0">{{ $hospital->district->name ?? 'No district' }} | {{ $hospital->phone }}</p>
    </div>
    <a href="{{ route('admin.hospitals.edit', $hospital->id) }}" class="btn btn-primary"><i class="fas fa-edit me-2"></i> Edit</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold">Login</h5>
                <p class="mb-1"><strong>Email:</strong> {{ $hospital->email }}</p>
                <p class="mb-1"><strong>Password:</strong> <code>{{ $hospital->password_plain ?? 'N/A' }}</code></p>
                <p class="mb-0"><strong>Status:</strong> {{ $hospital->is_active ? 'Active' : 'Inactive' }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold">Services</h5>
                <p><strong>Specialties:</strong> {{ $hospital->specialties ?: 'Not added' }}</p>
                <p><strong>Treatments:</strong> {{ $hospital->treatments ?: 'Not added' }}</p>
                <p class="mb-0"><strong>Facilities:</strong> {{ $hospital->facilities ?: 'Not added' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white">Doctors Under This Hospital</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Doctor</th>
                        <th>Specialization</th>
                        <th>Phone</th>
                        <th>District</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hospital->doctors as $doctor)
                    <tr>
                        <td class="ps-4">{{ $doctor->name }}<div class="small text-muted">{{ $doctor->email }}</div></td>
                        <td>{{ $doctor->specialization_category }}</td>
                        <td>{{ $doctor->phone }}</td>
                        <td>{{ $doctor->district->name ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No doctors added yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
