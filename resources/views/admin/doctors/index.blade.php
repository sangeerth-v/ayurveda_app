@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Manage Doctors | Ayurveda Admin')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="mb-1">Doctor Management</h2>
        <p class="text-muted mb-0">View and manage all registered healthcare professionals.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i> Add New Doctor
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 25%">Doctor Information</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Specialization Category</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Subcategory</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Hospital</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Login Password</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Location</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Contact</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 18%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 48px; height: 48px; background-color: #e8f5e9; color: var(--primary-green); overflow: hidden;">
                                    @if($doctor->photo)
                                        <img src="{{ asset('storage/' . $doctor->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user-md fa-lg"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $doctor->name }}</div>
                                    <div class="small text-muted">{{ $doctor->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 border border-success border-opacity-10 font-weight-normal">
                                {{ $doctor->specialization_category ?? 'General' }}
                            </span>
                        </td>
                        <td class="py-4">
                            <span class="text-muted small">
                                {{ $doctor->specialization_subcategory ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="py-4">
                            <span class="text-muted small">{{ $doctor->hospital->name ?? 'Independent' }}</span>
                        </td>
                        <td class="py-4">
                            <span class="badge {{ $doctor->is_active ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3 py-2">
                                {{ $doctor->is_active ? 'Active' : 'Pending Approval' }}
                            </span>
                        </td>
                        <td class="py-4">
                            <code class="text-primary">{{ $doctor->password_plain ?? 'N/A' }}</code>
                        </td>
                        <td class="py-4">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-map-marker-alt me-2 text-danger opacity-50"></i>
                                {{ $doctor->district->name ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="text-dark small"><i class="fas fa-phone-alt me-2 text-muted"></i>{{ $doctor->phone ?? 'Not provided' }}</div>
                        </td>
                        <td class="py-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.doctors.show', $doctor->id) }}" class="btn btn-sm btn-outline-success" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Doctor">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.doctors.toggle_active', $doctor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm {{ $doctor->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $doctor->is_active ? 'Deactivate' : 'Approve' }} Doctor">
                                        <i class="fas {{ $doctor->is_active ? 'fa-user-slash' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this doctor? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Doctor">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-user-md fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">No doctors found in the system.</p>
                                <a href="{{ route('admin.doctors.create') }}" class="btn btn-link text-success">Add your first doctor</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($doctors->hasPages())
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="small text-muted">
                Showing {{ $doctors->firstItem() }} to {{ $doctors->lastItem() }} of {{ $doctors->total() }} entries
            </div>
            <div>
                {{ $doctors->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .table thead th {
        border-bottom: 2px solid #f8f9fa;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .table tbody tr {
        transition: all 0.2s ease;
    }
    .table-hover tbody tr:hover {
        background-color: #fcfdfa;
    }
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    .pagination {
        margin-bottom: 0;
        gap: 4px;
    }
    .pagination .page-item .page-link {
        border-radius: 8px !important;
        color: var(--primary-green);
        border: 1px solid #dee2e6;
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }
    .pagination .page-item.active .page-link {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: #ffffff;
    }
    .pagination .page-link svg {
        width: 1rem;
        height: 1rem;
    }
</style>
@endsection
