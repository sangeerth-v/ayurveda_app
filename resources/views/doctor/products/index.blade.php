@extends('layouts.app')

@section('navbar')
    @include('partials.nav-doctor')
@endsection

@section('title', 'My Formulated Products | Doctor Portal')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--primary-green);">My Formulated Products</h2>
            <p class="text-muted mb-0">Manage your prescribed medicines, wellness formulations, and health products available in the patient store.</p>
        </div>
        <a href="{{ route('doctor.products.create') }}" class="btn btn-success shadow-sm px-4 py-2 rounded-3 fw-bold">
            <i class="fas fa-plus-circle me-2"></i> Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 py-3 px-4 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Product</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Category</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Price</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Stock</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Expiry Date</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 me-3 bg-light border d-flex align-items-center justify-content-center overflow-hidden" style="width: 50px; height: 50px;">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="fas fa-pills text-success fa-lg"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $product->name }}</div>
                                        <div class="small text-muted text-truncate" style="max-width: 250px;">{{ $product->description ?? 'No description' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-3 py-2 rounded-pill">
                                    {{ $product->category }}
                                </span>
                                @if($product->subcategory)
                                    <div class="small text-muted mt-1">{{ $product->subcategory }}</div>
                                @endif
                            </td>
                            <td class="py-3 fw-bold text-dark">
                                ₹{{ number_format($product->price, 2) }}
                            </td>
                            <td class="py-3">
                                <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill px-3 py-2">
                                    {{ $product->stock > 0 ? $product->stock . ' Units' : 'Out of Stock' }}
                                </span>
                            </td>
                            <td class="py-3 text-muted small">
                                {{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('doctor.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('doctor.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Product">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted py-4">
                                    <i class="fas fa-boxes fa-3x mb-3 opacity-25"></i>
                                    <h5>No Products Added Yet</h5>
                                    <p class="mb-3">You haven't listed any health or Ayurvedic products yet.</p>
                                    <a href="{{ route('doctor.products.create') }}" class="btn btn-success fw-bold px-4 rounded-3">
                                        <i class="fas fa-plus me-1"></i> Add Your First Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer bg-white py-3 border-top">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
