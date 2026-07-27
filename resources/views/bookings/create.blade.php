@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Book Doctor | Ayurveda')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header py-4" style="background: linear-gradient(135deg, #1a4d2e, #4f772d);">
                <h4 class="mb-0 text-white fw-bold">
                    <i class="fas fa-calendar-plus me-2"></i> Book Appointment
                </h4>
            </div>
            <div class="card-body p-4">
                {{-- Doctor Summary --}}
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="background: #f0f7f4;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:60px;height:60px;background:#1a4d2e;">
                        <i class="fas fa-user-md fa-lg text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold" style="color:#1a4d2e;">Dr. {{ $doctor->name }}</h5>
                        <p class="mb-0 text-muted small">
                            {{ $doctor->specialization_category ?? 'General' }} &bull; {{ $doctor->district->name ?? '' }}
                        </p>
                        <p class="mb-0 small">
                            <strong>₹{{ number_format($doctor->consultation_fee, 0) }}</strong>
                            <span class="text-muted">consultation fee</span>
                        </p>
                        <div class="mt-1 d-flex gap-2 flex-wrap">
                            @if(in_array($doctor->consultation_type, ['Offline', 'Both']) && $doctor->available_time)
                                <span class="badge bg-secondary"><i class="fas fa-hospital me-1"></i>In-person: {{ $doctor->available_time }}</span>
                            @endif
                            @if(in_array($doctor->consultation_type, ['Online', 'Both']) && $doctor->online_available_time)
                                <span class="badge" style="background:#0d6efd;"><i class="fas fa-video me-1"></i>Online: {{ $doctor->online_available_time }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                    {{-- Consultation Type Selection --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Consultation Type</label>
                        @if($doctor->consultation_type === 'Both')
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="radio" name="consultation_type" value="Offline" id="type_offline" class="btn-check" {{ old('consultation_type') === 'Online' ? '' : 'checked' }} required>
                                    <label for="type_offline" class="btn btn-outline-secondary w-100 py-3 rounded-3">
                                        <i class="fas fa-hospital d-block mb-1 fa-lg"></i>
                                        <strong>In-Person</strong>
                                        <div class="small opacity-75">{{ $doctor->available_time ?? 'Check schedule' }}</div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" name="consultation_type" value="Online" id="type_online" class="btn-check" {{ old('consultation_type') === 'Online' ? 'checked' : '' }} required>
                                    <label for="type_online" class="btn btn-outline-primary w-100 py-3 rounded-3">
                                        <i class="fas fa-video d-block mb-1 fa-lg"></i>
                                        <strong>Online Video</strong>
                                        <div class="small opacity-75">{{ $doctor->online_available_time ?? 'Check schedule' }}</div>
                                    </label>
                                </div>
                            </div>
                        @elseif($doctor->consultation_type === 'Online')
                            <input type="hidden" name="consultation_type" value="Online">
                            <div class="alert alert-info d-flex align-items-center gap-3 mb-0">
                                <i class="fas fa-video fa-2x"></i>
                                <div>
                                    <strong>Online Consultation Only</strong>
                                    <div class="small">This doctor is available online via Google Meet. A meeting link will be sent to you upon approval.</div>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="consultation_type" value="Offline">
                            <div class="alert alert-secondary d-flex align-items-center gap-3 mb-0">
                                <i class="fas fa-hospital fa-2x"></i>
                                <div>
                                    <strong>In-Person Consultation Only</strong>
                                    <div class="small">This doctor is available for in-person visits at their clinic.</div>
                                </div>
                            </div>
                        @endif
                        @error('consultation_type') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Appointment Date</label>
                            <input type="date"
                                   name="booking_date"
                                   id="booking_date"
                                   class="form-control @error('booking_date') is-invalid @enderror"
                                   min="{{ date('Y-m-d') }}"
                                   max="{{ date('Y-m-t', strtotime('+3 months')) }}"
                                   value="{{ old('booking_date', date('Y-m-d')) }}"
                                   required>
                            @error('booking_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Select Appointment Time</label>
                            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-2" id="time-slots-container">
                                @foreach($slots as $slot)
                                    <div class="col">
                                        <input type="radio" name="booking_time" value="{{ $slot }}" id="slot-{{ str_replace(':', '-', $slot) }}" class="btn-check" required>
                                        <label class="btn btn-outline-success w-100 py-2 rounded-3 shadow-sm time-slot-label" for="slot-{{ str_replace(':', '-', $slot) }}" data-slot="{{ $slot }}">
                                            {{ \Carbon\Carbon::parse($slot)->format('h:i A') }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('booking_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success px-4 fw-semibold shadow-sm">
                            <i class="fas fa-check-circle me-2"></i>Confirm Booking
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>

                <style>
                    .time-slot-label.booked {
                        background-color: #f8f9fa !important;
                        border-color: #e9ecef !important;
                        color: #adb5bd !important;
                        opacity: 0.55 !important;
                        cursor: not-allowed !important;
                        pointer-events: none !important;
                        box-shadow: inset 0 2px 4px rgba(0,0,0,0.04) !important;
                        text-decoration: none !important;
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const bookedData = {!! $bookedSlots->toJson() !!};
                        const leaveDates = {!! json_encode($unavailabilities) !!};
                        const offlineSlots = {!! json_encode(array_values($offlineSlots ?? [])) !!};
                        const onlineSlots = {!! json_encode(array_values($onlineSlots ?? [])) !!};

                        const dateInput = document.getElementById('booking_date');
                        const timeSlotsContainer = document.getElementById('time-slots-container');
                        const submitBtn = document.querySelector('button[type="submit"]');

                        function getSelectedConsultationType() {
                            const onlineRadio = document.getElementById('type_online');
                            const offlineRadio = document.getElementById('type_offline');
                            if (onlineRadio && onlineRadio.checked) return 'Online';
                            if (offlineRadio && offlineRadio.checked) return 'Offline';
                            const hiddenType = document.querySelector('input[name="consultation_type"]');
                            return hiddenType ? hiddenType.value : 'Offline';
                        }

                        function formatTime12h(time24) {
                            if (!time24) return '';
                            const [hStr, mStr] = time24.split(':');
                            let h = parseInt(hStr, 10);
                            const ampm = h >= 12 ? 'PM' : 'AM';
                            h = h % 12;
                            h = h ? h : 12;
                            return (h < 10 ? '0' + h : h) + ':' + mStr + ' ' + ampm;
                        }

                        function renderAndFilterSlots() {
                            const selectedDate = dateInput.value;
                            if (!selectedDate) return;

                            const now = new Date();
                            const todayStr = now.toLocaleDateString('en-CA'); // YYYY-MM-DD
                            const currentTimeStr = now.getHours().toString().padStart(2, '0') + ":" + now.getMinutes().toString().padStart(2, '0');

                            if (selectedDate < todayStr) {
                                alert("Past dates cannot be selected for appointment bookings. Resetting to today.");
                                dateInput.value = todayStr;
                                renderAndFilterSlots();
                                return;
                            }

                            const isUnavailable = leaveDates.includes(selectedDate);
                            if (isUnavailable) {
                                timeSlotsContainer.innerHTML = `
                                    <div class="col-12 w-100 mt-2">
                                        <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center py-4">
                                            <i class="fas fa-calendar-times fa-3x me-4 opacity-50"></i>
                                            <div>
                                                <h5 class="fw-bold mb-1">Doctor is Unavailable</h5>
                                                <p class="mb-0 small opacity-75">The doctor has marked this date as a leave. Please select another date for your appointment.</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                submitBtn.disabled = true;
                                submitBtn.classList.add('opacity-50');
                                return;
                            }

                            const currentType = getSelectedConsultationType();
                            let rawSlots = (currentType === 'Online') ? onlineSlots : offlineSlots;

                            if (!rawSlots || rawSlots.length === 0) {
                                rawSlots = (offlineSlots && offlineSlots.length > 0) ? offlineSlots : ((onlineSlots && onlineSlots.length > 0) ? onlineSlots : ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00']);
                            }

                            let html = '';
                            rawSlots.forEach(slot => {
                                const slotTimeNormalized = slot.substring(0, 5); // "HH:mm"
                                const slotId = 'slot-' + slotTimeNormalized.replace(':', '-');
                                const displayTime = formatTime12h(slotTimeNormalized);

                                // Check if booked by another patient on this date
                                const isBooked = bookedData.some(b => {
                                    const bTimeNorm = b.booking_time.substring(0, 5);
                                    return b.booking_date === selectedDate && bTimeNorm === slotTimeNormalized;
                                });

                                // Check if slot is in the past for TODAY
                                const isPast = (selectedDate === todayStr && slotTimeNormalized < currentTimeStr);

                                const isBlocked = isBooked || isPast;
                                const disabledAttr = isBlocked ? 'disabled' : '';
                                const bookedClass = isBlocked ? 'booked' : '';

                                html += `
                                    <div class="col">
                                        <input type="radio" name="booking_time" value="${slotTimeNormalized}" id="${slotId}" class="btn-check" ${disabledAttr} required>
                                        <label class="btn btn-outline-success w-100 py-2 rounded-3 shadow-sm time-slot-label ${bookedClass}" for="${slotId}" data-slot="${slotTimeNormalized}">
                                            ${displayTime}
                                        </label>
                                    </div>
                                `;
                            });

                            timeSlotsContainer.innerHTML = html;
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50');
                        }

                        dateInput.addEventListener('change', renderAndFilterSlots);

                        const typeOnlineRadio = document.getElementById('type_online');
                        const typeOfflineRadio = document.getElementById('type_offline');
                        if (typeOnlineRadio) typeOnlineRadio.addEventListener('change', renderAndFilterSlots);
                        if (typeOfflineRadio) typeOfflineRadio.addEventListener('change', renderAndFilterSlots);

                        renderAndFilterSlots(); // Initial render
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
