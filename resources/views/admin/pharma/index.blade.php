@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Manage Pharmas | Ayurveda Admin')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="mb-1">Pharma Management</h2>
        <p class="text-muted mb-0">Monitor and manage all pharmaceutical partners.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('admin.pharmas.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-building me-2"></i> Register Pharma
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 30%">Company Name</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Email Address</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Contact Number</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pharmas as $pharma)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm overflow-hidden" style="width: 48px; height: 48px; background-color: #fff8e1; color: var(--accent-gold);">
                                    @if($pharma->logo)
                                        <img src="{{ asset('storage/' . $pharma->logo) }}" style="width: 100%; height: 100%; object-fit: contain; background: white;">
                                    @else
                                        <i class="fas fa-capsules fa-lg"></i>
                                    @endif
                                </div>
                                <div class="fw-bold text-dark">{{ $pharma->company_name }}</div>
                            </div>
                        </td>
                        <td class="py-4 text-muted">
                            {{ $pharma->email }}
                        </td>
                        <td class="py-4">
                            <div class="text-dark small">
                                <i class="fas fa-phone-alt me-2 text-muted"></i>{{ $pharma->phone ?? 'Not provided' }}
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.pharmas.show', $pharma->id) }}" class="btn btn-sm btn-outline-warning text-dark" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.pharmas.edit', $pharma->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Pharma">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.pharmas.destroy', $pharma->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pharma company?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Pharma">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-building fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">No pharma companies registered yet.</p>
                                <a href="{{ route('admin.pharmas.create') }}" class="btn btn-link text-success">Register your first pharma partner</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pharmas->hasPages())
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Showing {{ $pharmas->firstItem() }} to {{ $pharmas->lastItem() }} of {{ $pharmas->total() }} entries
            </div>
            <div>
                {{ $pharmas->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .table thead th {
        border-bottom: 2px solid #f8f9fa;
        letter-spacing: 0.5px;
    }
    .table tbody tr {
        transition: all 0.2s ease;
    }
    .table-hover tbody tr:hover {
        background-color: #fafbfd;
        transform: scale(1.002);
    }
    .pagination {
        margin-bottom: 0;
    }
</style>
@endsection
