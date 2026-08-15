@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'All Store Products | Admin Oversight')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="fas fa-cubes text-success me-2"></i>All Store Products</h2>
            <p class="text-muted small mb-0">Overview and management of all Ayurvedic products across doctor formulations &amp; pharmacy catalogs.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter Toolbar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search product title, category, subcategory..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100 rounded-3 fw-bold"><i class="fas fa-search me-1"></i> Search</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-3" title="Reset Search"><i class="fas fa-undo"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small text-muted fw-bold">
                            <tr>
                                <th class="ps-4">Product Details</th>
                                <th>Category &amp; Subcategory</th>
                                <th>Vendor / Seller</th>
                                <th>Price</th>
                                <th>Remaining Stock</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="rounded border shadow-sm" style="width: 48px; height: 48px; object-fit: cover;">
                                            @else
                                                <div class="rounded bg-light border d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; color: #ccc;">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $product->name }}</div>
                                                <div class="small text-muted text-truncate" style="max-width: 200px;">{{ $product->description ?? 'No description' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $product->category }}</div>
                                        <div class="small text-muted">{{ $product->subcategory }}</div>
                                    </td>
                                    <td>
                                        @if($product->doctor)
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill">
                                                <i class="fas fa-user-md me-1"></i> Dr. {{ $product->doctor->name }}
                                            </span>
                                        @elseif($product->pharmaCompany)
                                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2.5 py-1.5 rounded-pill">
                                                <i class="fas fa-building me-1"></i> {{ $product->pharmaCompany->company_name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1.5 rounded-pill">System Store</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-success fs-6">
                                        ₹{{ number_format($product->price, 2) }}
                                    </td>
                                    <td>
                                        @if($product->stock > 10)
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> {{ $product->stock }} in stock</span>
                                        @elseif($product->stock > 0)
                                            <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i> {{ $product->stock }} left</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Out of stock</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary rounded-circle p-1.5" title="Edit Product"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-1.5" title="Delete Product"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-boxes fa-4x mb-3 text-secondary opacity-25"></i>
                    <h5 class="fw-bold">No Products Found</h5>
                    <p class="small mb-0">No products match your search query.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
