@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'All Patient Appointments | Admin Oversight')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="fas fa-calendar-check text-success me-2"></i>All Patient Appointments</h2>
            <p class="text-muted small mb-0">Overview and management of all doctor appointments booked across the platform.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Emergency 30-Min Warning Alert Banner --}}
    @if(isset($urgentBookings) && $urgentBookings->count() > 0)
        <div class="card border-danger shadow-sm rounded-4 mb-4 overflow-hidden" style="background-color: #fff5f5;">
            <div class="card-header bg-danger text-white py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="spinner-grow spinner-grow-sm text-light" role="status"></span>
                    <h6 class="fw-bold mb-0 text-white"><i class="fas fa-bolt me-2"></i>30-MIN EMERGENCY WARNING: {{ $urgentBookings->count() }} Appointment(s) Imminent &amp; Unconfirmed by Doctor</h6>
                </div>
                <span class="badge bg-white text-danger fw-bold px-3 py-1 rounded-pill">Urgent Action</span>
            </div>
            <div class="card-body p-3">
                <p class="small text-muted mb-3">The following appointments are starting within 30 minutes (or scheduled for today) and the doctor has not confirmed them yet. As Admin, you can emergency approve them to generate meeting links and notify the patient immediately.</p>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 bg-white rounded-3 overflow-hidden border">
                        <thead class="bg-light small text-uppercase text-muted fw-bold">
                            <tr>
                                <th class="ps-3">Token #</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Time</th>
                                <th class="text-end pe-3">Emergency Override</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($urgentBookings as $ub)
                                <tr>
                                    <td class="ps-3 fw-bold text-danger">#{{ $ub->token_number ?? $ub->id }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $ub->user ? $ub->user->name : 'Patient' }}</div>
                                        <div class="small text-muted">{{ $ub->user ? $ub->user->phone : '' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">Dr. {{ $ub->doctor ? $ub->doctor->name : 'Doctor' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-danger"><i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($ub->booking_date)->format('d M') }} at {{ $ub->booking_time }}</div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <form action="{{ route('admin.bookings.emergency_approve', $ub->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger fw-bold rounded-pill px-3 shadow-sm" onclick="return confirm('Emergency approve appointment #{{ $ub->id }}? Google Meet link will be generated and patient notified.');">
                                                <i class="fas fa-bolt me-1"></i> Emergency Approve
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Yesterday / Past Overdue Pending Appointments Alert Banner --}}
    @if(isset($pastOverdueBookings) && $pastOverdueBookings->count() > 0)
        <div class="card border-warning border-opacity-75 shadow-sm rounded-4 mb-4 overflow-hidden" style="background-color: #fffdf5;">
            <div class="card-header bg-warning text-dark py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-history fa-lg text-dark"></i>
                    <h6 class="fw-bold mb-0 text-dark">ATTENTION: {{ $pastOverdueBookings->count() }} Past Overdue Unhandled Booking(s) (Yesterday &amp; Earlier)</h6>
                </div>
                <span class="badge bg-dark text-warning fw-bold px-3 py-1 rounded-pill">Doctor Forgot / Overdue</span>
            </div>
            <div class="card-body p-3">
                <p class="small text-muted mb-3">The following appointments were scheduled for yesterday or earlier, but were left in <strong>Pending</strong> status because the doctor forgot or missed updating them. As Admin, you can review and update their status below.</p>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 bg-white rounded-3 overflow-hidden border">
                        <thead class="bg-light small text-uppercase text-muted fw-bold">
                            <tr>
                                <th class="ps-3">Token #</th>
                                <th>Booking Date</th>
                                <th>Patient Details</th>
                                <th>Assigned Doctor</th>
                                <th class="text-end pe-3">Resolve Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastOverdueBookings as $pob)
                                <tr>
                                    <td class="ps-3 fw-bold text-dark">#{{ $pob->token_number ?? $pob->id }}</td>
                                    <td>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1.5 rounded-pill fw-bold">
                                            <i class="far fa-calendar-times me-1"></i> {{ \Carbon\Carbon::parse($pob->booking_date)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $pob->user ? $pob->user->name : 'Patient' }}</div>
                                        <div class="small text-muted"><i class="fas fa-phone me-1"></i>{{ $pob->user ? $pob->user->phone : '' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">Dr. {{ $pob->doctor ? $pob->doctor->name : 'Doctor' }}</div>
                                        <small class="text-muted">{{ $pob->doctor ? $pob->doctor->specialization_category : '' }}</small>
                                    </td>
                                    <td class="text-end pe-3">
                                        <form action="{{ route('admin.bookings.update_status', $pob->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                                                <option value="Pending" selected>Pending (Overdue)</option>
                                                <option value="Confirmed">Mark Confirmed</option>
                                                <option value="Completed">Mark Completed</option>
                                                <option value="Cancelled">Mark Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Day Navigation Control Bar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                {{-- Date Stepper Buttons --}}
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.bookings.index', array_merge(request()->except(['date', 'page']), ['date' => $prevDate])) }}" class="btn btn-outline-dark rounded-pill px-3 fw-bold shadow-sm" title="Previous Day">
                        <i class="fas fa-chevron-left me-1"></i> Previous Day
                    </a>
                    <a href="{{ route('admin.bookings.index', array_merge(request()->except(['date', 'page', 'date_filter']), ['date' => $todayStr])) }}" class="btn {{ ($selectedDate == $todayStr) ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3.5 fw-bold shadow-sm">
                        <i class="fas fa-star me-1"></i> Today
                    </a>
                    <a href="{{ route('admin.bookings.index', array_merge(request()->except(['date', 'page']), ['date' => $nextDate])) }}" class="btn btn-outline-dark rounded-pill px-3 fw-bold shadow-sm" title="Next Day">
                        Next Day <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>

                {{-- Current Selected Date Badge Label --}}
                <div class="text-center">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3.5 py-2 rounded-pill fs-6 fw-bold">
                        <i class="far fa-calendar-alt me-1.5"></i>
                        @if($selectedDate == $todayStr)
                            Today ({{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }})
                        @elseif($selectedDate == $nextDate)
                            Tomorrow ({{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }})
                        @elseif($selectedDate)
                            {{ \Carbon\Carbon::parse($selectedDate)->format('l, d M Y') }}
                        @else
                            All Dates Combined
                        @endif
                    </span>
                </div>

                {{-- All Dates Switcher --}}
                <div>
                    <a href="{{ route('admin.bookings.index', ['date_filter' => 'all']) }}" class="btn {{ !$selectedDate ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3.5 fw-bold shadow-sm">
                        <i class="fas fa-list me-1"></i> View All Dates
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Toolbar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search patient, doctor, token..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar-day text-muted"></i></span>
                        <input type="date" name="date" class="form-control border-start-0" value="{{ $selectedDate ?? '' }}" onchange="this.form.submit()" title="Select calendar date">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="doctor_id" class="form-select">
                        <option value="">— All Doctors —</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>Dr. {{ $doc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100 rounded-3 fw-bold"><i class="fas fa-filter me-1"></i> Filter</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary rounded-3" title="Reset Filters"><i class="fas fa-undo"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Bookings Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small text-muted fw-bold">
                            <tr>
                                <th class="ps-4">Token #</th>
                                <th>Patient Details</th>
                                <th>Assigned Doctor</th>
                                <th>Date &amp; Time</th>
                                <th>Consultation Fee</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Manage Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="ps-4 fw-bold text-success">#{{ $booking->token_number ?? $booking->id }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $booking->user ? $booking->user->name : 'N/A' }}</div>
                                        <div class="small text-muted"><i class="fas fa-envelope me-1"></i>{{ $booking->user ? $booking->user->email : '' }}</div>
                                        <div class="small text-muted"><i class="fas fa-phone me-1"></i>{{ $booking->user ? $booking->user->phone : '' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">Dr. {{ $booking->doctor ? $booking->doctor->name : 'Doctor' }}</div>
                                        <div class="small text-success fw-semibold">{{ $booking->doctor ? $booking->doctor->specialization_category : '' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><i class="far fa-calendar-alt text-primary me-1"></i>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                        <div class="small text-muted"><i class="far fa-clock me-1"></i>{{ $booking->booking_time }}</div>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        ₹{{ number_format($booking->doctor ? $booking->doctor->consultation_fee : 0, 2) }}
                                    </td>
                                    <td>
                                        @if($booking->status == 'Confirmed')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill"><i class="fas fa-check-circle me-1"></i> Confirmed</span>
                                        @elseif($booking->status == 'Completed')
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1.5 rounded-pill text-dark"><i class="fas fa-flag-checkered me-1"></i> Completed</span>
                                        @elseif($booking->status == 'Cancelled')
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1.5 rounded-pill"><i class="fas fa-times-circle me-1"></i> Cancelled</span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2.5 py-1.5 rounded-pill text-dark"><i class="fas fa-clock me-1"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm d-inline-block w-auto rounded-pill" onchange="this.form.submit()">
                                                    <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Confirmed" {{ $booking->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                    <option value="Completed" {{ $booking->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="Cancelled" {{ $booking->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this booking record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-1.5" title="Delete Booking"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="far fa-calendar-times fa-4x mb-3 text-secondary opacity-25"></i>
                    <h5 class="fw-bold">No Appointments Found @if($selectedDate) for {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }} @endif</h5>
                    <p class="small mb-3">There are no patient bookings scheduled for this specific date.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.bookings.index', ['date' => $todayStr]) }}" class="btn btn-sm btn-success rounded-pill px-4 fw-bold">
                            <i class="fas fa-star me-1"></i> Jump to Today's Bookings
                        </a>
                        <a href="{{ route('admin.bookings.index', ['date' => $nextDate]) }}" class="btn btn-sm btn-outline-dark rounded-pill px-4 fw-bold">
                            View Next Day <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
