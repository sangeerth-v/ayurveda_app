@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0" style="color: #2c5f2d;">Order Details #{{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 border-end">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Order Information</h6>
                            <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                            <p class="mb-1"><strong>Status:</strong> <span class="badge bg-{{ $order->order_status == 'Delivered' ? 'success' : 'primary' }}">{{ $order->order_status }}</span></p>
                            <p class="mb-1"><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                            <p class="mb-1"><strong>Payment Status:</strong> <span class="badge bg-info">{{ $order->payment_status }}</span></p>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Shipping Address</h6>
                            <p class="mb-1"><strong>Full Name:</strong> {{ $order->delivery_name }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $order->delivery_phone }}</p>
                            <p class="mb-1"><strong>District:</strong> {{ $order->delivery_district }}</p>
                            <p class="mb-1"><strong>Pincode:</strong> {{ $order->delivery_pincode }}</p>
                            <p class="mb-1"><strong>Address:</strong> {{ $order->delivery_address }}</p>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Items Summary</h5>
                            <span class="h4 text-success mb-0">Total: ₹{{ number_format($order->total_price, 2) }}</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded shadow-sm border me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; border: 1px solid #dee2e6;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $item->product ? $item->product->name : 'Product Removed' }}</div>
                                                    <small class="text-muted">{{ $item->product ? $item->product->category : '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">₹{{ number_format($item->price, 2) }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>My Orders
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4" style="background-color: #2c5f2d; border-color: #2c5f2d;">
                            Continue Shopping<i class="fas fa-shopping-bag ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
