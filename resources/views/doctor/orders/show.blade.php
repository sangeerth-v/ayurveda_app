@extends('layouts.app')

@section('navbar')
    @include('partials.nav-doctor')
@endsection

@section('title', 'Process Order #' . $order->id . ' | Doctor Portal')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="fas fa-box-open text-success me-2"></i>Process Order #{{ $order->id }}</h2>
            <p class="text-muted small mb-0">Order Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <a href="{{ route('doctor.orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Back to Product Orders
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Order Items & Customer Info --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-shopping-bag text-success me-2"></i>Ordered Products</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light small text-uppercase text-muted fw-bold">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded shadow-sm border" style="width: 54px; height: 54px; object-fit: cover;">
                                                @else
                                                    <div class="rounded bg-light d-flex align-items-center justify-content-center border" style="width: 54px; height: 54px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $item->product ? $item->product->name : 'Product' }}</div>
                                                    <div class="small text-muted">{{ $item->product ? $item->product->category : '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-semibold">₹{{ number_format($item->price, 2) }}</td>
                                        <td class="text-center"><span class="badge bg-secondary-subtle text-dark fs-6 px-3 py-1">{{ $item->quantity }}</span></td>
                                        <td class="text-end pe-4 fw-bold text-success">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Shipping & Customer Details Card --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-map-marker-alt text-danger me-2"></i>Shipping Address</h5>
                </div>
                <div class="card-body p-4 pt-1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase text-muted fw-bold mb-1">Customer Name</label>
                            <div class="fw-bold text-dark fs-6">{{ $order->delivery_name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase text-muted fw-bold mb-1">Contact Phone</label>
                            <div class="fw-bold text-dark fs-6"><i class="fas fa-phone text-success me-2"></i>{{ $order->delivery_phone }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase text-muted fw-bold mb-1">District &amp; State</label>
                            <div class="fw-bold text-dark">{{ $order->delivery_district }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase text-muted fw-bold mb-1">Pincode</label>
                            <div class="fw-bold text-dark">{{ $order->delivery_pincode }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-uppercase text-muted fw-bold mb-1">Full Delivery Address</label>
                            <div class="p-3 bg-light rounded-3 text-dark font-monospace" style="font-size: 0.92rem;">
                                {{ $order->delivery_address }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping Status Update Controls --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 90px;">
                <div class="card-header bg-success text-white py-3 rounded-top-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-shipping-fast me-2"></i>Fulfillment &amp; Status</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('doctor.orders.update_status', $order->id) }}" method="POST">
                        @csrf

                        <!-- Current Status Badges -->
                        <div class="mb-4 p-3 bg-light rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted fw-bold">Order Status:</span>
                                @if($order->order_status == 'Delivered')
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Delivered</span>
                                @elseif($order->order_status == 'Shipped')
                                    <span class="badge bg-info text-dark"><i class="fas fa-truck me-1"></i> Shipped</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Placed</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted fw-bold">Payment Status:</span>
                                @if(in_array($order->payment_status, ['Completed', 'Received', 'Paid']))
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fas fa-coins me-1"></i> Pending ({{ $order->payment_method }})</span>
                                @endif
                            </div>
                        </div>

                        <!-- Update Order Status -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Update Order / Shipping Status</label>
                            <select name="order_status" class="form-select form-select-lg rounded-3 fs-6">
                                <option value="Placed" {{ $order->order_status == 'Placed' ? 'selected' : '' }}>📦 Order Placed (Processing)</option>
                                <option value="Shipped" {{ $order->order_status == 'Shipped' ? 'selected' : '' }}>🚚 Shipped / Out for Delivery</option>
                                <option value="Delivered" {{ $order->order_status == 'Delivered' ? 'selected' : '' }}>✅ Delivered to Customer</option>
                                <option value="Cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                            </select>
                        </div>

                        <!-- Update Payment Status -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Update Payment Status</label>
                            <select name="payment_status" class="form-select rounded-3">
                                <option value="Pending" {{ $order->payment_status == 'Pending' ? 'selected' : '' }}>⏳ Payment Pending</option>
                                <option value="Completed" {{ in_array($order->payment_status, ['Completed', 'Received', 'Paid']) ? 'selected' : '' }}>💰 Payment Received (Completed)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> Update Order Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
