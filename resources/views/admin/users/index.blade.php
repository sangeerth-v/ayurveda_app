@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'User Management | Ayurveda Admin')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="mb-1">User Management</h2>
        <p class="text-muted mb-0">Monitor and manage registered platform users.</p>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">User Details</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Email Address</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Phone Number</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Joined On</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm bg-primary bg-opacity-10 text-primary" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td class="py-4 text-muted">
                            {{ $user->email }}
                        </td>
                        <td class="py-4">
                            {{ $user->phone ?? 'N/A' }}
                        </td>
                        <td class="py-4 text-muted small">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="py-4 text-center">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">No registered users found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white border-top py-3">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
