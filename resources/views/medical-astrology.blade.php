@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Doctor Timings & Schedules | Ayurveda Wellness Platform')

@section('content')
<style>
/* ════════════════════════════════════════════════
   MEDICAL ASTROLOGY / SCHEDULE PAGE
   Warm parchment + deep forest + gold palette
════════════════════════════════════════════════ */
:root {
    --ma-dark: #0c2218;
    --ma-forest: #0c3b2e;
    --ma-sage: #1d5c42;
    --ma-herb: #4f772d;
    --ma-gold: #c5a059;
    --ma-amber: #ffba08;
    --ma-cream: #faf6ef;
    --ma-parch: #f2ede3;
}

/* ── MEDITATION HERO ───────────────────────────── */
.ma-hero {
    position: relative;
    min-height: 75vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}
.ma-hero-bg {
    position: absolute; inset: 0;
    background: url('/images/meditation_hero.png') center top / cover no-repeat;
    filter: brightness(0.28) saturate(1.1);
}
.ma-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(12,34,24,0.3) 0%, rgba(12,34,24,0.85) 100%);
}
.ma-hero-inner { position: relative; z-index: 2; width: 100%; }

.ma-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,186,8,0.18); border: 1px solid rgba(255,186,8,0.45);
    color: var(--ma-amber); font-size: 0.73rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 2px;
    padding: 5px 16px; border-radius: 50px; margin-bottom: 1.4rem;
}
.ma-hero-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(2.2rem, 5vw, 4rem);
    font-weight: 800; color: #fff; line-height: 1.12;
    margin-bottom: 1rem;
}
.ma-hero-title em { color: var(--ma-amber); font-style: normal; }
.ma-hero-desc { color: rgba(255,255,255,0.65); font-size: 0.98rem; line-height: 1.9; max-width: 560px; margin-bottom: 2rem; }

.ma-stat-bar {
    display: flex; flex-wrap: wrap; gap: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.12);
    padding-top: 1.5rem; margin-top: 2rem;
}
.ma-stat { text-align: center; }
.ma-stat-num { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 900; color: var(--ma-amber); line-height: 1; }
.ma-stat-label { font-size: 0.75rem; color: rgba(255,255,255,0.5); font-weight: 500; margin-top: 4px; }
.ma-stat-div { width: 1px; background: rgba(255,255,255,0.15); }

/* Right side: "About this platform" card */
.ma-about-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(24px);
    border-radius: 24px;
    padding: 2.5rem;
    height: 100%;
}
.ma-feature-row { display: flex; gap: 14px; margin-bottom: 1.4rem; align-items: flex-start; }
.ma-feat-icon {
    width: 44px; height: 44px; flex-shrink: 0;
    background: rgba(197,160,89,0.15); border: 1px solid rgba(197,160,89,0.3);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    color: var(--ma-amber); font-size: 1rem;
}

/* ── BOOK SPLIT SECTION ────────────────────────── */
.ma-split {
    background: var(--ma-cream);
    display: flex; min-height: 360px;
}
.ma-split-img {
    width: 38%; flex-shrink: 0;
    background: url('/images/ayurveda_book.png') center/cover no-repeat;
}
.ma-split-content {
    flex: 1; padding: 4rem;
    display: flex; flex-direction: column; justify-content: center;
    background: var(--ma-cream);
}
.ma-split-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.6rem, 2.5vw, 2rem);
    font-weight: 800; color: var(--ma-forest); line-height: 1.2;
    margin-bottom: 1rem;
}
.ma-split-title span { color: var(--ma-herb); }
.ma-split-desc { color: #5a6a5c; font-size: 0.92rem; line-height: 1.8; margin-bottom: 1.5rem; }
.ma-split-pill {
    display: inline-flex; align-items: center; gap: 7px;
    background: #fff; border: 1px solid #d4cfc4;
    border-radius: 50px; padding: 7px 16px;
    font-size: 0.81rem; font-weight: 600; color: var(--ma-forest);
}
.ma-split-pill i { color: var(--ma-herb); }

/* ── FILTER TOOLBAR ────────────────────────────── */
.ma-toolbar {
    background: var(--ma-forest);
    padding: 1.6rem 0;
}
.ma-search-pill {
    display: flex; align-items: center;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 50px; padding: 0 18px;
    height: 48px;
    flex: 1; max-width: 420px;
}
.ma-search-pill input {
    background: transparent; border: none; outline: none;
    color: #fff; font-size: 0.9rem; flex: 1;
}
.ma-search-pill input::placeholder { color: rgba(255,255,255,0.45); }
.ma-search-pill i { color: rgba(255,255,255,0.5); margin-right: 10px; }

.ma-filter-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; border-radius: 50px;
    font-size: 0.85rem; font-weight: 600; cursor: pointer;
    border: 1px solid rgba(255,255,255,0.25); color: rgba(255,255,255,0.8);
    background: transparent; transition: all 0.2s;
    white-space: nowrap;
}
.ma-filter-pill:hover, .ma-filter-pill.active {
    background: rgba(255,255,255,0.15);
    border-color: rgba(255,255,255,0.5); color: #fff;
}
.ma-filter-pill.active-online { background: rgba(13,110,253,0.25); border-color: rgba(13,110,253,0.6); color: #6eabff; }
.ma-filter-pill.active-offline { background: rgba(255,186,8,0.2); border-color: rgba(255,186,8,0.5); color: var(--ma-amber); }
.ma-filter-pill.active-all { background: rgba(29,92,66,0.4); border-color: rgba(29,92,66,0.8); color: #7dd3a8; }

/* ── DOCTOR CARDS ──────────────────────────────── */
.ma-cards-section { background: var(--ma-parch); padding: 4rem 0 6rem; }

.ma-doc-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e8e2d6;
    overflow: hidden;
    height: 100%;
    display: flex; flex-direction: column;
    box-shadow: 0 4px 14px rgba(12,59,46,0.06);
    transition: all 0.3s ease;
}
.ma-doc-card:hover {
    transform: translateY(-7px);
    border-color: var(--ma-gold);
    box-shadow: 0 18px 40px rgba(12,59,46,0.13);
}

.ma-card-top {
    background: linear-gradient(135deg, var(--ma-forest), var(--ma-sage));
    padding: 1.8rem 1.5rem 1.4rem;
    display: flex; align-items: center; gap: 16px;
    position: relative;
}
.ma-card-avatar {
    width: 68px; height: 68px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.12);
    overflow: hidden; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.ma-card-avatar img { width: 100%; height: 100%; object-fit: cover; }
.ma-card-name { color: #fff; font-weight: 800; font-size: 0.98rem; margin-bottom: 2px; }
.ma-card-spec { color: rgba(255,255,255,0.6); font-size: 0.78rem; }
.ma-card-exp {
    position: absolute; top: 12px; right: 12px;
    background: rgba(255,186,8,0.2); border: 1px solid rgba(255,186,8,0.4);
    color: var(--ma-amber); font-size: 0.65rem; font-weight: 700;
    padding: 3px 9px; border-radius: 50px;
}
.ma-type-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 0.68rem; font-weight: 700; padding: 3px 10px; border-radius: 50px; margin-top: 5px;
}

.ma-card-body { padding: 1.4rem 1.5rem; flex: 1; display: flex; flex-direction: column; }
.ma-info-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
.ma-info-icon { width: 26px; height: 26px; border-radius: 7px; background: #e8f5e9; color: var(--ma-sage); display: flex; align-items: center; justify-content: center; font-size: 0.72rem; flex-shrink: 0; }

/* Timing blocks */
.timing-block {
    border-radius: 12px; padding: 10px 12px; margin-bottom: 8px;
    border: 1px solid;
}
.timing-block.offline { background: #f0fdf4; border-color: #bbf7d0; }
.timing-block.online  { background: #eff6ff; border-color: #bfdbfe; }
.timing-block.na      { background: #f8f8f8; border-color: #e5e7eb; opacity: 0.6; }
.timing-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
.timing-time { font-size: 0.88rem; font-weight: 700; margin-top: 2px; }

.ma-book-btn {
    background: linear-gradient(135deg, var(--ma-forest) 0%, var(--ma-sage) 100%);
    color: #fff; border: none; border-radius: 12px; padding: 11px;
    font-weight: 700; font-size: 0.88rem; width: 100%;
    transition: all 0.2s; cursor: pointer; text-decoration: none; display: block; text-align: center;
}
.ma-book-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(12,59,46,0.25); color: #fff; }

/* Reveal animation */
.reveal { opacity: 0; transform: translateY(22px); transition: all 0.55s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
</style>

{{-- ═══ MEDITATION HERO ══════════════════════════ --}}
<section class="ma-hero">
    <div class="ma-hero-bg"></div>
    <div class="ma-hero-overlay"></div>
    <div class="ma-hero-inner py-5">
        <div class="container">
            <div class="row align-items-center g-5">

                {{-- Left: headline & stats --}}
                <div class="col-lg-7">
                    <div class="ma-eyebrow">
                        <i class="fas fa-spa"></i> Ayurvedic Wellness Platform
                    </div>
                    <h1 class="ma-hero-title">
                        Ancient Wisdom.<br>
                        <em>Modern Healing.</em>
                    </h1>
                    <p class="ma-hero-desc">
                        We connect you with verified Ayurvedic practitioners for in-clinic and online consultations,
                        authentic herbal medicines from licensed pharmacies, and ancient wellness guidance —
                        all in one trusted platform rooted in 5000 years of healing tradition.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-2">
                        <a href="{{ route('doctors.index') }}" style="background:linear-gradient(135deg,var(--ma-amber),#d4900c);color:#072a21;font-weight:800;padding:13px 30px;border-radius:50px;font-size:0.95rem;text-decoration:none;display:inline-flex;align-items:center;gap:9px;box-shadow:0 8px 22px rgba(255,186,8,0.3);">
                            <i class="fas fa-calendar-check"></i> Book a Consultation
                        </a>
                        <a href="{{ route('products.index') }}" style="border:2px solid rgba(255,255,255,0.35);color:#fff;padding:12px 26px;border-radius:50px;font-size:0.92rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s;">
                            <i class="fas fa-leaf"></i> Explore Herbs
                        </a>
                    </div>

                    <div class="ma-stat-bar">
                        <div class="ma-stat">
                            <div class="ma-stat-num">{{ $doctors->count() }}</div>
                            <div class="ma-stat-label">Verified Vaidyas</div>
                        </div>
                        <div class="ma-stat-div"></div>
                        <div class="ma-stat">
                            <div class="ma-stat-num">{{ $doctors->filter(fn($d) => strtolower($d->consultation_type ?? '') === 'online' || strtolower($d->consultation_type ?? '') === 'both' || !empty($d->online_available_time))->count() }}</div>
                            <div class="ma-stat-label">Online Doctors</div>
                        </div>
                        <div class="ma-stat-div"></div>
                        <div class="ma-stat">
                            <div class="ma-stat-num">14</div>
                            <div class="ma-stat-label">Kerala Districts</div>
                        </div>
                        <div class="ma-stat-div"></div>
                        <div class="ma-stat">
                            <div class="ma-stat-num">5K+</div>
                            <div class="ma-stat-label">Years of Wisdom</div>
                        </div>
                    </div>
                </div>

                {{-- Right: about platform card --}}
                <div class="col-lg-5">
                    <div class="ma-about-card">
                        <h4 style="color:#fff;font-family:'Playfair Display',serif;font-size:1.15rem;margin-bottom:1.6rem;border-bottom:1px solid rgba(255,255,255,0.1);padding-bottom:1rem;">
                            🌿 About This Platform
                        </h4>
                        <div class="ma-feature-row">
                            <div class="ma-feat-icon"><i class="fas fa-user-md"></i></div>
                            <div>
                                <div style="color:#fff;font-weight:700;font-size:0.88rem;">Doctor Consultations</div>
                                <div style="color:rgba(255,255,255,0.45);font-size:0.78rem;margin-top:3px;">Book online video or in-person clinic visits with BAMS & MD certified Vaidyas across Kerala.</div>
                            </div>
                        </div>
                        <div class="ma-feature-row">
                            <div class="ma-feat-icon"><i class="fas fa-flask"></i></div>
                            <div>
                                <div style="color:#fff;font-weight:700;font-size:0.88rem;">Herbal Pharmacy</div>
                                <div style="color:rgba(255,255,255,0.45);font-size:0.78rem;margin-top:3px;">GMP-licensed Ayurvedic products — oils, churnas, supplements — sourced directly from verified pharmacies.</div>
                            </div>
                        </div>
                        <div class="ma-feature-row">
                            <div class="ma-feat-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div>
                                <div style="color:#fff;font-weight:700;font-size:0.88rem;">Flexible Scheduling</div>
                                <div style="color:rgba(255,255,255,0.45);font-size:0.78rem;margin-top:3px;">View live doctor schedules, choose your preferred slot, and get instant booking confirmation.</div>
                            </div>
                        </div>
                        <div class="ma-feature-row" style="margin-bottom:0;">
                            <div class="ma-feat-icon"><i class="fas fa-video"></i></div>
                            <div>
                                <div style="color:#fff;font-weight:700;font-size:0.88rem;">Google Meet Integration</div>
                                <div style="color:rgba(255,255,255,0.45);font-size:0.78rem;margin-top:3px;">Online appointments generate an instant Google Meet link — secure, private, from anywhere.</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ═══ BOOK / ANCIENT WISDOM SPLIT ══════════════ --}}
<div class="ma-split d-none d-md-flex">
    <div class="ma-split-img"></div>
    <div class="ma-split-content">
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(79,119,45,0.1);border:1px solid rgba(79,119,45,0.25);color:var(--ma-herb);font-size:0.73rem;font-weight:700;text-transform:uppercase;letter-spacing:2px;padding:4px 14px;border-radius:50px;margin-bottom:1rem;width:fit-content;">
            <i class="fas fa-book-open"></i> Rooted in Tradition
        </div>
        <h2 class="ma-split-title">
            Doctor Consultation<br>
            <span>Timings &amp; Availability</span>
        </h2>
        <p class="ma-split-desc">
            Our registered Vaidyas offer both in-clinic consultations at their registered hospitals 
            and live video consultations via Google Meet. Browse doctor profiles below, check their 
            available slots, and book your appointment directly from this page.
        </p>
        <div class="d-flex flex-wrap gap-2">
            <span class="ma-split-pill"><i class="fas fa-clinic-medical"></i> In-Clinic Visits</span>
            <span class="ma-split-pill"><i class="fas fa-video"></i> Online Video Calls</span>
            <span class="ma-split-pill"><i class="fas fa-map-marker-alt"></i> 14 Districts</span>
            <span class="ma-split-pill"><i class="fas fa-check-circle"></i> Instant Booking</span>
        </div>
    </div>
</div>

{{-- ═══ FILTER TOOLBAR ════════════════════════════ --}}
<div class="ma-toolbar">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <div class="ma-search-pill">
                <i class="fas fa-search"></i>
                <input type="text" id="doctorSearchInput" placeholder="Search doctor by name, category or district…">
                <button id="clearSearchBtn" style="background:none;border:none;color:rgba(255,255,255,0.4);display:none;cursor:pointer;"><i class="fas fa-times"></i></button>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button class="ma-filter-pill filter-type-btn active" data-filter="all">
                    <i class="fas fa-user-md"></i> All Doctors
                </button>
                <button class="ma-filter-pill filter-type-btn" data-filter="online">
                    <i class="fas fa-video"></i> Online
                </button>
                <button class="ma-filter-pill filter-type-btn" data-filter="offline">
                    <i class="fas fa-clinic-medical"></i> Offline
                </button>
                <button class="ma-filter-pill filter-type-btn" data-filter="both">
                    <i class="fas fa-star"></i> Both
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ═══ DOCTOR SCHEDULE CARDS ═════════════════════ --}}
<section class="ma-cards-section">
    <div class="container">
        <div class="row g-4" id="doctorsContainer">
            @forelse($doctors as $doctor)
            @php
                $constype = strtolower($doctor->consultation_type ?? 'both');
                $hasOnline = ($constype === 'online' || $constype === 'both' || !empty($doctor->online_available_time));
                $hasOffline = ($constype === 'offline' || $constype === 'both' || !empty($doctor->available_time));
                $filterTag = 'both';
                if ($hasOnline && !$hasOffline) $filterTag = 'online';
                elseif ($hasOffline && !$hasOnline) $filterTag = 'offline';
            @endphp
            <div class="col-md-6 col-lg-4 doctor-card-wrapper reveal"
                 data-name="{{ strtolower($doctor->name) }}"
                 data-category="{{ strtolower($doctor->specialization_category ?? '') }}"
                 data-district="{{ strtolower($doctor->district->name ?? '') }}"
                 data-hospital="{{ strtolower($doctor->hospital->name ?? '') }}"
                 data-type="{{ $filterTag }}"
                 data-has-online="{{ $hasOnline ? 'true' : 'false' }}"
                 data-has-offline="{{ $hasOffline ? 'true' : 'false' }}">
                <div class="ma-doc-card">

                    {{-- Card Top --}}
                    <div class="ma-card-top">
                        <span class="ma-card-exp"><i class="fas fa-award me-1"></i>{{ $doctor->experience ?? 5 }}+ Yrs</span>
                        <div class="ma-card-avatar">
                            @if($doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="Dr. {{ $doctor->name }}">
                            @else
                                <i class="fas fa-user-md fa-xl" style="color:rgba(255,255,255,0.7);"></i>
                            @endif
                        </div>
                        <div>
                            <div class="ma-card-name">Dr. {{ $doctor->name }}</div>
                            <div class="ma-card-spec">{{ $doctor->specialization_category ?? 'Ayurveda Specialist' }}</div>
                            @if($hasOnline && $hasOffline)
                                <span class="ma-type-badge" style="background:rgba(29,92,66,0.3);color:#7dd3a8;border:1px solid rgba(29,92,66,0.5);">
                                    <i class="fas fa-check-circle"></i> Online &amp; Offline
                                </span>
                            @elseif($hasOnline)
                                <span class="ma-type-badge" style="background:rgba(13,110,253,0.25);color:#6eabff;border:1px solid rgba(13,110,253,0.4);">
                                    <i class="fas fa-video"></i> Online Only
                                </span>
                            @else
                                <span class="ma-type-badge" style="background:rgba(255,186,8,0.2);color:#ffba08;border:1px solid rgba(255,186,8,0.4);">
                                    <i class="fas fa-clinic-medical"></i> Offline Only
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="ma-card-body">
                        @if($doctor->qualification)
                        <div class="ma-info-row">
                            <div class="ma-info-icon"><i class="fas fa-graduation-cap"></i></div>
                            <span style="font-size:0.82rem;color:#5a6a5c;">{{ $doctor->qualification }}</span>
                        </div>
                        @endif
                        <div class="ma-info-row">
                            <div class="ma-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <span style="font-size:0.82rem;color:#5a6a5c;">
                                {{ $doctor->district->name ?? 'Kerala' }}
                                @if($doctor->current_location) · {{ $doctor->current_location }} @endif
                            </span>
                        </div>
                        @if($doctor->hospital)
                        <div class="ma-info-row" style="margin-bottom:1rem;">
                            <div class="ma-info-icon"><i class="fas fa-hospital-alt"></i></div>
                            <span style="font-size:0.82rem;color:#5a6a5c;">{{ $doctor->hospital->name }}</span>
                        </div>
                        @endif

                        {{-- Timing Blocks --}}
                        <div class="mb-3">
                            <div class="timing-block {{ $hasOffline ? 'offline' : 'na' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="timing-label {{ $hasOffline ? 'text-success' : 'text-muted' }}">
                                        <i class="fas fa-clinic-medical me-1"></i> In-Clinic
                                    </span>
                                    @if($hasOffline)
                                        <span style="background:#16a34a;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:50px;">Available</span>
                                    @else
                                        <span style="background:#9ca3af;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:50px;">N/A</span>
                                    @endif
                                </div>
                                <div class="timing-time {{ $hasOffline ? 'text-success' : 'text-muted' }}">
                                    {{ $doctor->available_time ?? ($hasOffline ? '09:00 AM – 01:00 PM' : 'Not Available') }}
                                </div>
                            </div>
                            <div class="timing-block {{ $hasOnline ? 'online' : 'na' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="timing-label {{ $hasOnline ? 'text-primary' : 'text-muted' }}">
                                        <i class="fas fa-video me-1"></i> Video Call
                                    </span>
                                    @if($hasOnline)
                                        <span style="background:#1d4ed8;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:50px;">Google Meet</span>
                                    @else
                                        <span style="background:#9ca3af;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:50px;">N/A</span>
                                    @endif
                                </div>
                                <div class="timing-time {{ $hasOnline ? 'text-primary' : 'text-muted' }}">
                                    {{ $doctor->online_available_time ?? ($hasOnline ? '04:00 PM – 07:00 PM' : 'Not Available') }}
                                </div>
                            </div>
                        </div>

                        {{-- Fee + Book --}}
                        <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between" style="border-color:#f0ece4 !important;">
                            <div>
                                <div style="font-size:0.72rem;color:#8a9a8b;">Consultation Fee</div>
                                <div style="font-size:1.15rem;font-weight:800;color:var(--ma-forest);">₹{{ number_format($doctor->consultation_fee ?? 300) }}</div>
                            </div>
                            @auth
                                <a href="{{ route('bookings.create', $doctor->id) }}" class="ma-book-btn" style="width:auto;padding:10px 22px;">
                                    <i class="fas fa-calendar-check me-2"></i>Book Slot
                                </a>
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('bookings.create', $doctor->id)) }}" class="ma-book-btn" style="width:auto;padding:10px 22px;">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-user-md fa-4x mb-4" style="color:#c8bfaf;"></i>
                    <h5 style="color:var(--ma-forest);">No Doctors Available</h5>
                    <p class="text-muted small">There are currently no doctors registered in the system.</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- No Search Results --}}
        <div id="noResultsState" class="text-center py-5" style="display:none;">
            <i class="fas fa-search fa-3x mb-3" style="color:#c8bfaf;"></i>
            <h5 style="color:var(--ma-forest);font-weight:700;">No Matching Doctors Found</h5>
            <p class="text-muted small">Try adjusting your search or switching the filter.</p>
            <button id="resetFiltersBtn" style="background:var(--ma-forest);color:#fff;border:none;padding:10px 26px;border-radius:50px;font-weight:700;cursor:pointer;font-size:0.88rem;margin-top:8px;">
                <i class="fas fa-redo me-2"></i>Reset Filters
            </button>
        </div>
    </div>
</section>

<script>
// Scroll reveal
const reveals = document.querySelectorAll('.reveal');
new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); } });
}, { threshold: 0.08 }).observe && reveals.forEach(r => {
    new IntersectionObserver(([entry]) => {
        if(entry.isIntersecting) { entry.target.classList.add('visible'); }
    }, { threshold: 0.08 }).observe(r);
});

// Filter logic
document.addEventListener('DOMContentLoaded', function () {
    const searchInput    = document.getElementById('doctorSearchInput');
    const clearBtn       = document.getElementById('clearSearchBtn');
    const filterBtns     = document.querySelectorAll('.filter-type-btn');
    const doctorCards    = document.querySelectorAll('.doctor-card-wrapper');
    const noResultsState = document.getElementById('noResultsState');
    const resetBtn       = document.getElementById('resetFiltersBtn');

    let currentFilter = 'all';
    let searchQuery = '';

    function filterDoctors() {
        let visible = 0;
        doctorCards.forEach(card => {
            const name = card.dataset.name || '';
            const cat  = card.dataset.category || '';
            const dist = card.dataset.district || '';
            const hosp = card.dataset.hospital || '';
            const hasOnline  = card.dataset.hasOnline === 'true';
            const hasOffline = card.dataset.hasOffline === 'true';

            const matchSearch = !searchQuery || name.includes(searchQuery) || cat.includes(searchQuery) || dist.includes(searchQuery) || hosp.includes(searchQuery);
            let matchType = true;
            if (currentFilter === 'online')  matchType = hasOnline;
            if (currentFilter === 'offline') matchType = hasOffline;
            if (currentFilter === 'both')    matchType = hasOnline && hasOffline;

            if (matchSearch && matchType) { card.style.display = ''; visible++; }
            else { card.style.display = 'none'; }
        });
        if (noResultsState) noResultsState.style.display = visible === 0 && doctorCards.length > 0 ? 'block' : 'none';
    }

    if (searchInput) {
        searchInput.addEventListener('input', e => {
            searchQuery = e.target.value.toLowerCase().trim();
            if (clearBtn) clearBtn.style.display = searchQuery ? 'inline-block' : 'none';
            filterDoctors();
        });
    }
    if (clearBtn) clearBtn.addEventListener('click', () => { searchInput.value = ''; searchQuery = ''; clearBtn.style.display = 'none'; filterDoctors(); });

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => { b.classList.remove('active','active-all','active-online','active-offline'); });
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            if (currentFilter === 'all') this.classList.add('active-all');
            if (currentFilter === 'online') this.classList.add('active-online');
            if (currentFilter === 'offline') this.classList.add('active-offline');
            filterDoctors();
        });
    });

    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (searchInput) { searchInput.value = ''; searchQuery = ''; }
            if (clearBtn) clearBtn.style.display = 'none';
            currentFilter = 'all';
            filterBtns.forEach(b => { b.classList.remove('active','active-all','active-online','active-offline'); if(b.dataset.filter==='all') b.classList.add('active','active-all'); });
            filterDoctors();
        });
    }
});
</script>
@endsection
