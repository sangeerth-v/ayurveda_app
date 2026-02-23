@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4 text-center" style="color: #2c5f2d;">Shopping Cart</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($cart && $cart->items->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">{{ $item->product->category }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td style="width: 150px;">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm me-2">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                                            </form>
                                        </td>
                                        <td>₹{{ number_format($total, 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                                    <td colspan="2"><strong>₹{{ number_format($grandTotal, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary me-2">Continue Shopping</a>
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="background-color: #2c5f2d; border-color: #2c5f2d;">Place Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Your cart is empty. <a href="{{ url('/') }}">Start shopping!</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
