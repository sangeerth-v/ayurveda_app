@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="container mb-5 mt-4">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-md-3 d-none d-md-block">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Filter</h5>
                        <a href="{{ route('products.index') }}" class="text-success text-decoration-none small">Clear All</a>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">Availability</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="availability" id="inStock" checked disabled>
                            <label class="form-check-label opacity-100" for="inStock">In Stock Only</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">Categories</h6>
                        <div class="d-flex flex-column gap-2" style="max-height: 300px; overflow-y: auto;">
                            @foreach(['Medicine', 'Wellness', 'Skincare', 'Haircare', 'Equipment', 'Supplements'] as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category }}" id="cat-{{ $category }}">
                                    <label class="form-check-label" for="cat-{{ $category }}">{{ $category }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-dark">Our Products <span class="text-muted fs-6">({{ $products->count() }})</span></h4>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Sort By: Price - Low to High
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item active" href="#">Price - Low to High</a></li>
                            <li><a class="dropdown-item" href="#">Price - High to Low</a></li>
                            <li><a class="dropdown-item" href="#">Newest First</a></li>
                        </ul>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach($products as $product)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm position-relative product-card">
                                    <!-- Wishlist Icon -->
                                    <button class="btn btn-link position-absolute top-0 end-0 p-3 text-muted" style="z-index: 10;">
                                        <i class="far fa-heart fa-lg"></i>
                                    </button>

                                    <!-- Prescription Badge -->
                                    @if($product->category == 'Medicine')
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3">Prescription</span>
                                    @endif

                                    <!-- Image -->
                                    <div class="p-3 bg-white text-center" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-height: 180px; max-width: 100%; object-fit: contain;">
                                            @else
                                                <img src="https://via.placeholder.com/150?text=No+Image" alt="No Image" style="max-height: 180px;">
                                            @endif
                                        </a>
                                    </div>

                                    <div class="card-body d-flex flex-column pt-0">
                                        <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                            <h6 class="card-title fw-bold mb-1" style="font-size: 1rem; min-height: 2.4em; line-height: 1.2em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                {{ $product->name }}
                                            </h6>
                                        </a>
                                        
                                        <div class="mt-auto">
                                            <h5 class="fw-bold mb-3">₹{{ number_format($product->price, 2) }}</h5>
                                            
                                            @if($product->stock > 0)
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-grid">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success fw-bold py-2" style="background-color: #008000; border: none;">
                                                        Add to Cart
                                                    </button>
                                                </form>
                                            @else
                                                <div class="d-grid">
                                                    <button class="btn btn-secondary fw-bold py-2 disabled">Out of Stock</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center">No products found.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
