@extends('layouts.app')

@section('navbar')
    @include('partials.nav-doctor')
@endsection

@section('title', 'Add New Formulated Product | Doctor Portal')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white py-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1 text-white" style="font-family: 'Playfair Display', serif;"><i class="fas fa-prescription-bottle-alt me-2"></i> Add Formulated Product</h3>
                        <p class="mb-0 text-white-50 small">Add Ayurvedic formulations or health products to be displayed for patients.</p>
                    </div>
                    <a href="{{ route('doctor.products.index') }}" class="btn btn-sm btn-light text-dark fw-bold rounded-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Products
                    </a>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form method="POST" action="{{ route('doctor.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <!-- Product Name -->
                            <div class="col-12">
                                <label for="name" class="form-label fw-bold text-dark">Product Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control form-control-lg border-success-subtle @error('name') is-invalid @enderror" name="name" placeholder="e.g. Organic Chyawanprash / Herbal Immunity Tonic" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                            </div>

                            <!-- Category -->
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold text-dark">Category <span class="text-danger">*</span></label>
                                <select id="category" name="category" class="form-select form-select-lg border-success-subtle @error('category') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                            </div>

                            <!-- Subcategory -->
                            <div class="col-md-6">
                                <label for="subcategory" class="form-label fw-bold text-dark">Subcategory <span class="text-danger">*</span></label>
                                <input id="subcategory" type="text" name="subcategory" class="form-control form-control-lg border-success-subtle @error('subcategory') is-invalid @enderror" placeholder="e.g. Immunity, Tonics, Oils, Capsules" value="{{ old('subcategory') }}" required>
                                @error('subcategory') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                            </div>

                            <!-- Price -->
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-bold text-dark">Price (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">₹</span>
                                    <input id="price" type="number" step="0.01" min="0" class="form-control form-control-lg border-success-subtle @error('price') is-invalid @enderror" name="price" placeholder="0.00" value="{{ old('price') }}" required>
                                </div>
                                @error('price') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                            </div>

                            <!-- Stock -->
                            <div class="col-md-6">
                                <label for="stock" class="form-label fw-bold text-dark">Stock Quantity <span class="text-danger">*</span></label>
                                <input id="stock" type="number" min="0" step="1" class="form-control form-control-lg border-success-subtle @error('stock') is-invalid @enderror" name="stock" placeholder="10" value="{{ old('stock', 10) }}" required>
                                @error('stock') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-md-6">
                                <label for="expiry_date" class="form-label fw-bold text-dark">Expiry Date</label>
                                <input id="expiry_date" type="date" class="form-control form-control-lg border-success-subtle" name="expiry_date" value="{{ old('expiry_date') }}">
                            </div>

                            <!-- Product Image -->
                            <div class="col-md-6">
                                <label for="image" class="form-label fw-bold text-dark">Product Image (JPEG / PNG)</label>
                                <input id="image" type="file" class="form-control form-control-lg border-success-subtle" name="image" accept="image/*">
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-bold text-dark">Description & Health Benefits</label>
                                <textarea id="description" class="form-control form-control-lg border-success-subtle" name="description" rows="4" placeholder="Describe ingredients, health benefits, dosage recommendations, and Ayurvedic properties...">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm py-3">
                                <i class="fas fa-check-circle me-2"></i> Save & Publish Product
                            </button>
                            <a href="{{ route('doctor.products.index') }}" class="btn btn-outline-secondary btn-lg fw-bold border-0">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
