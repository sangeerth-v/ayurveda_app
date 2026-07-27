@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', $product->name . ' | Ayurveda Pharmacy')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 overflow-hidden rounded-4">
                <div class="row g-0">
                    <div class="col-md-6 bg-light p-4 d-flex align-items-center justify-content-center position-relative">
                        @if($product->category == 'Medicine')
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-4"><i class="fas fa-file-prescription me-1"></i> Prescription Required</span>
                        @else
                            <span class="badge bg-success position-absolute top-0 start-0 m-4"><i class="fas fa-seedling me-1"></i> 100% Herbal Formulation</span>
                        @endif

                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}" style="max-height: 420px; object-fit: contain;">
                        @else
                            <div class="text-muted p-5 text-center">
                                <i class="fas fa-box-open fa-4x mb-3 opacity-50"></i>
                                <p class="mb-0">No Product Image Available</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="card-body p-4 p-md-5">
                            <span class="text-uppercase small fw-bold text-success tracking-wide">{{ $product->category ?? 'Ayurvedic Product' }}</span>
                            <h2 class="fw-bold my-2" style="color: #1a4d2e;">{{ $product->name }}</h2>
                            
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="text-warning small">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="small text-muted font-monospace">(4.8 / 5 Rating)</span>
                            </div>

                            <h3 class="fw-bold mb-4" style="color: #1a4d2e;">₹{{ number_format($product->price, 2) }}</h3>
                            
                            <p class="card-text text-muted mb-4" style="line-height: 1.8;">
                                {{ $product->description ?? 'Traditional Ayurvedic formulation carefully prepared to promote overall health and wellness.' }}
                            </p>

                            <div class="p-3 bg-light rounded-3 mb-4 border border-light">
                                <div class="row g-2 text-center text-muted small">
                                    <div class="col-4 border-end">
                                        <i class="fas fa-truck text-success d-block mb-1"></i> Fast Delivery
                                    </div>
                                    <div class="col-4 border-end">
                                        <i class="fas fa-shield-alt text-success d-block mb-1"></i> 100% Genuine
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-leaf text-success d-block mb-1"></i> Pure Herbal
                                    </div>
                                </div>
                            </div>

                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="d-flex align-items-center mb-4">
                                        <label class="me-3 fw-bold small text-dark">Quantity:</label>
                                        <div class="input-group" style="width: 130px;">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="const input = this.parentNode.querySelector('input'); if(input.value > 1) input.stepDown();">-</button>
                                            <input type="number" name="quantity" class="form-control form-control-sm text-center fw-bold" value="1" min="1" max="10">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success btn-lg fw-bold py-3" style="background-color: #1a4d2e; border: none;">
                                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                        </button>
                                    </div>
                                </form>
                                <p class="text-success mt-3 small"><i class="fas fa-check-circle me-1"></i> In Stock (Ready for Dispatch)</p>
                            @else
                                <button class="btn btn-secondary btn-lg w-100 disabled">Out of Stock</button>
                                <p class="text-danger mt-3 small"><i class="fas fa-times-circle me-1"></i> Currently Unavailable</p>
                            @endif

                            <div class="mt-4 pt-3 border-top">
                                <a href="{{ route('products.index') }}" class="text-decoration-none text-success fw-semibold small">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Pharmacy Products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
