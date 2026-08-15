@extends('layouts.app')

@section('navbar')
    @include('partials.nav-doctor')
@endsection

@section('title', 'Product Orders to Ship | Doctor Portal')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="fas fa-truck text-success me-2"></i>Product Orders</h2>
            <p class="text-muted small mb-0">Manage customer orders for your formulated products that require fulfillment & shipping.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
            <a href="{{ route('doctor.products.index') }}" class="btn btn-outline-success rounded-pill px-3">
                <i class="fas fa-boxes me-1"></i> My Products
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small text-muted fw-bold">
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>Customer &amp; Contact</th>
                                <th>Delivery Destination</th>
                                <th>Ordered Products</th>
                                <th>Order Status</th>
                                <th>Payment</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold text-success">#{{ $order->id }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $order->delivery_name }}</div>
                                        <div class="small text-muted"><i class="fas fa-phone me-1"></i>{{ $order->delivery_phone }}</div>
                                    </td>
                                    <td>
                                        <div class="small text-dark fw-semibold">{{ $order->delivery_district }} ({{ $order->delivery_pincode }})</div>
                                        <div class="small text-muted text-truncate" style="max-width: 180px;">{{ $order->delivery_address }}</div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            @foreach($order->items as $item)
                                                <div class="fw-semibold text-dark">
                                                    {{ $item->product ? $item->product->name : 'Product' }} <span class="badge bg-secondary-subtle text-secondary">x{{ $item->quantity }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @if($order->order_status == 'Delivered')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill">
                                                <i class="fas fa-check-circle me-1"></i> Delivered
                                            </span>
                                        @elseif($order->order_status == 'Shipped')
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1.5 rounded-pill text-dark">
                                                <i class="fas fa-shipping-fast me-1"></i> Shipped
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2.5 py-1.5 rounded-pill text-dark">
                                                <i class="fas fa-clock me-1"></i> Placed / Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array($order->payment_status, ['Completed', 'Received', 'Paid']))
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i class="fas fa-coins me-1"></i> Pending ({{ $order->payment_method }})</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('doctor.orders.show', $order->id) }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm font-weight-bold">
                                            <i class="fas fa-box-open me-1"></i> Process &amp; Ship
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-box-open fa-4x mb-3 text-secondary opacity-25"></i>
                    <h5 class="fw-bold">No Product Orders Yet</h5>
                    <p class="small mb-0">When customers order your products from the store, orders will appear here for shipping.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
