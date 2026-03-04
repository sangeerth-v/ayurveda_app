@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Order Details') }} #{{ $order->id }}</span>
                    <a href="{{ route('pharma.dashboard') }}" class="btn btn-sm btn-secondary">Back to Dashboard</a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <p>
                                <strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}<br>
                                <strong>Phone:</strong> {{ $order->delivery_phone }}<br>
                                <strong>District:</strong> {{ $order->delivery_district }}<br>
                                <strong>Pincode:</strong> {{ $order->delivery_pincode }}<br>
                                <strong>Address:</strong> {{ $order->delivery_address }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5>Order Summary</h5>
                            <p>
                                <strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}<br>
                            <div class="order-status-control mt-2">
                                <label class="small text-muted mb-1 d-block font-weight-bold">Update Order Status:</label>
                                <form action="{{ route('pharma.orders.status.update', $order->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PUT')
                                    <div class="btn-group shadow-sm" role="group">
                                        <button type="submit" name="order_status" value="Placed" class="btn btn-sm {{ $order->order_status == 'Placed' ? 'btn-primary shadow-none' : 'btn-outline-primary' }}">
                                            <i class="fas fa-box me-1"></i> Placed
                                        </button>
                                        <button type="submit" name="order_status" value="Delivered" class="btn btn-sm {{ $order->order_status == 'Delivered' ? 'btn-success shadow-none' : 'btn-outline-success' }}">
                                            <i class="fas fa-check-circle me-1"></i> Delivered
                                        </button>
                                    </div>
                                </form>
                            </div>
                            </p>
                        </div>
                    </div>

                    <h5>Ordered Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px; border-radius: 4px;">
                                                @endif
                                                {{ $item->product->name }}
                                            </div>
                                        </td>
                                        <td>Rs. {{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
