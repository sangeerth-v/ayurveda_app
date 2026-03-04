@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="row g-0">
                    <div class="col-md-6 bg-light d-flex align-items-center justify-content-center">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}" style="max-height: 500px; object-fit: contain;">
                        @else
                            <div class="text-muted p-5">No Image Available</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="card-body p-5">
                            <span class="badge bg-success mb-2">{{ $product->category }}</span>
                            <h1 class="card-title fw-bold mb-3" style="color: #2d6a4f;">{{ $product->name }}</h1>
                            <h2 class="text-success mb-4">₹{{ number_format($product->price, 2) }}</h2>
                            
                            <p class="card-text text-muted mb-4" style="line-height: 1.8;">
                                {{ $product->description }}
                            </p>

                            <hr class="my-4">

                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="d-flex align-items-center mb-4">
                                        <label class="me-3 fw-bold">Quantity:</label>
                                        <div class="input-group" style="width: 140px;">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="const input = this.parentNode.querySelector('input'); if(input.value > 1) input.stepDown();">-</button>
                                            <input type="number" name="quantity" class="form-control form-control-sm text-center fw-bold" value="1" min="1" max="10">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn btn-outline-success btn-lg w-100">
                                            <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                        </button>
                                        <button type="submit" name="buy_now" value="1" class="btn btn-primary btn-lg w-100" style="background-color: #2c5f2d; border-color: #2c5f2d;">
                                            <i class="fas fa-bolt me-2"></i> Buy Now
                                        </button>
                                    </div>
                                </form>
                                <p class="text-success mt-3 small"><i class="fas fa-check-circle me-1"></i> In Stock</p>
                            @else
                                <button class="btn btn-secondary btn-lg w-100" disabled>Out of Stock</button>
                                <p class="text-danger mt-3 small"><i class="fas fa-times-circle me-1"></i> Currently Unavailable</p>
                            @endif

                            <div class="mt-4">
                                <a href="{{ url('/') }}" class="text-decoration-none text-muted"> <i class="fas fa-arrow-left me-1"></i> Back to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
