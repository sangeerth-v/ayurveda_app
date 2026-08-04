@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Manage Doctor Categories | Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2 class="fw-bold" style="color: var(--primary-green);">Manage Doctor Categories</h2>
        <p class="text-muted">Create specialization categories to categorize practitioners.</p>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm p-4 mb-4">
            <h4 class="fw-bold mb-4" style="color: var(--primary-green);">Add Doctor Category</h4>
            <form action="{{ route('admin.categories.doctor.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Category Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g: Traditional specialization , Modern specialization" required>
                </div>
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-7 ps-md-4">
        <h4 class="fw-bold mb-4" style="color: var(--primary-green);">Existing Doctor Categories</h4>
        @forelse($categories as $category)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h5 class="fw-bold m-0 text-dark">{{ $category->name }}</h5>
                    </div>
                    <form action="{{ route('admin.categories.doctor.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Category"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm p-4 text-center text-muted">
            <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i>
            <p class="mb-0">No categories created yet.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
    .hov-bg:hover { background-color: rgba(255, 0, 0, 0.05); }
</style>
@endsection
