@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<!-- Single Popup Ad Overlay -->
@if(isset($popupAd))
<div id="singleAdPopup" class="adware-overlay" style="display: none;">
    <div class="adware-content d-flex justify-content-center align-items-center">
        <button class="adware-close" onclick="closePopupAd()">&times;</button>
        @if($popupAd->link)
            <a href="{{ $popupAd->link }}" target="_blank">
                <img src="{{ asset('storage/' . $popupAd->image_path) }}" class="img-fluid adware-img shadow-lg rounded" alt="{{ $popupAd->title }}">
            </a>
        @else
            <img src="{{ asset('storage/' . $popupAd->image_path) }}" class="img-fluid adware-img shadow-lg rounded" alt="{{ $popupAd->title }}">
        @endif
    </div>
</div>
@endif

<div class="container-fluid p-0">
    <section class="hero-section overflow-hidden mb-5">
        <div class="hero-overlay"></div>
        <div class="container position-relative py-6">
            <div class="row align-items-center gx-5">
                <div class="col-lg-6 text-white">
                    <span class="badge rounded-pill bg-white text-success mb-3 px-4 py-2 shadow-sm">Verified Ayurveda</span>
                    <h1 class="display-5 fw-bold mb-4">Professional Ayurveda care built for modern wellness.</h1>
                    <p class="lead text-white-75 mb-4">Connect with certified practitioners, source trusted herbal remedies, and manage wellbeing in one elegant platform.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('doctors.index') }}" class="btn btn-light btn-lg text-success px-4">Find a Doctor</a>
                        <a href="{{ route('hospitals.index') }}" class="btn btn-light btn-lg text-success px-4">Find a Hospital</a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="hero-card p-4 p-md-5 rounded-4 shadow-lg bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <span class="badge bg-success text-white rounded-pill px-3 py-2">Trusted platform</span>
                            <span class="text-success fw-semibold">100% authentic</span>
                        </div>
                        <h2 class="h4 fw-bold mb-3">Health made simple</h2>
                        <p class="text-muted mb-4">A seamless digital entry point for consultations, medicines, and preventive care with a calming, premium feel.</p>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="feature-box p-3 rounded-4 bg-success bg-opacity-10">
                                    <p class="mb-1 fw-semibold text-success">Certified Doctors</p>
                                    <h3 class="h5 fw-bold mb-0">150+</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-box p-3 rounded-4 bg-success bg-opacity-10">
                                    <p class="mb-1 fw-semibold text-success">Herbal Products</p>
                                    <h3 class="h5 fw-bold mb-0">145+</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-box p-3 rounded-4 bg-success bg-opacity-10">
                                    <p class="mb-1 fw-semibold text-success">Support</p>
                                    <h3 class="h5 fw-bold mb-0">24/7</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-box p-3 rounded-4 bg-success bg-opacity-10">
                                    <p class="mb-1 fw-semibold text-success">Natural Care</p>
                                    <h3 class="h5 fw-bold mb-0">Authentic</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row text-center g-4">
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-lift">
                    <div class="mb-3 text-success display-6">⚕️</div>
                    <h3 class="h5 fw-bold mb-3">Consult Verified Doctors</h3>
                    <p class="text-muted">Book consultations with certified Ayurveda practitioners and get clear treatment guidance.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-lift">
                    <div class="mb-3 text-success display-6">🌿</div>
                    <h3 class="h5 fw-bold mb-3">Authentic Herbal Remedies</h3>
                    <p class="text-muted">Choose from trusted products sourced directly for healing, immunity, and balance.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-lift">
                    <div class="mb-3 text-success display-6">📱</div>
                    <h3 class="h5 fw-bold mb-3">Modern Digital Care</h3>
                    <p class="text-muted">Experience a polished website flow with fast bookings, clear pricing, and smart wellness tracking.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row align-items-center gx-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">How Ayurveda Connect works</h2>
                <div class="step-card rounded-4 p-4 mb-3 border shadow-sm">
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div class="step-badge bg-success text-white rounded-circle">1</div>
                        <h4 class="mb-0">Search your need</h4>
                    </div>
                    <p class="text-muted mb-0">Find doctors, conditions, or products with clear categories and trusted results.</p>
                </div>
                <div class="step-card rounded-4 p-4 mb-3 border shadow-sm">
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div class="step-badge bg-success text-white rounded-circle">2</div>
                        <h4 class="mb-0">Choose expert care</h4>
                    </div>
                    <p class="text-muted mb-0">Select a verified Ayurveda practitioner or product and review key details before booking.</p>
                </div>
                <div class="step-card rounded-4 p-4 border shadow-sm">
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div class="step-badge bg-success text-white rounded-circle">3</div>
                        <h4 class="mb-0">Receive authentic support</h4>
                    </div>
                    <p class="text-muted mb-0">Enjoy personalized consultation, medicine delivery, and wellness guidance in one place.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 rounded-4 shadow-lg overflow-hidden">
                    <div class="card-body p-5 bg-success bg-opacity-10">
                        <h3 class="fw-bold mb-4">Trusted by thousands across India</h3>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="stat-box rounded-4 bg-white p-4 text-center shadow-sm">
                                    <div class="h2 fw-bold text-success mb-1">150+</div>
                                    <p class="mb-0 text-muted">Doctors</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-box rounded-4 bg-white p-4 text-center shadow-sm">
                                    <div class="h2 fw-bold text-success mb-1">145+</div>
                                    <p class="mb-0 text-muted">Herbal products</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-box rounded-4 bg-white p-4 text-center shadow-sm">
                                    <div class="h2 fw-bold text-success mb-1">98%</div>
                                    <p class="mb-0 text-muted">Positive feedback</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-box rounded-4 bg-white p-4 text-center shadow-sm">
                                    <div class="h2 fw-bold text-success mb-1">Fast</div>
                                    <p class="mb-0 text-muted">Consultation support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($advertisements) && $advertisements->count() > 0)
    <section class="container mb-5">
        <div class="rounded-4 border shadow-sm p-4 bg-white">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="h5 fw-bold mb-1">Featured partners</h3>
                    <p class="text-muted mb-0">Trusted brands and Ayurvedic partners in our network.</p>
                </div>
            </div>
            <div class="row g-3 align-items-center">
                @foreach($advertisements as $ad)
                    <div class="col-6 col-md-3">
                        <div class="partner-logo rounded-4 overflow-hidden border p-2 h-100 d-flex align-items-center justify-content-center bg-light">
                            @if($ad->link)
                                <a href="{{ $ad->link }}" target="_blank" class="d-block w-100 h-100">
                                    <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="img-fluid mx-auto" style="max-height: 70px; object-fit: contain;">
                                </a>
                            @else
                                <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="img-fluid mx-auto" style="max-height: 70px; object-fit: contain;">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

<style>
.hero-section {
    position: relative;
    background: linear-gradient(145deg, #194f35 0%, #266944 45%, #0f3824 100%);
    color: white;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at top left, rgba(255,255,255,0.12), transparent 20%),
                radial-gradient(circle at bottom right, rgba(255,255,255,0.08), transparent 18%);
    pointer-events: none;
}
.hero-section .container {
    position: relative;
    z-index: 1;
}
.hero-card {
    min-height: 320px;
}
.feature-box {
    border: 1px solid rgba(45, 106, 79, 0.15);
}
.step-card {
    background-color: #ffffff;
}
.step-badge {
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}
.stat-box {
    min-height: 130px;
}
.partner-logo {
    min-height: 110px;
}
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 32px rgba(0,0,0,0.08) !important;
}
@media (max-width: 767px) {
    .hero-section {
        border-radius: 0;
    }
}

/* Single Adware Modal CSS */
.adware-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0,0,0,0.85);
    z-index: 999999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
}

.adware-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
}

.adware-img {
    max-height: 85vh;
    object-fit: contain;
}

.adware-close {
    position: absolute;
    top: -20px;
    right: -20px;
    background: #ef3b2d;
    border: none;
    color: white;
    font-size: 24px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 1000000;
    box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.adware-close:hover {
    background: #d32f2f;
}
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script>
    function closePopupAd() {
        const popup = document.getElementById('singleAdPopup');
        if(popup) {
            gsap.to(popup, {opacity: 0, duration: 0.3, onComplete: () => popup.style.display = 'none'});
            @if(isset($popupAd))
            sessionStorage.setItem('popupAdClosed_{{ $popupAd->id }}', 'true');
            @endif
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        @if(isset($popupAd))
        if(!sessionStorage.getItem('popupAdClosed_{{ $popupAd->id }}')) {
            const popup = document.getElementById('singleAdPopup');
            if(popup) {
                popup.style.display = 'flex';
                gsap.fromTo(popup, {opacity: 0}, {opacity: 1, duration: 0.5});
                const content = popup.querySelector('.adware-content');
                if(content) {
                    gsap.fromTo(content, {scale: 0.8, opacity: 0}, {scale: 1, opacity: 1, duration: 0.5, delay: 0.2, ease: "back.out(1.5)"});
                }
            }
        }
        @endif

        // Bottom banner is handled natively by Bootstrap Carousel data attributes
    });
</script>
@endsection
