@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('title', 'Reschedule Appointment | Ayurveda')

@section('content')
<div class="container page-shell py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header py-4" style="background: linear-gradient(135deg, #1a4d2e, #4f772d);">
                    <h4 class="mb-0 text-white fw-bold">
                        <i class="fas fa-calendar-alt me-2"></i> Reschedule Appointment
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bookings.reschedule.update', $booking->id) }}" method="POST" id="reschedule-form">
                        @csrf

                        {{-- Doctor Selection --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #1a4d2e;">Choose Doctor</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-user-md"></i></span>
                                <select name="doctor_id" id="doctor_id" class="form-select border-start-0 ps-0 fw-semibold @error('doctor_id') is-invalid @enderror" required>
                                    @foreach($doctors as $doc)
                                        <option value="{{ $doc->id }}" {{ $doc->id == old('doctor_id', $booking->doctor_id) ? 'selected' : '' }}>
                                            Dr. {{ $doc->name }} ({{ $doc->specialization_category ?? 'General' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('doctor_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- Doctor Card Dynamic Area --}}
                        <div id="doctor-card-container" class="position-relative mb-4">
                            <!-- Loading Spinner Overlay -->
                            <div id="doctor-loading" class="position-absolute top-0 start-0 w-100 h-100 d-none justify-content-center align-items-center rounded-3" style="background: rgba(255,255,255,0.85); z-index: 10;">
                                <div class="spinner-border text-success" role="status">
                                    <span class="visually-hidden">Loading Doctor details...</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 p-3 rounded-3" id="doctor-details-card" style="background: #f0f7f4; border: 1px solid #e1eee8;">
                                <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width:65px;height:65px;background:#1a4d2e;border:2px solid #fff;">
                                    <img id="doctor-photo" src="" alt="Doctor photo" class="d-none" style="width:100%;height:100%;object-fit:cover;">
                                    <i id="doctor-icon-placeholder" class="fas fa-user-md fa-lg text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold" style="color:#1a4d2e;" id="doctor-name">Dr. Loading...</h5>
                                    <p class="mb-0 text-muted small" id="doctor-meta">
                                        Loading specialization...
                                    </p>
                                    <p class="mb-0 small">
                                        <strong id="doctor-fee">₹0</strong>
                                        <span class="text-muted">consultation fee</span>
                                    </p>
                                    <div class="mt-1 d-flex gap-2 flex-wrap" id="doctor-schedules">
                                        <!-- Will be populated via Javascript -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Consultation Type Selection --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #1a4d2e;">Consultation Type</label>
                            
                            <!-- Both Options Template -->
                            <div id="consultation-both" class="row g-3 d-none">
                                <div class="col-6">
                                    <input type="radio" name="consultation_type" value="Offline" id="type_offline" class="btn-check" required>
                                    <label for="type_offline" class="btn btn-outline-secondary w-100 py-3 rounded-3">
                                        <i class="fas fa-hospital d-block mb-1 fa-lg"></i>
                                        <strong>In-Person</strong>
                                        <div class="small opacity-75" id="schedule-offline-text">Check schedule</div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" name="consultation_type" value="Online" id="type_online" class="btn-check" required>
                                    <label for="type_online" class="btn btn-outline-primary w-100 py-3 rounded-3">
                                        <i class="fas fa-video d-block mb-1 fa-lg"></i>
                                        <strong>Online Video</strong>
                                        <div class="small opacity-75" id="schedule-online-text">Check schedule</div>
                                    </label>
                                </div>
                            </div>

                            <!-- Online Only Template -->
                            <div id="consultation-online-only" class="alert alert-info d-flex align-items-center gap-3 mb-0 d-none">
                                <i class="fas fa-video fa-2x"></i>
                                <div>
                                    <strong>Online Consultation Only</strong>
                                    <div class="small">This doctor is available online via Google Meet. A meeting link will be sent to you upon approval.</div>
                                </div>
                            </div>

                            <!-- Offline Only Template -->
                            <div id="consultation-offline-only" class="alert alert-secondary d-flex align-items-center gap-3 mb-0 d-none">
                                <i class="fas fa-hospital fa-2x"></i>
                                <div>
                                    <strong>In-Person Consultation Only</strong>
                                    <div class="small">This doctor is available for in-person visits at their clinic.</div>
                                </div>
                            </div>

                            @error('consultation_type') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" style="color: #1a4d2e;">Appointment Date</label>
                                <input type="date"
                                       name="booking_date"
                                       id="booking_date"
                                       class="form-control @error('booking_date') is-invalid @enderror"
                                       min="{{ date('Y-m-d') }}"
                                       max="{{ date('Y-m-t', strtotime('+3 months')) }}"
                                       value="{{ old('booking_date', $booking->booking_date) }}"
                                       required>
                                @error('booking_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="color: #1a4d2e;">Select Appointment Time</label>
                                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-2" id="time-slots-container">
                                    <!-- Dynamic Time slots -->
                                </div>
                                @error('booking_time')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4 fw-semibold shadow-sm" id="submit-btn">
                                <i class="fas fa-check-circle me-2"></i>Save Rescheduled Appointment
                            </button>
                            <a href="{{ route('bookings.my') }}" class="btn btn-outline-secondary px-4">Back</a>
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
                            const originalDoctorId = "{{ $booking->doctor_id }}";
                            const originalDate = "{{ $booking->booking_date }}";
                            const originalSlot = "{{ substr($booking->booking_time, 0, 5) }}";
                            const originalConsultationType = "{{ $booking->consultation_type }}";

                            const doctorSelect = document.getElementById('doctor_id');
                            const dateInput = document.getElementById('booking_date');
                            const timeSlotsContainer = document.getElementById('time-slots-container');
                            const submitBtn = document.getElementById('submit-btn');

                            const loader = document.getElementById('doctor-loading');
                            const docPhoto = document.getElementById('doctor-photo');
                            const docIcon = document.getElementById('doctor-icon-placeholder');
                            const docName = document.getElementById('doctor-name');
                            const docMeta = document.getElementById('doctor-meta');
                            const docFee = document.getElementById('doctor-fee');
                            const docSchedules = document.getElementById('doctor-schedules');

                            // Consultation containers
                            const bothContainer = document.getElementById('consultation-both');
                            const onlineOnlyContainer = document.getElementById('consultation-online-only');
                            const offlineOnlyContainer = document.getElementById('consultation-offline-only');

                            const radioOnline = document.getElementById('type_online');
                            const radioOffline = document.getElementById('type_offline');

                            let currentDoctorData = null;

                            // Format 12-hour time
                            function formatTime12h(time24) {
                                if (!time24) return '';
                                const [hStr, mStr] = time24.split(':');
                                let h = parseInt(hStr, 10);
                                const ampm = h >= 12 ? 'PM' : 'AM';
                                h = h % 12;
                                h = h ? h : 12;
                                return (h < 10 ? '0' + h : h) + ':' + mStr + ' ' + ampm;
                            }

                            // Fetch doctor details
                            async function fetchDoctorDetails(doctorId) {
                                loader.classList.remove('d-none');
                                loader.classList.add('d-flex');
                                submitBtn.disabled = true;

                                try {
                                    const response = await fetch(`/doctors/${doctorId}/booking-details`);
                                    if (!response.ok) throw new Error('Network error fetching doctor details');

                                    currentDoctorData = await response.json();
                                    updateDoctorDetailsUI();
                                    renderAndFilterSlots();
                                } catch (error) {
                                    console.error(error);
                                    alert('Failed to load doctor schedule. Please try again.');
                                } finally {
                                    loader.classList.add('d-none');
                                    loader.classList.remove('d-flex');
                                }
                            }

                            // Update doctor info card and consultation type radios
                            function updateDoctorDetailsUI() {
                                if (!currentDoctorData) return;

                                const doc = currentDoctorData.doctor;

                                // Update Card
                                docName.textContent = `Dr. ${doc.name}`;
                                docMeta.textContent = `${doc.specialization_category} • ${doc.district_name}`;
                                docFee.textContent = `₹${doc.consultation_fee}`;

                                if (doc.photo) {
                                    docPhoto.src = doc.photo;
                                    docPhoto.classList.remove('d-none');
                                    docIcon.classList.add('d-none');
                                } else {
                                    docPhoto.classList.add('d-none');
                                    docIcon.classList.remove('d-none');
                                }

                                // Update Consultation schedules tags
                                let scheduleHtml = '';
                                if (['Offline', 'Both'].includes(doc.consultation_type) && doc.available_time) {
                                    scheduleHtml += `<span class="badge bg-secondary"><i class="fas fa-hospital me-1"></i>In-person: ${doc.available_time}</span>`;
                                }
                                if (['Online', 'Both'].includes(doc.consultation_type) && doc.online_available_time) {
                                    scheduleHtml += `<span class="badge" style="background:#0d6efd;"><i class="fas fa-video me-1"></i>Online: ${doc.online_available_time}</span>`;
                                }
                                docSchedules.innerHTML = scheduleHtml;

                                // Update consultation selection layout
                                bothContainer.classList.add('d-none');
                                onlineOnlyContainer.classList.add('d-none');
                                offlineOnlyContainer.classList.add('d-none');

                                // Clear radios checked state
                                if (radioOnline) radioOnline.checked = false;
                                if (radioOffline) radioOffline.checked = false;

                                const oldTypeInput = document.querySelector('input[name="consultation_type"]:checked');
                                let typeToSelect = oldTypeInput ? oldTypeInput.value : null;

                                // If it is the initial load with the original doctor, set it to the original type
                                if (doc.id == originalDoctorId && !typeToSelect) {
                                    typeToSelect = originalConsultationType;
                                }

                                if (doc.consultation_type === 'Both') {
                                    bothContainer.classList.remove('d-none');
                                    document.getElementById('schedule-offline-text').textContent = doc.available_time || 'Check schedule';
                                    document.getElementById('schedule-online-text').textContent = doc.online_available_time || 'Check schedule';

                                    // Set default or restore selection
                                    if (typeToSelect === 'Online') {
                                        radioOnline.checked = true;
                                    } else {
                                        radioOffline.checked = true;
                                    }
                                } else if (doc.consultation_type === 'Online') {
                                    onlineOnlyContainer.classList.remove('d-none');
                                    // Create or ensure hidden input exists for consultation_type
                                    createHiddenConsultationTypeInput('Online');
                                } else {
                                    offlineOnlyContainer.classList.remove('d-none');
                                    createHiddenConsultationTypeInput('Offline');
                                }
                            }

                            // Creates a hidden consultation type input when only 1 option is available
                            function createHiddenConsultationTypeInput(val) {
                                let hiddenInput = document.querySelector('input[type="hidden"][name="consultation_type"]');
                                if (!hiddenInput) {
                                    hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = 'consultation_type';
                                    document.getElementById('reschedule-form').appendChild(hiddenInput);
                                }
                                hiddenInput.value = val;
                            }

                            function getSelectedConsultationType() {
                                if (currentDoctorData && currentDoctorData.doctor) {
                                    const type = currentDoctorData.doctor.consultation_type;
                                    if (type !== 'Both') return type;
                                }
                                if (radioOnline && radioOnline.checked) return 'Online';
                                if (radioOffline && radioOffline.checked) return 'Offline';
                                return 'Offline';
                            }

                            // Render slots dynamically
                            function renderAndFilterSlots() {
                                if (!currentDoctorData) return;

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

                                const isUnavailable = currentDoctorData.unavailabilities.includes(selectedDate);
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
                                const rawSlots = currentType === 'Online' ? currentDoctorData.onlineSlots : currentDoctorData.offlineSlots;

                                let html = '';
                                rawSlots.forEach(slot => {
                                    const slotTimeNormalized = slot.substring(0, 5); // "HH:mm"
                                    const slotId = 'slot-' + slotTimeNormalized.replace(':', '-');
                                    const displayTime = formatTime12h(slotTimeNormalized);

                                    // Check if booked by another patient on this date
                                    const isBooked = currentDoctorData.bookedSlots.some(b => {
                                        const bTimeNorm = b.booking_time.substring(0, 5);
                                        // Ignore booking's own slot if rescheduling to same doctor and same date
                                        if (doctorSelect.value == originalDoctorId && selectedDate === originalDate && slotTimeNormalized === originalSlot) {
                                            return false;
                                        }
                                        return b.booking_date === selectedDate && bTimeNorm === slotTimeNormalized;
                                    });

                                    const isPast = (selectedDate === todayStr && slotTimeNormalized < currentTimeStr);
                                    const isBlocked = isBooked || isPast;

                                    const disabledAttr = isBlocked ? 'disabled' : '';
                                    const bookedClass = isBlocked ? 'booked' : '';

                                    // Preselect if it's the original slot
                                    const isOriginal = (doctorSelect.value == originalDoctorId && selectedDate === originalDate && slotTimeNormalized === originalSlot);
                                    const checkedAttr = isOriginal ? 'checked' : '';

                                    html += `
                                        <div class="col">
                                            <input type="radio" name="booking_time" value="${slotTimeNormalized}" id="${slotId}" class="btn-check" ${disabledAttr} ${checkedAttr} required>
                                            <label class="btn btn-outline-success w-100 py-2 rounded-3 shadow-sm time-slot-label ${bookedClass}" for="${slotId}" data-slot="${slotTimeNormalized}">
                                                ${displayTime} ${isOriginal ? '<span class="d-block small opacity-75">(Current)</span>' : ''}
                                            </label>
                                        </div>
                                    `;
                                });

                                timeSlotsContainer.innerHTML = html || '<div class="col-12 text-muted">No time slots available for this consultation type.</div>';
                                submitBtn.disabled = false;
                                submitBtn.classList.remove('opacity-50');
                            }

                            // Event Listeners
                            doctorSelect.addEventListener('change', function() {
                                fetchDoctorDetails(this.value);
                            });

                            dateInput.addEventListener('change', renderAndFilterSlots);

                            if (radioOnline) radioOnline.addEventListener('change', renderAndFilterSlots);
                            if (radioOffline) radioOffline.addEventListener('change', renderAndFilterSlots);

                            // Initial load
                            fetchDoctorDetails(doctorSelect.value);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
