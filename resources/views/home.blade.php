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
    <!-- Hero Slider -->
    <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner rounded shadow-sm">
            <div class="carousel-item active">
                <div style="background: linear-gradient(135deg, #2d6a4f, #1b4332); height: 400px; display: flex; align-items: center; justify-content: center; color: white; text-align: center;">
                    <div>
                        <h1 class="display-3 fw-bold">Natural Healing</h1>
                        <p class="lead">Discover the power of Ayurveda</p>
                        <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg mt-3 fw-bold">Shop Medicines</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div style="background: linear-gradient(135deg, #40916c, #2d6a4f); height: 400px; display: flex; align-items: center; justify-content: center; color: white; text-align: center;">
                    <div>
                        <h1 class="display-3 fw-bold">Holistic Wellness</h1>
                        <p class="lead">Balance your mind, body, and soul</p>
                        <a href="{{ route('doctors.index') }}" class="btn btn-light btn-lg mt-3 fw-bold text-success">Book a Doctor</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div style="background: linear-gradient(135deg, #d4a373, #a98467); height: 400px; display: flex; align-items: center; justify-content: center; color: white; text-align: center;">
                    <div>
                        <h1 class="display-3 fw-bold">Pure Ingredients</h1>
                        <p class="lead">Sourced from nature's best</p>
                        <a href="{{ route('products.index') }}" class="btn btn-dark btn-lg mt-3 fw-bold border-0" style="background-color: #582f0e;">Browse Wellness</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Features Section -->
    <div class="container mb-5">
        <div class="row g-4 text-center">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm p-5 hover-lift">
                    <div class="mb-4">
                        <i class="fas fa-pills fa-4x text-success"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Ayurvedic Products</h2>
                    <p class="text-muted mb-4">Explore our curated collection of authentic Ayurvedic medicines, wellness products, and herbal supplements.</p>
                    <div class="mt-auto">
                        <a href="{{ route('products.index') }}" class="btn btn-success btn-lg px-5">View All Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm p-5 hover-lift">
                    <div class="mb-4">
                        <i class="fas fa-user-md fa-4x text-success"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Expert Consultations</h2>
                    <p class="text-muted mb-4">Connect with certified Ayurvedic practitioners for personalized health guidance and treatments.</p>
                    <div class="mt-auto">
                        <a href="{{ route('doctors.index') }}" class="btn btn-outline-success btn-lg px-5">Book a Doctor</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Bottom Advertisements Section -->
    @if(isset($advertisements) && $advertisements->count() > 0)
    <div class="fixed-bottom-banner shadow z-3 border-top">
        <div id="bottomAdCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner" style="height: 80px;">
                @foreach($advertisements as $index => $ad)
                    <div class="carousel-item h-100 w-100 bg-white {{ $index == 0 ? 'active' : '' }}">
                        @if($ad->link)
                            <a href="{{ $ad->link }}" target="_blank" class="d-block w-100 h-100">
                                <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

.fixed-bottom-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100vw;
    background-color: #fff;
    z-index: 1050; /* Stay above normal content */
    height: 80px;
    overflow: hidden;
}

body {
    padding-bottom: 110px; /* Leave space for bottom fixed banner */
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
