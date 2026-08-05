@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Order Details | Ayurveda Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row items-center mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Details #{{ $order->id }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold" style="color: var(--primary-green);">
                        <i class="fas fa-shopping-basket me-2"></i> Order Summary #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </h4>
                    <span class="badge bg-{{ $order->order_status == 'Delivered' ? 'success' : 'primary' }} bg-opacity-10 text-{{ $order->order_status == 'Delivered' ? 'success' : 'primary' }} px-4 py-2 rounded-pill fs-6">
                        {{ $order->order_status }}
                    </span>
                </div>
                <div class="card-body p-lg-5">
                    <div class="row g-4 mb-5">
                        <div class="col-md-6 border-end">
                            <h6 class="text-muted text-uppercase small fw-bold mb-4"><i class="fas fa-info-circle me-2"></i>Order Information</h6>
                            <div class="mb-2 d-flex justify-content-between pe-md-4">
                                <span class="text-secondary">Order Date:</span>
                                <span class="fw-bold">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between pe-md-4">
                                <span class="text-secondary">Payment Method:</span>
                                <span class="fw-bold text-dark">{{ $order->payment_method }}</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between pe-md-4">
                                <span class="text-secondary">Payment Status:</span>
                                @if(in_array($order->payment_status, ['Completed', 'Received', 'Paid']))
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1">Completed</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1">Pending</span>
                                @endif
                            </div>
                            <div class="mt-4 pt-3 border-top pe-md-4">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3"><i class="fas fa-user-tag me-2"></i>Customer Information</h6>
                                <p class="mb-1 text-dark fw-bold">{{ $order->user->name ?? 'N/A' }}</p>
                                <p class="mb-0 text-muted small">{{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-4"><i class="fas fa-shipping-fast me-2"></i>Shipping Address</h6>
                            <p class="mb-1 fw-bold text-dark">{{ $order->delivery_name }}</p>
                            <p class="mb-1 text-secondary"><i class="fas fa-phone-alt me-2"></i>{{ $order->delivery_phone }}</p>
                            <p class="mb-1 text-secondary"><i class="fas fa-map-marker-alt me-2"></i>{{ $order->delivery_address }}</p>
                            <p class="mb-0 text-secondary ms-4">{{ $order->delivery_district }}, {{ $order->delivery_pincode }}</p>
                        </div>
                    </div>

                    <div class="bg-light p-4 rounded-4 mb-4 border d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Inventory Breakdown</h5>
                        <div class="text-end">
                            <span class="text-muted small d-block mb-1 text-uppercase fw-bold">Grand Total</span>
                            <span class="h3 text-success mb-0 fw-bold">₹{{ number_format($order->total_price, 2) }}</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="border-0">Product Details</th>
                                    <th class="border-0 text-center">Price</th>
                                    <th class="border-0 text-center">Quantity</th>
                                    <th class="border-0 text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded shadow-sm me-3" style="width: 54px; height: 54px; object-fit: cover; border: 1px solid #eee;">
                                                @else
                                                    <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" style="width: 54px; height: 54px; color: #ccc; border: 1px solid #eee;">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $item->product ? $item->product->name : 'Product Removed' }}</div>
                                                    <small class="text-muted d-block">{{ $item->product ? $item->product->pharmaCompany->company_name : 'No Pharma' }}</small>
                                                    @if($item->product)
                                                        <span class="badge bg-light text-secondary border rounded-pill x-small px-2 py-0 fw-normal">{{ $item->product->category }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">₹{{ number_format($item->price, 2) }}</td>
                                        <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold text-dark pe-4">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5 border-top pt-4">
                        <button onclick="window.close();" class="btn btn-outline-secondary rounded-pill px-4 me-2">
                           <i class="fas fa-times me-2"></i>Close Tab
                        </button>
                        <a href="javascript:history.back()" class="btn btn-primary rounded-pill px-4" style="background-color: var(--primary-green); border-color: var(--primary-green);">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
