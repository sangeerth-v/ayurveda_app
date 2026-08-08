@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Ayurveda Pharmacy & Online Wellness Store')

@section('content')
<style>
/* ════════════════════════════════════════════════════
   PRODUCTS PAGE — UNIQUE DESIGN
   Palette: deep bottle-green, parchment cream, gold
════════════════════════════════════════════════════ */
:root {
    --pg:  #0c3b2e;
    --sg:  #1d5c42;
    --hg:  #4f772d;
    --gld: #c5a059;
    --amb: #ffba08;
    --par: #f5f0e8;
    --wht: #ffffff;
}

/* ── FLATLAY HERO BANNER ───────────────────────────── */
.ph-hero {
    position: relative;
    height: 420px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
.ph-hero-img {
    position: absolute; inset: 0;
    background: url('/images/herb_flatlay.png') center/cover no-repeat;
    filter: brightness(0.45) saturate(1.1);
}
.ph-hero-content {
    position: relative; z-index: 2;
    color: #fff;
}
.ph-hero-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(2rem, 5vw, 3.6rem);
    font-weight: 800;
    line-height: 1.15;
    color: #fff;
    margin-bottom: 0.6rem;
}
.ph-hero-title em { color: var(--amb); font-style: normal; }
.ph-hero-sub { color: rgba(255,255,255,0.7); font-size: 1rem; margin-bottom: 1.8rem; }

/* Search pill inside hero */
.hero-search-wrap { position: relative; max-width: 560px; margin: 0 auto; }
.hero-search-wrap input {
    width: 100%; height: 54px; border-radius: 50px;
    padding: 0 130px 0 24px;
    border: none; font-size: 0.96rem;
    box-shadow: 0 12px 35px rgba(0,0,0,0.25);
    outline: none;
}
.hero-search-wrap button {
    position: absolute; right: 5px; top: 5px; height: 44px;
    background: linear-gradient(135deg, var(--amb), #d4900c);
    border: none; border-radius: 40px; padding: 0 24px;
    color: #072a21; font-weight: 800; font-size: 0.9rem;
    cursor: pointer; transition: all 0.2s;
}
.hero-search-wrap button:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,186,8,0.4); }

/* Category pills on hero */
.hero-cat-pills { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-top: 1.5rem; }
.hero-cat-pill {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    color: #fff; padding: 7px 18px; border-radius: 50px;
    font-size: 0.83rem; font-weight: 500;
    text-decoration: none; transition: all 0.2s;
}
.hero-cat-pill:hover, .hero-cat-pill.active {
    background: #fff; color: var(--pg);
    font-weight: 700; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* ── SPLIT FEATURE STRIP ───────────────────────────── */
.feat-strip {
    display: flex;
    background: var(--pg);
}
.feat-strip-img {
    width: 42%;
    min-height: 280px;
    background: url('/images/product_bottle.png') center/cover no-repeat;
    flex-shrink: 0;
}
.feat-strip-content {
    flex: 1;
    padding: 3.5rem 4rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.feat-strip-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,186,8,0.15); border: 1px solid rgba(255,186,8,0.35);
    color: var(--amb); font-size: 0.73rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1.5px;
    padding: 4px 14px; border-radius: 50px; margin-bottom: 1.2rem;
    width: fit-content;
}
.feat-strip-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(1.6rem, 2.8vw, 2.2rem);
    color: #fff; font-weight: 800; line-height: 1.2;
    margin-bottom: 1rem;
}
.feat-strip-title span { color: var(--amb); }
.feat-strip-desc { color: rgba(255,255,255,0.6); font-size: 0.9rem; line-height: 1.8; margin-bottom: 1.5rem; }
.feat-pill-row { display: flex; flex-wrap: wrap; gap: 8px; }
.feat-pill {
    padding: 6px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 600;
    border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.85);
    background: rgba(255,255,255,0.07);
}

/* ── CATALOG TOOLBAR ───────────────────────────────── */
.catalog-bar {
    background: var(--par);
    border-bottom: 1px solid #e0d9cc;
    padding: 1.2rem 0;
}
.catalog-bar .toolbar-inner {
    display: flex; align-items: center;
    justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
}

/* ── PRODUCT CARDS ─────────────────────────────────── */
.catalog-section { background: var(--par); padding: 3rem 0 5rem; }

.prod-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e8e1d6;
    overflow: hidden;
    height: 100%;
    display: flex; flex-direction: column;
    transition: all 0.3s ease;
    box-shadow: 0 3px 12px rgba(12,59,46,0.05);
}
.prod-card:hover {
    transform: translateY(-6px);
    border-color: var(--gld);
    box-shadow: 0 18px 40px rgba(12,59,46,0.12);
}
.prod-img-wrap {
    height: 195px;
    background: linear-gradient(145deg, #f0ede5, #e8e4da);
    display: flex; align-items: center; justify-content: center;
    padding: 1.2rem; position: relative; overflow: hidden;
}
.prod-img-wrap img { max-height: 160px; max-width: 100%; object-fit: contain; transition: transform 0.4s ease; }
.prod-card:hover .prod-img-wrap img { transform: scale(1.07); }

.prod-badge-rx {
    position: absolute; top: 10px; left: 10px;
    background: #fffbeb; color: #92400e; border: 1px solid #fde68a;
    font-size: 0.65rem; font-weight: 700; padding: 3px 8px; border-radius: 6px;
}
.prod-badge-herb {
    position: absolute; top: 10px; right: 10px;
    background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;
    font-size: 0.65rem; font-weight: 600; padding: 3px 8px; border-radius: 6px;
}
.prod-body { padding: 1rem 1.1rem; display: flex; flex-direction: column; flex-grow: 1; }
.prod-cat { font-size: 0.7rem; color: var(--hg); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.prod-name {
    font-size: 0.98rem; font-weight: 700; color: var(--pg);
    line-height: 1.35; height: 2.7em; overflow: hidden;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    margin-bottom: 8px; text-decoration: none;
}
.prod-name:hover { color: var(--hg); }
.prod-by { font-size: 0.74rem; margin-bottom: 8px; }
.prod-stars { color: #f59e0b; font-size: 0.75rem; margin-bottom: 10px; }
.prod-footer { margin-top: auto; padding-top: 10px; border-top: 1px solid #f0ece4; }
.prod-price { font-size: 1.2rem; font-weight: 800; color: var(--pg); }
.prod-stock { font-size: 0.72rem; color: #16a34a; font-weight: 600; }
.btn-addcart {
    background: var(--pg);
    color: #fff; border: none; border-radius: 10px;
    font-weight: 700; font-size: 0.85rem; padding: 9px;
    width: 100%; transition: all 0.2s;
    cursor: pointer;
}
.btn-addcart:hover { background: var(--sg); transform: translateY(-1px); box-shadow: 0 6px 16px rgba(12,59,46,0.2); }
.qty-grp { display: flex; gap: 8px; align-items: center; }
.qty-btn { width: 30px; height: 30px; border: 1px solid #d0cab8; border-radius: 8px; background: #f8f5ef; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--pg); }
.qty-input { width: 45px; height: 30px; text-align: center; border: 1px solid #d0cab8; border-radius: 8px; font-weight: 700; font-size: 0.85rem; color: var(--pg); }

/* ── EMPTY / NO RESULTS ────────────────────────────── */
.empty-state { text-align: center; padding: 5rem 1rem; }
.empty-state i { color: #c8bfaf; font-size: 3rem; margin-bottom: 1rem; display: block; }

/* ── SORT DROPDOWN ─────────────────────────────────── */
.sort-btn {
    background: #fff; border: 1px solid #d0cab8;
    border-radius: 50px; padding: 8px 18px;
    font-size: 0.85rem; font-weight: 600; color: var(--pg);
    cursor: pointer;
}
</style>

{{-- ═══ FLATLAY HERO ═══════════════════════════════ --}}
<div class="ph-hero">
    <div class="ph-hero-img"></div>
    <div class="ph-hero-content px-3">
        <h1 class="ph-hero-title">
            Ayurveda Pharmacy<br>
            <em>&amp; Wellness Store</em>
        </h1>
        <p class="ph-hero-sub">Genuine herbal medicines, oils &amp; certified Ayurvedic formulations</p>

        <div class="hero-search-wrap">
            <form action="{{ route('products.index') }}" method="GET">
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <input type="text" name="search" placeholder="Search medicines, churnas, oils, hair care…" value="{{ $search ?? '' }}">
                <button type="submit"><i class="fas fa-search me-1"></i>Search</button>
            </form>
        </div>

        <div class="hero-cat-pills">
            <a href="{{ route('products.index') }}" class="hero-cat-pill {{ !request('categories') ? 'active' : '' }}">✨ All</a>
            @foreach($categoryData as $catName => $subCats)
                <a href="{{ route('products.index', ['categories' => [$catName]]) }}"
                   class="hero-cat-pill {{ is_array(request('categories')) && in_array($catName, request('categories')) ? 'active' : '' }}">
                    @if(Str::contains($catName, ['Medicine','Rx'])) 💊
                    @elseif(Str::contains($catName, ['Oil','Hair','Care'])) 💆
                    @elseif(Str::contains($catName, ['Wellness','Health'])) 🛡️
                    @else 🌿 @endif
                    {{ $catName }}
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══ PRODUCT BOTTLE SPLIT STRIP ════════════════ --}}
<div class="feat-strip d-none d-md-flex">
    <div class="feat-strip-img"></div>
    <div class="feat-strip-content">
        <div class="feat-strip-badge"><i class="fas fa-seedling"></i> From Nature's Lab</div>
        <h2 class="feat-strip-title">Pure. Potent.<br><span>Proven by Tradition.</span></h2>
        <p class="feat-strip-desc">
            Every product is sourced from GMP-licensed pharmacies and formulated by BAMS &amp; MD 
            Ayurvedic practitioners. Ancient healing science — delivered directly to you.
        </p>
        <div class="feat-pill-row">
            <span class="feat-pill"><i class="fas fa-leaf me-1"></i>100% Natural</span>
            <span class="feat-pill"><i class="fas fa-certificate me-1"></i>GMP Certified</span>
            <span class="feat-pill"><i class="fas fa-flask me-1"></i>Lab Tested</span>
            <span class="feat-pill"><i class="fas fa-user-md me-1"></i>Doctor Formulated</span>
        </div>
    </div>
</div>

{{-- ═══ CATALOG TOOLBAR ════════════════════════════ --}}
<div class="catalog-bar">
    <div class="container">
        <div class="toolbar-inner">
            <div>
                <span style="font-weight:700;color:var(--pg);font-size:1rem;">
                    @if($search)
                        Results for "<span style="color:var(--hg);">{{ $search }}</span>"
                    @else
                        All Ayurvedic Products
                    @endif
                </span>
                <span style="background:#e8f5e9;color:#2d6a4f;padding:3px 10px;border-radius:50px;font-size:0.78rem;font-weight:700;margin-left:8px;">
                    {{ $products->count() }} items
                </span>
                @if($search)
                    <a href="{{ route('products.index') }}" style="color:#e74c3c;margin-left:10px;font-size:0.83rem;text-decoration:none;">
                        <i class="fas fa-times-circle"></i> Clear
                    </a>
                @endif
            </div>
            <div class="dropdown">
                <button class="sort-btn dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-sort-amount-down me-1"></i>
                    Sort: {{ str_replace('_',' ', ucwords($sort ?? 'price_asc','_')) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                    <li><a class="dropdown-item {{ (!request('sort')||request('sort')=='price_asc') ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort'=>'price_asc']) }}">Price: Low → High</a></li>
                    <li><a class="dropdown-item {{ request('sort')=='price_desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort'=>'price_desc']) }}">Price: High → Low</a></li>
                    <li><a class="dropdown-item {{ request('sort')=='newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort'=>'newest']) }}">Newest Arrivals</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- ═══ PRODUCT GRID ════════════════════════════════ --}}
<section class="catalog-section">
    <div class="container">
        @if($products->count() > 0)
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
            @foreach($products as $product)
            <div class="col">
                <div class="prod-card">
                    {{-- Badge --}}
                    @if($product->category == 'Medicine')
                        <span class="prod-badge-rx"><i class="fas fa-file-prescription me-1"></i>Rx</span>
                    @else
                        <span class="prod-badge-herb"><i class="fas fa-seedling me-1"></i>Herbal</span>
                    @endif

                    {{-- Image --}}
                    <div class="prod-img-wrap">
                        <a href="{{ route('products.show', $product->id) }}">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="/images/herb_flatlay.png" alt="{{ $product->name }}" style="border-radius:10px;">
                            @endif
                        </a>
                    </div>

                    {{-- Body --}}
                    <div class="prod-body">
                        @if($product->category)
                            <div class="prod-cat">{{ $product->category }}</div>
                        @endif
                        <a href="{{ route('products.show', $product->id) }}" class="prod-name">{{ $product->name }}</a>

                        @if($product->doctor)
                            <div class="prod-by">
                                <span class="badge" style="background:#e8f5e9;color:#1d5c42;font-size:0.72rem;padding:4px 8px;border-radius:20px;">
                                    <i class="fas fa-user-md me-1"></i>Dr. {{ $product->doctor->name }}
                                </span>
                            </div>
                        @elseif($product->pharmaCompany)
                            <div class="prod-by">
                                <span class="badge" style="background:#f5f5f5;color:#555;font-size:0.72rem;padding:4px 8px;border-radius:20px;">
                                    <i class="fas fa-building me-1"></i>{{ $product->pharmaCompany->company_name }}
                                </span>
                            </div>
                        @endif

                        <div class="prod-stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span style="color:#9ca3af;margin-left:4px;">(4.8)</span>
                        </div>

                        <div class="prod-footer">
                            <div class="d-flex justify-content-between align-items-end mb-3">
                                <div>
                                    <div class="prod-price">₹{{ number_format($product->price, 2) }}</div>
                                    @if($product->stock > 0)
                                        <div class="prod-stock"><i class="fas fa-check-circle me-1"></i>In Stock</div>
                                    @endif
                                </div>
                            </div>

                            @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="qty-grp mb-2">
                                    <button type="button" class="qty-btn" onclick="const i=this.parentNode.querySelector('input');if(i.value>1)i.stepDown()">−</button>
                                    <input type="number" name="quantity" class="qty-input" value="1" min="1" max="10">
                                    <button type="button" class="qty-btn" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                </div>
                                <button type="submit" class="btn-addcart">
                                    <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                                </button>
                            </form>
                            @else
                                <button class="btn-addcart" style="opacity:0.5;cursor:not-allowed;" disabled>Out of Stock</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h5 style="color:var(--pg);font-weight:700;">No Products Found</h5>
            <p class="text-muted small">Try a different search or clear your category filter.</p>
            <a href="{{ route('products.index') }}" style="background:var(--pg);color:#fff;padding:10px 28px;border-radius:50px;text-decoration:none;font-weight:700;font-size:0.9rem;display:inline-block;margin-top:10px;">
                <i class="fas fa-redo me-2"></i>Reset Filters
            </a>
        </div>
        @endif
    </div>
</section>

@endsection
