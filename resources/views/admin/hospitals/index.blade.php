@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Manage Hospitals | Ayurveda Admin')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="mb-1">Hospital Management</h2>
        <p class="text-muted mb-0">Register hospitals or wellness centers and issue login credentials.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('admin.hospitals.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i> Add Hospital
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Hospital</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Doctors</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Login Password</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Location</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hospitals as $hospital)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm overflow-hidden border" style="width: 44px; height: 44px; background-color: #e8f5e9; color: var(--primary-green);">
                                    @if($hospital->logo)
                                        <img src="{{ asset('storage/' . $hospital->logo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-hospital fa-lg"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $hospital->name }}</div>
                                    <div class="small text-muted">{{ $hospital->email }} | {{ $hospital->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">{{ $hospital->doctors_count }}</td>
                        <td class="py-4"><code>{{ $hospital->password_plain ?? 'N/A' }}</code></td>
                        <td class="py-4">{{ $hospital->district->name ?? 'N/A' }}</td>
                        <td class="py-4">
                            <span class="badge {{ $hospital->is_active ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3 py-2">
                                {{ $hospital->is_active ? 'Active' : 'Pending Approval' }}
                            </span>
                        </td>
                        <td class="py-4 text-center">
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('admin.hospitals.show', $hospital->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.hospitals.edit', $hospital->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.hospitals.toggle_active', $hospital->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm {{ $hospital->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $hospital->is_active ? 'Deactivate' : 'Approve' }} Hospital">
                                        <i class="fas {{ $hospital->is_active ? 'fa-user-slash' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.hospitals.destroy', $hospital->id) }}" method="POST" onsubmit="return confirm('Delete this hospital? Doctors will become independent.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-hospital fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">No hospitals registered yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($hospitals->hasPages())
    <div class="card-footer bg-white">{{ $hospitals->links() }}</div>
    @endif
</div>
@endsection
