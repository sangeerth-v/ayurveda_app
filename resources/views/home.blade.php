@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Ayurveda Management System | Traditional Healing & Clinical Care')

@section('content')

<style>
/* ─── ROOT PALETTE ─────────────────────────────────── */
:root {
    --forest:   #0c3b2e;
    --sage:     #1d5c42;
    --herb:     #4f772d;
    --mint:     #d4edda;
    --parchment:#f9f5ef;
    --gold:     #c5a059;
    --amber:    #ffba08;
    --clay:     #8b4513;
    --cream:    #faf8f4;
}

/* ─── HERO ─────────────────────────────────────────── */
.hero-wrap {
    position: relative;
    min-height: 92vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: var(--forest);
}
.hero-bg-img {
    position: absolute; inset: 0;
    background: url('/images/ayurveda_hero.png') center center / cover no-repeat;
    filter: brightness(0.38) saturate(1.2);
    z-index: 0;
}
.hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(120deg, rgba(12,59,46,0.82) 40%, rgba(12,59,46,0.35) 100%);
    z-index: 1;
}
.hero-content { position: relative; z-index: 2; }

.hero-badge {
    display: inline-block;
    background: rgba(255,186,8,0.18);
    border: 1px solid rgba(255,186,8,0.4);
    color: var(--amber);
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 6px 18px;
    border-radius: 50px;
    margin-bottom: 1.5rem;
}
.hero-title {
    font-family: 'Playfair Display', 'Georgia', serif;
    font-size: clamp(2.2rem, 5vw, 4rem);
    font-weight: 800;
    color: #ffffff;
    line-height: 1.15;
    margin-bottom: 1.5rem;
}
.hero-title .accent { color: var(--amber); }
.hero-quote {
    font-style: italic;
    font-size: 1.2rem;
    color: rgba(255,255,255,0.72);
    margin-bottom: 2rem;
    line-height: 1.7;
    border-left: 3px solid var(--gold);
    padding-left: 1.2rem;
}
.btn-hero-primary {
    background: linear-gradient(135deg, var(--amber) 0%, #e09020 100%);
    color: var(--forest);
    font-weight: 800;
    border: none;
    padding: 14px 32px;
    border-radius: 50px;
    font-size: 0.96rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(255,186,8,0.3);
}
.btn-hero-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 35px rgba(255,186,8,0.45);
    color: var(--forest);
}
.btn-hero-outline {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255,255,255,0.5);
    padding: 13px 30px;
    border-radius: 50px;
    font-size: 0.96rem;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-hero-outline:hover {
    background: rgba(255,255,255,0.12);
    border-color: #fff;
    color: #fff;
}

/* Floating wellness card */
.wellness-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2.5rem;
}
.service-link {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 18px;
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    text-decoration: none;
    color: #fff;
    transition: all 0.25s ease;
    margin-bottom: 12px;
}
.service-link:last-child { margin-bottom: 0; }
.service-link:hover {
    background: rgba(255,255,255,0.12);
    border-color: var(--gold);
    color: #fff;
    transform: translateX(5px);
}
.service-icon {
    width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
}
.service-link .svc-label { font-weight: 700; font-size: 0.95rem; }
.service-link .svc-sub { font-size: 0.78rem; opacity: 0.6; }

/* ─── MARQUEE TRUST BAR ────────────────────────────── */
.trust-bar {
    background: var(--forest);
    color: rgba(255,255,255,0.7);
    padding: 12px 0;
    overflow: hidden;
    white-space: nowrap;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}
.trust-bar .inner { display: inline-block; animation: marquee 30s linear infinite; }
.trust-bar .inner span { margin: 0 2.5rem; }
.trust-bar .dot { color: var(--amber); }
@keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }

/* ─── SECTION TITLES ───────────────────────────────── */
.section-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(79,119,45,0.1); color: var(--herb);
    font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
    padding: 6px 16px; border-radius: 50px; margin-bottom: 1rem;
}
.section-title {
    font-family: 'Playfair Display', 'Georgia', serif;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    color: var(--forest);
    font-weight: 800;
    line-height: 1.2;
}

/* ─── SPLIT PHOTO CONTENT BLOCK ───────────────────── */
.photo-block {
    border-radius: 28px;
    overflow: hidden;
    height: 420px;
    object-fit: cover;
    width: 100%;
    box-shadow: 0 25px 60px rgba(12,59,46,0.18);
}
.photo-block-sm {
    border-radius: 20px;
    overflow: hidden;
    height: 196px;
    object-fit: cover;
    width: 100%;
    box-shadow: 0 12px 30px rgba(12,59,46,0.12);
}

/* ─── QUOTE BANNER ─────────────────────────────────── */
.quote-banner {
    background: linear-gradient(135deg, #0c3b2e 0%, #1d5c42 100%);
    border-radius: 28px;
    padding: 4rem 3rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.quote-banner::before {
    content: '"';
    position: absolute;
    top: -40px; left: 20px;
    font-size: 18rem;
    color: rgba(255,255,255,0.04);
    font-family: Georgia, serif;
    line-height: 1;
    pointer-events: none;
}
.quote-text {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(1.5rem, 3.5vw, 2.4rem);
    color: #fff;
    font-style: italic;
    line-height: 1.4;
    font-weight: 600;
    margin-bottom: 1rem;
}
.quote-sub { color: rgba(255,255,255,0.6); font-size: 0.9rem; }

/* ─── BENEFIT CARDS ────────────────────────────────── */
.benefit-card {
    background: var(--cream);
    border: 1px solid #e5ede6;
    border-radius: 20px;
    padding: 2rem;
    transition: all 0.3s ease;
    height: 100%;
}
.benefit-card:hover {
    transform: translateY(-8px);
    border-color: var(--herb);
    box-shadow: 0 20px 45px rgba(12,59,46,0.1);
}
.benefit-icon-wrap {
    width: 60px; height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--forest) 0%, var(--sage) 100%);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 1.2rem;
    box-shadow: 0 8px 20px rgba(12,59,46,0.25);
}

/* ─── PILL CATEGORY BAR ────────────────────────────── */
.cat-bar {
    background: var(--parchment);
    border-bottom: 1px solid #e5ede0;
    padding: 0.8rem 0;
}
.cat-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 20px;
    background: #fff;
    border: 1px solid #dce8dc;
    border-radius: 50px;
    font-size: 0.87rem;
    font-weight: 600;
    color: var(--forest);
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
}
.cat-pill:hover {
    background: var(--forest);
    color: #fff;
    border-color: var(--forest);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(12,59,46,0.18);
}

/* ─── SCROLL ANIMATION ─────────────────────────────── */
.reveal { opacity: 0; transform: translateY(30px); transition: all 0.7s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }
</style>

<!-- ═══ HERO ═══════════════════════════════════════════ -->
<section class="hero-wrap">
    <div class="hero-bg-img"></div>
    <div class="hero-overlay"></div>

    <div class="container hero-content py-5">
        <div class="row align-items-center g-5">
            <!-- Left Content -->
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="fas fa-leaf me-2"></i>Authentic Ayurvedic Healthcare
                </div>
                <h1 class="hero-title">
                    Ancient Wisdom.<br>
                    <span class="accent">Modern Healing.</span>
                </h1>
                <p class="hero-quote">
                    "Your body knows how to heal.<br>Herbs just guide the way."
                </p>
                <p class="text-white-50 mb-4" style="font-size:1rem;line-height:1.8;max-width:520px;">
                    Connect with verified Ayurvedic practitioners, discover authentic herbal formulations, 
                    and restore balance — all in one trusted platform.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('doctors.index') }}" class="btn-hero-primary text-decoration-none">
                        <i class="fas fa-user-md me-2"></i>Book a Consultation
                    </a>
                    <a href="{{ route('products.index') }}" class="btn-hero-outline text-decoration-none">
                        <i class="fas fa-mortar-pestle me-2"></i>Explore Herbs
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="d-flex flex-wrap gap-4 mt-4 pt-4" style="border-top:1px solid rgba(255,255,255,0.12);">
                    <div class="d-flex align-items-center gap-2 text-white" style="font-size:0.82rem;">
                        <i class="fas fa-check-circle text-warning"></i>
                        <span>100% Certified Practitioners</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-white" style="font-size:0.82rem;">
                        <i class="fas fa-shield-alt text-warning"></i>
                        <span>GMP Licensed Medicines</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-white" style="font-size:0.82rem;">
                        <i class="fas fa-seedling text-warning"></i>
                        <span>Pure Herbal Formulations</span>
                    </div>
                </div>
            </div>

            <!-- Right Quick Access Card -->
            <div class="col-lg-5">
                <div class="wellness-card">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="badge" style="background:rgba(197,160,89,0.2);color:var(--amber);font-size:0.75rem;padding:6px 12px;border-radius:50px;">
                            <i class="fas fa-heartbeat me-1"></i>Wellness Portal
                        </span>
                        <span class="ms-auto" style="color:rgba(255,255,255,0.45);font-size:0.78rem;">
                            <i class="fas fa-shield-alt me-1" style="color:var(--amber);"></i>Verified
                        </span>
                    </div>

                    <h3 style="color:#fff;font-family:'Playfair Display',serif;font-size:1.35rem;margin-bottom:0.4rem;">
                        Healthcare Services
                    </h3>
                    <p style="color:rgba(255,255,255,0.45);font-size:0.83rem;margin-bottom:1.5rem;">
                        Choose your path to holistic wellbeing.
                    </p>

                    <a href="{{ route('doctors.index') }}" class="service-link">
                        <div class="service-icon" style="background:linear-gradient(135deg,#1d5c42,#40916c);">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div>
                            <div class="svc-label">Doctor Consultations</div>
                            <div class="svc-sub">Online video & clinic visits</div>
                        </div>
                        <i class="fas fa-chevron-right ms-auto" style="opacity:0.35;font-size:0.8rem;"></i>
                    </a>

                    <a href="{{ route('products.index') }}" class="service-link">
                        <div class="service-icon" style="background:linear-gradient(135deg,#c5a059,#8b6914);">
                            <i class="fas fa-mortar-pestle"></i>
                        </div>
                        <div>
                            <div class="svc-label">Herbal Pharmacy</div>
                            <div class="svc-sub">Authentic Ayurvedic products</div>
                        </div>
                        <i class="fas fa-chevron-right ms-auto" style="opacity:0.35;font-size:0.8rem;"></i>
                    </a>

                    <a href="{{ route('medical_astrology') }}" class="service-link">
                        <div class="service-icon" style="background:linear-gradient(135deg,#4f772d,#2d6a4f);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <div class="svc-label">Doctor Schedule</div>
                            <div class="svc-sub">View all availability times</div>
                        </div>
                        <i class="fas fa-chevron-right ms-auto" style="opacity:0.35;font-size:0.8rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div style="position:absolute;bottom:28px;left:50%;transform:translateX(-50%);z-index:2;animation:bounce 2s infinite;">
        <i class="fas fa-chevron-down" style="color:rgba(255,255,255,0.35);font-size:1.2rem;"></i>
    </div>
</section>

<!-- ═══ TRUST MARQUEE ═══════════════════════════════════ -->
<div class="trust-bar">
    <div class="inner">
        <span><i class="fas fa-leaf dot me-2"></i>100% Natural Ingredients</span>
        <span><i class="fas fa-certificate dot me-2"></i>GMP Certified Products</span>
        <span><i class="fas fa-user-md dot me-2"></i>BAMS & MD Practitioners</span>
        <span><i class="fas fa-shield-alt dot me-2"></i>Safe & Clinically Tested</span>
        <span><i class="fas fa-map-marker-alt dot me-2"></i>14 Kerala Districts Covered</span>
        <span><i class="fas fa-video dot me-2"></i>Online Video Consultations</span>
        <span><i class="fas fa-truck dot me-2"></i>Authentic Home Delivery</span>
        <!-- duplicate for seamless loop -->
        <span><i class="fas fa-leaf dot me-2"></i>100% Natural Ingredients</span>
        <span><i class="fas fa-certificate dot me-2"></i>GMP Certified Products</span>
        <span><i class="fas fa-user-md dot me-2"></i>BAMS & MD Practitioners</span>
        <span><i class="fas fa-shield-alt dot me-2"></i>Safe & Clinically Tested</span>
        <span><i class="fas fa-map-marker-alt dot me-2"></i>14 Kerala Districts Covered</span>
        <span><i class="fas fa-video dot me-2"></i>Online Video Consultations</span>
        <span><i class="fas fa-truck dot me-2"></i>Authentic Home Delivery</span>
    </div>
</div>

<!-- ═══ QUICK CATEGORY BAR ══════════════════════════════ -->
<div class="cat-bar">
    <div class="container">
        <div class="d-flex gap-3 align-items-center justify-content-center overflow-x-auto py-1" style="scrollbar-width:none;">
            <a href="{{ route('doctors.index') }}" class="cat-pill">🩺 Doctor Consultations</a>
            <a href="{{ route('products.index') }}" class="cat-pill">🌿 Herbal Medicines</a>
            <a href="{{ route('medical_astrology') }}" class="cat-pill">📋 Schedule Directory</a>
        </div>
    </div>
</div>

<!-- ═══ PHOTO + QUOTE SPLIT SECTION ═════════════════════ -->
<section class="py-6" style="background:var(--parchment);padding-top:5rem;padding-bottom:5rem;">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Photos Column -->
            <div class="col-lg-6 reveal">
                <div class="row g-3">
                    <div class="col-12">
                        <img src="/images/herb_hands.png" alt="Hands holding fresh Ayurvedic herbs" class="photo-block" style="object-fit:cover;">
                    </div>
                    <div class="col-6">
                        <img src="/images/mortar_pestle.png" alt="Traditional herb grinding" class="photo-block-sm" style="object-fit:cover;">
                    </div>
                    <div class="col-6">
                        <div class="photo-block-sm d-flex flex-column align-items-center justify-content-center text-center" style="background:linear-gradient(135deg,var(--forest),var(--sage));border-radius:20px;">
                            <div style="color:var(--amber);font-size:2.5rem;font-weight:800;font-family:'Playfair Display',serif;">5000+</div>
                            <div style="color:rgba(255,255,255,0.75);font-size:0.85rem;margin-top:4px;">Years of<br>Ayurvedic Science</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="col-lg-6 reveal" style="transition-delay:0.15s;">
                <div class="section-eyebrow">
                    <i class="fas fa-seedling"></i> Our Philosophy
                </div>
                <h2 class="section-title mb-4">
                    Nature Provides.<br>
                    Science Validates.<br>
                    We Deliver.
                </h2>
                <p class="text-muted mb-4" style="line-height:1.9;font-size:1.02rem;">
                    Rooted in 5,000 years of Ayurvedic tradition, our platform bridges ancient healing 
                    wisdom with modern clinical care. Every doctor is BAMS or MD certified. Every product 
                    is sourced from GMP-licensed, government-approved pharmacies.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:36px;height:36px;border-radius:10px;background:#e8f5e9;color:var(--herb);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <div style="font-weight:700;color:var(--forest);font-size:0.9rem;">BAMS & MD Certified</div>
                                <div style="color:#7a8a7c;font-size:0.8rem;">Verified practitioners only</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:36px;height:36px;border-radius:10px;background:#fff8e1;color:#c5a059;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-flask"></i>
                            </div>
                            <div>
                                <div style="font-weight:700;color:var(--forest);font-size:0.9rem;">Lab-Tested Herbs</div>
                                <div style="color:#7a8a7c;font-size:0.8rem;">Quality assured formulas</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:36px;height:36px;border-radius:10px;background:#e3f2fd;color:#1565c0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-video"></i>
                            </div>
                            <div>
                                <div style="font-weight:700;color:var(--forest);font-size:0.9rem;">Online Video Care</div>
                                <div style="color:#7a8a7c;font-size:0.8rem;">Google Meet consultations</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:36px;height:36px;border-radius:10px;background:#fce4ec;color:#c62828;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <div style="font-weight:700;color:var(--forest);font-size:0.9rem;">14 Districts</div>
                                <div style="color:#7a8a7c;font-size:0.8rem;">All Kerala regions covered</div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('doctors.index') }}" class="btn-hero-primary text-decoration-none" style="display:inline-flex;align-items:center;gap:10px;">
                    <i class="fas fa-calendar-check"></i> Book Consultation Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══ BIG QUOTE BANNER ═════════════════════════════════ -->
<section class="py-5" style="background:#fff;">
    <div class="container">
        <div class="quote-banner reveal">
            <div style="width:60px;height:3px;background:var(--gold);margin:0 auto 2rem;border-radius:2px;"></div>
            <p class="quote-text">
                "Your body knows how to heal.<br>
                <span style="color:var(--amber);">Herbs just guide the way.</span>"
            </p>
            <p class="quote-sub">— Ancient Ayurvedic Philosophy</p>
            <a href="{{ route('products.index') }}" class="btn-hero-primary text-decoration-none mt-4" style="display:inline-block;">
                <i class="fas fa-mortar-pestle me-2"></i>Explore Our Herbs
            </a>
        </div>
    </div>
</section>

<!-- ═══ BENEFIT CARDS ════════════════════════════════════ -->
<section class="py-5" style="background:var(--parchment);padding-top:5rem;padding-bottom:5rem;">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-eyebrow mx-auto mb-3">
                <i class="fas fa-award"></i> Why Choose Us
            </div>
            <h2 class="section-title">Why Millions Trust Our<br>Ayurvedic Ecosystem</h2>
        </div>

        <div class="row g-4">
            <div class="col-sm-6 col-lg-3 reveal">
                <div class="benefit-card">
                    <div class="benefit-icon-wrap">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h5 style="color:var(--forest);font-weight:700;margin-bottom:0.75rem;">Verified Practitioners</h5>
                    <p style="color:#6b7c6b;font-size:0.88rem;line-height:1.7;margin:0;">
                        BAMS & MD Ayurvedic doctors verified with official Medical Council registration (KMC/TNMC).
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 reveal" style="transition-delay:0.1s;">
                <div class="benefit-card">
                    <div class="benefit-icon-wrap" style="background:linear-gradient(135deg,#c5a059,#8b6914);">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h5 style="color:var(--forest);font-weight:700;margin-bottom:0.75rem;">Licensed Pharmacies</h5>
                    <p style="color:#6b7c6b;font-size:0.88rem;line-height:1.7;margin:0;">
                        Herbal medicines from government-licensed, drug-certified pharmaceutical partners.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 reveal" style="transition-delay:0.2s;">
                <div class="benefit-card">
                    <div class="benefit-icon-wrap" style="background:linear-gradient(135deg,#1b4332,#2d6a4f);">
                        <i class="fas fa-video"></i>
                    </div>
                    <h5 style="color:var(--forest);font-weight:700;margin-bottom:0.75rem;">Google Meet Care</h5>
                    <p style="color:#6b7c6b;font-size:0.88rem;line-height:1.7;margin:0;">
                        Seamless video consultations with instant Google Meet links and appointment reminders.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 reveal" style="transition-delay:0.3s;">
                <div class="benefit-card">
                    <div class="benefit-icon-wrap" style="background:linear-gradient(135deg,#40916c,#52b788);">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h5 style="color:var(--forest);font-weight:700;margin-bottom:0.75rem;">14 Kerala Districts</h5>
                    <p style="color:#6b7c6b;font-size:0.88rem;line-height:1.7;margin:0;">
                        Complete regional coverage so patients discover nearby doctors and clinics instantly.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CTA FOOTER BANNER ════════════════════════════════ -->
<section style="background:linear-gradient(135deg,#0c3b2e 0%,#1d5c42 100%);padding:5rem 0;">
    <div class="container text-center">
        <div class="reveal">
            <div class="section-eyebrow mx-auto mb-4" style="background:rgba(255,186,8,0.15);color:var(--amber);border-color:transparent;">
                <i class="fas fa-leaf"></i> Start Your Journey
            </div>
            <h2 style="font-family:'Playfair Display',serif;color:#fff;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;margin-bottom:1.2rem;">
                Begin Your Healing Journey Today
            </h2>
            <p style="color:rgba(255,255,255,0.6);max-width:550px;margin:0 auto 2.5rem;line-height:1.8;">
                Join thousands of patients rediscovering the power of authentic Ayurvedic care on our 
                verified and trusted platform.
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('doctors.index') }}" class="btn-hero-primary text-decoration-none">
                    <i class="fas fa-user-md me-2"></i>Find a Doctor
                </a>
                <a href="{{ route('products.index') }}" class="btn-hero-outline text-decoration-none">
                    <i class="fas fa-shopping-bag me-2"></i>Browse Medicines
                </a>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes bounce { 0%,100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(-10px); } }
.py-6 { padding-top: 5rem; padding-bottom: 5rem; }
</style>

<script>
// Scroll reveal
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.12 });
reveals.forEach(r => observer.observe(r));
</script>

@endsection
