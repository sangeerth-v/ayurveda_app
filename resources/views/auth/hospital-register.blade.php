<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Registration | Ayurveda Management System</title>
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

        /* Right Side Form Card */
        .right-panel {
            background-color: var(--beige-bg);
            padding: 2.5rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hospital-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(224, 229, 213, 0.8);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 680px;
            box-shadow: var(--shadow-lg);
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

        .btn-submit-hospital {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 18px rgba(26, 77, 46, 0.25);
        }

        .btn-submit-hospital:hover {
            background: linear-gradient(135deg, var(--secondary-green) 0%, var(--accent-green) 100%);
            color: #ffffff;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

@include('partials.nav-public')

<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 80px);">
    <div class="hospital-card">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="system-logo mb-2 d-lg-none">
                        <i class="fas fa-leaf text-success me-1"></i> Ayurveda
                    </a>
                    <h3 class="fw-bold text-dark mb-1"><i class="fas fa-hospital me-2 text-success"></i> Hospital Registration</h3>
                    <p class="text-muted small mb-0">Fill in your hospital details & verification documents below.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 py-2 px-3 mb-4 small">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('hospital.register.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <!-- Hospital Name -->
                        <div class="col-md-6">
                            <label class="form-label">Hospital Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Ayurveda Care Hospital" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- License Number -->
                        <div class="col-md-6">
                            <label class="form-label">License Number <span class="text-danger">*</span></label>
                            <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" placeholder="e.g. HSP/2026/8942" value="{{ old('license_number') }}" required>
                            @error('license_number') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- GST Number (optional) -->
                        <div class="col-md-6">
                            <label class="form-label">GST Number <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="gst_number" class="form-control" placeholder="29AAAAA0000A1Z5" value="{{ old('gst_number') }}">
                        </div>

                        <!-- Contact Person -->
                        <div class="col-md-6">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" placeholder="Administrator Name" value="{{ old('contact_person') }}" required>
                            @error('contact_person') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-6">
                            <label class="form-label">Hospital Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="hospital@example.com" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="9876543210" value="{{ old('phone') }}" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                            @error('phone') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label">Portal Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" id="hospPassword" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('hospPassword', this)"><i class="fas fa-eye"></i></button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- District -->
                        <div class="col-md-6">
                            <label class="form-label">Location District <span class="text-danger">*</span></label>
                            <select name="district_id" class="form-select @error('district_id') is-invalid @enderror" required>
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Hospital Address -->
                        <div class="col-12">
                            <label class="form-label">Hospital Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="Complete hospital street address" required>{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Hospital License Document Upload -->
                        <div class="col-12">
                            <label class="form-label">Hospital License Document (PDF / Image)</label>
                            <input type="file" name="license_document" class="form-control" accept=".pdf,image/*">
                            <div class="form-text small text-muted">Upload registered hospital establishment license or certificate (max 5MB).</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-submit-hospital w-100 py-3 fw-bold">
                            <i class="fas fa-check-circle me-2"></i> Register Hospital
                        </button>
                    </div>
                </form>

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
</script>
</body>
</html>
