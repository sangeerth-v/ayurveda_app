@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Ayurveda Management System | Traditional Healing & Clinical Care')

@section('content')
<!-- Single Popup Ad Overlay -->
@if(isset($popupAd))
<div id="singleAdPopup" class="adware-overlay" style="display: none;">
    <div class="adware-content d-flex justify-content-center align-items-center">
        <button class="adware-close" onclick="closePopupAd()">&times;</button>
        @if($popupAd->link)
            <a href="{{ $popupAd->link }}" target="_blank">
                <img src="{{ asset('storage/' . $popupAd->image_path) }}" class="img-fluid adware-img shadow-lg rounded-4" alt="{{ $popupAd->title }}">
            </a>
        @else
            <img src="{{ asset('storage/' . $popupAd->image_path) }}" class="img-fluid adware-img shadow-lg rounded-4" alt="{{ $popupAd->title }}">
        @endif
    </div>
</div>
@endif

<div class="container-fluid p-0">

    <!-- HERO SECTION: ROYAL FOREST & SAGE MINT -->
    <section class="royal-hero py-6 text-white position-relative overflow-hidden">
        <div class="container position-relative z-1">
            <div class="row align-items-center gx-5 py-5">
                <div class="col-lg-7">
                    <span class="badge rounded-pill bg-white bg-opacity-15 text-warning fw-bold px-3 py-2 mb-3 shadow-sm border border-white border-opacity-20">
                        <i class="fas fa-leaf me-1"></i> Authentic Ayurvedic Healthcare Network
                    </span>
                    <h1 class="display-4 fw-bold mb-3" style="line-height: 1.25;">
                        Natural Healing &<br>
                        <span style="color: #ffba08;">Clinical Ayurvedic Care</span>
                    </h1>
                    <p class="lead text-white-75 mb-4 max-w-600" style="font-size: 1.1rem; line-height: 1.7;">
                        Connect with verified Ayurvedic doctors, order authentic herbal formulations, and manage your health seamlessly on one trusted digital platform.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ route('doctors.index') }}" class="btn btn-honey-amber btn-lg px-4 py-3 fw-bold rounded-pill shadow">
                            <i class="fas fa-user-md me-2"></i> Book Doctor Consultation
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold rounded-pill">
                            <i class="fas fa-pills me-2"></i> Order Medicines
                        </a>
                    </div>

                    <!-- Trust Stats -->
                    <div class="d-flex align-items-center gap-4 text-white-50 small pt-3 border-top border-white border-opacity-15">
                        <span class="text-white"><i class="fas fa-check-circle text-warning me-1.5"></i> 100% Certified Practitioners</span>
                        <span class="text-white"><i class="fas fa-shield-alt text-warning me-1.5"></i> GMP Licensed Products</span>
                    </div>
                </div>

                <!-- Right Card: Glassmorphic Quick Access -->
                <div class="col-lg-5 mt-4 mt-lg-0">
                    <div class="glass-card p-4 p-md-5 rounded-4 bg-white shadow-lg text-dark">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-2 fw-semibold">
                                <i class="fas fa-heartbeat me-1"></i> Wellness Portal
                            </span>
                            <span class="text-muted small"><i class="fas fa-shield-alt text-success me-1"></i> Verified</span>
                        </div>

                        <h3 class="h4 fw-bold mb-3 text-dark">Healthcare Services</h3>
                        <p class="text-muted small mb-4">Choose a service below for instant care and consultations.</p>

                        <div class="d-grid gap-3">
                            <a href="{{ route('doctors.index') }}" class="service-tile p-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none text-dark">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="tile-icon bg-success bg-opacity-10 text-success rounded-circle p-2.5">
                                        <i class="fas fa-user-md fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Doctor Appointments</h6>
                                        <small class="text-muted">Online video & clinic visits</small>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>

                            <a href="{{ route('products.index') }}" class="service-tile p-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none text-dark">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="tile-icon bg-success bg-opacity-10 text-success rounded-circle p-2.5">
                                        <i class="fas fa-mortar-pestle fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Herbal Pharmacy</h6>
                                        <small class="text-muted">Authentic Ayurvedic products</small>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>

                            <a href="{{ route('hospitals.index') }}" class="service-tile p-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none text-dark">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="tile-icon bg-success bg-opacity-10 text-success rounded-circle p-2.5">
                                        <i class="fas fa-hospital fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Ayurvedic Hospitals</h6>
                                        <small class="text-muted">Accredited Panchakarma centers</small>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- QUICK CATEGORY BAR -->
    <section class="bg-white py-3 border-bottom shadow-sm">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between gap-3 overflow-x-auto py-1 hide-scrollbar">
                <a href="{{ route('doctors.index') }}" class="pill-btn btn btn-light rounded-pill px-4 py-2 border text-nowrap fw-medium text-dark">
                    🩺 Doctor Consultations
                </a>
                <a href="{{ route('products.index') }}" class="pill-btn btn btn-light rounded-pill px-4 py-2 border text-nowrap fw-medium text-dark">
                    🌿 Herbal Medicines
                </a>
                <a href="{{ route('hospitals.index') }}" class="pill-btn btn btn-light rounded-pill px-4 py-2 border text-nowrap fw-medium text-dark">
                    🏥 Care Hospitals
                </a>
               
            </div>
        </div>
    </section>

    <!-- 3 HEALTHCARE PILLARS -->
    <section class="container py-5">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-2 mb-2 fw-semibold">Services</span>
            <h2 class="fw-bold mb-3" style="color: var(--primary-green);">Complete Ayurvedic Healthcare Services</h2>
            <p class="text-muted">Providing traditional healing, verified practitioners, and authentic herbal remedies in one unified platform.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100 border-0 rounded-4 shadow-sm p-4 hover-lift bg-white">
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-4 p-3 d-inline-block mb-3">
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-dark">Verified Practitioners</h4>
                    <p class="text-muted small mb-4">Connect with accredited BAMS & MD Ayurvedic doctors for online video consultations or clinic appointments.</p>
                    <a href="{{ route('doctors.index') }}" class="fw-bold text-success text-decoration-none mt-auto small">
                        Book Consultation <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100 border-0 rounded-4 shadow-sm p-4 hover-lift bg-white">
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-4 p-3 d-inline-block mb-3">
                        <i class="fas fa-leaf fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-dark">Authentic Medicines</h4>
                    <p class="text-muted small mb-4">Source genuine herbal products, oils, and Rasayanas manufactured by verified pharmaceutical companies.</p>
                    <a href="{{ route('products.index') }}" class="fw-bold text-success text-decoration-none mt-auto small">
                        Shop Medicines <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100 border-0 rounded-4 shadow-sm p-4 hover-lift bg-white">
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-4 p-3 d-inline-block mb-3">
                        <i class="fas fa-hospital-user fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-dark">Integrated Hospitals</h4>
                    <p class="text-muted small mb-4">Explore specialized Panchakarma centers and accredited Ayurvedic hospitals with transparent details.</p>
                    <a href="{{ route('hospitals.index') }}" class="fw-bold text-success text-decoration-none mt-auto small">
                        Explore Hospitals <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS OVERVIEW SECTION -->
    <section class="bg-white py-5 border-top border-bottom">
        <div class="container">
            <div class="row align-items-center gx-5">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-2 mb-2 fw-semibold">Our Impact</span>
                    <h2 class="fw-bold mb-3" style="color: var(--primary-green);">Trusted Network for Ayurvedic Health</h2>
                    <p class="text-muted mb-4">Connecting patients, certified doctors, accredited hospitals, and pharmaceutical partners across India.</p>

                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                            <span class="fw-medium text-dark">SMS & Mobile Notifications on Appointments</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                            <span class="fw-medium text-dark">Google Meet Online Video Consultations</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                            <span class="fw-medium text-dark">Admin Verified Drug Licenses & Certificates</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-4 rounded-4 bg-light text-center border">
                                <h2 class="display-6 fw-bold text-success mb-1">150+</h2>
                                <p class="text-muted small mb-0 fw-medium">Verified Doctors</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-4 rounded-4 bg-light text-center border">
                                <h2 class="display-6 fw-bold text-success mb-1">145+</h2>
                                <p class="text-muted small mb-0 fw-medium">Herbal Products</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-4 rounded-4 bg-light text-center border">
                                <h2 class="display-6 fw-bold text-success mb-1">14</h2>
                                <p class="text-muted small mb-0 fw-medium">Districts Covered</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-4 rounded-4 bg-light text-center border">
                                <h2 class="display-6 fw-bold text-success mb-1">98%</h2>
                                <p class="text-muted small mb-0 fw-medium">Positive Feedback</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- MODALS -->

<!-- Dosha Assessment Modal -->
<!-- <div class="modal fade" id="doshaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-success text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-brain me-2"></i> Dosha Assessment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small">Select your primary physical characteristic to discover your Dosha recommendations:</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-success text-start p-3 rounded-3" onclick="showDoshaResult('Vata')">
                        <strong>Vata (Air & Space)</strong>
                        <div class="small opacity-75">Creative, fast-moving, energetic, dry skin</div>
                    </button>
                    <button class="btn btn-outline-success text-start p-3 rounded-3" onclick="showDoshaResult('Pitta')">
                        <strong>Pitta (Fire & Water)</strong>
                        <div class="small opacity-75">Focused, strong digestion, warm body temperature</div>
                    </button>
                    <button class="btn btn-outline-success text-start p-3 rounded-3" onclick="showDoshaResult('Kapha')">
                        <strong>Kapha (Earth & Water)</strong>
                        <div class="small opacity-75">Calm, steady stamina, strong build, smooth skin</div>
                    </button>
                </div>
                <div id="doshaInfo" class="alert alert-success mt-3 d-none border-0 small"></div>
            </div>
        </div>
    </div>
</div>

Dinacharya Routine Modal -->
<!-- <div class="modal fade" id="dinacharyaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-success text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-clock me-2"></i> Daily Dinacharya Guide</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 small">
                <h6 class="fw-bold text-success mb-1">🌅 Morning Routine (Brahma Muhurta):</h6>
                <p class="text-muted mb-3">Wake up before sunrise, drink warm water, cleanse tongue & practice oil pulling.</p>

                <h6 class="fw-bold text-success mb-1">☀️ Mid-Day Routine:</h6>
                <p class="text-muted mb-3">Eat main meal when digestive fire (Agni) is highest, stay hydrated.</p>

                <h6 class="fw-bold text-success mb-1">🌙 Evening Rejuvenation:</h6>
                <p class="text-muted mb-0">Light dinner before 8 PM, early sleep for vitality & Rasayana rejuvenation.</p>
            </div>
        </div>
    </div>
</div> -->

<style>
.royal-hero {
    background: linear-gradient(135deg, #0c3b2e 0%, #1d5c42 60%, #6d9773 100%);
}

.btn-honey-amber {
    background: linear-gradient(135deg, #ffba08 0%, #f4a261 100%);
    color: #072a21;
    border: none;
    transition: all 0.25s ease;
}

.btn-honey-amber:hover {
    color: #072a21;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 186, 8, 0.35) !important;
}

.glass-card {
    border: 1px solid rgba(109, 151, 115, 0.2);
    border-radius: 24px !important;
}

.service-tile {
    transition: all 0.25s ease;
}

.service-tile:hover {
    background-color: #f4f7f4 !important;
    border-color: #6d9773 !important;
    transform: translateY(-2px);
}

.pill-btn {
    transition: all 0.25s ease;
}

.pill-btn:hover {
    background-color: #0c3b2e !important;
    color: #ffffff !important;
    border-color: #0c3b2e !important;
}

.hover-lift {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.hover-lift:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 35px rgba(12, 59, 46, 0.12) !important;
}

.max-w-600 { max-width: 600px; }
.max-w-700 { max-width: 700px; }

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
</style>

<script>
function showDoshaResult(type) {
    const info = document.getElementById('doshaInfo');
    let text = '';
    if (type === 'Vata') {
        text = '<strong>Vata Recommendation:</strong> Warm sesame oil, Ashwagandha, and calming herbs.';
    } else if (type === 'Pitta') {
        text = '<strong>Pitta Recommendation:</strong> Shatavari, Brahmi, coconut oil, and cooling herbs.';
    } else {
        text = '<strong>Kapha Recommendation:</strong> Trikatu, Tulsi tea, and energizing spices.';
    }
    info.innerHTML = text + '<br><a href="{{ route("products.index") }}" class="btn btn-sm btn-success mt-2">Browse Herbs</a>';
    info.classList.remove('d-none');
}
</script>
@endsection
