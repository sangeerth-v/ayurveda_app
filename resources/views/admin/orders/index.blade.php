@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'All Customer Product Orders | Admin Oversight')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="fas fa-boxes text-success me-2"></i>All Customer Product Orders</h2>
            <p class="text-muted small mb-0">Overview and order status management for all store product purchases across the website.</p>
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
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search customer name, phone, or order ID..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">— All Order Statuses —</option>
                        <option value="Placed" {{ request('status') == 'Placed' ? 'selected' : '' }}>Placed</option>
                        <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100 rounded-3 fw-bold"><i class="fas fa-filter me-1"></i> Filter Orders</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-3" title="Reset Filters"><i class="fas fa-undo"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small text-muted fw-bold">
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>Customer Info</th>
                                <th>Delivery Destination</th>
                                <th>Ordered Items</th>
                                <th>Total Amount</th>
                                <th>Order Status</th>
                                <th>Payment</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold text-success">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
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
                                    <td class="fw-bold text-success">
                                        ₹{{ number_format($order->total_price, 2) }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="order_status" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                                                <option value="Placed" {{ $order->order_status == 'Placed' ? 'selected' : '' }}>Placed</option>
                                                <option value="Shipped" {{ $order->order_status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="Delivered" {{ $order->order_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="Cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        @if(in_array($order->payment_status, ['Completed', 'Received', 'Paid']))
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i class="fas fa-coins me-1"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 shadow-sm font-weight-bold">
                                            <i class="fas fa-eye me-1"></i> View Order
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
                    <h5 class="fw-bold">No Product Orders Found</h5>
                    <p class="small mb-0">No customer purchases match the selected filter criteria.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
