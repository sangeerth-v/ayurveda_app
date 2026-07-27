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
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Dr. Firstname Lastname" value="{{ old('name') }}" required>
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
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="9876543210" value="{{ old('phone') }}" pattern="[0-9]{10}" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                            </div>
                            @error('phone') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label">Account Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="docPassword" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('docPassword', this)"><i class="fas fa-eye"></i></button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Medical Registration Number -->
                        <div class="col-md-6">
                            <label class="form-label">Medical Registration Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="medical_registration_no" class="form-control @error('medical_registration_no') is-invalid @enderror" placeholder="e.g. KMC/12345/2020" value="{{ old('medical_registration_no') }}" required>
                            </div>
                            @error('medical_registration_no') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Qualification -->
                        <div class="col-md-6">
                            <label class="form-label">Qualification <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-graduation-cap"></i></span>
                                <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" placeholder="MBBS, BAMS, BHMS, MD..." value="{{ old('qualification') }}" required>
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
                            <select name="district_id" class="form-select @error('district_id') is-invalid @enderror" required>
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
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
                            <select name="consultation_type" id="consultation_type" class="form-select @error('consultation_type') is-invalid @enderror" required>
                                <option value="Both" {{ old('consultation_type') == 'Both' ? 'selected' : '' }}>Both (In-Person & Online Video)</option>
                                <option value="Offline" {{ old('consultation_type') == 'Offline' ? 'selected' : '' }}>In-Person Clinic Only</option>
                                <option value="Online" {{ old('consultation_type') == 'Online' ? 'selected' : '' }}>Online Video Consultation Only</option>
                            </select>
                            @error('consultation_type') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- In-Person Working Hours (15-min Slot Generation) -->
                        <div class="col-md-6">
                            <label class="form-label">In-Person Working Hours (15-Min Slots) <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="time" name="available_from" class="form-control" value="{{ old('available_from', '09:00') }}" required>
                                    <div class="form-text small">Start Time</div>
                                </div>
                                <div class="col-6">
                                    <input type="time" name="available_to" class="form-control" value="{{ old('available_to', '13:00') }}" required>
                                    <div class="form-text small">End Time</div>
                                </div>
                            </div>
                        </div>

                        <!-- Online Working Hours (15-min Slot Generation) -->
                        <div class="col-md-6">
                            <label class="form-label">Online Video Working Hours (15-Min Slots)</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="time" name="online_available_from" class="form-control" value="{{ old('online_available_from', '16:00') }}">
                                    <div class="form-text small">Start Time</div>
                                </div>
                                <div class="col-6">
                                    <input type="time" name="online_available_to" class="form-control" value="{{ old('online_available_to', '20:00') }}">
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
</script>
</body>
</html>
