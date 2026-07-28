<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ayurveda Management System</title>
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
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .center-circle {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            border: 2px dashed rgba(197, 160, 89, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
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
        .badge-3 { top: 40px; right: 15px; animation-delay: 0.8s; }

        @keyframes float-around {
            from { transform: translateY(0px); }
            to { transform: translateY(-8px); }
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.3rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.75rem;
        }

        .brand-subtitle {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
            max-width: 480px;
            margin: 0 auto;
        }

        /* Right Side Login Panel */
        .right-panel {
            background-color: var(--beige-bg);
            padding: 3rem 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(224, 229, 213, 0.8);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }

        .system-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .form-floating > .form-control {
            border-radius: 12px;
            border: 1.5px solid #dce4dc;
            padding-left: 2.8rem;
        }

        .form-floating > label {
            padding-left: 2.8rem;
        }

        .form-floating > .form-control:focus {
            border-color: var(--secondary-green);
            box-shadow: 0 0 0 4px rgba(45, 106, 79, 0.12);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            color: var(--secondary-green);
            font-size: 1.1rem;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 8px;
        }

        .btn-login {
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

        .btn-login:hover {
            background: linear-gradient(135deg, var(--secondary-green) 0%, var(--accent-green) 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26, 77, 46, 0.35);
        }

        /* Divider */
        .divider-wrap {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.8rem 0;
            color: #8fa396;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .divider-wrap::before, .divider-wrap::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dce4dc;
        }

        .divider-wrap span {
            padding: 0 1rem;
            letter-spacing: 2px;
        }

        /* Register as Patient Button */
        .btn-register-patient {
            border: 2px solid var(--secondary-green);
            color: var(--secondary-green);
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .btn-register-patient:hover {
            background-color: var(--secondary-green);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Partner Registration Section */
        .partner-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 1rem;
        }

        .partner-btn {
            background: #f4f8f4;
            border: 1px solid #d4e2d6;
            border-radius: 10px;
            padding: 0.75rem 0.5rem;
            text-align: center;
            color: var(--primary-green);
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .partner-btn i {
            font-size: 1.1rem;
            color: var(--secondary-green);
        }

        .partner-btn:hover {
            background: #e1efe3;
            border-color: var(--secondary-green);
            color: var(--primary-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 77, 46, 0.1);
        }

        .admin-verify-notice {
            background: #fff8e6;
            border: 1px solid #ffe8b3;
            color: #8a6d3b;
            font-size: 0.76rem;
            padding: 0.65rem 0.85rem;
            border-radius: 8px;
            margin-top: 1.2rem;
            line-height: 1.45;
            text-align: center;
        }

        .footer-text {
            font-size: 0.78rem;
            color: #8fa396;
            text-align: center;
            margin-top: 1.8rem;
        }
    </style>
</head>
<body>

@include('partials.nav-public')

<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 80px);">
    <div class="login-card">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="system-logo mb-2">
                        <i class="fas fa-leaf text-success me-1"></i> Ayurveda
                    </a>
                    <h3 class="fw-bold text-dark mt-2 mb-1">Welcome Back</h3>
                    <p class="text-muted small">Sign in to continue.</p>
                </div>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 py-2 px-3 mb-4" style="font-size: 0.88rem;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 py-2 px-3 mb-4 small">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Universal Authentication Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}">

                    <!-- Email Input -->
                    <div class="form-floating mb-3 position-relative">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                        <label for="floatingEmail">Email Address</label>
                    </div>

                    <!-- Password Input -->
                    <div class="form-floating mb-3 position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('floatingPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-secondary" for="remember">Remember me</label>
                        </div>
                        <a href="#" onclick="alert('Please contact System Administrator or use OTP login to reset password.')" class="text-success text-decoration-none fw-semibold">Forgot Password?</a>
                    </div>

                    <!-- Submit Login Button -->
                    <button type="submit" class="btn btn-login w-100 mb-3">
                        Login <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider-wrap">
                    <span>OR</span>
                </div>

                <!-- Registration Actions -->
                <div class="text-center">
                    <p class="small text-muted mb-2 font-weight-500">New to our platform?</p>
                    <a href="{{ route('register') }}{{ request()->has('redirect') ? '?redirect=' . urlencode(request()->query('redirect')) : '' }}" class="btn btn-register-patient w-100 py-2.5 mb-4">
                        <i class="fas fa-user-plus me-2"></i> Register as Patient
                    </a>

                    <p class="small fw-bold text-dark mb-2">Join as a Partner</p>
                    <div class="partner-cards-grid">
                        <a href="{{ route('doctor.register') }}" class="partner-btn">
                            <i class="fas fa-user-md"></i>
                            <span>Apply as Doctor</span>
                        </a>
                        <a href="{{ route('hospital.register') }}" class="partner-btn">
                            <i class="fas fa-hospital"></i>
                            <span>Register Hospital</span>
                        </a>
                        <a href="{{ route('pharma.register') }}" class="partner-btn">
                            <i class="fas fa-capsules"></i>
                            <span>Register Pharma</span>
                        </a>
                    </div>

                    <div class="admin-verify-notice">
                        <i class="fas fa-info-circle me-1 text-warning"></i> Applications for Doctors, Hospitals, and Pharma Companies require admin verification before account activation.
                    </div>

                    <div class="footer-text">
                        © 2026 Ayurveda Management System. All rights reserved.
                    </div>
                </div>
            </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="modal fade" id="partnerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h5 class="modal-title fw-bold text-success" id="partnerModalTitle">Partner Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex p-3 mb-3" style="font-size: 2rem;">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark" id="partnerRoleText">Doctor Partner Registration</h5>
                <p class="text-muted small mb-3">
                    To maintain strict medical quality and regulatory compliance, partner accounts (Doctors, Hospitals, and Pharma Companies) are registered and verified by **System Administrator**.
                </p>
                <div class="p-3 bg-light rounded-3 text-start small border border-light">
                    <i class="fas fa-check-circle text-success me-2"></i> Submit credentials & license verification to Admin.<br>
                    <i class="fas fa-check-circle text-success me-2"></i> Account credential generation takes less than 24 hours.<br>
                    <i class="fas fa-phone-alt text-success me-2"></i> Admin Support Desk: <strong>admin@ayurveda.com</strong>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                <button type="button" class="btn btn-success px-4 rounded-pill" data-bs-dismiss="modal">Understand & Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.bundle.min.js"></script>
<script>
function togglePasswordVisibility(inputId, button) {
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

function showPartnerNotice(roleName) {
    document.getElementById('partnerModalTitle').innerText = roleName + ' Partner Registration';
    document.getElementById('partnerRoleText').innerText = roleName + ' Account Request';
    const partnerModal = new bootstrap.Modal(document.getElementById('partnerModal'));
    partnerModal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        const emailInputs = form.querySelectorAll('input[type="email"], input[name="email"]');

        function createOrGetFeedback(input) {
            let container = input.closest('.form-floating') || input.parentNode;
            let feedback = container.parentNode.querySelector('.live-feedback') || container.querySelector('.live-feedback');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'live-feedback text-danger small mt-1 fw-semibold ps-1';
                container.parentNode.appendChild(feedback);
            }
            return feedback;
        }

        function clearFeedback(input) {
            input.classList.remove('is-invalid');
            let container = input.closest('.form-floating') || input.parentNode;
            const feedback = container.parentNode.querySelector('.live-feedback') || container.querySelector('.live-feedback');
            if (feedback) feedback.textContent = '';
        }

        function setError(input, msg) {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            const feedback = createOrGetFeedback(input);
            feedback.textContent = msg;
        }

        // --- EMAIL VALIDATION ---
        emailInputs.forEach(input => {
            function validateEmail() {
                const val = input.value.trim();
                if (!val) {
                    clearFeedback(input);
                    return true;
                }
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailRegex.test(val)) {
                    setError(input, 'Please enter a valid email address (e.g. name@domain.com)');
                    return false;
                }
                clearFeedback(input);
                return true;
            }

            input.addEventListener('input', function() {
                const val = input.value.trim();
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!val || emailRegex.test(val)) clearFeedback(input);
            });
            input.addEventListener('blur', validateEmail);
        });

        // --- FORM SUBMIT GUARD ---
        form.addEventListener('submit', function(e) {
            let isValid = true;
            emailInputs.forEach(input => {
                const val = input.value.trim();
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!val && input.hasAttribute('required')) {
                    setError(input, 'Email address is required.');
                    isValid = false;
                } else if (val && !emailRegex.test(val)) {
                    setError(input, 'Please enter a valid email address (e.g. name@domain.com)');
                    isValid = false;
                }
            });
            if (!isValid) {
                e.preventDefault();
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) firstInvalid.focus();
            }
        });
    });
});
</script>
</body>
</html>

