@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white text-center py-4">
                    <h3 class="fw-bold mb-0 text-white" style="font-family: 'Playfair Display', serif;">Edit Product</h3>
                </div>

                <div class="card-body p-5 bg-light-subtle">
                    <form method="POST" action="{{ route('pharma.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold text-dark">{{ __('Product Name') }}</label>
                                <input id="name" type="text" class="form-control form-control-lg border-success-subtle" name="name" value="{{ old('name', $product->name) }}" required>
                            </div>

                            <!-- Category & Subcategory -->
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold text-dark">{{ __('Category') }}</label>
                                <select id="category" name="category" class="form-select form-select-lg border-success-subtle" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ (old('category', $product->category) == $cat->id || old('category', $product->category) == $cat->name) ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="subcategory" class="form-label fw-bold text-dark">{{ __('Subcategory') }} <span class="text-danger">*</span></label>
                                <input id="subcategory" type="text" class="form-control form-control-lg border-success-subtle @error('subcategory') is-invalid @enderror" name="subcategory" value="{{ old('subcategory', $product->subcategory) }}" placeholder="Subcategory Name" required>
                                @error('subcategory') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="price" class="form-label fw-bold text-dark">{{ __('Price (₹)') }}</label>
                                <input id="price" type="number" step="0.01" min="0" class="form-control form-control-lg border-success-subtle" name="price" value="{{ old('price', $product->price) }}" required>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold text-dark">{{ __('Description') }}</label>
                                <textarea id="description" class="form-control form-control-lg border-success-subtle" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <!-- Stock, Expiry, Image -->
                            <div class="col-md-4">
                                <label for="stock" class="form-label fw-bold text-dark">{{ __('Stock Quantity') }}</label>
                                <input id="stock" type="number" min="0" step="1" class="form-control form-control-lg border-success-subtle" name="stock" value="{{ old('stock', $product->stock) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="expiry_date" class="form-label fw-bold text-dark">{{ __('Expiry Date') }}</label>
                                <input id="expiry_date" type="date" class="form-control form-control-lg border-success-subtle" name="expiry_date" value="{{ old('expiry_date', $product->expiry_date) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="image" class="form-label fw-bold text-dark">{{ __('Product Image') }}</label>
                                <input id="image" type="file" class="form-control form-control-lg border-success-subtle" name="image">
                                @if($product->image)
                                    <div class="mt-2">
                                        <small class="text-muted">Current:</small>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="rounded border mt-1" style="height: 40px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> {{ __('Update Product') }}
                            </button>
                            <a href="{{ route('pharma.dashboard') }}" class="btn btn-outline-secondary btn-lg fw-bold border-0">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
