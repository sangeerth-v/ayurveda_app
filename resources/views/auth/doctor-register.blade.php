<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Application | Ayurveda Management System</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-dark: #123722;
            --primary-green: #1a4d2e;
            --secondary-green: #2d6a4f;
            --accent-green: #40916c;
            --accent-gold: #c5a059;
            --light-bg: #fcfdfa;
            --beige-bg: #fbf8f3;
            --text-dark: #1b4332;
            --shadow-md: 0 12px 32px rgba(26, 77, 46, 0.08);
            --shadow-lg: 0 20px 40px rgba(26, 77, 46, 0.12);
        }

        /* Hide browser-native password reveal eye icons */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear,
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--beige-bg);
            color: var(--text-dark);
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        .split-layout {
            min-height: 100vh;
            display: flex;
        }

        /* Left Side Illustration & Branding */
        .left-panel {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-green) 50%, var(--secondary-green) 100%);
            color: #ffffff;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(197, 160, 89, 0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -150px;
            right: -150px;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(64, 145, 108, 0.25) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .illustration-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 2rem 0;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .illustration-art {
            position: relative;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .center-circle {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            border: 2px dashed rgba(197, 160, 89, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: var(--accent-gold);
            animation: pulse-ring 4s infinite ease-in-out;
        }

        @keyframes pulse-ring {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .floating-badge {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            color: var(--primary-green);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.82rem;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 8px;
            animation: float-around 3s infinite ease-in-out alternate;
        }

        .badge-1 { top: 10px; left: 10px; }
        .badge-2 { bottom: 10px; right: 10px; animation-delay: 1.5s; }
        .badge-3 { top: 30px; right: 15px; animation-delay: 0.8s; }

        @keyframes float-around {
            from { transform: translateY(0px); }
            to { transform: translateY(-8px); }
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.75rem;
        }

        .brand-subtitle {
            font-size: 0.92rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
            max-width: 480px;
            margin: 0 auto;
        }

        /* Right Side Doctor Register Card Panel */
        .right-panel {
            background-color: var(--beige-bg);
            padding: 2.5rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .doctor-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(224, 229, 213, 0.8);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 720px;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }

        .system-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--primary-green);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #2d4030;
            margin-bottom: 4px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #dce4dc;
            padding: 0.65rem 0.9rem;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-green);
            box-shadow: 0 0 0 3.5px rgba(45, 106, 79, 0.12);
        }

        .btn-submit-doctor {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 18px rgba(26, 77, 46, 0.25);
        }

        .btn-submit-doctor:hover {
            background: linear-gradient(135deg, var(--secondary-green) 0%, var(--accent-green) 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26, 77, 46, 0.35);
        }

        .verification-alert {
            background: #fff8e6;
            border: 1px solid #ffe8b3;
            color: #8a6d3b;
            font-size: 0.8rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            line-height: 1.45;
        }
    </style>
</head>
<body>

@include('partials.nav-public')

<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 80px);">
    <div class="doctor-card">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="system-logo mb-2 d-lg-none">
                        <i class="fas fa-leaf text-success me-1"></i> Ayurveda
                    </a>
                    <h3 class="fw-bold text-dark mb-1"><i class="fas fa-user-md text-success me-2"></i> Apply as Doctor</h3>
                    <p class="text-muted small mb-0">Fill in your medical credentials & registration details below.</p>
                </div>

                <div class="verification-alert">
                    <i class="fas fa-info-circle me-1 text-warning"></i> <strong>Note:</strong> All doctor applications are verified by Admin against council records before account activation.
                </div>

                <!-- Display Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 py-2 px-3 mb-4 small">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Doctor Registration Form -->
                <form action="{{ route('doctor.register.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Dr. Firstname Lastname" value="{{ old('name') }}" minlength="3" required>
                            </div>
                            @error('name') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-6">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="doctor@example.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label class="form-label">Phone Number (10 Digits) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-phone"></i></span>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="9876543210" value="{{ old('phone') }}" pattern="[6-9][0-9]{9}" maxlength="10" minlength="10" title="Valid 10-digit mobile number starting with 6-9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                            </div>
                            @error('phone') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label">Account Password (min 8 chars) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="docPassword" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" minlength="8" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('docPassword', this)"><i class="fas fa-eye"></i></button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Medical Registration Number -->
                        <div class="col-md-6">
                            <label class="form-label">Medical Registration Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="medical_registration_no" class="form-control @error('medical_registration_no') is-invalid @enderror" placeholder="e.g. KMC/12345/2020" value="{{ old('medical_registration_no') }}" maxlength="25" minlength="5" pattern="[A-Z]{2,10}[-\/][A-Z0-9\/-]*[0-9]+[A-Z0-9\/-]*" title="Format: Council Abbreviation / Number / Year e.g. KMC/12345/2020" required>
                            </div>
                            @error('medical_registration_no') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Qualification -->
                        <div class="col-md-6">
                            <label class="form-label">Qualification <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-graduation-cap"></i></span>
                                <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" placeholder="MBBS, BAMS, BHMS, MD..." value="{{ old('qualification') }}" minlength="2" required>
                            </div>
                            @error('qualification') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Specialization Category -->
                        <div class="col-md-6">
                            <label class="form-label">Specialization Category <span class="text-danger">*</span></label>
                            <select name="specialization_category" id="specialization_category" class="form-select @error('specialization_category') is-invalid @enderror" required>
                                <option value="">Select Specialization</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('specialization_category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('specialization_category') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Specialization Subcategory -->
                        <div class="col-md-6">
                            <label class="form-label">Specialization Subcategory</label>
                            <select name="specialization_subcategory" id="specialization_subcategory" class="form-select">
                                <option value="">Select Subcategory</option>
                            </select>
                        </div>

                        <!-- Working District -->
                        <div class="col-md-6">
                            <label class="form-label">Working District <span class="text-danger">*</span></label>
                            <input type="text" name="district_name" id="district_name" list="kerala_districts_list" class="form-control @error('district_name') is-invalid @enderror" placeholder="Type or select district (e.g. Ernakulam)" value="{{ old('district_name') }}" required autocomplete="off">
                            <datalist id="kerala_districts_list">
                                @foreach($districts as $district)
                                    <option value="{{ $district->name }}"></option>
                                @endforeach
                            </datalist>
                            @error('district_name') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Years of Experience -->
                        <div class="col-md-6">
                            <label class="form-label">Years of Experience <span class="text-danger">*</span></label>
                            <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" placeholder="e.g. 5" min="0" value="{{ old('experience') }}" required>
                            @error('experience') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Consultation Fee -->
                        <div class="col-md-6">
                            <label class="form-label">Consultation Fee (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">₹</span>
                                <input type="number" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" placeholder="e.g. 500" min="0" value="{{ old('consultation_fee') }}" required>
                            </div>
                            @error('consultation_fee') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Consultation Mode -->
                        <div class="col-md-6">
                            <label class="form-label">Consultation Mode <span class="text-danger">*</span></label>
                            <select name="consultation_type" id="consultation_type" class="form-select @error('consultation_type') is-invalid @enderror" onchange="toggleConsultationTimes()" required>
                                <option value="Both" {{ old('consultation_type', 'Both') == 'Both' ? 'selected' : '' }}>Both (In-Person & Online Video)</option>
                                <option value="Offline" {{ old('consultation_type') == 'Offline' ? 'selected' : '' }}>In-Person Clinic Only</option>
                                <option value="Online" {{ old('consultation_type') == 'Online' ? 'selected' : '' }}>Online Video Consultation Only</option>
                            </select>
                            @error('consultation_type') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- In-Person Working Hours (15-min Slot Generation) -->
                        <div class="col-md-6" id="offline_time_wrapper">
                            <label class="form-label">In-Person Working Hours (15-Min Slots) <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="time" name="available_from" id="available_from" class="form-control" value="{{ old('available_from', '09:00') }}">
                                    <div class="form-text small">Start Time</div>
                                </div>
                                <div class="col-6">
                                    <input type="time" name="available_to" id="available_to" class="form-control" value="{{ old('available_to', '13:00') }}">
                                    <div class="form-text small">End Time</div>
                                </div>
                            </div>
                        </div>

                        <!-- Online Working Hours (15-min Slot Generation) -->
                        <div class="col-md-6" id="online_time_wrapper">
                            <label class="form-label">Online Video Working Hours (15-Min Slots)</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="time" name="online_available_from" id="online_available_from" class="form-control" value="{{ old('online_available_from', '16:00') }}">
                                    <div class="form-text small">Start Time</div>
                                </div>
                                <div class="col-6">
                                    <input type="time" name="online_available_to" id="online_available_to" class="form-control" value="{{ old('online_available_to', '20:00') }}">
                                    <div class="form-text small">End Time</div>
                                </div>
                            </div>
                        </div>

                        <!-- Hospital Name / Selection -->
                        <div class="col-12">
                            <label class="form-label">Associated Hospital / Practice Center</label>
                            <select name="hospital_id" class="form-select">
                                <option value="">Independent Doctor / Private Practice</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{ old('hospital_id') == $hospital->id ? 'selected' : '' }}>{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Clinic / Practice Address -->
                        <div class="col-12">
                            <label class="form-label">Clinic / Practice Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="Enter complete clinic or consultation address" required>{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Registration Certificate Upload -->
                        <div class="col-md-6">
                            <label class="form-label">Registration Certificate (PDF / Image)</label>
                            <input type="file" name="registration_certificate" class="form-control" accept=".pdf,image/*">
                            <div class="form-text small text-muted">Medical practice registration document (max 5MB).</div>
                        </div>

                        <!-- Medical Council Certificate Upload -->
                        <div class="col-md-6">
                            <label class="form-label">Medical Council Certificate (PDF / Image)</label>
                            <input type="file" name="council_certificate" class="form-control" accept=".pdf,image/*">
                            <div class="form-text small text-muted">State/National council certificate (max 5MB).</div>
                        </div>

                        <!-- Profile Photo Upload -->
                        <div class="col-12">
                            <label class="form-label">Profile Photo (Headshot)</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <div class="form-text small text-muted">Professional headshot photo (JPEG/PNG, max 2MB).</div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-submit-doctor w-100 py-3 fw-bold">
                            <i class="fas fa-paper-plane me-2"></i> Submit Doctor Application
                        </button>
                    </div>
                </form>

                <!-- Login Redirect Link -->
                <div class="text-center mt-4 pt-3 border-top">
                    <p class="small text-muted mb-0">Already registered? <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Sign In Here</a></p>
                </div>
            </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.getElementById('specialization_category').addEventListener('change', function() {
    const categoryId = this.value;
    const subSelect = document.getElementById('specialization_subcategory');
    subSelect.innerHTML = '<option value="">Select Subcategory</option>';
    
    if (categoryId) {
        fetch(`/api/doctor-subcategories/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(sub => {
                    subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            });
    }
});

function toggleConsultationTimes() {
    const typeSelect = document.getElementById('consultation_type');
    const offlineWrap = document.getElementById('offline_time_wrapper');
    const onlineWrap = document.getElementById('online_time_wrapper');
    
    if (!typeSelect || !offlineWrap || !onlineWrap) return;
    
    const val = typeSelect.value;
    
    if (val === 'Offline') {
        offlineWrap.style.display = 'block';
        onlineWrap.style.display = 'none';
    } else if (val === 'Online') {
        offlineWrap.style.display = 'none';
        onlineWrap.style.display = 'block';
    } else { // 'Both'
        offlineWrap.style.display = 'block';
        onlineWrap.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleConsultationTimes();
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        /* ── helpers ── */
        function getFeedback(input) {
            let c = input.closest('.input-group') || input.closest('.form-floating') || input.parentNode;
            let fb = (c.parentNode || c).querySelector('.live-feedback');
            if (!fb) {
                fb = document.createElement('div');
                fb.className = 'live-feedback small mt-1 fw-semibold ps-1';
                (c.parentNode || c).appendChild(fb);
            }
            return fb;
        }
        function ok(input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            const fb = getFeedback(input);
            fb.textContent = '';
            fb.className = 'live-feedback small mt-1 fw-semibold ps-1';
        }
        function err(input, msg) {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            const fb = getFeedback(input);
            fb.textContent = '⚠ ' + msg;
            fb.className = 'live-feedback text-danger small mt-1 fw-semibold ps-1';
        }
        function hint(input, msg) {
            input.classList.remove('is-invalid', 'is-valid');
            const fb = getFeedback(input);
            fb.textContent = '💡 ' + msg;
            fb.className = 'live-feedback text-muted small mt-1 ps-1';
        }
        function clear(input) {
            input.classList.remove('is-invalid', 'is-valid');
            const fb = getFeedback(input);
            fb.textContent = '';
        }

        /* ══════════════════════════════════════════════════
           EMAIL – allow free typing, validate on blur only
           ══════════════════════════════════════════════════ */
        form.querySelectorAll('input[type="email"], input[name="email"]').forEach(inp => {
            inp.addEventListener('blur', () => {
                const v = inp.value.trim();
                if (!v) { clear(inp); return; }
                if (!/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/.test(v)) {
                    err(inp, 'Enter a valid email — e.g. doctor@domain.com');
                } else { ok(inp); }
            });
        });

        /* ══════════════════════════════════════════════════
           PHONE – digits only, first digit 6-9, max 10
           Typing invalid chars: blocked in-place
           ══════════════════════════════════════════════════ */
        form.querySelectorAll('input[name="phone"]').forEach(inp => {
            inp.setAttribute('maxlength', '10');
            inp.setAttribute('inputmode', 'numeric');

            inp.addEventListener('input', function() {
                let cur = this.value.replace(/\D/g, '');
                // First digit must be 6-9
                if (cur.length > 0 && !/^[6-9]/.test(cur)) {
                    cur = cur.slice(1); // strip the bad first digit
                }
                this.value = cur.slice(0, 10);
                const len = this.value.length;
                if (len === 0) { clear(inp); return; }
                if (len < 10) {
                    hint(inp, `${len}/10 digits entered — need ${10 - len} more`);
                } else {
                    ok(inp);
                }
            });

            inp.addEventListener('blur', () => {
                const v = inp.value;
                if (!v) { clear(inp); return; }
                if (!/^[6-9]\d{9}$/.test(v)) {
                    err(inp, 'Must be exactly 10 digits starting with 6, 7, 8, or 9.');
                } else { ok(inp); }
            });
        });

        /* ══════════════════════════════════════════════════
           MEDICAL REGISTRATION NUMBER
           Format: 2-10 UPPERCASE letters → separator (/ or -)
                   → digits + optional year segment
           e.g.  KMC/12345/2020   MCI-98765-2022
           Live: strip invalid chars, guide user position by position
           ══════════════════════════════════════════════════ */
        form.querySelectorAll('input[name="medical_registration_no"]').forEach(inp => {
            inp.setAttribute('maxlength', '18');
            inp.setAttribute('autocomplete', 'off');
            inp.setAttribute('spellcheck', 'false');
            inp.setAttribute('placeholder', 'e.g. KMC/12345/2020');

            /* Positional mask — GST-style:
               Segment A: 2-6 LETTERS  (council code e.g. KMC, TNMC)  → auto '/'
               Segment B: 1-6 DIGITS   (registration number)           → auto '/'
               Segment C: 4  DIGITS    (year)
            */
            function maskMedReg(raw) {
                let out = ''; let ri = 0;

                // Segment A: council letters (max 6)
                let aLen = 0;
                while (ri < raw.length && aLen < 6) {
                    if (/[A-Z]/.test(raw[ri])) { out += raw[ri++]; aLen++; }
                    else break;
                }
                if (aLen < 2) return out;

                out += '/';  // auto-separator

                // Segment B: reg number digits (max 6)
                let bLen = 0;
                while (ri < raw.length && bLen < 6) {
                    if (/[0-9]/.test(raw[ri])) { out += raw[ri++]; bLen++; }
                    else break;
                }
                if (bLen === 0) return out;
                if (ri >= raw.length) return out;

                out += '/';  // auto-separator

                // Segment C: year digits (max 4)
                let cLen = 0;
                while (ri < raw.length && cLen < 4) {
                    if (/[0-9]/.test(raw[ri])) { out += raw[ri++]; cLen++; }
                    else break;
                }
                return out;
            }

            inp.addEventListener('input', function() {
                const raw = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                const result = maskMedReg(raw);
                this.value = result;
                if (raw.length === 0) { clear(inp); return; }

                const full = /^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/;
                if (full.test(result)) { ok(inp); return; }

                const parts = result.split('/');
                if (parts.length === 1) {
                    hint(inp, parts[0].length < 2
                        ? `Council code: type 2-6 letters (KMC, TNMC, MCI)`
                        : `Council "${parts[0]}" — type registration number digits next`);
                } else if (parts.length === 2) {
                    hint(inp, `${parts[1].length}/6 reg digits entered — type / then 4-digit year`);
                } else {
                    hint(inp, `Year: ${parts[2]} (${parts[2].length}/4 digits)`);
                }
            });

            inp.addEventListener('blur', () => {
                const v = inp.value;
                if (!v) { clear(inp); return; }
                if (!/^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/.test(v)) {
                    err(inp, 'Invalid format — e.g. KMC/12345/2020  TNMC/98765/2022  MCI/4321/2019');
                } else { ok(inp); }
            });
        });


        /* ══════════════════════════════════════════════════
           FORM SUBMIT GUARD
           ══════════════════════════════════════════════════ */
        form.addEventListener('submit', function(e) {
            let valid = true;

            form.querySelectorAll('input[type="email"], input[name="email"]').forEach(inp => {
                const v = inp.value.trim();
                if (!v && inp.required) { err(inp, 'Email address is required.'); valid = false; }
                else if (v && !/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/.test(v)) {
                    err(inp, 'Enter a valid email — e.g. doctor@domain.com'); valid = false;
                }
            });

            form.querySelectorAll('input[name="phone"]').forEach(inp => {
                const v = inp.value;
                if (!v && inp.required) { err(inp, '10-digit mobile number is required.'); valid = false; }
                else if (v && !/^[6-9]\d{9}$/.test(v)) {
                    err(inp, 'Must be exactly 10 digits starting with 6, 7, 8, or 9.'); valid = false;
                }
            });

            form.querySelectorAll('input[name="medical_registration_no"]').forEach(inp => {
                const v = inp.value;
                if (!v && inp.required) { err(inp, 'Medical Registration Number is required.'); valid = false; }
                else if (v && !/^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/.test(v)) {
                    err(inp, 'Invalid — e.g. KMC/12345/2020  TNMC/98765/2022  MCI/4321/2019'); valid = false;
                }
            });


            if (!valid) {
                e.preventDefault();
                const first = form.querySelector('.is-invalid');
                if (first) { first.scrollIntoView({ behavior: 'smooth', block: 'center' }); first.focus(); }
            }
        });
    });
});
</script>
</body>
</html>

