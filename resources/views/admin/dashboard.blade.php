@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Admin Dashboard | Ayurveda Portal')

@section('content')
<div class="container-fluid py-4 px-4 px-xl-5" style="max-width: 1750px;">
    {{-- Header Banner --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3 p-4 bg-white rounded-4 shadow-sm border">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill small fw-bold">
                    <i class="fas fa-shield-alt me-1"></i> Super Admin Control Panel
                </span>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1.5 rounded-pill small fw-bold">
                    <i class="fas fa-circle text-success me-1 small"></i> System Operational
                </span>
            </div>
            <h2 class="fw-bold text-dark mb-0">Welcome back, {{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</h2>
            <p class="text-muted small mb-0 mt-1"><i class="far fa-calendar-alt me-1"></i> Today is {{ now()->format('l, d F Y') }}</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('admin.doctors.create') }}" class="btn btn-success px-3 py-2 fw-bold small rounded-3 shadow-sm text-decoration-none">
                <i class="fas fa-user-plus me-1"></i> Add Doctor
            </a>
            <a href="{{ route('admin.pharmas.create') }}" class="btn btn-outline-dark px-3 py-2 fw-bold small rounded-3 shadow-sm text-decoration-none">
                <i class="fas fa-building me-1"></i> Register Pharmacy
            </a>
            <a href="{{ route('admin.advertisements.create') }}" class="btn btn-outline-primary px-3 py-2 fw-bold small rounded-3 shadow-sm text-decoration-none">
                <i class="fas fa-bullhorn me-1"></i> Add Advertisement
            </a>
        </div>
    </div>

    {{-- Emergency 30-Min Unconfirmed Appointments Alert Banner --}}
    @if(isset($urgentBookings) && $urgentBookings->count() > 0)
        <div class="card border-danger border-opacity-50 shadow-sm rounded-4 mb-4 overflow-hidden" style="background-color: #fff8f8;">
            <div class="card-header bg-danger text-white py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="spinner-grow spinner-grow-sm text-light" role="status"></span>
                    <h6 class="fw-bold mb-0 text-white"><i class="fas fa-exclamation-triangle me-2"></i>EMERGENCY WARNING: {{ $urgentBookings->count() }} Unconfirmed Appointment(s) Imminent (Within 30 Mins / Doctor Inactive)</h6>
                </div>
                <span class="badge bg-white text-danger font-weight-bold px-3 py-1 rounded-pill">Action Required</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-uppercase text-muted fw-bold">
                            <tr>
                                <th class="ps-4">Token #</th>
                                <th>Patient Details</th>
                                <th>Assigned Doctor</th>
                                <th>Scheduled Time</th>
                                <th class="text-end pe-4">Emergency Admin Override</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($urgentBookings as $ub)
                                <tr>
                                    <td class="ps-4 fw-bold text-danger">#{{ $ub->token_number ?? $ub->id }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $ub->user ? $ub->user->name : 'Patient' }}</div>
                                        <div class="small text-muted"><i class="fas fa-phone me-1"></i>{{ $ub->user ? $ub->user->phone : '' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">Dr. {{ $ub->doctor ? $ub->doctor->name : 'Doctor' }}</div>
                                        <span class="badge bg-warning bg-opacity-25 text-dark border border-warning border-opacity-50 small">Doctor Has Not Responded</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-danger"><i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($ub->booking_date)->format('d M') }} at {{ $ub->booking_time }}</div>
                                        <small class="text-danger fw-semibold">⚡ Starting Soon / Urgent!</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.bookings.emergency_approve', $ub->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger fw-bold rounded-pill px-3 shadow-sm" onclick="return confirm('Emergency approve booking #{{ $ub->id }} on behalf of doctor? This will confirm the appointment and send the Google Meet link to the patient.');">
                                                <i class="fas fa-bolt me-1"></i> Emergency Approve &amp; Send Meet Link
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
            <div class="card-body p-0">
                <div class="p-3 bg-warning bg-opacity-10 border-bottom small text-dark">
                    <i class="fas fa-info-circle me-1"></i> These appointments were booked for yesterday or earlier, but were left in <strong>Pending</strong> status by the doctor. You can update their status below to clear or resolve them.
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-uppercase text-muted fw-bold">
                            <tr>
                                <th class="ps-4">Token #</th>
                                <th>Booking Date</th>
                                <th>Patient Details</th>
                                <th>Assigned Doctor</th>
                                <th class="text-end pe-4">Resolve Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastOverdueBookings as $pob)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">#{{ $pob->token_number ?? $pob->id }}</td>
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
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end align-items-center gap-2">
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
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Standard Metric Cards Grid --}}
    <div class="row g-3 mb-4">
        {{-- Appointments --}}
        <div class="col-sm-6 col-xl-4 col-xxl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3.5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-3 p-2.5 bg-success bg-opacity-10 text-success">
                            <i class="fas fa-calendar-check fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2.5 py-1 rounded-pill">Appointments</span>
                    </div>
                    <div class="text-muted small fw-bold text-uppercase">Total Bookings</div>
                    <div class="h2 fw-bold text-dark my-1">{{ number_format($totalAppointments ?? 0) }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="small text-muted"><strong class="text-warning">{{ $pendingAppointments ?? 0 }}</strong> pending</span>
                        <a href="{{ route('admin.bookings.index') }}" class="small fw-bold text-success text-decoration-none">Manage <i class="fas fa-chevron-right ms-0.5"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Orders --}}
        <div class="col-sm-6 col-xl-4 col-xxl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3.5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-3 p-2.5 bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-shopping-bag fa-lg"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2.5 py-1 rounded-pill">Store Orders</span>
                    </div>
                    <div class="text-muted small fw-bold text-uppercase">Total Purchases</div>
                    <div class="h2 fw-bold text-dark my-1">{{ number_format($totalOrders ?? 0) }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="small text-muted">Customer orders</span>
                        <a href="{{ route('admin.orders.index') }}" class="small fw-bold text-primary text-decoration-none">Manage <i class="fas fa-chevron-right ms-0.5"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Store Products --}}
        <div class="col-sm-6 col-xl-4 col-xxl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3.5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-3 p-2.5" style="background:#f3e8ff; color:#6f42c1;">
                            <i class="fas fa-cubes fa-lg"></i>
                        </div>
                        <span class="badge fw-bold px-2.5 py-1 rounded-pill" style="background:#f3e8ff; color:#6f42c1;">Catalog</span>
                    </div>
                    <div class="text-muted small fw-bold text-uppercase">Store Products</div>
                    <div class="h2 fw-bold text-dark my-1">{{ number_format($totalProducts ?? 0) }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="small text-muted">Active items</span>
                        <a href="{{ route('admin.products.index') }}" class="small fw-bold text-decoration-none" style="color:#6f42c1;">Manage <i class="fas fa-chevron-right ms-0.5"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Doctors --}}
        <div class="col-sm-6 col-xl-4 col-xxl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3.5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-3 p-2.5" style="background:#e6fcf5; color:#0ca678;">
                            <i class="fas fa-user-md fa-lg"></i>
                        </div>
                        <span class="badge fw-bold px-2.5 py-1 rounded-pill" style="background:#e6fcf5; color:#0ca678;">Directory</span>
                    </div>
                    <div class="text-muted small fw-bold text-uppercase">Total Doctors</div>
                    <div class="h2 fw-bold text-dark my-1">{{ number_format($totalDoctors ?? 0) }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="small text-muted"><strong class="text-success">{{ ($totalDoctors ?? 0) - ($pendingDoctors ?? 0) }}</strong> approved</span>
                        <a href="{{ route('admin.doctors.index') }}" class="small fw-bold text-decoration-none" style="color:#0ca678;">Manage <i class="fas fa-chevron-right ms-0.5"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pharmacies --}}
        <div class="col-sm-6 col-xl-4 col-xxl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3.5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-3 p-2.5 bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-building fa-lg"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-dark fw-bold px-2.5 py-1 rounded-pill">Partners</span>
                    </div>
                    <div class="text-muted small fw-bold text-uppercase">Pharmacies</div>
                    <div class="h2 fw-bold text-dark my-1">{{ number_format($totalPharmas ?? 0) }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="small text-muted">GMP Certified</span>
                        <a href="{{ route('admin.pharmas.index') }}" class="small fw-bold text-dark text-decoration-none">Manage <i class="fas fa-chevron-right ms-0.5"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users --}}
        <div class="col-sm-6 col-xl-4 col-xxl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3.5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-3 p-2.5 bg-info bg-opacity-10 text-info">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-info fw-bold px-2.5 py-1 rounded-pill">Patients</span>
                    </div>
                    <div class="text-muted small fw-bold text-uppercase">Registered Users</div>
                    <div class="h2 fw-bold text-dark my-1">{{ number_format($totalUsers ?? 0) }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="small text-muted">Patient accounts</span>
                        <a href="{{ route('admin.users.index') }}" class="small fw-bold text-info text-decoration-none">Manage <i class="fas fa-chevron-right ms-0.5"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Today's Priority & Recent Activity Tables --}}
    <div class="row g-4 mb-4">
        {{-- Today's Priority Appointments Table --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold mb-1"><i class="fas fa-star me-1"></i> HIGH PRIORITY</span>
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-calendar-day text-success me-2"></i>Today's Priority Appointments ({{ now()->format('d M') }})</h5>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
                        All Bookings <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(isset($todaysBookings) && $todaysBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small text-uppercase text-muted fw-bold">
                                    <tr>
                                        <th class="ps-4">Time &amp; Token</th>
                                        <th>Patient Details</th>
                                        <th>Assigned Doctor</th>
                                        <th class="text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todaysBookings as $tbk)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-success"><i class="far fa-clock me-1"></i>{{ $tbk->booking_time }}</div>
                                                <small class="text-muted fw-semibold">Token #{{ $tbk->token_number ?? $tbk->id }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $tbk->user ? $tbk->user->name : 'Patient' }}</div>
                                                <div class="small text-muted"><i class="fas fa-phone me-1"></i>{{ $tbk->user ? $tbk->user->phone : '' }}</div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-dark">Dr. {{ $tbk->doctor ? $tbk->doctor->name : 'Doctor' }}</div>
                                                <div class="small text-muted">{{ $tbk->doctor ? $tbk->doctor->specialization_category : '' }}</div>
                                            </td>
                                            <td class="text-end pe-4">
                                                @if(in_array($tbk->status, ['Confirmed', 'Booked']))
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill"><i class="fas fa-check-circle me-1"></i> Confirmed</span>
                                                @elseif($tbk->status == 'Completed')
                                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1 rounded-pill text-dark">Completed</span>
                                                @elseif($tbk->status == 'Cancelled')
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-pill">Cancelled</span>
                                                @else
                                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2.5 py-1 rounded-pill text-dark"><i class="fas fa-clock me-1"></i> Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted small">
                            <i class="far fa-calendar-check fa-2x mb-2 text-secondary opacity-25"></i>
                            <div>No appointments scheduled specifically for today.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Orders Table --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-boxes text-primary me-2"></i>Recent Product Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentOrders) && $recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small text-uppercase text-muted fw-bold">
                                    <tr>
                                        <th class="ps-4">Order ID</th>
                                        <th>Customer</th>
                                        <th>Destination</th>
                                        <th>Amount</th>
                                        <th class="text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $ord)
                                        <tr>
                                            <td class="ps-4 fw-bold text-primary">#ORD-{{ str_pad($ord->id, 5, '0', STR_PAD_LEFT) }}</td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $ord->delivery_name }}</div>
                                                <div class="small text-muted"><i class="fas fa-phone me-1"></i>{{ $ord->delivery_phone }}</div>
                                            </td>
                                            <td class="small text-dark font-weight-semibold">{{ $ord->delivery_district }}</td>
                                            <td class="fw-bold text-success">₹{{ number_format($ord->total_price, 2) }}</td>
                                            <td class="text-end pe-4">
                                                @if($ord->order_status == 'Delivered')
                                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i> Delivered</span>
                                                @elseif($ord->order_status == 'Shipped')
                                                    <span class="badge bg-info text-dark"><i class="fas fa-truck me-1"></i> Shipped</span>
                                                @else
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Placed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted small">No recent product purchases recorded yet.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- System Quick Management Hub --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-th-large text-success me-2"></i>Quick Management Modules</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-light w-100 p-3 text-start rounded-4 border shadow-sm h-100 text-decoration-none hover-lift">
                                <div class="p-2.5 rounded-3 bg-success bg-opacity-10 text-success d-inline-block mb-2">
                                    <i class="fas fa-calendar-check fa-lg"></i>
                                </div>
                                <div class="fw-bold text-dark fs-6">Appointments</div>
                                <small class="text-muted d-block">Manage bookings</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-light w-100 p-3 text-start rounded-4 border shadow-sm h-100 text-decoration-none hover-lift">
                                <div class="p-2.5 rounded-3 bg-primary bg-opacity-10 text-primary d-inline-block mb-2">
                                    <i class="fas fa-shopping-bag fa-lg"></i>
                                </div>
                                <div class="fw-bold text-dark fs-6">Product Orders</div>
                                <small class="text-muted d-block">Track sales</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light w-100 p-3 text-start rounded-4 border shadow-sm h-100 text-decoration-none hover-lift">
                                <div class="p-2.5 rounded-3 d-inline-block mb-2" style="background:#f3e8ff; color:#6f42c1;">
                                    <i class="fas fa-cubes fa-lg"></i>
                                </div>
                                <div class="fw-bold text-dark fs-6">Store Catalog</div>
                                <small class="text-muted d-block">All store items</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ route('admin.doctors.index') }}" class="btn btn-light w-100 p-3 text-start rounded-4 border shadow-sm h-100 text-decoration-none hover-lift">
                                <div class="p-2.5 rounded-3 d-inline-block mb-2" style="background:#e6fcf5; color:#0ca678;">
                                    <i class="fas fa-user-md fa-lg"></i>
                                </div>
                                <div class="fw-bold text-dark fs-6">Doctors</div>
                                <small class="text-muted d-block">Directory &amp; approval</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ route('admin.pharmas.index') }}" class="btn btn-light w-100 p-3 text-start rounded-4 border shadow-sm h-100 text-decoration-none hover-lift">
                                <div class="p-2.5 rounded-3 bg-warning bg-opacity-10 text-warning d-inline-block mb-2">
                                    <i class="fas fa-building fa-lg"></i>
                                </div>
                                <div class="fw-bold text-dark fs-6">Pharmacies</div>
                                <small class="text-muted d-block">Partners &amp; GMP</small>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light w-100 p-3 text-start rounded-4 border shadow-sm h-100 text-decoration-none hover-lift">
                                <div class="p-2.5 rounded-3 bg-info bg-opacity-10 text-info d-inline-block mb-2">
                                    <i class="fas fa-users fa-lg"></i>
                                </div>
                                <div class="fw-bold text-dark fs-6">Users</div>
                                <small class="text-muted d-block">Patient accounts</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.hover-lift:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important; }
</style>
@endsection
