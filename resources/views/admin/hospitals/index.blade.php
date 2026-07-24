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
                            <div class="fw-bold">{{ $hospital->name }}</div>
                            <div class="small text-muted">{{ $hospital->email }} | {{ $hospital->phone }}</div>
                        </td>
                        <td class="py-4">{{ $hospital->doctors_count }}</td>
                        <td class="py-4"><code>{{ $hospital->password_plain ?? 'N/A' }}</code></td>
                        <td class="py-4">{{ $hospital->district->name ?? 'N/A' }}</td>
                        <td class="py-4">
                            <span class="badge {{ $hospital->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $hospital->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="py-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.hospitals.show', $hospital->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.hospitals.edit', $hospital->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
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
