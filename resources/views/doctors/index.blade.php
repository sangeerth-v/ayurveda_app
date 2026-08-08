@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Find an Ayurvedic Doctor | Online & Offline Consultations')

@section('content')
<style>
:root {
    --forest:#0c3b2e; --sage:#1d5c42; --herb:#4f772d;
    --gold:#c5a059; --amber:#ffba08; --parchment:#f9f5ef; --cream:#faf8f4;
}

/* ─ HERO ─ */
.doc-hero { position:relative; min-height:90vh; display:flex; align-items:center; overflow:hidden; background:var(--forest); }
.doc-hero-bg { position:absolute; inset:0; background:url('/images/doctors_hero.png') center/cover no-repeat; filter:brightness(0.32) saturate(1.2); z-index:0; }
.doc-hero-overlay { position:absolute; inset:0; background:linear-gradient(160deg,rgba(12,59,46,0.90) 40%,rgba(12,59,46,0.55) 100%); z-index:1; }
.doc-hero-content { position:relative; z-index:2; width:100%; }

.hero-eyebrow { display:inline-flex; align-items:center; gap:8px; background:rgba(255,186,8,0.15); border:1px solid rgba(255,186,8,0.4); color:var(--amber); font-size:0.78rem; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; padding:5px 16px; border-radius:50px; margin-bottom:1.5rem; }
.hero-title { font-family:'Playfair Display',Georgia,serif; font-size:clamp(2rem,5vw,3.8rem); font-weight:800; color:#fff; line-height:1.15; margin-bottom:1rem; }
.hero-title .gold { color:var(--amber); }
.hero-subtitle { font-family:'Playfair Display',Georgia,serif; font-size:clamp(1rem,2vw,1.4rem); font-style:italic; color:var(--amber); margin-bottom:1rem; }
.hero-desc { color:rgba(255,255,255,0.65); font-size:1rem; line-height:1.8; max-width:520px; margin-bottom:2rem; }

.btn-cta-gold { background:linear-gradient(135deg,var(--amber) 0%,#e09020 100%); color:var(--forest); font-weight:800; border:none; padding:14px 36px; border-radius:50px; font-size:1rem; transition:all 0.3s ease; box-shadow:0 8px 25px rgba(255,186,8,0.35); text-decoration:none; display:inline-flex; align-items:center; gap:10px; }
.btn-cta-gold:hover { transform:translateY(-3px); box-shadow:0 14px 35px rgba(255,186,8,0.5); color:var(--forest); }
.btn-cta-outline { background:transparent; color:#fff; border:2px solid rgba(255,255,255,0.45); padding:13px 28px; border-radius:50px; font-size:0.96rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all 0.3s ease; }
.btn-cta-outline:hover { background:rgba(255,255,255,0.1); border-color:#fff; color:#fff; }

.hero-trust { display:flex; flex-wrap:wrap; gap:1.5rem; padding-top:1.5rem; border-top:1px solid rgba(255,255,255,0.1); margin-top:2rem; }
.trust-item { display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.8); font-size:0.83rem; }
.trust-item i { color:var(--amber); }

/* ─ FEATURES ─ */
.features-section { background:#0f2419; padding:5rem 0; }
.feat-card { border:1px solid rgba(255,255,255,0.08); border-radius:20px; padding:2rem 1.8rem; background:rgba(255,255,255,0.03); text-align:center; transition:all 0.3s ease; height:100%; }
.feat-card:hover { background:rgba(255,255,255,0.06); border-color:rgba(197,160,89,0.35); transform:translateY(-5px); }
.feat-icon { width:64px; height:64px; background:linear-gradient(135deg,var(--forest),var(--sage)); border-radius:18px; display:flex; align-items:center; justify-content:center; margin:0 auto 1.2rem; font-size:1.5rem; color:var(--amber); box-shadow:0 8px 20px rgba(12,59,46,0.4); }
.feat-title { font-family:'Playfair Display',serif; color:var(--amber); font-size:1.05rem; font-weight:700; margin-bottom:0.6rem; }
.feat-desc { color:rgba(255,255,255,0.55); font-size:0.88rem; line-height:1.7; margin:0; }

/* ─ FILTERS ─ */
.filters-bar { background:var(--parchment); padding:2.5rem 0; border-bottom:1px solid #e5ede0; }
.search-input-wrap { position:relative; }
.search-input-wrap input { height:52px; border-radius:30px; padding-left:48px; padding-right:16px; border:1px solid #c8dfc8; background:#fff; font-size:0.96rem; box-shadow:0 4px 14px rgba(12,59,46,0.06); transition:all 0.2s; width:100%; }
.search-input-wrap input:focus { outline:none; border-color:var(--sage); box-shadow:0 4px 18px rgba(29,92,66,0.15); }
.search-input-wrap .search-icon { position:absolute; left:16px; top:50%; transform:translateY(-50%); color:var(--sage); font-size:1rem; pointer-events:none; }
.filter-pill { display:inline-flex; align-items:center; gap:6px; padding:9px 20px; border-radius:50px; font-size:0.88rem; font-weight:600; cursor:pointer; transition:all 0.25s; background:#fff; border:1px solid #dce8dc; color:var(--forest); white-space:nowrap; text-decoration:none; }
.filter-pill:hover,.filter-pill.active { background:var(--forest); color:#fff; border-color:var(--forest); box-shadow:0 6px 16px rgba(12,59,46,0.2); }
.filter-pill.pill-online.active { background:#0d6efd; border-color:#0d6efd; color:#fff; }
.filter-pill.pill-offline.active { background:#6c757d; border-color:#6c757d; color:#fff; }
.filter-pill.pill-both.active { background:#6f42c1; border-color:#6f42c1; color:#fff; }

/* ─ STEPS ─ */
.steps-section { background:var(--forest); padding:5rem 0; }
.step-num { width:56px; height:56px; border-radius:50%; background:var(--amber); color:var(--forest); font-weight:900; font-size:1.2rem; display:flex; align-items:center; justify-content:center; margin:0 auto 1.2rem; box-shadow:0 8px 20px rgba(255,186,8,0.35); }

/* ─ DOCTOR CARDS ─ */
.doctors-section { background:var(--parchment); padding:5rem 0; }
.doc-card { background:#fff; border-radius:20px; border:1px solid #e5ede6; overflow:hidden; height:100%; transition:all 0.3s cubic-bezier(0.165,0.84,0.44,1); box-shadow:0 4px 16px rgba(12,59,46,0.06); }
.doc-card:hover { transform:translateY(-8px); border-color:var(--gold); box-shadow:0 20px 45px rgba(12,59,46,0.14); }
.doc-card-header { background:linear-gradient(160deg,#0c3b2e 0%,#1d5c42 100%); padding:2rem 1.5rem 1.5rem; text-align:center; position:relative; }
.doc-avatar { width:82px; height:82px; border-radius:50%; border:3px solid rgba(255,255,255,0.35); background:rgba(255,255,255,0.12); overflow:hidden; margin:0 auto 1rem; display:flex; align-items:center; justify-content:center; }
.doc-avatar img { width:100%; height:100%; object-fit:cover; }
.doc-name { color:#fff; font-weight:800; font-size:1.05rem; margin-bottom:2px; }
.doc-spec { color:rgba(255,255,255,0.65); font-size:0.82rem; }
.doc-card-body { padding:1.5rem; display:flex; flex-direction:column; flex-grow:1; }
.doc-info-row { display:flex; align-items:center; gap:10px; margin-bottom:10px; }
.doc-info-icon { width:28px; height:28px; border-radius:8px; background:#e8f5e9; color:var(--sage); display:flex; align-items:center; justify-content:center; font-size:0.78rem; flex-shrink:0; }
.doc-info-text { font-size:0.84rem; color:#5a6a5c; }
.doc-fee { font-size:1.25rem; font-weight:800; color:var(--forest); }
.doc-fee-label { font-size:0.75rem; color:#8a9a8b; }
.btn-book { background:linear-gradient(135deg,var(--forest) 0%,var(--sage) 100%); color:#fff; border:none; width:100%; padding:12px; border-radius:12px; font-weight:700; font-size:0.92rem; transition:all 0.25s; cursor:pointer; text-decoration:none; display:block; text-align:center; }
.btn-book:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(12,59,46,0.25); color:#fff; }
.btn-book-outline { background:transparent; color:var(--forest); border:2px solid var(--forest); width:100%; padding:11px; border-radius:12px; font-weight:700; font-size:0.92rem; transition:all 0.25s; cursor:pointer; text-decoration:none; display:block; text-align:center; }
.btn-book-outline:hover { background:var(--forest); color:#fff; }
.type-badge { position:absolute; top:12px; right:12px; font-size:0.68rem; font-weight:700; padding:4px 10px; border-radius:50px; }
.badge-online { background:#0d6efd; color:#fff; }
.badge-offline { background:rgba(255,255,255,0.2); color:#fff; border:1px solid rgba(255,255,255,0.35); }
.badge-both { background:#6f42c1; color:#fff; }
.location-badge { position:absolute; top:12px; left:12px; font-size:0.65rem; font-weight:700; background:var(--amber); color:var(--forest); padding:3px 10px; border-radius:50px; }
.cat-pill-btn { background:#fff; border:1px solid #dce8dc; color:var(--forest); padding:7px 18px; border-radius:50px; font-size:0.83rem; font-weight:600; cursor:pointer; transition:all 0.2s; white-space:nowrap; }
.cat-pill-btn:hover,.cat-pill-btn.active { background:var(--sage); color:#fff; border-color:var(--sage); }
.section-eyebrow { display:inline-flex; align-items:center; gap:8px; font-size:0.76rem; font-weight:700; text-transform:uppercase; letter-spacing:2px; padding:5px 14px; border-radius:50px; margin-bottom:1rem; }
.reveal { opacity:0; transform:translateY(28px); transition:all 0.65s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
@keyframes bounce { 0%,100%{transform:translateX(-50%) translateY(0);} 50%{transform:translateX(-50%) translateY(-8px);} }
</style>

{{-- HERO --}}
<section class="doc-hero">
    <div class="doc-hero-bg"></div>
    <div class="doc-hero-overlay"></div>
    <div class="doc-hero-content py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-white">
                    <div class="hero-eyebrow"><i class="fas fa-leaf"></i> Expert Ayurvedic Consultations</div>
                    <h1 class="hero-title">
                        Transformative Healing<br>
                        <span class="gold">Wherever You Are</span>
                    </h1>
                    <p class="hero-subtitle">Expert Ayurvedic Online Consultations for Personalized Care</p>
                    <p class="hero-desc">Personalized Ayurvedic care from world-renowned practitioners — accessible from the comfort of your home, at your chosen time.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#doctor-grid" class="btn-cta-gold"><i class="fas fa-calendar-check"></i> Book My Consultation</a>
                        @auth
                            <a href="{{ route('bookings.my') }}" class="btn-cta-outline"><i class="fas fa-history"></i> My Appointments</a>
                        @endauth
                    </div>
                    <div class="hero-trust">
                        <div class="trust-item"><i class="fas fa-check-circle"></i> 100% Certified Practitioners</div>
                        <div class="trust-item"><i class="fas fa-video"></i> Online + In-Person</div>
                        <div class="trust-item"><i class="fas fa-map-marker-alt"></i> 14 Kerala Districts</div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);backdrop-filter:blur(20px);border-radius:24px;padding:2.5rem;">
                        <h4 style="color:#fff;font-family:'Playfair Display',serif;margin-bottom:1.8rem;font-size:1.2rem;">Why Choose Our Vaidyas?</h4>
                        <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:1.2rem;">
                            <div style="width:42px;height:42px;border-radius:12px;background:rgba(197,160,89,0.15);color:var(--amber);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(197,160,89,0.3);"><i class="fas fa-user-md"></i></div>
                            <div><div style="color:#fff;font-weight:700;font-size:0.92rem;">BAMS &amp; MD Certified</div><div style="color:rgba(255,255,255,0.5);font-size:0.8rem;margin-top:2px;">Official medical council verified</div></div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:1.2rem;">
                            <div style="width:42px;height:42px;border-radius:12px;background:rgba(197,160,89,0.15);color:var(--amber);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(197,160,89,0.3);"><i class="fas fa-video"></i></div>
                            <div><div style="color:#fff;font-weight:700;font-size:0.92rem;">Google Meet Video Sessions</div><div style="color:rgba(255,255,255,0.5);font-size:0.8rem;margin-top:2px;">Instant link, secure &amp; private</div></div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:1.2rem;">
                            <div style="width:42px;height:42px;border-radius:12px;background:rgba(197,160,89,0.15);color:var(--amber);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(197,160,89,0.3);"><i class="fas fa-leaf"></i></div>
                            <div><div style="color:#fff;font-weight:700;font-size:0.92rem;">Ancient Siddha Frameworks</div><div style="color:rgba(255,255,255,0.5);font-size:0.8rem;margin-top:2px;">5000+ years of healing science</div></div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:14px;">
                            <div style="width:42px;height:42px;border-radius:12px;background:rgba(197,160,89,0.15);color:var(--amber);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(197,160,89,0.3);"><i class="fas fa-file-medical"></i></div>
                            <div><div style="color:#fff;font-weight:700;font-size:0.92rem;">Personalized Health Plans</div><div style="color:rgba(255,255,255,0.5);font-size:0.8rem;margin-top:2px;">Custom diet, herbs &amp; lifestyle</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="position:absolute;bottom:24px;left:50%;transform:translateX(-50%);z-index:3;animation:bounce 2s infinite;">
        <i class="fas fa-chevron-down" style="color:rgba(255,255,255,0.3);font-size:1.1rem;"></i>
    </div>
</section>

{{-- FEATURES --}}
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-eyebrow" style="background:rgba(255,186,8,0.1);color:var(--amber);margin:0 auto 1rem;"><i class="fas fa-star"></i> Unlock Ancient Secrets</div>
            <h2 style="font-family:'Playfair Display',serif;color:#fff;font-size:clamp(1.8rem,3vw,2.4rem);font-weight:800;">Your Path to <span style="color:var(--amber);">Vibrant Health</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-sm-6 col-lg-3 reveal">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-globe"></i></div>
                    <h5 class="feat-title">World-Class Expertise</h5>
                    <p class="feat-desc">Personalized Ayurvedic guidance from renowned doctors, anywhere, anytime.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 reveal" style="transition-delay:0.1s;">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-route"></i></div>
                    <h5 class="feat-title">Tailored Healing Plans</h5>
                    <p class="feat-desc">Customized diet, herbs, and lifestyle plans for lasting health.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 reveal" style="transition-delay:0.2s;">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-lock"></i></div>
                    <h5 class="feat-title">Convenient Private Consultations</h5>
                    <p class="feat-desc">Easily fit expert care into your schedule, fully online.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 reveal" style="transition-delay:0.3s;">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-heart"></i></div>
                    <h5 class="feat-title">Holistic Wellness</h5>
                    <p class="feat-desc">Addressing root causes through ancient Siddha and Ayurvedic frameworks.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FILTER BAR --}}
<section class="filters-bar" id="doctor-grid">
    <div class="container">
        <div class="text-center mb-4 reveal">
            <div class="section-eyebrow" style="background:rgba(79,119,45,0.1);color:var(--herb);margin:0 auto 0.8rem;"><i class="fas fa-search"></i> Find Your Vaidya</div>
            <h2 style="font-family:'Playfair Display',serif;color:var(--forest);font-size:clamp(1.6rem,2.5vw,2.2rem);font-weight:800;margin:0;">Our Expert Practitioners</h2>
        </div>

        @if(isset($doctors) && $doctors->count() > 0)
        <div class="row g-3 mb-4">
            <div class="col-md-5">
                <div class="search-input-wrap">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                    <input type="text" id="doctorSearch" placeholder="Search by name, specialty…">
                    <button id="clearSearch" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;display:none;"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="col-md-3">
                <select id="districtFilter" style="height:52px;border-radius:30px;border:1px solid #c8dfc8;padding:0 20px;width:100%;background:#fff;font-size:0.9rem;box-shadow:0 4px 14px rgba(12,59,46,0.06);">
                    <option value="all">📍 All Districts</option>
                    <option value="abroad">✈️ Other / Abroad</option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2 h-100 align-items-center flex-wrap">
                    <a href="{{ route('doctors.index') }}" class="filter-pill {{ ($activeType ?? 'all') === 'all' ? 'active' : '' }}">All</a>
                    <a href="{{ route('doctors.index', ['type' => 'Online']) }}" class="filter-pill pill-online {{ ($activeType ?? 'all') === 'Online' ? 'active' : '' }}"><i class="fas fa-video"></i> Online</a>
                    <a href="{{ route('doctors.index', ['type' => 'Offline']) }}" class="filter-pill pill-offline {{ ($activeType ?? 'all') === 'Offline' ? 'active' : '' }}"><i class="fas fa-hospital"></i> Offline</a>
                    <a href="{{ route('doctors.index', ['type' => 'Other']) }}" class="filter-pill pill-both {{ ($activeType ?? 'all') === 'Other' ? 'active' : '' }}"><i class="fas fa-globe-asia"></i> Abroad</a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2 mb-2" id="categoryFilters">
            <button class="cat-pill-btn active" data-cat="all">All Specialties</button>
            @foreach($doctors->pluck('specialization_category')->filter()->unique() as $catName)
                <button class="cat-pill-btn" data-cat="{{ strtolower($catName) }}">{{ $catName }}</button>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- DOCTOR CARDS --}}
<section class="doctors-section">
    <div class="container">
        @if(isset($doctors) && $doctors->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="doctorGrid">
            @foreach($doctors as $doctor)
            <div class="col doctor-card-wrap"
                 data-name="{{ strtolower($doctor->name) }}"
                 data-category="{{ strtolower($doctor->specialization_category ?? '') }}"
                 data-district="{{ $doctor->district_id }}"
                 data-constype="{{ strtolower($doctor->consultation_type ?? 'offline') }}"
                 data-haslocation="{{ !empty($doctor->current_location) ? 'yes' : 'no' }}"
                 data-location="{{ strtolower($doctor->current_location ?? '') }}">
                <div class="doc-card">
                    <div class="doc-card-header">
                        @if($doctor->consultation_type === 'Online')
                            <span class="type-badge badge-online">🎥 Online</span>
                        @elseif($doctor->consultation_type === 'Both')
                            <span class="type-badge badge-both">🌐 Online + Offline</span>
                        @else
                            <span class="type-badge badge-offline">🏥 Offline</span>
                        @endif
                        @if($doctor->current_location)
                            <span class="location-badge"><i class="fas fa-globe-asia me-1"></i>{{ $doctor->current_location }}</span>
                        @endif
                        <div class="doc-avatar">
                            @if($doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="Dr. {{ $doctor->name }}">
                            @else
                                <i class="fas fa-user-md fa-2x" style="color:rgba(255,255,255,0.7);"></i>
                            @endif
                        </div>
                        <div class="doc-name">Dr. {{ $doctor->name }}</div>
                        <div class="doc-spec">{{ $doctor->specialization_category ?? 'Ayurvedic Practitioner' }}</div>
                        @if($doctor->specialization_subcategory)
                            <div style="color:rgba(255,255,255,0.4);font-size:0.72rem;margin-top:3px;">{{ $doctor->specialization_subcategory }}</div>
                        @endif
                    </div>
                    <div class="doc-card-body">
                        @if($doctor->qualification)
                        <div class="doc-info-row">
                            <div class="doc-info-icon"><i class="fas fa-graduation-cap"></i></div>
                            <span class="doc-info-text">{{ $doctor->qualification }}</span>
                        </div>
                        @endif
                        @if($doctor->experience)
                        <div class="doc-info-row">
                            <div class="doc-info-icon"><i class="fas fa-briefcase"></i></div>
                            <span class="doc-info-text">{{ $doctor->experience }} years experience</span>
                        </div>
                        @endif
                        @if($doctor->district)
                        <div class="doc-info-row">
                            <div class="doc-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <span class="doc-info-text">{{ $doctor->district->name }}</span>
                        </div>
                        @endif
                        @if($doctor->available_time)
                        <div class="doc-info-row">
                            <div class="doc-info-icon" style="background:#fff3e0;color:#e65100;"><i class="fas fa-clock"></i></div>
                            <span class="doc-info-text"><strong>In-person:</strong> {{ $doctor->available_time }}</span>
                        </div>
                        @endif
                        @if($doctor->online_available_time && in_array($doctor->consultation_type, ['Online', 'Both']))
                        <div class="doc-info-row">
                            <div class="doc-info-icon" style="background:#e3f2fd;color:#1565c0;"><i class="fas fa-video"></i></div>
                            <span class="doc-info-text" style="color:#1565c0;"><strong>Online:</strong> {{ $doctor->online_available_time }}</span>
                        </div>
                        @endif
                        @if($doctor->current_location)
                        <div class="doc-info-row">
                            <div class="doc-info-icon" style="background:#fff8e1;color:#c5a059;"><i class="fas fa-globe-asia"></i></div>
                            <span class="doc-info-text" style="color:#8b6914;font-weight:600;">{{ $doctor->current_location }}</span>
                        </div>
                        @endif

                        <div class="mt-auto pt-3 border-top" style="border-color:#f0f4f0 !important;">
                            <div class="d-flex justify-content-between align-items-end mb-3">
                                <div>
                                    <div class="doc-fee">₹{{ number_format($doctor->consultation_fee, 0) }}</div>
                                    <div class="doc-fee-label">Consultation Fee</div>
                                </div>
                                <span style="background:#e8f5e9;color:#2d6a4f;padding:5px 12px;border-radius:50px;font-size:0.75rem;font-weight:700;">
                                    <i class="fas fa-check-circle me-1"></i>Verified
                                </span>
                            </div>
                            @if(Auth::guard('web')->check())
                                <a href="{{ route('bookings.create', $doctor->id) }}" class="btn-book">
                                    <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                                </a>
                            @elseif(Auth::guard('admin')->check() || Auth::guard('doctor')->check() || Auth::guard('pharma')->check())
                                <button class="btn-book" style="opacity:0.6;cursor:not-allowed;" disabled>
                                    <i class="fas fa-exclamation-circle me-2"></i>Patient Account Needed
                                </button>
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('bookings.create', $doctor->id)) }}" class="btn-book-outline">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div id="noResults" class="text-center py-5" style="display:none;">
            <i class="fas fa-user-slash fa-3x mb-3" style="color:#c8dfc8;"></i>
            <h5 style="color:var(--forest);">No doctors found matching your criteria.</h5>
            <p class="text-muted small">Try searching by a different name, specialty, or district.</p>
        </div>

        @else
        <div class="text-center py-5">
            <i class="fas fa-user-md fa-4x mb-4" style="color:#c8dfc8;"></i>
            <h4 style="color:var(--forest);">No doctors available at the moment.</h4>
            <p class="text-muted">Please check back soon — our network is growing!</p>
        </div>
        @endif
    </div>
</section>

{{-- 3 STEPS --}}
<section class="steps-section">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-eyebrow" style="background:rgba(255,186,8,0.1);color:var(--amber);margin:0 auto 1rem;"><i class="fas fa-list-ol"></i> Simple Steps</div>
            <h2 style="font-family:'Playfair Display',serif;color:#fff;font-size:clamp(1.6rem,3vw,2.4rem);font-weight:800;">Your Path to<br><span style="color:var(--amber);">Vibrant Health</span></h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4 reveal">
                <div style="padding:2rem;">
                    <div class="step-num">1</div>
                    <h5 style="color:#fff;font-weight:700;margin-bottom:0.6rem;">Uncover Your Imbalances</h5>
                    <p style="color:rgba(255,255,255,0.5);font-size:0.9rem;line-height:1.7;">In-depth analysis of your imbalances and health goals with a certified Vaidya.</p>
                </div>
            </div>
            <div class="col-md-4 reveal" style="transition-delay:0.15s;">
                <div style="padding:2rem;">
                    <div class="step-num">2</div>
                    <h5 style="color:#fff;font-weight:700;margin-bottom:0.6rem;">Receive Your Healing Plan</h5>
                    <p style="color:rgba(255,255,255,0.5);font-size:0.9rem;line-height:1.7;">A personalized Ayurvedic healing blueprint — custom diet, herbs, and lifestyle routines.</p>
                </div>
            </div>
            <div class="col-md-4 reveal" style="transition-delay:0.3s;">
                <div style="padding:2rem;">
                    <div class="step-num">3</div>
                    <h5 style="color:#fff;font-weight:700;margin-bottom:0.6rem;">Celebrate Your Progress</h5>
                    <p style="color:rgba(255,255,255,0.5);font-size:0.9rem;line-height:1.7;">Track progress, adjust your plan, and enjoy every healing milestone with ongoing support.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 reveal">
            <a href="#doctor-grid" class="btn-cta-gold"><i class="fas fa-calendar-check"></i> Book My Consultation Slot</a>
        </div>
    </div>
</section>

<script>
// Scroll reveal
const reveals = document.querySelectorAll('.reveal');
const revealObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); revealObs.unobserve(e.target); } });
}, { threshold: 0.1 });
reveals.forEach(r => revealObs.observe(r));

// Search & filter
(function() {
    const searchInput    = document.getElementById('doctorSearch');
    const clearBtn       = document.getElementById('clearSearch');
    const districtFilter = document.getElementById('districtFilter');
    const catBtns        = document.querySelectorAll('.cat-pill-btn');
    const cards          = document.querySelectorAll('.doctor-card-wrap');
    const noResults      = document.getElementById('noResults');
    let activeCategory   = 'all';

    function filterCards() {
        if (!searchInput) return;
        const query = searchInput.value.trim().toLowerCase();
        const selectedDistrict = districtFilter ? districtFilter.value : 'all';
        if (clearBtn) clearBtn.style.display = query.length ? 'block' : 'none';
        let visible = 0;
        cards.forEach(card => {
            const name = card.dataset.name || '';
            const category = card.dataset.category || '';
            const districtId = card.dataset.district || '';
            const hasLocation = card.dataset.haslocation || 'no';
            const location = card.dataset.location || '';
            const matchSearch = !query || name.includes(query) || category.includes(query) || location.includes(query);
            const matchCategory = activeCategory === 'all' || category === activeCategory;
            let matchDistrict = selectedDistrict === 'all' || districtId === selectedDistrict;
            if (selectedDistrict === 'abroad') matchDistrict = hasLocation === 'yes' || !districtId;
            if (matchSearch && matchCategory && matchDistrict) { card.style.display = ''; visible++; }
            else { card.style.display = 'none'; }
        });
        if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    if (searchInput) searchInput.addEventListener('input', filterCards);
    if (districtFilter) districtFilter.addEventListener('change', filterCards);
    if (clearBtn) clearBtn.addEventListener('click', () => { searchInput.value = ''; filterCards(); searchInput.focus(); });
    catBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            catBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeCategory = btn.dataset.cat;
            filterCards();
        });
    });
    document.querySelectorAll('a[href="#doctor-grid"]').forEach(a => {
        a.addEventListener('click', e => {
            e.preventDefault();
            document.getElementById('doctor-grid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
})();
</script>
@endsection
