@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<div class="container mb-5 mt-4">

    {{-- Section Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#1a4d2e;"><i class="fas fa-user-md me-2"></i>Find an Ayurvedic Doctor</h2>
            <p class="text-muted mb-0">Book your consultation with our expert practitioners</p>
        </div>
        @auth
            <a href="{{ route('bookings.my') }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-calendar-check me-1"></i> My Appointments
            </a>
        @endauth
    </div>

    @if(isset($doctors) && $doctors->count() > 0)

        {{-- ── Search & Filter Row ── --}}
        <div class="row mb-4 g-3">
            <div class="col-md-6">
                <div class="input-group shadow-sm h-100">
                    <span class="input-group-text bg-white border-end-0" style="border-color:#c8dfc8;">
                        <i class="fas fa-search text-success"></i>
                    </span>
                    <input type="text"
                           id="doctorSearch"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search by doctor name or category…"
                           style="border-color:#c8dfc8;">
                    <button class="btn btn-outline-secondary" id="clearSearch" type="button" style="display:none;" title="Clear">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group shadow-sm h-100">
                    <span class="input-group-text bg-white border-end-0" style="border-color:#c8dfc8;">
                        <i class="fas fa-map-marker-alt text-success"></i>
                    </span>
                    <select id="districtFilter" class="form-select border-start-0 ps-0" style="border-color:#c8dfc8;">
                        <option value="all">All Districts (Kerala)</option>
                        @foreach($districts as $dist)
                            <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- ── Category Filter Pills ── --}}
        <div class="mb-4 d-flex flex-wrap gap-2" id="categoryFilters">
            <button class="btn btn-success btn-sm rounded-pill px-3 fw-semibold category-btn active" data-cat="all">
                All Specialties
            </button>
            @foreach($doctors->pluck('specialization_category')->filter()->unique() as $catName)
                <button class="btn btn-outline-success btn-sm rounded-pill px-3 category-btn" data-cat="{{ strtolower($catName) }}">
                    {{ $catName }}
                </button>
            @endforeach
        </div>

        {{-- ── Doctor Cards ── --}}
        <div class="row row-cols-1 row-cols-md-3 g-4" id="doctorGrid">
            @foreach($doctors as $doctor)
                <div class="col doctor-card"
                     data-name="{{ strtolower($doctor->name) }}"
                     data-category="{{ strtolower($doctor->specialization_category ?? '') }}"
                     data-district="{{ $doctor->district_id }}">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="transition: transform 0.2s, box-shadow 0.2s;">
                        {{-- Header band --}}
                        <div class="py-4 text-center" style="background: linear-gradient(135deg, #1a4d2e, #4f772d);">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2"
                                 style="width:70px;height:70px;background:rgba(255,255,255,0.15);border:2px solid rgba(255,255,255,0.4);">
                                <i class="fas fa-user-md fa-2x text-white"></i>
                            </div>
                            <h5 class="text-white fw-bold mb-0">Dr. {{ $doctor->name }}</h5>
                            <small class="text-white opacity-75">{{ $doctor->specialization_category ?? 'General Practice' }}</small>
                            @if($doctor->specialization_subcategory)
                                <br><small class="text-white opacity-50 small" style="font-size: 0.7rem;">{{ $doctor->specialization_subcategory }}</small>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3">
                                @if($doctor->qualification)
                                    <p class="mb-1 small text-muted"><i class="fas fa-graduation-cap me-2 text-success"></i>{{ $doctor->qualification }}</p>
                                @endif
                                @if($doctor->experience)
                                    <p class="mb-1 small text-muted"><i class="fas fa-briefcase me-2 text-success"></i>{{ $doctor->experience }} years experience</p>
                                @endif
                                @if($doctor->district)
                                    <p class="mb-1 small text-muted"><i class="fas fa-map-marker-alt me-2 text-success"></i>{{ $doctor->district->name }}</p>
                                @endif
                                @if($doctor->available_time)
                                    <p class="mb-1 small text-muted"><i class="fas fa-clock me-2 text-success"></i>Available: {{ $doctor->available_time }}</p>
                                @endif
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold" style="color:#1a4d2e; font-size:1.1rem;">
                                        ₹{{ number_format($doctor->consultation_fee, 2) }}
                                    </span>
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small">Consultation Fee</span>
                                </div>
                                @auth
                                    <a href="{{ route('bookings.create', $doctor->id) }}"
                                       class="btn btn-success w-100 fw-semibold">
                                        <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                                    </a>
                                @else
                                    <a href="{{ route('bookings.create', $doctor->id) }}"
                                       class="btn btn-outline-success w-100 fw-semibold">
                                        <i class="fas fa-calendar-plus me-2"></i>Login to Book
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- No results message --}}
        <div id="noResults" class="text-center py-5" style="display:none;">
            <i class="fas fa-user-slash fa-3x text-muted opacity-50 mb-3"></i>
            <h5 class="text-muted">No doctors found matching your criteria.</h5>
            <p class="text-muted small">Try searching by a different name, category, or district.</p>
        </div>

    @else
        <div class="alert alert-info text-center">No doctors available at the moment.</div>
    @endif
</div>

{{-- ── Live Search & Filter JS ── --}}
<script>
(function () {
    const searchInput   = document.getElementById('doctorSearch');
    const clearBtn      = document.getElementById('clearSearch');
    const districtFilter = document.getElementById('districtFilter');
    const catBtns       = document.querySelectorAll('.category-btn');
    const cards         = document.querySelectorAll('.doctor-card');
    const noResults     = document.getElementById('noResults');

    let activeCategory = 'all';

    function filterCards() {
        if (!searchInput) return;
        const query = searchInput.value.trim().toLowerCase();
        const selectedDistrict = districtFilter ? districtFilter.value : 'all';
        
        if (clearBtn) clearBtn.style.display = query.length ? 'block' : 'none';

        let visible = 0;

        cards.forEach(function (card) {
            const name           = card.dataset.name     || '';
            const category       = card.dataset.category || '';
            const cardDistrictId = card.dataset.district || '';

            const matchesSearch   = !query || name.includes(query) || category.includes(query);
            const matchesCategory = activeCategory === 'all' || category === activeCategory;
            const matchesDistrict = selectedDistrict === 'all' || cardDistrictId === selectedDistrict;

            if (matchesSearch && matchesCategory && matchesDistrict) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterCards);
    }

    if (districtFilter) {
        districtFilter.addEventListener('change', filterCards);
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            filterCards();
            searchInput.focus();
        });
    }

    catBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            catBtns.forEach(function (b) {
                b.classList.remove('active', 'btn-success');
                b.classList.add('btn-outline-success');
            });
            btn.classList.add('active', 'btn-success');
            btn.classList.remove('btn-outline-success');
            activeCategory = btn.dataset.cat;
            filterCards();
        });
    });
})();
</script>
@endsection
