@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white text-center py-4">
                    <h3 class="fw-bold mb-0 text-white" style="font-family: 'Playfair Display', serif;">Add New Product</h3>
                </div>

                <div class="card-body p-5 bg-light-subtle">
                    <form method="POST" action="{{ route('pharma.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold text-dark">{{ __('Product Name') }}</label>
                                <input id="name" type="text" class="form-control form-control-lg border-success-subtle focus-ring-success" name="name" placeholder="E.g. Ashwagandha Powder" required>
                            </div>

                            <!-- Category & Subcategory -->
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold text-dark">{{ __('Category') }}</label>
                                <input id="category" type="text" class="form-control form-control-lg border-success-subtle" name="category" placeholder="E.g. Medicine, Wellness" required>
                            </div>

                            <div class="col-md-6">
                                <label for="subcategory" class="form-label fw-bold text-dark">{{ __('Subcategory') }}</label>
                                <input id="subcategory" type="text" class="form-control form-control-lg border-success-subtle" name="subcategory" placeholder="E.g. Immunity, Digestion">
                            </div>

                            <div class="col-md-12">
                                <label for="price" class="form-label fw-bold text-dark">{{ __('Price (₹)') }}</label>
                                <input id="price" type="number" step="0.01" min="0" class="form-control form-control-lg border-success-subtle" name="price" placeholder="0.00" required>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold text-dark">{{ __('Description') }}</label>
                                <textarea id="description" class="form-control form-control-lg border-success-subtle" name="description" rows="4" placeholder="Describe the product benefits and usage..."></textarea>
                            </div>

                            <!-- Stock, Expiry, Image -->
                            <div class="col-md-4">
                                <label for="stock" class="form-label fw-bold text-dark">{{ __('Stock Quantity') }}</label>
                                <input id="stock" type="number" min="0" step="1" class="form-control form-control-lg border-success-subtle" name="stock" required>
                            </div>

                            <div class="col-md-4">
                                <label for="expiry_date" class="form-label fw-bold text-dark">{{ __('Expiry Date') }}</label>
                                <input id="expiry_date" type="date" class="form-control form-control-lg border-success-subtle" name="expiry_date">
                            </div>

                            <div class="col-md-4">
                                <label for="image" class="form-label fw-bold text-dark">{{ __('Product Image') }}</label>
                                <input id="image" type="file" class="form-control form-control-lg border-success-subtle" name="image">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                <i class="fas fa-plus-circle me-2"></i> {{ __('Add Product') }}
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
