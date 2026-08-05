@extends('layouts.app')

@section('navbar')
    @include('partials.nav-doctor')
@endsection

@section('title', 'Doctor Dashboard | Ayurveda')

@section('content')
<div class="row justify-content-center">
    <!-- Welcome & Header -->
    <div class="col-md-11 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="mb-1 fw-bold text-dark">Welcome, Dr. {{ Auth::guard('doctor')->user()->name }}</h2>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill small">
                        <i class="fas fa-circle me-1 small"></i> Online
                    </span>
                    <p class="text-muted mb-0 small"><i class="far fa-calendar-alt me-1"></i> {{ now()->format('l, d M Y') }}</p>
                </div>
            </div>
            <div class="text-end d-flex align-items-center gap-2 flex-wrap justify-content-end">
                <a href="{{ route('doctor.products.create') }}" class="btn btn-outline-success px-3 py-2 fw-semibold small rounded-3 text-decoration-none shadow-sm">
                    <i class="fas fa-plus-circle me-1"></i> Add Product
                </a>
                <a href="{{ route('doctor.products.index') }}" class="btn btn-outline-dark px-3 py-2 fw-semibold small rounded-3 text-decoration-none shadow-sm">
                    <i class="fas fa-boxes me-1"></i> My Products
                </a>
                <div class="btn-group shadow-sm bg-white p-1" style="border-radius: 12px;">
                    <button class="btn btn-success border-0 px-3 py-2 fw-semibold small rounded-3 me-1" data-bs-toggle="modal" data-bs-target="#calendarModal">
                        <i class="fas fa-calendar-check me-1"></i> Full Calendar
                    </button>
                    <a href="{{ route('doctor.dashboard', ['filter' => 'upcoming']) }}" 
                       class="btn {{ $filter == 'upcoming' ? 'btn-dark' : 'btn-light' }} border-0 px-3 py-2 fw-semibold small rounded-3 me-1 text-decoration-none">
                       Today Only
                    </a>
                    <a href="{{ route('doctor.dashboard', ['filter' => 'all']) }}" 
                       class="btn {{ $filter == 'all' ? 'btn-dark' : 'btn-light' }} border-0 px-3 py-2 fw-semibold small rounded-3 text-decoration-none">
                       All History
                    </a>
                </div>
            </div>
        </div>

        <!-- Date Strip (Only relevant for Today/Upcoming) -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-9">
                <div class="date-scroll-wrapper">
                    <div class="d-flex gap-2 overflow-auto hide-scrollbar py-2" id="dateStrip">
                        @php
                            $today = \Carbon\Carbon::today();
                            $selectedDate = request('date', $today->format('Y-m-d'));
                        @endphp
                        @for($i = -2; $i < 14; $i++)
                            @php 
                                $date = \Carbon\Carbon::today()->addDays($i);
                                $dateStr = $date->format('Y-m-d');
                                $isActive = ($selectedDate == $dateStr);
                                $isUnavailable = in_array($dateStr, $unavailabilities);
                            @endphp
                            <div class="date-pill {{ $isActive ? 'active' : '' }} {{ $isUnavailable ? 'unavailable' : '' }} flex-shrink-0 d-flex flex-column align-items-center justify-content-center" 
                                 onclick="window.location.href='{{ route('doctor.dashboard', ['filter' => 'upcoming', 'date' => $dateStr]) }}'"
                                 style="cursor: pointer; position: relative;">
                                <span class="day">{{ $date->format('D') }}</span>
                                <span class="num">{{ $date->format('d') }}</span>
                                @if($isUnavailable)
                                    <span class="unavailable-marker px-1 rounded-pill bg-danger text-white position-absolute top-0 end-0" style="font-size: 8px; transform: translate(30%, -30%);">Leave</span>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                @if($filter == 'upcoming')
                    <form action="{{ route('doctor.unavailability.toggle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="date" value="{{ $selectedDate }}">
                        <button type="submit" class="btn {{ in_array($selectedDate, $unavailabilities) ? 'btn-success' : 'btn-danger' }} rounded-pill px-4 shadow-sm w-100">
                            @if(in_array($selectedDate, $unavailabilities))
                                <i class="fas fa-check-circle me-1"></i> Mark Available
                            @else
                                <i class="fas fa-times-circle me-1"></i> Mark Leave Today
                            @endif
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Minimal Appointment List -->
        <div class="appointment-card-list shadow-sm bg-white rounded-4 overflow-hidden border">
            <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-uppercase small text-muted" style="letter-spacing: 1px;">
                    {{ $filter == 'upcoming' ? 'Today\'s Appointments' : 'All Appointments' }}
                </h6>
                <span class="badge bg-success text-white px-3">{{ $bookings instanceof \Illuminate\Pagination\LengthAwarePaginator ? $bookings->total() : $bookings->count() }} Total</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 small text-uppercase text-muted">Time</th>
                            <th class="py-3 border-0 small text-uppercase text-muted">Patient Name</th>
                            <th class="py-3 border-0 small text-uppercase text-muted">Contact Info</th>
                            <th class="py-3 border-0 small text-uppercase text-muted">Status</th>
                            <th class="py-3 border-0 small text-uppercase text-muted">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark fs-6">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</div>
                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M') }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm bg-success bg-opacity-10 text-success fw-bold d-flex align-items-center justify-content-center rounded-circle" style="width: 35px; height: 35px;">
                                            {{ substr($booking->user->name ?? 'P', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $booking->user->name ?? 'Patient' }}</div>
                                            @if($booking->consultation_type === 'Online')
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill small" style="font-size: 10px;">
                                                    <i class="fas fa-video me-1"></i> Online
                                                </span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill small" style="font-size: 10px;">
                                                    <i class="fas fa-user me-1"></i> Offline
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-medium"><i class="fas fa-phone-alt me-1 text-muted"></i> {{ $booking->user->phone ?? 'No Phone' }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 150px;">{{ $booking->user->email ?? '' }}</div>
                                </td>
                                <td>
                                    @if($booking->status == 'Pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10 px-3 py-1 rounded-pill">Pending</span>
                                    @elseif($booking->status == 'Booked')
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-1 rounded-pill">Scheduled</span>
                                        @if($booking->consultation_type == 'Online')
                                            @php $meetLink = $booking->google_meet_link ?: ($booking->doctor->google_meet_link ?? null); @endphp
                                            <div class="mt-1 small">
                                                @if($meetLink)
                                                    <a href="{{ $meetLink }}" target="_blank" class="text-primary text-decoration-none small"><i class="fas fa-video me-1"></i> Meet Link</a>
                                                @else
                                                    <span class="text-danger small"><i class="fas fa-exclamation-circle me-1"></i> No link</span>
                                                @endif
                                                <button type="button" class="btn btn-link btn-sm p-0 text-muted ms-1" data-bs-toggle="modal" data-bs-target="#acceptOnlineModal-{{ $booking->id }}" title="Edit Google Meet Link">
                                                    <i class="fas fa-pencil-alt small"></i>
                                                </button>
                                            </div>
                                        @endif
                                    @elseif($booking->status == 'Completed')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-3 py-1 rounded-pill">Completed</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 px-3 py-1 rounded-pill">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->status == 'Pending')
                                        @if($booking->consultation_type === 'Online')
                                            <button type="button" class="btn btn-sm btn-success rounded-pill px-3 py-1 me-1" data-bs-toggle="modal" data-bs-target="#acceptOnlineModal-{{ $booking->id }}">
                                                <i class="fas fa-check me-1 small"></i> Accept
                                            </button>
                                        @else
                                            <form action="{{ route('doctor.bookings.status.update', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Booked">
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1 me-1"><i class="fas fa-check me-1 small"></i> Accept</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('doctor.bookings.status.update', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Cancelled">
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 py-1"><i class="fas fa-times me-1 small"></i> Reject</button>
                                        </form>
                                    @elseif($booking->status == 'Booked')
                                        <form action="{{ route('doctor.bookings.status.update', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Completed">
                                            <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 me-1"><i class="fas fa-check-double me-1 small"></i> Complete</button>
                                        </form>
                                        <form action="{{ route('doctor.bookings.status.update', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Cancelled">
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1"><i class="fas fa-ban me-1 small"></i> Cancel</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif

                                    @if($booking->consultation_type === 'Online')
                                        <!-- Accept / Update Meet Link Modal for Booking #{{ $booking->id }} -->
                                        <div class="modal fade" id="acceptOnlineModal-{{ $booking->id }}" tabindex="-1" aria-labelledby="acceptOnlineModalLabel-{{ $booking->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                                    <form action="{{ route('doctor.bookings.status.update', $booking->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Booked">
                                                        <div class="modal-header border-0 pb-0 pt-4 px-4">
                                                            <h5 class="modal-title fw-bold" id="acceptOnlineModalLabel-{{ $booking->id }}">
                                                                <i class="fas fa-video text-success me-2"></i>
                                                                {{ $booking->status == 'Booked' ? 'Update Google Meet Link' : 'Approve Online Consultation' }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="p-3 bg-light rounded-3 mb-3">
                                                                <div class="d-flex justify-content-between mb-1">
                                                                    <span class="text-muted small">Patient:</span>
                                                                    <span class="fw-bold small">{{ $booking->user->name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="text-muted small">Date & Time:</span>
                                                                    <span class="fw-bold small">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} at {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="meet_link_{{ $booking->id }}" class="form-label fw-semibold small">
                                                                    Google Meet Link <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text bg-white text-muted"><i class="fas fa-link"></i></span>
                                                                    <input type="url" 
                                                                           name="google_meet_link" 
                                                                           id="meet_link_{{ $booking->id }}" 
                                                                           class="form-control" 
                                                                           placeholder="https://meet.google.com/xxx-xxxx-xxx" 
                                                                           value="{{ old('google_meet_link', $booking->google_meet_link ?: ($booking->doctor->google_meet_link ?? '')) }}" 
                                                                           required>
                                                                </div>
                                                                <div class="form-text small text-muted">
                                                                    Paste the Google Meet link for this consultation. The patient will see this link after approval.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0 px-4 pb-4">
                                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                                                <i class="fas fa-check-circle me-1"></i> {{ $booking->status == 'Booked' ? 'Save Link' : 'Approve & Save Link' }}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center text-muted">
                                    <i class="fas fa-calendar-times mb-3 fa-2x opacity-25"></i>
                                    <p class="mb-0">No appointments found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="px-4 py-3 bg-light border-top d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} appointments
                    </div>
                    <div class="d-flex gap-2">
                        @if($bookings->onFirstPage())
                            <span class="btn btn-sm btn-light disabled px-3 rounded-pill border">Previous</span>
                        @else
                            <a href="{{ $bookings->previousPageUrl() }}&filter=all" class="btn btn-sm btn-white px-3 rounded-pill border text-dark text-decoration-none shadow-sm">Previous</a>
                        @endif

                        @if($bookings->hasMorePages())
                            <a href="{{ $bookings->nextPageUrl() }}&filter=all" class="btn btn-sm btn-white px-3 rounded-pill border text-dark text-decoration-none shadow-sm">Next</a>
                        @else
                            <span class="btn btn-sm btn-light disabled px-3 rounded-pill border">Next</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Full Calendar Modal -->
<div class="modal fade" id="calendarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pb-0 pe-4 pt-4">
                <h5 class="fw-bold mb-0 ms-2">Appointment Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="fullCalendar" class="p-2">
                    <div class="d-flex align-items-center justify-content-between mb-4 px-2">
                        <h4 id="currentMonthStr" class="mb-0 fw-bold">Month Year</h4>
                        <div class="btn-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                            <button class="btn btn-light btn-sm px-3" onclick="prevMonth()"><i class="fas fa-chevron-left"></i></button>
                            <button class="btn btn-light btn-sm px-3" onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="calendar-grid">
                        <div class="calendar-weekday">Sun</div>
                        <div class="calendar-weekday">Mon</div>
                        <div class="calendar-weekday">Tue</div>
                        <div class="calendar-weekday">Wed</div>
                        <div class="calendar-weekday">Thu</div>
                        <div class="calendar-weekday">Fri</div>
                        <div class="calendar-weekday">Sat</div>
                    </div>
                    <div id="calendarDays" class="calendar-grid mt-2">
                        <!-- Days will be generated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Date Pills */
    .date-pill {
        padding: 10px 15px;
        border-radius: 14px;
        background: #f8f9fa;
        min-width: 60px;
        border: 1px solid #eee;
        transition: all 0.2s;
    }
    .date-pill .day { font-size: 0.7rem; font-weight: 700; color: #6c757d; text-uppercase: true; }
    .date-pill .num { font-size: 1.1rem; font-weight: 800; color: #212529; }
    .date-pill.active { background: #1a4d2e; border-color: #1a4d2e; color: #fff; }
    .date-pill.active .day, .date-pill.active .num { color: #fff; }

    /* Calendar Grid */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }
    .calendar-weekday {
        text-align: center;
        font-weight: 700;
        font-size: 0.75rem;
        text-uppercase: true;
        color: #adb5bd;
        padding-bottom: 10px;
    }
    .calendar-day {
        aspect-ratio: 1/1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        cursor: pointer;
        position: relative;
        font-weight: 600;
        transition: all 0.2s;
        border: 1px solid #f8f9fa;
        background: #fff;
    }
    .calendar-day:hover { background: #f0f7f4; border-color: #e8f5e9; }
    .calendar-day.today { border: 2px solid #1a4d2e; color: #1a4d2e; }
    .calendar-day.has-appointment { background: #e8f5e9; }
    
    /* Green Button Marker */
    .calendar-day.has-appointment::after {
        content: '';
        position: absolute;
        bottom: 5px;
        width: 6px;
        height: 6px;
        background: #198754;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(25, 135, 84, 0.5);
    }
    
    .calendar-day.on-leave { background: #fee2e2; border-color: #fecaca; color: #991b1b; }
    
    .calendar-day.on-leave::after {
        content: '';
        background: #ef4444 !important;
        box-shadow: 0 0 5px rgba(239, 68, 68, 0.5) !important;
    }

    .calendar-day.past-date {
        background-color: #f1f3f5 !important;
        color: #a0aec0 !important;
        opacity: 0.45 !important;
        cursor: not-allowed !important;
        pointer-events: none !important;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05) !important;
        border-color: #e9ecef !important;
        text-decoration: line-through;
    }

    .date-pill.unavailable {
        background: #f1f3f5 !important;
        border-color: #dee2e6 !important;
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .date-pill.unavailable .day, .date-pill.unavailable .num {
        color: #adb5bd !important;
        text-decoration: line-through;
    }

    .pagination { margin-bottom: 0; }
    .page-link { color: #1a4d2e; border-radius: 8px !important; margin: 0 2px; border: none; background: #f8f9fa; }
    .page-item.active .page-link { background-color: #1a4d2e; border-color: #1a4d2e; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const appointmentDates = {!! json_encode($allBookingDates) !!};
    const leaveDates = {!! json_encode($unavailabilities) !!};
    let currentViewDate = new Date();

    function renderCalendar() {
        const calendarDays = document.getElementById('calendarDays');
        const monthStr = document.getElementById('currentMonthStr');
        calendarDays.innerHTML = '';
        
        const year = currentViewDate.getFullYear();
        const month = currentViewDate.getMonth();
        monthStr.innerText = new Intl.DateTimeFormat('en-US', { month: 'long', year: 'numeric' }).format(currentViewDate);
        
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getUTCDate(); // Fixed for UTC
        const now = new Date();
        
        // Offset
        const prevMonthDays = new Date(year, month, 0).getDate();
        for (let i = firstDay - 1; i >= 0; i--) {
            const div = document.createElement('div');
            div.className = 'calendar-day other-month';
            div.innerText = prevMonthDays - i;
            calendarDays.appendChild(div);
        }
        
        const todayStr = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;

        for (let i = 1; i <= new Date(year, month + 1, 0).getDate(); i++) {
            const div = document.createElement('div');
            div.className = 'calendar-day';
            div.innerText = i;
            
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            
            if (appointmentDates.includes(dateStr)) {
                div.classList.add('has-appointment');
            }

            if (leaveDates.includes(dateStr)) {
                div.classList.add('on-leave');
                div.title = 'Marked as Leave';
            }
            
            if (dateStr < todayStr) {
                div.classList.add('past-date');
                div.title = 'Past Date (Disabled)';
            } else {
                if (year === now.getFullYear() && month === now.getMonth() && i === now.getDate()) {
                    div.classList.add('today');
                }
                
                div.addEventListener('click', () => {
                    window.location.href = `{{ route('doctor.dashboard') }}?filter=upcoming&date=${dateStr}`;
                });
            }
            
            calendarDays.appendChild(div);
        }
    }

    window.prevMonth = function() {
        const today = new Date();
        const minDate = new Date(today.getFullYear(), today.getMonth(), 1);
        const target = new Date(currentViewDate.getFullYear(), currentViewDate.getMonth() - 1, 1);
        
        if (target >= minDate) {
            currentViewDate.setMonth(currentViewDate.getMonth() - 1);
            renderCalendar();
        }
    };

    window.nextMonth = function() {
        const today = new Date();
        const maxDate = new Date(today.getFullYear(), today.getMonth() + 3, 1);
        const target = new Date(currentViewDate.getFullYear(), currentViewDate.getMonth() + 1, 1);
        
        if (target <= maxDate) {
            currentViewDate.setMonth(currentViewDate.getMonth() + 1);
            renderCalendar();
        }
    };

    renderCalendar();
});
</script>
@endsection
