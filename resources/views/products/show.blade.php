@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', $product->name . ' | Ayurveda Wellness Store')

@section('content')
<style>
/* ════════════════════════════════════════════════════
   PRODUCT DETAIL PAGE — AESTHETIC & PREMIUM
   Palette: deep bottle-green, parchment cream, gold
════════════════════════════════════════════════════ */
:root {
    --pd-forest: #0c3b2e;
    --pd-sage: #1d5c42;
    --pd-herb: #4f772d;
    --pd-gold: #c5a059;
    --pd-amber: #ffba08;
    --pd-parchment: #f9f5ef;
    --pd-cream: #faf8f4;
    --pd-dark: #1e293b;
}

.pd-section {
    background-color: var(--pd-parchment);
    padding: 4rem 0 6rem;
    min-height: 90vh;
}

/* Container Card */
.pd-card {
    background: #ffffff;
    border: 1px solid #e2dacf;
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 0 16px 45px rgba(12,59,46,0.06);
}

/* Left image panel */
.pd-img-panel {
    background: linear-gradient(145deg, #f3ede2, #eae4d8);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    position: relative;
    min-height: 480px;
}
.pd-img-panel img {
    max-height: 380px;
    max-width: 100%;
    object-fit: contain;
    filter: drop-shadow(0 12px 24px rgba(12,59,46,0.12));
    transition: transform 0.4s ease;
}
.pd-img-panel:hover img {
    transform: scale(1.03);
}

.pd-rx-badge {
    position: absolute; top: 24px; left: 24px;
    background: #fffbeb; color: #92400e; border: 1px solid #fde68a;
    font-size: 0.72rem; font-weight: 700; padding: 5px 12px; border-radius: 30px;
    display: inline-flex; align-items: center; gap: 6px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
.pd-herb-badge {
    position: absolute; top: 24px; left: 24px;
    background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;
    font-size: 0.72rem; font-weight: 700; padding: 5px 12px; border-radius: 30px;
    display: inline-flex; align-items: center; gap: 6px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

/* Right content panel */
.pd-content-panel {
    padding: 3.5rem 3rem;
}

.pd-cat-label {
    font-size: 0.78rem;
    color: var(--pd-herb);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
    display: inline-block;
}

.pd-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 2.3rem;
    font-weight: 800;
    color: var(--pd-forest);
    line-height: 1.2;
    margin-bottom: 12px;
}

.pd-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 1.5rem;
}
.pd-rating .stars { color: #f59e0b; font-size: 0.85rem; }
.pd-rating .text { color: #64748b; font-size: 0.82rem; font-weight: 600; }

.pd-price {
    font-size: 2.1rem;
    font-weight: 900;
    color: var(--pd-forest);
    margin-bottom: 1.5rem;
}

.pd-desc {
    color: #475569;
    font-size: 0.95rem;
    line-height: 1.85;
    margin-bottom: 2rem;
}

/* Provider/Doctor box */
.pd-provider-card {
    background: var(--pd-cream);
    border: 1px solid #eae2d4;
    border-radius: 18px;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 2rem;
}
.pd-provider-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: rgba(197, 160, 89, 0.15); border: 1px solid rgba(197, 160, 89, 0.3);
    color: var(--pd-forest); display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}

/* Trust features strip */
.pd-trust-row {
    display: flex; gap: 12px; margin-bottom: 2.5rem;
}
.pd-trust-item {
    flex: 1; text-align: center;
    background: #fcfbfa; border: 1px solid #eae2d4;
    border-radius: 12px; padding: 12px 6px;
    font-size: 0.78rem; font-weight: 600; color: #475569;
}
.pd-trust-item i { color: var(--pd-herb); font-size: 1rem; margin-bottom: 4px; display: block; }

/* Booking / Cart form */
.pd-qty-group {
    display: flex; align-items: center; gap: 8px;
    border: 1px solid #d4cfc4; border-radius: 10px;
    padding: 6px 10px; background: #fff;
    width: fit-content;
}
.pd-qty-btn {
    border: none; background: transparent;
    color: var(--pd-forest); font-size: 1.1rem; font-weight: 700;
    width: 28px; height: 28px; cursor: pointer;
}
.pd-qty-input {
    width: 45px; text-align: center; border: none; outline: none;
    font-weight: 800; color: var(--pd-forest); font-size: 0.95rem;
}

.btn-pd-add {
    background: linear-gradient(135deg, var(--pd-forest) 0%, var(--pd-sage) 100%);
    color: #fff; border: none; border-radius: 12px;
    height: 52px; font-weight: 800; font-size: 0.98rem;
    padding: 0 35px; transition: all 0.25s; cursor: pointer;
    box-shadow: 0 8px 24px rgba(12, 59, 46, 0.16);
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-pd-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(12, 59, 46, 0.25);
    color: #fff;
}
</style>

<div class="pd-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="pd-card">
                    <div class="row g-0">
                        
                        {{-- Image Panel --}}
                        <div class="col-md-6 pd-img-panel">
                            @if($product->category == 'Medicine')
                                <span class="pd-rx-badge"><i class="fas fa-file-prescription"></i> Rx Required</span>
                            @else
                                <span class="pd-herb-badge"><i class="fas fa-seedling"></i> 100% Herbal</span>
                            @endif

                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-box-open fa-4x mb-3 opacity-40"></i>
                                    <div>No product image available</div>
                                </div>
                            @endif
                        </div>

                        {{-- Details Panel --}}
                        <div class="col-md-6 pd-content-panel">
                            <span class="pd-cat-label">
                                {{ $product->category ?? 'Ayurvedic Store' }}
                                @if($product->subcategory) · {{ $product->subcategory }} @endif
                            </span>
                            <h1 class="pd-title">{{ $product->name }}</h1>

                            <div class="pd-rating">
                                <span class="stars text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->average_rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - $product->average_rating < 1)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </span>
                                <span class="text fw-bold">{{ $product->average_rating }} ({{ $product->reviews_count }} verified {{ Str::plural('review', $product->reviews_count) }})</span>
                            </div>

                            <div class="pd-price">₹{{ number_format($product->price, 2) }}</div>
                            <p class="pd-desc">
                                {{ $product->description ?? 'Traditional Ayurvedic formulation prepared using authentic ingredients to support natural healing, daily wellness, and balance.' }}
                            </p>

                            {{-- Formulated By info --}}
                            @if($product->doctor)
                            <div class="pd-provider-card">
                                <div class="pd-provider-icon"><i class="fas fa-user-md"></i></div>
                                <div>
                                    <div style="font-size:0.75rem;color:#7c7263;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Formulated By</div>
                                    <div style="font-weight:800;color:var(--pd-forest);font-size:0.92rem;">Dr. {{ $product->doctor->name }}</div>
                                    <div style="font-size:0.75rem;color:#64748b;">{{ $product->doctor->specialization_category ?? 'Ayurveda Specialist' }}</div>
                                </div>
                            </div>
                            @elseif($product->pharmaCompany)
                            <div class="pd-provider-card">
                                <div class="pd-provider-icon"><i class="fas fa-building"></i></div>
                                <div>
                                    <div style="font-size:0.75rem;color:#7c7263;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Manufacturer</div>
                                    <div style="font-weight:800;color:var(--pd-forest);font-size:0.92rem;">{{ $product->pharmaCompany->company_name }}</div>
                                </div>
                            </div>
                            @endif

                            {{-- Trust feature list --}}
                            <div class="pd-trust-row">
                                <div class="pd-trust-item"><i class="fas fa-truck"></i>Fast Delivery</div>
                                <div class="pd-trust-item"><i class="fas fa-shield-alt"></i>100% Genuine</div>
                                <div class="pd-trust-item"><i class="fas fa-certificate"></i>GMP Certified</div>
                            </div>

                            {{-- Cart section --}}
                            @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="pd-qty-group">
                                        <button type="button" class="pd-qty-btn" onclick="const i=this.parentNode.querySelector('input');if(i.value>1)i.stepDown();">−</button>
                                        <input type="number" name="quantity" class="pd-qty-input" value="1" min="1" max="{{ $product->stock }}">
                                        <button type="button" class="pd-qty-btn" onclick="const i=this.parentNode.querySelector('input');if(parseInt(i.value)<{{ $product->stock }})i.stepUp();">+</button>
                                    </div>

                                    <button type="submit" class="btn-pd-add">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                            </form>
                            <div style="color:#16a34a;font-size:0.83rem;font-weight:700;display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} units available)
                            </div>
                            @else
                            <div class="d-flex gap-3 align-items-center mb-4">
                                <button class="btn-pd-add" style="opacity:0.5;cursor:not-allowed;" disabled>
                                    <i class="fas fa-box-open"></i> Out of Stock
                                </button>
                            </div>
                            <div style="color:#dc2626;font-size:0.83rem;font-weight:700;display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-times-circle"></i> Currently Unavailable
                            </div>
                            @endif

                            <div class="mt-4 pt-3 border-top" style="border-color:#e2dacf !important;">
                                <a href="{{ route('products.index') }}" style="color:var(--pd-forest);font-size:0.88rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                                    <i class="fas fa-arrow-left"></i> Back to Pharmacy Store
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Customer Reviews Section --}}
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mt-5" style="background:#fff;">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                        <div>
                            <h3 class="fw-bold mb-1" style="color:var(--pd-forest);font-family:'Playfair Display',serif;">Customer Ratings &amp; Reviews</h3>
                            <div class="text-muted small">Real feedback from verified buyers</div>
                        </div>
                        <div class="text-end">
                            <div class="display-6 fw-bold text-success">{{ $product->average_rating }} <small class="fs-6 text-muted">/ 5</small></div>
                            <div class="stars text-warning fs-6">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->average_rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - $product->average_rating < 1)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    @forelse($product->reviews as $rev)
                        <div class="mb-4 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width:42px;height:42px;font-size:1.1rem;">
                                        {{ strtoupper(substr($rev->user->name ?? 'User', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $rev->user->name ?? 'Verified Buyer' }} <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill ms-2" style="font-size:0.68rem;"><i class="fas fa-check-circle me-1"></i>Verified Purchase</span></div>
                                        <div class="text-muted" style="font-size:0.75rem;">{{ $rev->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="text-warning fs-6">
                                    @for($s = 1; $s <= 5; $s++)
                                        <i class="fa{{ $s <= $rev->rating ? 's' : 'r' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($rev->review)
                                <p class="text-secondary mb-0 mt-2 ms-5 ps-1" style="line-height:1.6;font-size:0.92rem;">"{{ $rev->review }}"</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-comment-alt fa-3x mb-3 text-secondary opacity-25"></i>
                            <h5>No Reviews Yet</h5>
                            <p class="small mb-0">Be the first to buy and rate this product once delivered!</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
