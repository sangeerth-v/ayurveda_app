@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Manage Advertisements | Ayurveda Admin')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="mb-1">Advertisement Management</h2>
        <p class="text-muted mb-0">Manage rolling advertisements for the home page.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i> Add New Advertisement
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 25%">Image</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Title / Link</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Status</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Popup</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Order Index</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 25%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advertisements as $ad)
                    <tr>
                        <td class="ps-4 py-4">
                            <div style="width: 150px; height: 80px; overflow: hidden; border-radius: 8px;">
                                <img src="{{ asset('storage/' . $ad->image_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="fw-bold text-dark">{{ $ad->title ?? 'No Title' }}</div>
                            <div class="small text-muted">
                                @if($ad->link)
                                <a href="{{ $ad->link }}" target="_blank" class="text-primary">{{ $ad->link }}</a>
                                @else
                                No Link
                                @endif
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            @if($ad->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-10">Active</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2 border border-secondary border-opacity-10">Inactive</span>
                            @endif
                        </td>
                        <td class="py-4 text-center">
                            @if($ad->is_popup)
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 border border-primary border-opacity-10">Active Popup</span>
                            @else
                                <span class="text-muted small">No</span>
                            @endif
                        </td>
                        <td class="py-4 text-center">
                            <span class="fw-bold">{{ $ad->order_index }}</span>
                        </td>
                        <td class="py-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @if($ad->is_popup)
                                    <form action="{{ route('admin.advertisements.set_popup', 0) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-secondary" title="Remove Popup Status">
                                            Remove Popup
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.advertisements.set_popup', $ad->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-info" title="Set as Popup">
                                            Make Popup
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.advertisements.edit', $ad->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Advertisement">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.advertisements.destroy', $ad->id) }}" method="POST" onsubmit="return confirm('Delete this advertisement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Advertisement">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-images fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">No advertisements found.</p>
                                <a href="{{ route('admin.advertisements.create') }}" class="btn btn-link text-success">Create the first advertisement</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
