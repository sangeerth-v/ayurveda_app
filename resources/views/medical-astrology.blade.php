@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Doctor Timings & Online/Offline Schedules | Ayurveda App')

@section('content')
<!-- Hero Header -->
<div class="position-relative overflow-hidden p-4 p-md-5 text-center text-white mb-4 rounded-4 shadow-lg" 
     style="background: linear-gradient(135deg, #0c3b2e 0%, #1d5c42 50%, #2d7a58 100%);">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: radial-gradient(#ffba08 1px, transparent 1px); background-size: 20px 20px;"></div>
    
    <div class="col-md-10 p-lg-3 mx-auto position-relative" style="z-index: 2;">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="letter-spacing: 1px;">
            ✨ AYURVEDIC DOCTOR SCHEDULES
        </span>
        <h1 class="display-5 fw-bold text-white mb-3" style="font-family: 'Playfair Display', serif;">
            Doctor Consultation Timings & Availability
        </h1>
        <p class="lead text-light opacity-90 mb-4 mx-auto" style="max-width: 750px; font-size: 1.1rem; line-height: 1.7;">
            Explore verified Ayurvedic specialists available for <strong>In-Clinic (Offline)</strong> visits and <strong>Online Video Consultations</strong>. Check daily timings and book your slot seamlessly.
        </p>

        <!-- Doctor Stat Counters -->
        <div class="row g-3 justify-content-center text-dark">
            <div class="col-6 col-md-3">
                <div class="bg-white bg-opacity-95 p-3 rounded-4 shadow-sm backdrop-blur">
                    <div class="h3 fw-bold text-success mb-0">{{ $doctors->count() }}</div>
                    <small class="text-muted fw-semibold">Total Doctors</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="bg-white bg-opacity-95 p-3 rounded-4 shadow-sm backdrop-blur">
                    <div class="h3 fw-bold text-primary mb-0">
                        {{ $doctors->filter(fn($d) => strtolower($d->consultation_type ?? '') === 'online' || strtolower($d->consultation_type ?? '') === 'both' || !empty($d->online_available_time))->count() }}
                    </div>
                    <small class="text-muted fw-semibold">Online Doctors</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="bg-white bg-opacity-95 p-3 rounded-4 shadow-sm backdrop-blur">
                    <div class="h3 fw-bold text-warning mb-0">
                        {{ $doctors->filter(fn($d) => strtolower($d->consultation_type ?? '') === 'offline' || strtolower($d->consultation_type ?? '') === 'both' || !empty($d->available_time))->count() }}
                    </div>
                    <small class="text-muted fw-semibold">Offline Doctors</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <!-- Filter & Search Controls Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 p-3 bg-light">
        <div class="row g-3 align-items-center">
            <!-- Search Box -->
            <div class="col-md-5">
                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden bg-white">
                    <span class="input-group-text bg-white border-0 ps-3 text-success">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="doctorSearchInput" class="form-control border-0 ps-2" placeholder="Search doctor by name, category, or location..." style="font-size: 0.95rem; box-shadow: none;">
                    <button class="btn btn-link text-muted border-0 me-2" id="clearSearchBtn" type="button" style="display:none;" title="Clear Search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Consultation Type Filter Pills -->
            <div class="col-md-7">
                <div class="d-flex gap-2 flex-wrap justify-content-md-end" id="typeFilterGroup">
                    <button type="button" class="btn btn-success rounded-pill px-3 py-2 fw-semibold filter-type-btn active" data-filter="all">
                        <i class="fas fa-user-md me-1"></i> All Doctors
                    </button>
                    <button type="button" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold filter-type-btn" data-filter="online">
                        <i class="fas fa-video me-1"></i> Online Doctors
                    </button>
                    <button type="button" class="btn btn-outline-success rounded-pill px-3 py-2 fw-semibold filter-type-btn" data-filter="offline">
                        <i class="fas fa-hospital-user me-1"></i> Offline Doctors
                    </button>
                    <button type="button" class="btn btn-outline-warning text-dark rounded-pill px-3 py-2 fw-semibold filter-type-btn" data-filter="both">
                        <i class="fas fa-star me-1"></i> Online & Offline
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Grid -->
    <div class="row g-4" id="doctorsContainer">
        @forelse($doctors as $doctor)
            @php
                $constype = strtolower($doctor->consultation_type ?? 'both');
                $hasOnline = ($constype === 'online' || $constype === 'both' || !empty($doctor->online_available_time));
                $hasOffline = ($constype === 'offline' || $constype === 'both' || !empty($doctor->available_time));
                
                $filterTag = 'both';
                if ($hasOnline && !$hasOffline) {
                    $filterTag = 'online';
                } elseif ($hasOffline && !$hasOnline) {
                    $filterTag = 'offline';
                } elseif ($hasOnline && $hasOffline) {
                    $filterTag = 'both';
                }
            @endphp
            <div class="col-md-6 col-lg-4 doctor-card-wrapper" 
                 data-name="{{ strtolower($doctor->name) }}"
                 data-category="{{ strtolower($doctor->specialization_category ?? '') }}"
                 data-district="{{ strtolower($doctor->district->name ?? '') }}"
                 data-hospital="{{ strtolower($doctor->hospital->name ?? '') }}"
                 data-type="{{ $filterTag }}"
                 data-has-online="{{ $hasOnline ? 'true' : 'false' }}"
                 data-has-offline="{{ $hasOffline ? 'true' : 'false' }}">
                
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift overflow-hidden bg-white">
                    <!-- Top Status Bar -->
                    <div class="px-4 pt-3 pb-0 d-flex justify-content-between align-items-center">
                        <span class="badge bg-light text-muted border rounded-pill px-3 py-1 fw-normal small">
                            <i class="fas fa-award text-warning me-1"></i> {{ $doctor->experience ?? 5 }}+ Yrs Exp
                        </span>
                        
                        @if($hasOnline && $hasOffline)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 fw-bold small">
                                <i class="fas fa-check-circle me-1"></i> Online & Offline
                            </span>
                        @elseif($hasOnline)
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 fw-bold small">
                                <i class="fas fa-video me-1"></i> Online Only
                            </span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-50 rounded-pill px-3 py-1 fw-bold small">
                                <i class="fas fa-clinic-medical me-1"></i> Offline Only
                            </span>
                        @endif
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <!-- Doctor Info Header -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="position-relative me-3 flex-shrink-0">
                                <div class="rounded-circle overflow-hidden shadow-sm d-flex align-items-center justify-content-center" 
                                     style="width: 68px; height: 68px; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border: 3px solid #1d5c42;">
                                    @if($doctor->photo)
                                        <img src="{{ asset('storage/' . $doctor->photo) }}" alt="Dr. {{ $doctor->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user-md fa-2x text-success"></i>
                                    @endif
                                </div>
                                <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle" title="Active Practitioner">
                                    <span class="visually-hidden">Active</span>
                                </span>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Dr. {{ $doctor->name }}</h5>
                                <div class="mb-1">
                                    <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-2 py-1 rounded">
                                        {{ $doctor->specialization_category ?? 'Ayurveda Specialist' }}
                                    </span>
                                </div>
                                @if($doctor->qualification)
                                    <small class="text-muted d-block text-truncate" style="max-width: 200px;" title="{{ $doctor->qualification }}">
                                        <i class="fas fa-graduation-cap me-1 text-secondary"></i> {{ $doctor->qualification }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- Location & Hospital -->
                        <div class="p-2 px-3 bg-light rounded-3 small mb-3">
                            <div class="d-flex align-items-center mb-1 text-muted">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <span class="fw-semibold text-dark">{{ $doctor->district->name ?? 'Kerala' }}</span>
                                @if($doctor->current_location)
                                    <span class="ms-1">({{ $doctor->current_location }})</span>
                                @endif
                            </div>
                            @if($doctor->hospital)
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-hospital-alt text-info me-2"></i>
                                    <span class="text-truncate" title="{{ $doctor->hospital->name }}">{{ $doctor->hospital->name }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Consultation Timings Section -->
                        <div class="rounded-3 border p-3 mb-3 bg-body mt-auto">
                            <h6 class="fw-bold small text-uppercase text-muted mb-2 tracking-wider">
                                <i class="far fa-clock me-1 text-warning"></i> Consultation Timings
                            </h6>

                            <!-- Offline Timings -->
                            <div class="p-2 rounded mb-2 {{ $hasOffline ? 'bg-success bg-opacity-10 border border-success border-opacity-25' : 'bg-light text-muted' }}">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold small {{ $hasOffline ? 'text-success' : 'text-muted' }}">
                                        <i class="fas fa-clinic-medical me-1"></i> In-Clinic (Offline)
                                    </span>
                                    @if($hasOffline)
                                        <span class="badge bg-success text-white small" style="font-size: 0.7rem;">Available</span>
                                    @else
                                        <span class="badge bg-secondary text-white small" style="font-size: 0.7rem;">N/A</span>
                                    @endif
                                </div>
                                <div class="small fw-semibold text-dark">
                                    {{ $doctor->available_time ?? ($hasOffline ? '09:00 AM - 01:00 PM' : 'Not Available') }}
                                </div>
                            </div>

                            <!-- Online Timings -->
                            <div class="p-2 rounded {{ $hasOnline ? 'bg-primary bg-opacity-10 border border-primary border-opacity-25' : 'bg-light text-muted' }}">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold small {{ $hasOnline ? 'text-primary' : 'text-muted' }}">
                                        <i class="fas fa-video me-1"></i> Video Call (Online)
                                    </span>
                                    @if($hasOnline)
                                        <span class="badge bg-primary text-white small" style="font-size: 0.7rem;">Google Meet</span>
                                    @else
                                        <span class="badge bg-secondary text-white small" style="font-size: 0.7rem;">N/A</span>
                                    @endif
                                </div>
                                <div class="small fw-semibold text-dark">
                                    {{ $doctor->online_available_time ?? ($hasOnline ? '04:00 PM - 07:00 PM' : 'Not Available') }}
                                </div>
                            </div>
                        </div>

                        <!-- Fee & Booking Action -->
                        <div class="d-flex align-items-center justify-content-between pt-2">
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Consultation Fee</small>
                                <span class="fw-bold text-success fs-5">₹{{ number_format($doctor->consultation_fee ?? 300) }}</span>
                            </div>
                            @auth
                                <a href="{{ route('bookings.create', $doctor->id) }}" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="fas fa-calendar-check me-1"></i> Book Slot
                                </a>
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('bookings.create', $doctor->id)) }}" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="fas fa-calendar-check me-1"></i> Book Slot
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-light rounded-4 shadow-sm d-inline-block text-center" style="max-width: 450px;">
                    <i class="fas fa-user-md fa-4x text-muted mb-3 opacity-50"></i>
                    <h5 class="fw-bold text-dark">No Doctors Available</h5>
                    <p class="text-muted small mb-0">There are currently no doctors registered in the system.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Empty State for JS Search -->
    <div id="noResultsState" class="text-center py-5" style="display: none;">
        <div class="p-4 bg-light rounded-4 d-inline-block text-center shadow-sm" style="max-width: 420px;">
            <i class="fas fa-search fa-3x text-success mb-3 opacity-50"></i>
            <h5 class="fw-bold text-dark mb-2">No Matching Doctors Found</h5>
            <p class="text-muted small mb-3">Try adjusting your search criteria or switching the filter category.</p>
            <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-4" id="resetFiltersBtn">
                Reset Search Filters
            </button>
        </div>
    </div>
</div>

<style>
    .hover-lift {
        transition: transform 0.25s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(12, 59, 46, 0.12) !important;
    }
    .backdrop-blur {
        backdrop-filter: blur(10px);
    }
    .tracking-wider {
        letter-spacing: 0.5px;
    }
    .filter-type-btn {
        transition: all 0.2s ease-in-out;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('doctorSearchInput');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const filterBtns = document.querySelectorAll('.filter-type-btn');
    const doctorCards = document.querySelectorAll('.doctor-card-wrapper');
    const noResultsState = document.getElementById('noResultsState');
    const resetFiltersBtn = document.getElementById('resetFiltersBtn');

    let currentFilter = 'all';
    let searchQuery = '';

    function filterDoctors() {
        let visibleCount = 0;

        doctorCards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const category = card.getAttribute('data-category') || '';
            const district = card.getAttribute('data-district') || '';
            const hospital = card.getAttribute('data-hospital') || '';
            const hasOnline = card.getAttribute('data-has-online') === 'true';
            const hasOffline = card.getAttribute('data-has-offline') === 'true';

            // Match search text
            const matchesSearch = !searchQuery || 
                name.includes(searchQuery) || 
                category.includes(searchQuery) || 
                district.includes(searchQuery) || 
                hospital.includes(searchQuery);

            // Match consultation type filter
            let matchesType = true;
            if (currentFilter === 'online') {
                matchesType = hasOnline;
            } else if (currentFilter === 'offline') {
                matchesType = hasOffline;
            } else if (currentFilter === 'both') {
                matchesType = hasOnline && hasOffline;
            }

            if (matchesSearch && matchesType) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0 && doctorCards.length > 0) {
            noResultsState.style.display = 'block';
        } else {
            noResultsState.style.display = 'none';
        }
    }

    // Search Input listener
    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            searchQuery = e.target.value.toLowerCase().trim();
            if (searchQuery.length > 0) {
                clearSearchBtn.style.display = 'inline-block';
            } else {
                clearSearchBtn.style.display = 'none';
            }
            filterDoctors();
        });
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function () {
            searchInput.value = '';
            searchQuery = '';
            clearSearchBtn.style.display = 'none';
            filterDoctors();
        });
    }

    // Filter Buttons listener
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => {
                b.classList.remove('active');
                if (b.classList.contains('btn-success')) {
                    b.classList.replace('btn-success', 'btn-outline-success');
                }
                if (b.classList.contains('btn-primary')) {
                    b.classList.replace('btn-primary', 'btn-outline-primary');
                }
                if (b.classList.contains('btn-warning')) {
                    b.classList.replace('btn-warning', 'btn-outline-warning');
                }
            });

            this.classList.add('active');
            const filter = this.getAttribute('data-filter');
            currentFilter = filter;

            if (filter === 'all') {
                this.classList.replace('btn-outline-success', 'btn-success');
            } else if (filter === 'online') {
                this.classList.replace('btn-outline-primary', 'btn-primary');
            } else if (filter === 'offline') {
                this.classList.replace('btn-outline-success', 'btn-success');
            } else if (filter === 'both') {
                this.classList.replace('btn-outline-warning', 'btn-warning');
            }

            filterDoctors();
        });
    });

    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function () {
            searchInput.value = '';
            searchQuery = '';
            clearSearchBtn.style.display = 'none';
            currentFilter = 'all';

            filterBtns.forEach(b => {
                b.classList.remove('active');
                if (b.getAttribute('data-filter') === 'all') {
                    b.classList.add('active');
                    b.classList.replace('btn-outline-success', 'btn-success');
                }
            });

            filterDoctors();
        });
    }
});
</script>
@endsection
