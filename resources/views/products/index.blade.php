@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Ayurveda Pharmacy & Online Wellness Store')

@section('content')
<style>
    /* Apollo Pharmacy Inspired Ayurvedic Design System */
    .pharmacy-hero {
        background: linear-gradient(135deg, #0c3b2e 0%, #1d5c42 60%, #6d9773 100%);
        color: #ffffff;
        padding: 2.5rem 1rem 3rem;
        position: relative;
        overflow: hidden;
    }
    .pharmacy-hero::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(197, 160, 89, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .search-box-wrap {
        max-width: 650px;
        margin: 0 auto;
        position: relative;
    }
    .search-box-input {
        height: 52px;
        border-radius: 30px;
        padding-left: 25px;
        padding-right: 120px;
        border: none;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        font-size: 0.98rem;
    }
    .search-box-btn {
        position: absolute;
        right: 5px;
        top: 5px;
        height: 42px;
        border-radius: 25px;
        padding: 0 24px;
        background: var(--accent-gold, #c5a059);
        border: none;
        color: #1a4d2e;
        font-weight: 700;
        transition: all 0.2s ease;
    }
    .search-box-btn:hover {
        background: #d4af66;
        transform: translateY(-1px);
    }
    
    /* Category Quick Pills */
    .category-pills-slider {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
        scrollbar-width: thin;
    }
    .category-pills-slider::-webkit-scrollbar {
        height: 4px;
    }
    .category-pills-slider::-webkit-scrollbar-thumb {
        background: #c5a059;
        border-radius: 4px;
    }
    .category-pill {
        white-space: nowrap;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(5px);
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 25px;
        font-size: 0.88rem;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.25);
        transition: all 0.2s;
    }
    .category-pill:hover, .category-pill.active {
        background: #ffffff;
        color: #1a4d2e;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Trust Feature Bar */
    .trust-bar {
        background: #f4f8f4;
        border-bottom: 1px solid #e0e9e1;
        padding: 0.85rem 0;
        font-size: 0.88rem;
        color: #2d6a4f;
    }
    .trust-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }
    .trust-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #e1efe3;
        color: #1a4d2e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    /* Product Card Styling */
    .ap-product-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e8eee9;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .ap-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(26, 77, 46, 0.12) !important;
        border-color: #c5a059;
    }
    .ap-img-wrap {
        height: 200px;
        background: #f9fbf9;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.2rem;
        position: relative;
        overflow: hidden;
    }
    .ap-img-wrap img {
        max-height: 160px;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.4s ease;
    }
    .ap-product-card:hover .ap-img-wrap img {
        transform: scale(1.06);
    }
    .badge-rx {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #fff3cd;
        color: #856404;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid #ffeeba;
        z-index: 2;
    }
    .badge-herbal {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #d4edda;
        color: #155724;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 6px;
        z-index: 2;
    }
    .ap-card-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .ap-cat-title {
        font-size: 0.75rem;
        color: #4f772d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .ap-product-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a4d2e;
        line-height: 1.35;
        height: 2.7em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 8px;
        text-decoration: none;
    }
    .ap-product-title:hover {
        color: #4f772d;
    }
    .ap-rating {
        font-size: 0.78rem;
        color: #ffc107;
        margin-bottom: 10px;
    }
    .ap-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a4d2e;
    }
    .btn-add-cart {
        background: #1a4d2e;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 8px;
        transition: all 0.2s ease;
    }
    .btn-add-cart:hover {
        background: #4f772d;
        color: #ffffff;
    }
    .qty-picker {
        width: 85px;
    }
    .qty-picker input {
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .qty-btn {
        padding: 2px 8px;
        font-size: 0.8rem;
    }

    /* Filter Sidebar Styling */
    .filter-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e0e9e1;
    }
    .filter-header {
        border-bottom: 1px solid #edf2ee;
        padding: 1rem 1.25rem;
    }
</style>

<!-- Hero & Search Banner -->
<div class="pharmacy-hero">
    <div class="container text-center">
        <h2 class="text-white fw-bold mb-2">🌿 Ayurveda Pharmacy & Wellness</h2>
        <p class="text-white-50 mb-4 small">Genuine Herbal Medicines, Oils, Supplements & Certified Ayurvedic Formulations</p>
        
        <!-- Live Search Bar -->
        <div class="search-box-wrap mb-4">
            <form action="{{ route('products.index') }}" method="GET">
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <input type="text" name="search" class="form-control search-box-input" placeholder="Search for medicines, churnas, oils, hair care..." value="{{ $search ?? '' }}">
                <button type="submit" class="search-box-btn">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </form>
        </div>

        <!-- Quick Category Pills -->
        <div class="category-pills-slider justify-content-center">
            <a href="{{ route('products.index') }}" class="category-pill {{ !request('categories') ? 'active' : '' }}">
                ✨ All Products
            </a>
            @foreach($categoryData as $catName => $subCats)
                <a href="{{ route('products.index', ['categories' => [$catName]]) }}" 
                   class="category-pill {{ is_array(request('categories')) && in_array($catName, request('categories')) ? 'active' : '' }}">
                    @if(Str::contains($catName, ['Medicine', 'Rx'])) 💊 
                    @elseif(Str::contains($catName, ['Oil', 'Hair', 'Care'])) 💆 
                    @elseif(Str::contains($catName, ['Wellness', 'Health'])) 🛡️ 
                    @else 🌿 @endif
                    {{ $catName }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Apollo-Style Assurance Bar
<div class="trust-bar d-none d-md-block">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-3">
                <div class="trust-item justify-content-center">
                    <div class="trust-icon"><i class="fas fa-bolt"></i></div>
                    <span>Fast Express Delivery</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="trust-item justify-content-center">
                    <div class="trust-icon"><i class="fas fa-shield-alt"></i></div>
                    <span>100% Genuine Ayurvedic</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="trust-item justify-content-center">
                    <div class="trust-icon"><i class="fas fa-leaf"></i></div>
                    <span>Certified Quality Herbs</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="trust-item justify-content-center">
                    <div class="trust-icon"><i class="fas fa-user-md"></i></div>
                    <span>Doctor Consultations</span>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Main Catalog Container -->
<div class="container my-5">
    <div class="row">
        <!-- Product Listing Section (Full Width) -->
        <div class="col-lg-12">
            <!-- Header Toolbar -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 bg-white p-3 rounded-3 shadow-sm border border-light">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        @if($search)
                            Search Results for "<span class="text-success">{{ $search }}</span>"
                        @else
                            All Ayurvedic Products
                        @endif
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill ms-2 font-monospace">{{ $products->count() }} items</span>
                    </h5>
                    <p class="text-muted small mb-0">Original, lab-tested herbal formulations for holistic health.</p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sort-amount-down me-1"></i> Sort: {{ str_replace('_', ' ', ucwords($sort ?? 'price_asc', '_')) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item {{ (request('sort') == 'price_asc' || !request('sort')) ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price: Low to High</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'price_desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price: High to Low</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest Arrivals</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Active Search Filter Badge -->
            @if($search)
                <div class="mb-3 d-flex align-items-center gap-2">
                    <span class="small text-muted">Active Search:</span>
                    <span class="badge bg-success bg-opacity-15 text-success p-2 rounded-pill">
                        "{{ $search }}" <a href="{{ route('products.index') }}" class="text-success ms-2 text-decoration-none"><i class="fas fa-times-circle"></i></a>
                    </span>
                </div>
            @endif

            <!-- Product Grid -->
            @if($products->count() > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
                    @foreach($products as $product)
                        <div class="col">
                            <div class="ap-product-card shadow-sm">
                                <!-- Prescription / Herbal Badge -->
                                @if($product->category == 'Medicine')
                                    <span class="badge-rx"><i class="fas fa-file-prescription me-1"></i> Prescription</span>
                                @else
                                    <span class="badge-herbal"><i class="fas fa-seedling me-1"></i> 100% Herbal</span>
                                @endif

                                <!-- Product Image Wrap -->
                                <div class="ap-img-wrap">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="https://via.placeholder.com/200x200?text=Ayurvedic+Product" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                </div>

                                <!-- Card Content -->
                                <div class="ap-card-body">
                                    <a href="{{ route('products.show', $product->id) }}" class="ap-product-title">
                                        {{ $product->name }}
                                    </a>
                                    
                                    <!-- Rating -->
                                    <div class="ap-rating d-flex align-items-center gap-1">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        <span class="text-muted ms-1 small">(4.8)</span>
                                    </div>

                                    <!-- Pricing & Add to Cart -->
                                    <div class="mt-auto pt-2 border-top">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <div>
                                                <span class="ap-price">₹{{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <span class="badge bg-success bg-opacity-10 text-success small">In Stock</span>
                                        </div>

                                        @if($product->stock > 0)
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="input-group input-group-sm qty-picker">
                                                        <button class="btn btn-outline-secondary qty-btn" type="button" onclick="const input = this.parentNode.querySelector('input'); if(input.value > 1) input.stepDown();">-</button>
                                                        <input type="number" name="quantity" class="form-control p-0 text-center" value="1" min="1" max="10">
                                                        <button class="btn btn-outline-secondary qty-btn" type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                                    </div>
                                                    <button type="submit" class="btn btn-add-cart flex-grow-1">
                                                        <i class="fas fa-shopping-cart me-1"></i> Add
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm w-100 disabled">Out of Stock</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card border-0 shadow-sm p-5 text-center my-4">
                    <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-50"></i>
                    <h5 class="fw-bold">No Products Found</h5>
                    <p class="text-muted small">Try searching with a different term or clearing your category filters.</p>
                    <div>
                        <a href="{{ route('products.index') }}" class="btn btn-success btn-sm px-4">Reset Filters</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

