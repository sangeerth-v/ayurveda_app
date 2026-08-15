<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ayurveda Portal</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,500&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --forest: #0c3b2e;
            --sage: #1d5c42;
            --herb: #4f772d;
            --gold: #c5a059;
            --amber: #ffba08;
            --parchment: #f9f5ef;
            --cream: #faf8f4;
            --dark: #1e293b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--parchment);
            color: var(--dark);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* ── MINIMAL CARD CONTAINER ────────────────────────── */
        .login-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid #e2dacf;
            border-radius: 28px;
            padding: 3.5rem 3rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 16px 45px rgba(12,59,46,0.06);
            transition: all 0.3s ease;
        }

        .system-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--forest);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .subtitle {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 4px;
        }

        /* ── FORM ELEMENTS ─────────────────────────────────── */
        .input-group-custom {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-group-custom input {
            width: 100%;
            height: 52px;
            border-radius: 12px;
            border: 1.5px solid #dce4dc;
            padding: 0 45px 0 18px;
            font-size: 0.95rem;
            font-weight: 500;
            background: #fff;
            transition: all 0.25s ease;
            outline: none;
        }

        .input-group-custom label {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            pointer-events: none;
            transition: all 0.2s ease;
            background: #fff;
            padding: 0 4px;
        }

        .input-group-custom input:focus ~ label,
        .input-group-custom input:valid ~ label {
            top: 0;
            font-size: 0.75rem;
            color: var(--sage);
            font-weight: 600;
        }

        .input-group-custom input:focus {
            border-color: var(--sage);
            box-shadow: 0 0 0 4px rgba(29, 92, 66, 0.08);
        }

        .input-icon-right {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-size: 1rem;
        }

        /* ── BUTTONS ───────────────────────────────────────── */
        .btn-submit {
            background: linear-gradient(135deg, var(--forest) 0%, var(--sage) 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            height: 52px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.25s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 8px 24px rgba(12, 59, 46, 0.16);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(12, 59, 46, 0.25);
            color: #fff;
        }

        .btn-register-link {
            border: 2px solid var(--forest);
            color: var(--forest);
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-register-link:hover {
            background-color: var(--forest);
            color: #ffffff;
        }

        /* ── PARTNER PILLS ─────────────────────────────────── */
        .partner-row {
            display: flex;
            gap: 12px;
            margin-top: 1rem;
        }

        .partner-pill {
            flex: 1;
            background: #fff;
            border: 1px solid #e2dacf;
            border-radius: 12px;
            padding: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--forest);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .partner-pill:hover {
            background: var(--parchment);
            border-color: var(--forest);
            transform: translateY(-1px);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.8rem 0;
            color: #94a3b8;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2dacf;
        }

        .divider span {
            padding: 0 10px;
        }

        .notice-info {
            background: rgba(197, 160, 89, 0.08);
            border: 1px solid rgba(197, 160, 89, 0.3);
            color: #7c5e28;
            font-size: 0.73rem;
            padding: 10px 14px;
            border-radius: 8px;
            margin-top: 1.2rem;
            line-height: 1.45;
            text-align: center;
        }
    </style>
</head>
<body>

@include('partials.nav-public')

<section class="login-section">
    <div class="login-card">
        <div class="text-center mb-4">
            <a href="{{ url('/') }}" class="system-logo">
                <i class="fas fa-leaf text-success me-1"></i> Ayurveda
            </a>
            <div class="subtitle">Sign in to access your consultations &amp; store</div>
        </div>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3 py-2 px-3 mb-4" style="font-size: 0.85rem;">
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

            <!-- Email or Username Input -->
            <div class="input-group-custom">
                <input type="text" name="email" id="email" value="{{ old('email') }}" required autocomplete="off">
                <label for="email">Email Address or Name (Username)</label>
            </div>

            <!-- Password Input -->
            <div class="input-group-custom">
                <input type="password" name="password" id="password" required autocomplete="off">
                <label for="password">Password</label>
                <button type="button" class="input-icon-right" onclick="togglePasswordVisibility('password', this)" title="Toggle password visibility">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4" style="font-size:0.83rem;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-secondary" for="remember">Remember me</label>
                </div>
                <a href="#" onclick="alert('Please contact your System Administrator to reset your password.')" class="text-success text-decoration-none fw-bold">Forgot Password?</a>
            </div>

            <!-- Submit Login Button -->
            <button type="submit" class="btn-submit">
                Login <i class="fas fa-arrow-right ms-1"></i>
            </button>
        </form>

        <div class="divider">
            <span>OR</span>
        </div>

        <div class="text-center">
            <a href="{{ route('register') }}{{ request()->has('redirect') ? '?redirect=' . urlencode(request()->query('redirect')) : '' }}" class="btn-register-link mb-3">
                <i class="fas fa-user-plus me-2"></i> Register as Patient
            </a>

            <div style="font-size: 0.8rem; font-weight: 700; color: var(--forest); margin-top: 1.2rem;">Join as Partner</div>
            <div class="partner-row">
                <a href="{{ route('doctor.register') }}" class="partner-pill">
                    <i class="fas fa-user-md"></i> Doctor
                </a>
                <a href="{{ route('pharma.register') }}" class="partner-pill">
                    <i class="fas fa-capsules"></i> Pharmacy
                </a>
            </div>

            <div class="notice-info">
                <i class="fas fa-info-circle me-1"></i> Applications for Doctors &amp; Pharmacy Companies require admin verification. Chief Astrologer login is supported through the main form above.
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
</body>
</html>
