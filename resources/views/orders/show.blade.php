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
                        <div class="col-md-6">
                            <strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}<br>
                            <strong>Status:</strong> {{ $order->status }}<br>
                            <strong>Payment Status:</strong> {{ $order->payment_status }}
                        </div>
                        <div class="col-md-6 text-md-end">
                            <strong>Total Amount:</strong> <span class="h5 text-success">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <h5>Items</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product ? $item->product->name : 'Product Removed' }}</td>
                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Back to My Orders</a>
                        <a href="{{ url('/') }}" class="btn btn-primary" style="background-color: #2c5f2d; border-color: #2c5f2d;">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
