@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<style>
    .quantity-selector {
        background: #f8f9fa;
        border-radius: 50px;
        padding: 4px;
        display: inline-flex;
        align-items: center;
        border: 1px solid #e9ecef;
    }
    .qty-btn {
        width: 32px;
        height: 32px;
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        background: white;
        border: 1px solid #dee2e6;
        color: #1a4d2e;
        transition: all 0.2s;
    }
    .qty-btn:hover:not(:disabled) {
        background: #1a4d2e;
        color: white;
        border-color: #1a4d2e;
    }
    .qty-value {
        min-width: 40px;
        text-align: center;
        font-weight: 700;
        color: #1a4d2e;
    }
    .cart-table th {
        background: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        color: #6c757d;
        border-top: none;
    }
</style>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="mb-1" style="color: #1a4d2e; font-family: 'Playfair Display', serif;">Your Shopping Cart</h2>
                    <p class="text-muted mb-0">Review your selected Ayurvedic products</p>
                </div>
                @if($cart && $cart->items->count() > 0)
                    <a href="{{ url('/products') }}" class="btn btn-outline-success btn-sm rounded-pill px-4">
                        <i class="fas fa-shopping-basket me-2"></i>Continue Shopping
                    </a>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($cart && $cart->items->count() > 0)
                <div class="card border-0 shadow-md rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover cart-table mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4 py-3">Product</th>
                                        <th class="py-3">Price</th>
                                        <th class="py-3">Quantity</th>
                                        <th class="py-3">Total</th>
                                        <th class="py-3 pe-4 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @foreach($cart->items as $item)
                                        @php 
                                            $total = $item->price * $item->quantity; 
                                            $grandTotal += $total;
                                        @endphp
                                        <tr>
                                            <td class="align-middle ps-4 py-4">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded-3 shadow-sm border" style="width: 80px; height: 80px; object-fit: cover; margin-right: 20px;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1 fw-bold text-dark">{{ $item->product->name }}</h6>
                                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-normal" style="font-size: 0.75rem;">{{ $item->product->category }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle fw-semibold">₹{{ number_format($item->price, 2) }}</td>
                                            <td class="align-middle">
                                                <div class="quantity-selector">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                                        <button type="submit" class="btn qty-btn" {{ $item->quantity <= 1 ? 'disabled' : '' }} title="Decrease">
                                                            <i class="fas fa-minus small"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <span class="qty-value px-2">{{ $item->quantity }}</span>
                                                    
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                        <button type="submit" class="btn qty-btn" title="Increase">
                                                            <i class="fas fa-plus small"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="align-middle fw-bold text-success fs-5">₹{{ number_format($total, 2) }}</td>
                                            <td class="align-middle pe-4 text-end">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2" title="Remove from cart">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i> Shipping and taxes calculated at checkout
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="mb-3">
                                    <span class="text-muted me-2">Order Total:</span>
                                    <span class="fs-3 fw-bold text-success">₹{{ number_format($grandTotal, 2) }}</span>
                                </div>
                                <form action="{{ route('orders.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                                        Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Your cart is empty. <a href="{{ url('products') }}">Start shopping!</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
