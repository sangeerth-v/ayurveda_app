@php $fullWidth = true; @endphp
@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Medical Astrology | Ayurveda Platform')

@section('content')
<style>
/* ════════════════════════════════════════════════
   MEDICAL ASTROLOGY REDESIGNED - MOCKUP STYLE
   Warm parchment backgrounds + deep forest + gold details
   Clean, modern, premium consulting look
   ════════════════════════════════════════════════ */
:root {
    --ma-dark: #072218;
    --ma-forest: #0c3b2e;
    --ma-sage: #1d5c42;
    --ma-herb: #4f772d;
    --ma-gold: #c5a059;
    --ma-amber: #ffba08;
    --ma-light-gray: #f8f9fa;
    --ma-cream: #faf8f5;
    --ma-border: #e8e2d6;
}

body {
    background-color: #fff;
    color: #2e3b2e;
}

.ma-badge-pill {
    display: inline-block;
    background-color: transparent;
    border: 1px solid #d4cfc4;
    color: var(--ma-forest);
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 6px 16px;
    border-radius: 50px;
    margin-bottom: 1.2rem;
}

.ma-main-heading {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 800;
    color: var(--ma-forest);
    line-height: 1.15;
    margin-bottom: 1.5rem;
}

.ma-paragraph {
    color: #5a6a5c;
    font-size: 0.95rem;
    line-height: 1.8;
    margin-bottom: 2rem;
}

/* Custom rounded images */
.ma-rounded-img-wrap {
    border-radius: 32px;
    overflow: hidden;
    height: 100%;
    min-height: 380px;
    box-shadow: 0 10px 30px rgba(12, 59, 46, 0.06);
    border: 1px solid var(--ma-border);
    background-color: var(--ma-light-gray);
}
.ma-rounded-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Metric Stats */
.ma-metric-num {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.2rem, 3.5vw, 3rem);
    font-weight: 900;
    color: var(--ma-forest);
    line-height: 1;
    margin-bottom: 6px;
}
.ma-metric-label {
    font-size: 0.76rem;
    color: #7a8a7a;
    font-weight: 600;
    line-height: 1.3;
}

/* Buttons */
.ma-btn-primary {
    background-color: var(--ma-forest);
    color: #fff !important;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 14px 28px;
    border-radius: 50px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    box-shadow: 0 4px 12px rgba(12, 59, 46, 0.15);
    transition: all 0.2s ease-in-out;
}
.ma-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(12, 59, 46, 0.22);
}

.ma-btn-outline {
    background-color: transparent;
    color: var(--ma-forest) !important;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 13px 28px;
    border-radius: 50px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 2px solid var(--ma-forest);
    transition: all 0.2s ease-in-out;
}
.ma-btn-outline:hover {
    background-color: rgba(12, 59, 46, 0.04);
}

/* Checklists */
.ma-check-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 12px;
}
.ma-check-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--ma-forest);
}
.ma-check-icon {
    width: 22px;
    height: 22px;
    background-color: rgba(79, 119, 45, 0.1);
    color: var(--ma-herb);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    flex-shrink: 0;
}

/* Service Grid Cards */
.ma-service-card {
    background-color: var(--ma-light-gray);
    border: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 20px;
    padding: 2.2rem 1.8rem;
    height: 100%;
    transition: all 0.3s ease;
}
.ma-service-card:hover {
    background-color: #fff;
    border-color: var(--ma-gold);
    box-shadow: 0 10px 24px rgba(12, 59, 46, 0.08);
}
.ma-service-card.primary {
    background-color: var(--ma-forest);
    color: #fff;
    border: none;
}
.ma-service-card.primary:hover {
    box-shadow: 0 12px 28px rgba(12, 59, 46, 0.25);
}

.ma-card-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background-color: #fff;
    color: var(--ma-forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    margin-bottom: 1.4rem;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
}
.ma-service-card.primary .ma-card-icon {
    background-color: rgba(255,255,255,0.15);
    color: #fff;
    box-shadow: none;
}

.ma-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.8rem;
}
.ma-card-text {
    font-size: 0.85rem;
    line-height: 1.6;
    color: #6a7a6c;
}
.ma-service-card.primary .ma-card-text {
    color: rgba(255,255,255,0.7);
}
</style>

{{-- ═══ SECTION 1: HERO / PROFILE INTRO ══════════ --}}
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            {{-- Left column --}}
            <div class="col-lg-7">
                <span class="ma-badge-pill">Chief Astrologer</span>
                <h1 class="ma-main-heading">
                    Meet Dr. {{ $astrologer->name }}
                </h1>
                <p class="ma-paragraph">
                    Dr. {{ $astrologer->name }} is our Chief Medical Astrologer. By combining the natural healing science of Ayurveda with planetary diagnostic insights from Vedic Astrology (Jyotish), we help you uncover health predispositions in your birth chart and suggest lifestyle adaptations to maintain absolute wellness.
                </p>

                <div class="d-flex flex-wrap gap-3 mb-5">
                    @auth
                        <a href="{{ route('bookings.create', $astrologer->id) }}" class="ma-btn-primary">
                            <span>Book Consultation</span> <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(route('bookings.create', $astrologer->id)) }}" class="ma-btn-primary">
                            <span>Login to Book</span> <i class="fas fa-sign-in-alt"></i>
                        </a>
                    @endauth
                    <a href="#offerings-section" class="ma-btn-outline">Explore Timings</a>
                </div>

                {{-- Metrics Row --}}
                <div class="row g-4">
                    <div class="col-4 border-end">
                        <div class="ma-metric-num">{{ $astrologer->experience ?? 15 }}+ Yrs</div>
                        <div class="ma-metric-label">Professional<br>Experience</div>
                    </div>
                    <div class="col-4 border-end ps-4">
                        <div class="ma-metric-num">₹{{ number_format($astrologer->consultation_fee) }}</div>
                        <div class="ma-metric-label">Consultation<br>Fee</div>
                    </div>
                    <div class="col-4 ps-4">
                        <div class="ma-metric-num">100%</div>
                        <div class="ma-metric-label">Personalized<br>Chart Reading</div>
                    </div>
                </div>
            </div>

            {{-- Right column --}}
            <div class="col-lg-5">
                <div class="ma-rounded-img-wrap">
                    @if($astrologer->photo)
                        <img src="{{ asset('storage/' . $astrologer->photo) }}" alt="Dr. {{ $astrologer->name }}">
                    @else
                        <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: var(--ma-sage); background: linear-gradient(135deg, #e8f0e8 0%, #d8e6d8 100%);">
                            <i class="fas fa-user-md fa-7x"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 2: COSMIC HEALTH INSIGHTS ════════ --}}
<section class="py-5" style="background-color: var(--ma-cream);">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            {{-- Left column --}}
            <div class="col-lg-5">
                <div class="ma-rounded-img-wrap" style="min-height: 420px;">
                    <img src="{{ asset('images/astrology_mandala.jpg') }}" alt="Vedic Astrology Mandala illustration">
                </div>
            </div>

            {{-- Right column --}}
            <div class="col-lg-7 ps-lg-5">
                <span class="ma-badge-pill">Astrological Approach</span>
                <h2 class="ma-main-heading" style="font-size: clamp(1.8rem, 3.5vw, 2.5rem);">
                    Unlock planetary insights to restore physical vitality.
                </h2>
                <p class="ma-paragraph">
                    Ayurveda and Vedic Astrology (Jyotish) are twin sciences designed to help humans align with natural cycles. By studying planetary alignments at your time of birth, our Chief Astrologer assesses imbalances in Vata, Pitta, and Kapha and prescribes herbs, diet modifications, and spiritual therapies.
                </p>

                {{-- Checklist Grid --}}
                <div class="ma-check-grid mb-2">
                    <div class="ma-check-item">
                        <div class="ma-check-icon"><i class="fas fa-check"></i></div>
                        <span>Planetary Tridosha Diagnosis</span>
                    </div>
                    <div class="ma-check-item">
                        <div class="ma-check-icon"><i class="fas fa-check"></i></div>
                        <span>Customized Birth Charts</span>
                    </div>
                    <div class="ma-check-item">
                        <div class="ma-check-icon"><i class="fas fa-check"></i></div>
                        <span>Online Google Meet Slots</span>
                    </div>
                    <div class="ma-check-item">
                        <div class="ma-check-icon"><i class="fas fa-check"></i></div>
                        <span>In-Clinic Visit Schedules</span>
                    </div>
                    <div class="ma-check-item">
                        <div class="ma-check-icon"><i class="fas fa-check"></i></div>
                        <span>Natural Herbal Prescriptions</span>
                    </div>
                    <div class="ma-check-item">
                        <div class="ma-check-icon"><i class="fas fa-check"></i></div>
                        <span>Long-term Wellness Support</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: TIMINGS & CARD GRID ══════════ --}}
<section class="py-5 bg-white" id="offerings-section">
    <div class="container py-4">
        {{-- Section Title & Subheading --}}
        <div class="row mb-5 align-items-end g-3">
            <div class="col-md-6">
                <span class="ma-badge-pill" style="margin-bottom:0.8rem;">Timings &amp; Services</span>
                <h2 class="fw-bold text-dark mb-0" style="font-family:'Playfair Display',serif; font-size:clamp(1.8rem, 3vw, 2.3rem); line-height:1.2;">
                    Our Astrology Services &amp; Availability
                </h2>
            </div>
            <div class="col-md-6">
                <p class="text-muted mb-0 small" style="line-height:1.6; max-width:540px;">
                    Review the consultation details, check current timings for online or in-person slots, and schedule your appointment with our Chief Medical Astrologer.
                </p>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div class="row g-4">
            {{-- Card 1: Vedic Chart Analysis (Solid primary color) --}}
            <div class="col-md-4">
                <div class="ma-service-card primary">
                    <div class="ma-card-icon">
                        <i class="fas fa-star-of-life"></i>
                    </div>
                    <h4 class="ma-card-title">Vedic Chart Analysis</h4>
                    <p class="ma-card-text">A deep dive into your birth chart (Janma Kundali) to locate planetary positions affecting your primary organs and energy centers.</p>
                </div>
            </div>

            {{-- Card 2: Tridosha Balancing --}}
            <div class="col-md-4">
                <div class="ma-service-card">
                    <div class="ma-card-icon" style="background-color: rgba(79, 119, 45, 0.1); color: var(--ma-herb);">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4 class="ma-card-title">Tridosha Balancing</h4>
                    <p class="ma-card-text">Correlating your natal planets with Vata, Pitta, and Kapha configurations to design targeted corrective wellness remedies.</p>
                </div>
            </div>

            {{-- Card 3: Online Video Consultation --}}
            <div class="col-md-4">
                <div class="ma-service-card">
                    <div class="ma-card-icon" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                        <i class="fas fa-video"></i>
                    </div>
                    <h4 class="ma-card-title">Online Google Meet</h4>
                    <p class="ma-card-text">
                        Consult via Google Meet from anywhere.
                        @if(in_array($astrologer->consultation_type, ['Online', 'Both']) && $astrologer->online_available_time)
                            <br><strong class="text-dark">Timings: {{ $astrologer->online_available_time }}</strong>
                        @else
                            <br><strong class="text-muted">Not offered online</strong>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Card 4: In-Clinic Visits --}}
            <div class="col-md-4">
                <div class="ma-service-card">
                    <div class="ma-card-icon" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <h4 class="ma-card-title">In-Clinic Consultations</h4>
                    <p class="ma-card-text">
                        In-person visits in {{ $astrologer->district->name ?? 'Kerala' }}. Address: {{ $astrologer->address }}.
                        @if(in_array($astrologer->consultation_type, ['Offline', 'Both']) && $astrologer->available_time)
                            <br><strong class="text-dark">Timings: {{ $astrologer->available_time }}</strong>
                        @else
                            <br><strong class="text-muted">Not offered in-clinic</strong>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Card 5: Herbal Remedies --}}
            <div class="col-md-4">
                <div class="ma-service-card">
                    <div class="ma-card-icon" style="background-color: rgba(255, 193, 7, 0.15); color: #b45309;">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h4 class="ma-card-title">Pharmacy Integration</h4>
                    <p class="ma-card-text">Directly purchase authentic herbal oils, churnas, and formulations prescribed during your session from our verified pharmacy partners.</p>
                </div>
            </div>

            {{-- Card 6: Dashboard Reschedule --}}
            <div class="col-md-4">
                <div class="ma-service-card">
                    <div class="ma-card-icon" style="background-color: rgba(108, 117, 125, 0.1); color: #495057;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4 class="ma-card-title">Flexible Rescheduling</h4>
                    <p class="ma-card-text">Need to change your date or time slot? Easily reschedule or cancel your appointment directly from your patient dashboard menu.</p>
                </div>
            </div>
        </div>

        {{-- Direct Book CTA --}}
        <div class="mt-5 text-center">
            @auth
                <a href="{{ route('bookings.create', $astrologer->id) }}" class="ma-btn-primary" style="padding: 16px 36px;">
                    <span>Schedule Astrology Session Now</span> <i class="fas fa-calendar-check ms-1"></i>
                </a>
            @else
                <a href="{{ route('login') }}?redirect={{ urlencode(route('bookings.create', $astrologer->id)) }}" class="ma-btn-primary" style="padding: 16px 36px;">
                    <span>Login to Schedule Consultation</span> <i class="fas fa-sign-in-alt ms-1"></i>
                </a>
            @endauth
        </div>
    </div>
</section>
@endsection
