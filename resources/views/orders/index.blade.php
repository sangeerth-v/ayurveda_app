@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4 text-center" style="color: #2c5f2d;">My Orders</h2>

            @if($orders->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'Completed' ? 'success' : ($order->status == 'Pending' ? 'warning' : 'secondary') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    You haven't placed any orders yet. <a href="{{ url('products') }}">Start shopping!</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
