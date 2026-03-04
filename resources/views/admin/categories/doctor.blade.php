@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Manage Doctor Categories | Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2 class="fw-bold" style="color: var(--primary-green);">Manage Doctor Categories</h2>
        <p class="text-muted">Create specialization categories and subcategories to categorize your practitioners.</p>
    </div>

    <div class="col-md-6 border-end">
        <div class="card border-0 shadow-sm p-4 mb-4">
            <h4 class="fw-bold mb-4" style="color: var(--primary-green);">Add Doctor Category</h4>
            <form action="{{ route('admin.categories.doctor.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Category Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                </div>
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </form>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <h4 class="fw-bold mb-4" style="color: var(--primary-green);">Add Subcategory</h4>
            <form action="{{ route('admin.categories.doctor_subcategory.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Category</label>
                    <select name="doctor_category_id" class="form-select" required>
                        <option value="">Choose Category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Subcategory Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Subcategory Name" required>
                </div>
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i> Add Subcategory
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-6 ps-4">
        <h4 class="fw-bold mb-4" style="color: var(--primary-green);">Existing Categories & Subcategories</h4>
        @foreach($categories as $category)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold m-0">{{ $category->name }}</h5>
                    <form action="{{ route('admin.categories.doctor.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Deleting category will delete all its subcategories. Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm text-danger hov-bg" title="Delete Category"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @forelse($category->subcategories as $sub)
                        <div class="badge bg-light text-dark border d-flex align-items-center gap-2 p-2">
                            {{ $sub->name }}
                            <form action="{{ route('admin.categories.doctor_subcategory.destroy', $sub->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-close" style="font-size: 0.6rem;"></button>
                            </form>
                        </div>
                    @empty
                        <span class="text-muted small">No subcategories.</span>
                    @endforelse
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .hov-bg:hover { background-color: rgba(255, 0, 0, 0.05); }
</style>
@endsection
