@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
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
</div>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
</style>
@endsection
