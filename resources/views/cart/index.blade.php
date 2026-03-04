@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<style>
    .quantity-selector {
        background: #f8f9fa;
        border-radius: 50px;
        padding: 4px;
        display: inline-flex;
        align-items: center;
        border: 1px solid #e9ecef;
    }
    .qty-btn {
        width: 32px;
        height: 32px;
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        background: white;
        border: 1px solid #dee2e6;
        color: #1a4d2e;
        transition: all 0.2s;
    }
    .qty-btn:hover:not(:disabled) {
        background: #1a4d2e;
        color: white;
        border-color: #1a4d2e;
    }
    .qty-value {
        min-width: 40px;
        text-align: center;
        font-weight: 700;
        color: #1a4d2e;
    }
    .cart-table th {
        background: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        color: #6c757d;
        border-top: none;
    }
    .custom-option {
        border: 1px solid #dee2e6;
        padding: 10px 15px;
        border-radius: 12px;
        transition: all 0.2s;
        cursor: pointer;
        display: flex;
        align-items: center;
        background: white;
    }
    .custom-option:hover {
        border-color: #1a4d2e;
        background: #f0f7f2;
    }
    .form-check-input:checked + .form-check-label {
        font-weight: bold;
        color: #1a4d2e;
    }
</style>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="mb-1" style="color: #1a4d2e; font-family: 'Playfair Display', serif;">Your Shopping Cart</h2>
                    <p class="text-muted mb-0">Review your selected Ayurvedic products</p>
                </div>
                @if($cart && $cart->items->count() > 0)
                    <a href="{{ url('/products') }}" class="btn btn-outline-success btn-sm rounded-pill px-4">
                        <i class="fas fa-shopping-basket me-2"></i>Continue Shopping
                    </a>
                @endif
            </div>



            @if($cart && $cart->items->count() > 0)
                <div class="card border-0 shadow-md rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover cart-table mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4 py-3">Product</th>
                                        <th class="py-3">Price</th>
                                        <th class="py-3">Quantity</th>
                                        <th class="py-3">Total</th>
                                        <th class="py-3 pe-4 text-end">Action</th>
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
                                            <td class="align-middle ps-4 py-4">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded-3 shadow-sm border" style="width: 80px; height: 80px; object-fit: cover; margin-right: 20px;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1 fw-bold text-dark">{{ $item->product->name }}</h6>
                                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-normal" style="font-size: 0.75rem;">{{ $item->product->category }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle fw-semibold">₹{{ number_format($item->price, 2) }}</td>
                                            <td class="align-middle">
                                                <div class="quantity-selector">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0 d-flex align-items-center">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn qty-btn" onclick="const input = this.nextElementSibling; if(input.value > 1) { input.stepDown(); this.form.submit(); }" title="Decrease">
                                                            <i class="fas fa-minus small"></i>
                                                        </button>
                                                        
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="20" class="form-control border-0 bg-transparent text-center fw-bold text-success" style="width: 50px;" onchange="this.form.submit()">
                                                        
                                                        <button type="button" class="btn qty-btn" onclick="const input = this.previousElementSibling; input.stepUp(); this.form.submit();" title="Increase">
                                                            <i class="fas fa-plus small"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="align-middle fw-bold text-success fs-5">₹{{ number_format($total, 2) }}</td>
                                            <td class="align-middle pe-4 text-end">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2" title="Remove from cart">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i> Shipping and taxes calculated at checkout
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end" id="cart-summary-section">
                                <div class="mb-4">
                                    <span class="text-muted me-2">Subtotal:</span>
                                    <span class="fs-3 fw-bold text-success">₹{{ number_format($grandTotal, 2) }}</span>
                                </div>
                                <button type="button" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm" onclick="showCheckout()">
                                    Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>

                            <div class="col-12 d-none" id="checkout-form-section">
                                <hr class="my-5">
                                <div class="row justify-content-end">
                                    <div class="col-lg-8">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h4 style="color: #1a4d2e;"><i class="fas fa-truck me-2"></i>Shipping & Payment</h4>
                                            <span class="fs-4 fw-bold text-success">Total: ₹{{ number_format($grandTotal, 2) }}</span>
                                        </div>

                                        <form action="{{ route('orders.store') }}" method="POST">
                                            @csrf
                                            <div class="card bg-light border-0 rounded-4 mb-4 text-start">
                                                <div class="card-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Full Name</label>
                                                            <input type="text" name="delivery_name" class="form-control rounded-pill" placeholder="Enter recipient name" required value="{{ auth()->user()->name }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Phone Number</label>
                                                            <input type="tel" name="delivery_phone" class="form-control rounded-pill @error('delivery_phone') is-invalid @enderror" placeholder="Enter 10-digit phone number" required pattern="[0-9]{10}" maxlength="10" minlength="10" title="Please enter exactly 10 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ auth()->user()->phone ?? '' }}">
                                                            @error('delivery_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Pincode</label>
                                                            <input type="text" name="delivery_pincode" id="delivery_pincode" class="form-control rounded-pill" placeholder="Enter 6-digit pincode" required pattern="\d{6}" maxlength="6" title="Please enter a valid 6-digit pincode">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">District</label>
                                                            <input type="text" name="delivery_district" id="delivery_district" class="form-control rounded-pill" placeholder="Enter district" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label small fw-bold">Shipping Address</label>
                                                            <textarea name="delivery_address" class="form-control rounded-4" rows="3" placeholder="Enter full delivery address" required></textarea>
                                                        </div>
                                                        
                                                        <div class="col-12 mt-4">
                                                            <h5 class="mb-3" style="color: #1a4d2e;"><i class="fas fa-credit-card me-2"></i>Payment Method</h5>
                                                            <div class="form-check custom-option w-100">
                                                                <input class="form-check-input" type="radio" name="payment_method" id="pay_cod" value="COD" checked required>
                                                                <label class="form-check-label w-100" for="pay_cod">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <span>Cash on Delivery</span>
                                                                        <i class="fas fa-money-bill-wave text-success"></i>
                                                                    </div>
                                                                    <div class="small text-muted mt-1">Pay when you receive your order</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-3 justify-content-end">
                                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="hideCheckout()">Back to Cart</button>
                                                <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm">
                                                    Complete Order <i class="fas fa-check-circle ms-2"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Your cart is empty. <a href="{{ url('products') }}">Start shopping!</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function showCheckout() {
    document.getElementById('cart-summary-section').classList.add('d-none');
    document.getElementById('checkout-form-section').classList.remove('d-none');
    window.scrollTo({ top: document.getElementById('checkout-form-section').offsetTop - 100, behavior: 'smooth' });
}

function hideCheckout() {
    document.getElementById('checkout-form-section').classList.add('d-none');
    document.getElementById('cart-summary-section').classList.remove('d-none');
}

document.getElementById('delivery_pincode')?.addEventListener('input', function(e) {
    const pincode = e.target.value;
    const districtInput = document.getElementById('delivery_district');

    if (pincode.length === 6) {
        fetch(`https://api.postalpincode.in/pincode/${pincode}`)
            .then(res => res.json())
            .then(data => {
                if (data[0].Status === "Success") {
                    const district = data[0].PostOffice[0].District;
                    
                    // Directly fill the district value
                    districtInput.value = district;
                    districtInput.classList.add('is-valid');
                    setTimeout(() => districtInput.classList.remove('is-valid'), 2000);
                }
            })
            .catch(err => console.error('Pincode fetch error:', err));
    }
});
</script>
@endsection
