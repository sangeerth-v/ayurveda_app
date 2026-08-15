@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Edit Product | Admin Oversight')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="fas fa-edit text-success me-2"></i>Edit Product #{{ $product->id }}</h2>
            <p class="text-muted small mb-0">Modify product details, pricing, stock count, or imagery.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Back to Products List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-muted small text-uppercase">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg rounded-3" value="{{ old('name', $product->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Category <span class="text-danger">*</span></label>
                                <select name="category" id="category_select" class="form-select rounded-3" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category', $product->category) == $cat->name || old('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Subcategory <span class="text-danger">*</span></label>
                                <input type="text" name="subcategory" class="form-control rounded-3" value="{{ old('subcategory', $product->subcategory) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Price (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="price" step="0.01" min="0" class="form-control form-control-lg rounded-3" value="{{ old('price', $product->price) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Stock Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="stock" min="0" class="form-control form-control-lg rounded-3" value="{{ old('stock', $product->stock) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control rounded-3" value="{{ old('expiry_date', $product->expiry_date) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Product Image</label>
                                <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                                @if($product->image)
                                    <div class="mt-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="rounded border" style="width: 42px; height: 42px; object-fit: cover;">
                                        <small class="text-muted">Current image file attached</small>
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small text-uppercase">Product Description</label>
                                <textarea name="description" class="form-control rounded-3" rows="4" placeholder="Enter full product ingredients, dosage, benefits, and details...">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i> Update Product Details
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
