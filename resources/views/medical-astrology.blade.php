@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Medical Astrology & Doctor Timings | Ayurveda App')

@section('content')
<!-- Hero Header -->
<div class="position-relative overflow-hidden p-4 p-md-5 text-center text-white mb-5 rounded-4 shadow-lg" 
     style="background: linear-gradient(135deg, #0c3b2e 0%, #1d5c42 50%, #2d7a58 100%);">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: radial-gradient(#ffba08 1px, transparent 1px); background-size: 20px 20px;"></div>
    
    <div class="col-md-9 p-lg-4 mx-auto my-3 position-relative" style="z-index: 2;">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="letter-spacing: 1px;">
            ✨ JYOTISHYA CHIKITSA & AYURVEDA
        </span>
        <h1 class="display-4 fw-bold font-serif text-warning mb-3" style="font-family: 'Playfair Display', serif;">
            Medical Astrology & Doctor Schedule
        </h1>
        <p class="lead font-weight-normal text-light mb-4" style="font-size: 1.15rem; line-height: 1.8;">
            Discover how cosmic alignments, planetary energies, and Ayurvedic <strong>Tridoshas (Vata, Pitta, Kapha)</strong> unite to guide holistic healing. Check doctor consultation timings and book your personalized health session.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="#doctorScheduleSection" class="btn btn-warning text-dark fw-bold px-4 py-3 rounded-pill shadow-sm">
                <i class="fas fa-calendar-alt me-2"></i> View Doctor Timings
            </a>
            <a href="#aboutAstrologySection" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill">
                <i class="fas fa-compass me-2"></i> Learn About Medical Astrology
            </a>
        </div>
    </div>
</div>

<div class="container my-5">
    <!-- What is Medical Astrology Section -->
    <div class="row align-items-center mb-5" id="aboutAstrologySection">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="text-uppercase text-success fw-bold small tracking-wider"><i class="fas fa-star me-2"></i>Ancient Healing Science</span>
            <h2 class="fw-bold mb-3 mt-1" style="color: #0c3b2e; font-family: 'Playfair Display', serif;">
                What is Medical Astrology (*Jyotishya Chikitsa*)?
            </h2>
            <p class="text-muted leading-relaxed">
                In classical Ayurveda and Vedic sciences, <strong>Medical Astrology</strong> (or <em>Jyotishya Chikitsa</em>) is the study of how planetary cycles, solar-lunar rhythms, and zodiac alignments influence the human bio-energies (<strong>Vata, Pitta, and Kapha</strong>).
            </p>
            <p class="text-muted leading-relaxed">
                By evaluating birth charts alongside Ayurvedic diagnostic methods (such as <em>Nadi Pariksha</em>), practitioners gain deeper insights into physical vulnerability, immunity patterns, and the most auspicious times (<em>Muhurta</em>) for treatments and wellness regimens.
            </p>

            <div class="row g-3 mt-2">
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded-3 border-start border-4 border-warning shadow-sm h-100">
                        <h6 class="fw-bold text-dark mb-1"><i class="fas fa-sun text-warning me-2"></i>Solar Energy & Pitta</h6>
                        <small class="text-muted">Governs metabolism, digestion, vital energy, and circulation.</small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded-3 border-start border-4 border-info shadow-sm h-100">
                        <h6 class="fw-bold text-dark mb-1"><i class="fas fa-moon text-info me-2"></i>Lunar Rhythms & Kapha</h6>
                        <small class="text-muted">Controls bodily fluids, emotional calm, cellular regeneration, and immunity.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: linear-gradient(145deg, #ffffff 0%, #f4f8f5 100%);">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold mb-4 text-center" style="color: #0c3b2e;">
                        <i class="fas fa-atom text-warning me-2"></i>Planetary & Tridosha Correspondences
                    </h4>
                    <ul class="list-group list-group-flush border-0">
                        <li class="list-group-item bg-transparent d-flex align-items-center py-3 border-bottom">
                            <span class="badge bg-danger bg-opacity-10 text-danger p-3 rounded-circle me-3"><i class="fas fa-fire fa-lg"></i></span>
                            <div>
                                <h6 class="mb-0 fw-bold">Sun & Mars &mdash; Pitta (Fire Element)</h6>
                                <small class="text-muted">Blood pressure, digestive fire (Agni), liver health & inflammation.</small>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent d-flex align-items-center py-3 border-bottom">
                            <span class="badge bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3"><i class="fas fa-wind fa-lg"></i></span>
                            <div>
                                <h6 class="mb-0 fw-bold">Saturn & Mercury &mdash; Vata (Air Element)</h6>
                                <small class="text-muted">Nervous system, joint mobility, respiratory flow & mental activity.</small>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent d-flex align-items-center py-3 border-bottom">
                            <span class="badge bg-info bg-opacity-10 text-info p-3 rounded-circle me-3"><i class="fas fa-water fa-lg"></i></span>
                            <div>
                                <h6 class="mb-0 fw-bold">Moon & Jupiter &mdash; Kapha (Earth/Water Element)</h6>
                                <small class="text-muted">Lymphatic system, body weight, tissue strength & psychological calm.</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5 opacity-25">

    <!-- About Our App Section -->
    <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 mb-5 border">
        <div class="row align-items-center">
            <div class="col-md-3 text-center mb-4 mb-md-0">
                <div class="p-4 bg-success bg-opacity-10 text-success rounded-circle d-inline-block shadow-sm">
                    <i class="fas fa-heartbeat fa-4x"></i>
                </div>
            </div>
            <div class="col-md-9">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold mb-2">ABOUT THIS APP</span>
                <h3 class="fw-bold mb-3" style="color: #0c3b2e;">Integrative Ayurvedic Healthcare & Tele-Consultations</h3>
                <p class="text-muted">
                    Our platform connects patients directly with verified Ayurvedic doctors, hospital specialists, and authentic pharmaceutical remedies. Whether you seek online video consultations or in-person visits, our system simplifies token bookings, doctor availability schedules, and prescription fulfillment.
                </p>
                <div class="row g-3">
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-md text-success fs-4 me-2"></i>
                            <span class="fw-bold small text-dark">Verified Doctors</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-video text-primary fs-4 me-2"></i>
                            <span class="fw-bold small text-dark">Online Google Meet</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-pills text-warning fs-4 me-2"></i>
                            <span class="fw-bold small text-dark">Genuine Medicines</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Timings & Consultation Schedule Section -->
    <div class="mb-5" id="doctorScheduleSection">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold mb-1" style="color: #0c3b2e; font-family: 'Playfair Display', serif;">
                    <i class="fas fa-user-clock me-2 text-warning"></i> Doctor Timings & Available Slots
                </h3>
                <p class="text-muted mb-0">Select a doctor to view their consultation schedules and book an appointment.</p>
            </div>
            <a href="{{ route('doctors.index') }}" class="btn btn-outline-success rounded-pill px-4">
                View All Doctors <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($doctors as $doctor)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift overflow-hidden">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center me-3 flex-shrink-0 shadow-sm" style="width: 60px; height: 60px; background: #e8f5e9; border: 2px solid #1a4d2e;">
                                    @if($doctor->photo)
                                        <img src="{{ asset('storage/' . $doctor->photo) }}" alt="Dr. {{ $doctor->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span class="fw-bold text-success" style="font-size: 1.1rem;">Dr.</span>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">Dr. {{ $doctor->name }}</h5>
                                    <span class="badge bg-light text-success border border-success border-opacity-25 rounded-pill px-3">
                                        {{ $doctor->specialization_category ?? 'Ayurveda Specialist' }}
                                    </span>
                                </div>
                            </div>

                            <div class="small text-muted mb-3">
                                <div class="mb-1"><i class="fas fa-map-marker-alt me-2 text-danger"></i><strong>District:</strong> {{ $doctor->district->name ?? 'Kerala' }}</div>
                                <div class="mb-1"><i class="fas fa-briefcase me-2 text-info"></i><strong>Experience:</strong> {{ $doctor->experience_years ?? 5 }} Years</div>
                            </div>

                            <div class="bg-light p-3 rounded-3 mb-4 mt-auto">
                                <h6 class="fw-bold small text-dark mb-2"><i class="far fa-clock me-1 text-warning"></i> Consultation Timings:</h6>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted"><i class="fas fa-clinic-medical me-1 text-secondary"></i> Offline Hours:</span>
                                    <span class="fw-semibold text-dark">{{ $doctor->available_time ?? '09:00 AM - 01:00 PM' }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted"><i class="fas fa-video me-1 text-primary"></i> Online Hours:</span>
                                    <span class="fw-semibold text-dark">{{ $doctor->online_available_time ?? '04:00 PM - 07:00 PM' }}</span>
                                </div>
                            </div>

                            <a href="{{ route('bookings.create', $doctor->id) }}" class="btn btn-success w-100 rounded-pill fw-bold py-2 shadow-sm">
                                <i class="fas fa-calendar-check me-2"></i> Book Appointment
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fas fa-user-md fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">No doctor schedules available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(12, 59, 46, 0.15) !important;
    }
    .leading-relaxed {
        line-height: 1.7;
    }
</style>
@endsection
