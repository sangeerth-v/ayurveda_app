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
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Ayurveda Care Hospital" value="{{ old('name') }}" minlength="3" required>
                            @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- License Number -->
                        <div class="col-md-6">
                            <label class="form-label">License Number <span class="text-danger">*</span></label>
                            <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" placeholder="e.g. HSP/2026/8942" value="{{ old('license_number') }}" maxlength="25" minlength="5" pattern="[A-Z0-9]{2,10}[-\/][A-Z0-9\/-]*[0-9]+[A-Z0-9\/-]*" title="Format: HSP/2026/8942" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9\/-]/g, '');" required>
                            @error('license_number') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- GST Number (optional) -->
                        <div class="col-md-6">
                            <label class="form-label">GST Number <span class="text-muted">(Optional - 15 Chars)</span></label>
                            <input type="text" name="gst_number" class="form-control @error('gst_number') is-invalid @enderror" placeholder="29AAAAA0000A1Z5" value="{{ old('gst_number') }}" pattern="[0-9]{2}[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}[1-9A-Za-z]{1}[Zz][0-9A-Za-z]{1}" maxlength="15" minlength="15" title="15-character GSTIN format e.g. 29AAAAA0000A1Z5" oninput="this.value = this.value.toUpperCase();">
                            @error('gst_number') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Contact Person -->
                        <div class="col-md-6">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" placeholder="Administrator Name" value="{{ old('contact_person') }}" minlength="3" required>
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
                            <label class="form-label">Phone Number (10 Digits) <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="9876543210" value="{{ old('phone') }}" pattern="[6-9][0-9]{9}" maxlength="10" minlength="10" title="Valid 10-digit mobile number starting with 6-9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                            @error('phone') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label">Portal Password (min 8 chars) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" id="hospPassword" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" minlength="8" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('hospPassword', this)"><i class="fas fa-eye"></i></button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- District -->
                        <div class="col-md-6">
                            <label class="form-label">Location District <span class="text-danger">*</span></label>
                            <input type="text" name="district_name" id="district_name" list="kerala_districts_list" class="form-control @error('district_name') is-invalid @enderror" placeholder="Type or select district (e.g. Ernakulam)" value="{{ old('district_name') }}" required autocomplete="off">
                            <datalist id="kerala_districts_list">
                                @foreach($districts as $district)
                                    <option value="{{ $district->name }}"></option>
                                @endforeach
                            </datalist>
                            @error('district_name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Hospital Address -->
                        <div class="col-12">
                            <label class="form-label">Hospital Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="Complete hospital street address" minlength="10" required>{{ old('address') }}</textarea>
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

document.addEventListener('DOMContentLoaded', function() {
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
            input.classList.remove('is-invalid'); input.classList.add('is-valid');
            const fb = getFeedback(input); fb.textContent = '';
            fb.className = 'live-feedback small mt-1 fw-semibold ps-1';
        }
        function err(input, msg) {
            input.classList.remove('is-valid'); input.classList.add('is-invalid');
            const fb = getFeedback(input); fb.textContent = '⚠ ' + msg;
            fb.className = 'live-feedback text-danger small mt-1 fw-semibold ps-1';
        }
        function hint(input, msg) {
            input.classList.remove('is-invalid', 'is-valid');
            const fb = getFeedback(input); fb.textContent = '💡 ' + msg;
            fb.className = 'live-feedback text-muted small mt-1 ps-1';
        }
        function clear(input) {
            input.classList.remove('is-invalid', 'is-valid');
            getFeedback(input).textContent = '';
        }

        /* ══ EMAIL ══ */
        form.querySelectorAll('input[type="email"], input[name="email"]').forEach(inp => {
            inp.addEventListener('blur', () => {
                const v = inp.value.trim();
                if (!v) { clear(inp); return; }
                if (!/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/.test(v)) {
                    err(inp, 'Enter a valid email — e.g. hospital@domain.com');
                } else { ok(inp); }
            });
        });

        /* ══ PHONE — digits only, first digit 6-9, max 10 ══ */
        form.querySelectorAll('input[name="phone"]').forEach(inp => {
            inp.setAttribute('maxlength', '10');
            inp.setAttribute('inputmode', 'numeric');
            inp.addEventListener('input', function() {
                let cur = this.value.replace(/\D/g, '');
                if (cur.length > 0 && !/^[6-9]/.test(cur)) cur = cur.slice(1);
                this.value = cur.slice(0, 10);
                const len = this.value.length;
                if (len === 0) { clear(inp); return; }
                if (len < 10) { hint(inp, `${len}/10 digits — need ${10 - len} more`); }
                else { ok(inp); }
            });
            inp.addEventListener('blur', () => {
                const v = inp.value;
                if (!v) { clear(inp); return; }
                if (!/^[6-9]\d{9}$/.test(v)) { err(inp, 'Must be 10 digits starting with 6, 7, 8, or 9.'); }
                else { ok(inp); }
            });
        });

        /* ══ GSTIN — strict positional masking ══
           Format: 2-digits | 5-letters | 4-digits | 1-letter | 1-alphanum | Z | 1-alphanum = 15 chars */
        form.querySelectorAll('input[name="gst_number"]').forEach(inp => {
            inp.setAttribute('maxlength', '15');
            inp.setAttribute('autocomplete', 'off');
            inp.setAttribute('spellcheck', 'false');

            inp.addEventListener('input', function() {
                let raw = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                let out = '';
                for (let i = 0; i < raw.length && i < 15; i++) {
                    const ch = raw[i];
                    if (i < 2) {
                        if (/[0-9]/.test(ch)) out += ch; else break;
                    } else if (i < 7) {
                        if (/[A-Z]/.test(ch)) out += ch; else break;
                    } else if (i < 11) {
                        if (/[0-9]/.test(ch)) out += ch; else break;
                    } else if (i === 11) {
                        if (/[A-Z]/.test(ch)) out += ch; else break;
                    } else if (i === 12) {
                        if (/[A-Z0-9]/.test(ch)) out += ch; else break;
                    } else if (i === 13) {
                        if (ch === 'Z') out += ch; else break;
                    } else if (i === 14) {
                        if (/[A-Z0-9]/.test(ch)) out += ch;
                    }
                }
                this.value = out;
                const len = out.length;
                if (len === 0) { clear(inp); return; }
                const gstFull = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                if (len === 15 && gstFull.test(out)) { ok(inp); }
                else { hint(inp, `${len}/15 chars — e.g. 29AAAAA0000A1Z5`); }
            });

            inp.addEventListener('blur', () => {
                const v = inp.value;
                if (!v) { clear(inp); return; }
                const gstFull = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                if (v.length !== 15 || !gstFull.test(v)) {
                    err(inp, `Invalid GSTIN. Must be 15 chars: e.g. 29AAAAA0000A1Z5 (got ${v.length}/15)`);
                } else { ok(inp); }
            });
        });

        /* ══ HOSPITAL LICENSE NUMBER — strict positional masking ══
           Indian hospitals: HSP/NNNNN/YYYY
           Segment A: 2-6 LETTERS  (hospital type code: HSP, CH, NH, GH)
           Auto '/'
           Segment B: 1-6 DIGITS   (license number)
           Auto '/'
           Segment C: 4  DIGITS    (year) */
        form.querySelectorAll('input[name="license_number"]').forEach(inp => {
            inp.setAttribute('maxlength', '18');
            inp.setAttribute('autocomplete', 'off');
            inp.setAttribute('spellcheck', 'false');
            inp.setAttribute('placeholder', 'e.g. HSP/12345/2025');

            function maskHospLic(raw) {
                let out = ''; let ri = 0;
                // Segment A: type code letters (2-6)
                let aLen = 0;
                while (ri < raw.length && aLen < 6) {
                    if (/[A-Z]/.test(raw[ri])) { out += raw[ri++]; aLen++; } else break;
                }
                if (aLen < 2) return out;
                out += '/';
                // Segment B: license number digits (1-6)
                let bLen = 0;
                while (ri < raw.length && bLen < 6) {
                    if (/[0-9]/.test(raw[ri])) { out += raw[ri++]; bLen++; } else break;
                }
                if (bLen === 0 || ri >= raw.length) return out;
                out += '/';
                // Segment C: year digits (4)
                let cLen = 0;
                while (ri < raw.length && cLen < 4) {
                    if (/[0-9]/.test(raw[ri])) { out += raw[ri++]; cLen++; } else break;
                }
                return out;
            }

            inp.addEventListener('input', function() {
                const raw = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                const result = maskHospLic(raw);
                this.value = result;
                if (raw.length === 0) { clear(inp); return; }
                const full = /^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/;
                if (full.test(result)) { ok(inp); return; }
                const parts = result.split('/');
                if (parts.length === 1) {
                    hint(inp, parts[0].length < 2
                        ? `Type code: type 2-6 letters (HSP, CH, NH, GH)`
                        : `Type "${parts[0]}" — type license number digits next`);
                } else if (parts.length === 2) {
                    hint(inp, `${parts[1].length}/6 digits — type / then 4-digit year`);
                } else {
                    hint(inp, `Year: ${parts[2]} (${parts[2].length}/4 digits)`);
                }
            });

            inp.addEventListener('blur', () => {
                const v = inp.value;
                if (!v) { clear(inp); return; }
                if (!/^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/.test(v)) {
                    err(inp, 'Invalid — e.g. HSP/12345/2025  CH/98765/2024  NH/5678/2023');
                } else { ok(inp); }
            });
        });

        /* ══ FORM SUBMIT GUARD ══ */
        form.addEventListener('submit', function(e) {
            let valid = true;

            form.querySelectorAll('input[type="email"], input[name="email"]').forEach(inp => {
                const v = inp.value.trim();
                if (!v && inp.required) { err(inp, 'Email address is required.'); valid = false; }
                else if (v && !/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/.test(v)) {
                    err(inp, 'Enter a valid email — e.g. hospital@domain.com'); valid = false;
                }
            });

            form.querySelectorAll('input[name="phone"]').forEach(inp => {
                const v = inp.value;
                if (!v && inp.required) { err(inp, '10-digit mobile number is required.'); valid = false; }
                else if (v && !/^[6-9]\d{9}$/.test(v)) {
                    err(inp, 'Must be 10 digits starting with 6, 7, 8, or 9.'); valid = false;
                }
            });

            form.querySelectorAll('input[name="gst_number"]').forEach(inp => {
                const v = inp.value;
                const gstFull = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                if (!v && inp.required) { err(inp, 'GST number is required.'); valid = false; }
                else if (v && !gstFull.test(v)) {
                    err(inp, 'Invalid GSTIN — e.g. 29AAAAA0000A1Z5 (must be exactly 15 chars)'); valid = false;
                }
            });

            form.querySelectorAll('input[name="license_number"]').forEach(inp => {
                const v = inp.value;
                if (!v && inp.required) { err(inp, 'Hospital License Number is required.'); valid = false; }
                else if (v && !/^[A-Z]{2,6}\/[0-9]{1,6}\/[0-9]{4}$/.test(v)) {
                    err(inp, 'Invalid — e.g. HSP/12345/2025  CH/98765/2024'); valid = false;
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
