@extends('layouts.app')

@section('navbar')
    @include('partials.nav-pharma')
@endsection

@section('title', 'Pharma Inventory | Ayurveda')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="mb-1">Product Inventory</h2>
        <p class="text-muted mb-0">Manage your pharmaceutical catalog and stock levels.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <div class="d-flex gap-2 justify-content-md-end">
            <button class="btn btn-outline-dark shadow-sm" data-bs-toggle="collapse" data-bs-target="#orderOrdersSection">
                <i class="fas fa-shopping-basket me-2"></i> View Orders
            </button>
            <a href="{{ route('pharma.products.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i> Add New Product
            </a>
        </div>
    </div>
</div>

<!-- Orders Section (Collapsed by default) -->
<div class="collapse mb-5" id="orderOrdersSection">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2"></i> Recent Orders</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                            <td>
                                <div class="fw-bold">{{ $order->user->name ?? 'Guest User' }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-phone-alt me-1 small"></i>{{ $order->delivery_phone }} | 
                                    <i class="fas fa-map-pin me-1 small"></i>{{ $order->delivery_pincode }}
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-link text-success p-0 text-decoration-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        {{ $order->items->count() }} items
                                    </button>
                                    <ul class="dropdown-menu shadow border-0">
                                        @foreach($order->items as $item)
                                        <li class="dropdown-item small text-muted">
                                            {{ $item->product->name }} <span class="badge bg-light text-dark">x{{ $item->quantity }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                            <td class="fw-bold text-success">₹{{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $order->order_status == 'Placed' ? 'primary' : ($order->order_status == 'Delivered' ? 'success' : 'warning') }} bg-opacity-10 text-{{ $order->order_status == 'Placed' ? 'primary' : ($order->order_status == 'Delivered' ? 'success' : 'warning') }} border border-{{ $order->order_status == 'Placed' ? 'primary' : ($order->order_status == 'Delivered' ? 'success' : 'warning') }} border-opacity-10 px-3">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pharma.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="row g-4">
    @forelse($products as $product)
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <!-- Product Image -->
            <div class="position-relative overflow-hidden" style="height: 200px; background-color: #f8f9fa;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted bg-light">
                        <i class="fas fa-pills fa-4x opacity-25"></i>
                    </div>
                @endif
                
                <!-- Category Badge -->
                <span class="badge bg-dark rounded-0 rounded-start position-absolute bottom-0 end-0 px-3 py-2 bg-opacity-75">
                    {{ $product->category ?? 'General' }}
                    @if($product->subcategory)
                        <span class="ms-1 ps-1 border-start border-light border-opacity-25">{{ $product->subcategory }}</span>
                    @endif
                </span>
                
                <!-- Stock Status -->
                <div class="position-absolute top-0 start-0 m-2">
                    @if($product->stock > 10)
                        <span class="badge bg-success shadow-sm px-3 border border-white border-opacity-25">{{ $product->stock }} in stock</span>
                    @elseif($product->stock > 0)
                        <span class="badge bg-warning text-dark shadow-sm px-3 border border-white border-opacity-25">Low stock: {{ $product->stock }}</span>
                    @else
                        <span class="badge bg-danger shadow-sm px-3 border border-white border-opacity-25">Out of Stock</span>
                    @endif
                </div>
            </div>

            <div class="card-body d-flex flex-column p-4">
                <h5 class="card-title fw-bold text-dark mb-1 h-auto text-truncate-2" style="height: 3rem;">{{ $product->name }}</h5>
                <div class="d-flex align-items-baseline gap-2 mb-3">
                    <span class="h4 fw-bold text-success mb-0">₹{{ number_format($product->price, 2) }}</span>
                </div>
                
                <div class="small text-muted mb-4 border-top pt-3 mt-auto">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="far fa-calendar-alt me-2 text-warning"></i>Expiry:</span>
                        <span class="fw-medium text-dark">{{ $product->expiry_date ?? 'Not set' }}</span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('pharma.products.edit', $product->id) }}" class="btn btn-outline-success flex-grow-1 py-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('pharma.products.destroy', $product->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Permanently remove this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 py-2">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="py-5 bg-white rounded-4 shadow-sm border border-dashed border-2">
            <i class="fas fa-boxes fa-4x text-light mb-3"></i>
            <h4 class="text-muted">No products in your catalog yet.</h4>
            <p class="text-muted mb-4">Start by adding your first product to reach customers.</p>
            <a href="{{ route('pharma.products.create') }}" class="btn btn-primary px-4 py-2">
                <i class="fas fa-plus me-2"></i> Add First Product
            </a>
        </div>
    </div>
    @endforelse
</div>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-title {
        line-height: 1.25;
    }
    .border-dashed {
        border-style: dashed !important;
    }
</style>
@endsection
