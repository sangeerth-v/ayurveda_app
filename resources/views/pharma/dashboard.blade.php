@extends('layouts.app')

@section('navbar')
    @include('partials.nav-pharma')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pharma Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as Pharma!') }}

                    <hr>
                    <h3>Actions</h3>
                    <a href="{{ route('pharma.products.create') }}" class="btn btn-primary">Add Product</a>
                    
                    <hr>
                    <h3>My Products</h3>
                    @if($products->isEmpty())
                        <div class="alert alert-info">No products added yet. Click "Add Product" to get started.</div>
                    @else
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @foreach($products as $product)
                                <div class="col">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="position-relative">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 180px;">
                                                    <span class="text-muted">No Image</span>
                                                </div>
                                            @endif
                                            
                                            <!-- Stock Badge -->
                                            <span class="badge position-absolute top-0 end-0 m-2 {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->stock > 0 ? 'In Stock: ' . $product->stock : 'Out of Stock' }}
                                            </span>
                                        </div>

                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title fw-bold text-truncate">{{ $product->name }}</h5>
                                            <p class="card-text text-success fw-bold">₹{{ number_format($product->price, 2) }}</p>
                                            
                                            <div class="small text-muted mb-3">
                                                <div><i class="far fa-calendar-alt me-1"></i> Expires: {{ $product->expiry_date }}</div>
                                                <div><i class="fas fa-tag me-1"></i> {{ $product->category ?? 'General' }}</div>
                                            </div>

                                            <div class="mt-auto d-flex gap-2">
                                                <a href="{{ route('pharma.products.edit', $product->id) }}" class="btn btn-warning flex-grow-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('pharma.products.destroy', $product->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger w-100">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <hr>
                    <h3>My Orders</h3>
                    @if($orders->isEmpty())
                        <p>No orders yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'Guest' }}<br><small>{{ $order->delivery_phone }}</small></td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    @foreach($order->items as $item)
                                                        <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>Rs. {{ $order->total_price }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->order_status == 'Placed' ? 'primary' : ($order->order_status == 'Delivered' ? 'success' : 'warning') }}">
                                                    {{ $order->order_status }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('pharma.orders.show', $order->id) }}" class="btn btn-sm btn-info text-white">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
