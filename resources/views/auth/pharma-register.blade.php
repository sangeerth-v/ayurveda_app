<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharma Company Registration | Ayurveda Management System</title>
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

        .pharma-card {
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

        .btn-submit-pharma {
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

        .btn-submit-pharma:hover {
            background: linear-gradient(135deg, var(--secondary-green) 0%, var(--accent-green) 100%);
            color: #ffffff;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

@include('partials.nav-public')

<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 80px);">
    <div class="pharma-card">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="system-logo mb-2 d-lg-none">
                        <i class="fas fa-leaf text-success me-1"></i> Ayurveda
                    </a>
                    <h3 class="fw-bold text-dark mb-1"><i class="fas fa-capsules me-2 text-success"></i> Pharma Registration</h3>
                    <p class="text-muted small mb-0">Fill in your company credentials & drug license details below.</p>
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

                <form action="{{ route('pharma.register.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <!-- Company Name -->
                        <div class="col-md-6">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Herbal Pharma Pvt Ltd" value="{{ old('company_name') }}" minlength="3" required>
                            @error('company_name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Drug License Number -->
                        <div class="col-md-6">
                            <label class="form-label">Drug License Number <span class="text-danger">*</span></label>
                            <input type="text" name="drug_license_no" class="form-control @error('drug_license_no') is-invalid @enderror" placeholder="e.g. DL-20B/1234/2026" value="{{ old('drug_license_no') }}" maxlength="25" minlength="5" pattern="[A-Z0-9]{2,10}[-\/][A-Z0-9\/-]*[0-9]+[A-Z0-9\/-]*" title="Format: DL-20B/1234/2026" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9\/-]/g, '');" required>
                            @error('drug_license_no') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- GST Number -->
                        <div class="col-md-6">
                            <label class="form-label">GST Number (15 Chars) <span class="text-danger">*</span></label>
                            <input type="text" name="gst_number" class="form-control @error('gst_number') is-invalid @enderror" placeholder="29AAAAA0000A1Z5" value="{{ old('gst_number') }}" pattern="[0-9]{2}[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}[1-9A-Za-z]{1}[Zz][0-9A-Za-z]{1}" maxlength="15" minlength="15" title="15-character GSTIN format e.g. 29AAAAA0000A1Z5" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 15);" required>
                            @error('gst_number') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Contact Person -->
                        <div class="col-md-6">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" placeholder="Representative Name" value="{{ old('contact_person') }}" minlength="3" required>
                            @error('contact_person') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Company Email -->
                        <div class="col-md-6">
                            <label class="form-label">Company Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="info@company.com" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label class="form-label">Phone Number (10 Digits) <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="9876543210" value="{{ old('phone') }}" pattern="[6-9][0-9]{9}" maxlength="10" minlength="10" title="Valid 10-digit mobile number starting with 6-9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                            @error('phone') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-12">
                            <label class="form-label">Portal Password (min 8 chars) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" id="pharmaPassword" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" minlength="8" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('pharmaPassword', this)"><i class="fas fa-eye"></i></button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                        </div>

                        <!-- State & District -->
                        <div class="col-md-6">
                            <label class="form-label" for="state_name">State <span class="text-danger">*</span></label>
                            <select name="state_name" id="state_name" class="form-select @error('state_name') is-invalid @enderror" required>
                                <option value="">— Select State —</option>
                                <option value="Andhra Pradesh" {{ old('state_name') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                <option value="Arunachal Pradesh" {{ old('state_name') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                <option value="Assam" {{ old('state_name') == 'Assam' ? 'selected' : '' }}>Assam</option>
                                <option value="Bihar" {{ old('state_name') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                <option value="Chhattisgarh" {{ old('state_name') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                <option value="Goa" {{ old('state_name') == 'Goa' ? 'selected' : '' }}>Goa</option>
                                <option value="Gujarat" {{ old('state_name') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                <option value="Haryana" {{ old('state_name') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                <option value="Himachal Pradesh" {{ old('state_name') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                <option value="Jharkhand" {{ old('state_name') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                <option value="Karnataka" {{ old('state_name') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                <option value="Kerala" {{ old('state_name') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                <option value="Madhya Pradesh" {{ old('state_name') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                <option value="Maharashtra" {{ old('state_name') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                <option value="Manipur" {{ old('state_name') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                <option value="Meghalaya" {{ old('state_name') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                <option value="Mizoram" {{ old('state_name') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                <option value="Nagaland" {{ old('state_name') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                <option value="Odisha" {{ old('state_name') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                <option value="Punjab" {{ old('state_name') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                <option value="Rajasthan" {{ old('state_name') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                <option value="Sikkim" {{ old('state_name') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                <option value="Tamil Nadu" {{ old('state_name') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                <option value="Telangana" {{ old('state_name') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                <option value="Tripura" {{ old('state_name') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                <option value="Uttar Pradesh" {{ old('state_name') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                <option value="Uttarakhand" {{ old('state_name') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                <option value="West Bengal" {{ old('state_name') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                <option value="Andaman and Nicobar Islands" {{ old('state_name') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                <option value="Chandigarh" {{ old('state_name') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('state_name') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra & Nagar Haveli and Daman & Diu</option>
                                <option value="Delhi" {{ old('state_name') == 'Delhi' ? 'selected' : '' }}>Delhi (NCT)</option>
                                <option value="Jammu and Kashmir" {{ old('state_name') == 'Jammu and Kashmir' ? 'selected' : '' }}>Jammu & Kashmir</option>
                                <option value="Ladakh" {{ old('state_name') == 'Ladakh' ? 'selected' : '' }}>Ladakh</option>
                                <option value="Lakshadweep" {{ old('state_name') == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                <option value="Puducherry" {{ old('state_name') == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                            </select>
                            @error('state_name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="district_name">District <span class="text-danger">*</span></label>
                            <select name="district_name" id="district_name" class="form-select @error('district_name') is-invalid @enderror" required disabled>
                                <option value="">— Select State First —</option>
                            </select>
                            @error('district_name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label class="form-label">Registered Office Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="Full registered company address" minlength="10" required>{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>

                        <!-- License Certificate Upload -->
                        <div class="col-12">
                            <label class="form-label">Drug License Certificate (PDF / Image)</label>
                            <input type="file" name="license_document" class="form-control" accept=".pdf,image/*">
                            <div class="form-text small text-muted">Upload valid Ayurvedic drug manufacturing or distribution license (max 5MB).</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-submit-pharma w-100 py-3 fw-bold">
                            <i class="fas fa-check-circle me-2"></i> Register Pharma Company
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
                    err(inp, 'Enter a valid email — e.g. company@domain.com');
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

        /* ══ GSTIN — accept the full 15-character GSTIN format ══
           Format: 2-digits | 5-letters | 4-digits | 1-letter | 1-alphanum | Z | 1-alphanum = 15 chars
           e.g. 29AAAAA0000A1Z5  32ABCDE1234F1Z9 */
        form.querySelectorAll('input[name="gst_number"]').forEach(inp => {
            inp.setAttribute('maxlength', '15');
            inp.setAttribute('autocomplete', 'off');
            inp.setAttribute('spellcheck', 'false');
            inp.setAttribute('inputmode', 'text');

            inp.addEventListener('input', function() {
                const raw = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 15);
                this.value = raw;
                const len = raw.length;

                if (len === 0) { clear(inp); return; }
                if (len < 15) {
                    hint(inp, `${len}/15 chars — continue typing your GSTIN`);
                    return;
                }

                const gstFull = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                if (gstFull.test(raw)) { ok(inp); }
                else { hint(inp, 'Type a valid GSTIN like 29AAAAA0000A1Z5'); }
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

        /* ══ DRUG LICENSE NUMBER — strict positional masking ══
           Indian Retail: DL-20B/12345/2025  (Form 20-B retail)
           Pos 0-1: state letters (DL/KL/MH)  auto '-'
           Pos 2-3: category digits (20/21)
           Pos 4:   category letter (B/G)     auto '/'
           Pos 5-9: license digits (5 digits) auto '/'
           Pos 10-13: year digits (4 digits)  */
        form.querySelectorAll('input[name="drug_license_no"]').forEach(inp => {
            inp.setAttribute('maxlength', '18');
            inp.setAttribute('autocomplete', 'off');
            inp.setAttribute('spellcheck', 'false');
            inp.setAttribute('placeholder', 'e.g. DL-20B/12345/2025');

            function maskDrugLic(raw) {
                let out = ''; let ri = 0;
                // [0-1] State: 2 letters
                let stLen = 0;
                while (ri < raw.length && stLen < 2) {
                    if (/[A-Z]/.test(raw[ri])) { out += raw[ri++]; stLen++; } else break;
                }
                if (stLen < 2) return out;
                out += '-';
                // [2-3] Category digits: 2 digits (20 or 21)
                let cdLen = 0;
                while (ri < raw.length && cdLen < 2) {
                    if (/[0-9]/.test(raw[ri])) { out += raw[ri++]; cdLen++; } else break;
                }
                if (cdLen < 2) return out;
                // [4] Category letter: B or G
                if (ri >= raw.length) return out;
                if (/[A-Z]/.test(raw[ri])) { out += raw[ri++]; } else return out;
                out += '/';
                // [5-9] License number digits: up to 5
                let licLen = 0;
                while (ri < raw.length && licLen < 5) {
                    if (/[0-9]/.test(raw[ri])) { out += raw[ri++]; licLen++; } else break;
                }
                if (licLen === 0 || ri >= raw.length) return out;
                out += '/';
                // [10-13] Year: 4 digits
                let yrLen = 0;
                while (ri < raw.length && yrLen < 4) {
                    if (/[0-9]/.test(raw[ri])) { out += raw[ri++]; yrLen++; } else break;
                }
                return out;
            }

            inp.addEventListener('input', function() {
                const raw = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                const result = maskDrugLic(raw);
                this.value = result;
                if (raw.length === 0) { clear(inp); return; }
                const full = /^[A-Z]{2}-[0-9]{2}[A-Z]\/[0-9]{1,5}\/[0-9]{4}$/;
                if (full.test(result)) { ok(inp); return; }
                const sl = raw.length;
                if (sl < 2)       hint(inp, `State: type 2-letter state code (DL, KL, MH, TN)`);
                else if (sl < 4)  hint(inp, `Category: type 20 (retail) or 21 (wholesale)`);
                else if (sl < 5)  hint(inp, `Form type: B = retail (20-B), G = wholesale (21-G)`);
                else if (sl < 10) hint(inp, `License number: ${sl-5}/5 digits`);
                else              hint(inp, `Year: ${raw.slice(10)} (${raw.length-10}/4 digits)`);
            });

            inp.addEventListener('blur', () => {
                const v = inp.value;
                if (!v) { clear(inp); return; }
                if (!/^[A-Z]{2}-[0-9]{2}[A-Z]\/[0-9]{1,5}\/[0-9]{4}$/.test(v)) {
                    err(inp, 'Invalid — e.g. DL-20B/12345/2025  KL-21G/98765/2024  MH-20B/5678/2025');
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
                    err(inp, 'Enter a valid email — e.g. company@domain.com'); valid = false;
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

            form.querySelectorAll('input[name="drug_license_no"]').forEach(inp => {
                const v = inp.value;
                if (!v && inp.required) { err(inp, 'Drug License Number is required.'); valid = false; }
                else if (v && !/^[A-Z]{2}-[0-9]{2}[A-Z]\/[0-9]{1,5}\/[0-9]{4}$/.test(v)) {
                    err(inp, 'Invalid — e.g. DL-20B/12345/2025  KL-21G/98765/2024'); valid = false;
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

/* ══ State to District dynamic populator ══ */
const stateDistricts = {
    "Andhra Pradesh": ["Ananthapuramu", "Chittoor", "East Godavari", "Guntur", "Krishna", "Kurnool", "Prakasam", "Srikakulam", "Sri Potti Sriramulu Nellore", "Visakhapatnam", "Vizianagaram", "West Godavari", "YSR Kadapa", "Parvathipuram Manyam", "Alluri Sitharama Raju", "Anakapalli", "Kakinada", "Konaseema", "Eluru", "NTR", "Palnadu", "Bapatla", "Nandyal", "Sri Sathya Sai", "Annamayya", "Tirupati"],
    "Arunachal Pradesh": ["Tawang", "West Kameng", "East Kameng", "Pakke Kessang", "Kurung Kumey", "Kra Daadi", "Lower Subansiri", "Upper Subansiri", "West Siang", "Shi Yomi", "East Siang", "Siang", "Upper Siang", "Lepa Rada", "Lower Siang", "Dibang Valley", "Lower Dibang Valley", "Anjaw", "Lohit", "Namsai", "Changlang", "Tirap", "Longding", "Kamle", "Itanagar Capital Complex"],
    "Assam": ["Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Dima Hasao", "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup", "Kamrup Metropolitan", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", "Majuli", "Morigaon", "Nagaon", "Nalbari", "Sivasagar", "Sonitpur", "South Salmara-Mankachar", "Tinsukia", "Udalguri", "West Karbi Anglong", "Tamulpur", "Bajali"],
    "Bihar": ["Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur", "Bhojpur", "Buxar", "Darbhanga", "East Champaran", "Gaya", "Gopalganj", "Jamui", "Jehanabad", "Kaimur", "Katihar", "Khagaria", "Kishanganj", "Lakhisarai", "Madhepura", "Madhubani", "Munger", "Muzaffarpur", "Nalanda", "Nawada", "Patna", "Purnia", "Rohtas", "Saharsa", "Samastipur", "Saran", "Sheikhpura", "Sheohar", "Sitamarhi", "Siwan", "Supaul", "Vaishali", "West Champaran"],
    "Chhattisgarh": ["Balod", "Baloda Bazar", "Balrampur", "Bastar", "Bemetara", "Bijapur", "Bilaspur", "Dantewada", "Dhamtari", "Durg", "Gariaband", "Gaurela-Pendra-Marwahi", "Janjgir-Champa", "Jashpur", "Kabirdham", "Kanker", "Kondagaon", "Korba", "Koriya", "Mahasamund", "Manendragarh-Chirmiri-Bharatpur", "Mohla-Manpur-Ambagarh Chowki", "Mungeli", "Narayanpur", "Raigarh", "Raipur", "Rajnandgaon", "Sarangarh-Bilaigarh", "Sakti", "Sukma", "Surajpur", "Surguja", "Khairagarh-Chhuikhadan-Gandai"],
    "Goa": ["North Goa", "South Goa"],
    "Gujarat": ["Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha", "Bharuch", "Bhavnagar", "Botad", "Chhota Udaipur", "Dahod", "Dang", "Devbhumi Dwarka", "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kheda", "Kutch", "Mahisagar", "Mehsana", "Morbi", "Narmada", "Navsari", "Panchmahal", "Patan", "Porbandar", "Rajkot", "Sabarkantha", "Surat", "Surendranagar", "Tapi", "Vadodara", "Valsad"],
    "Haryana": ["Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fatehabad", "Gurugram", "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal", "Kurukshetra", "Mahendragarh", "Nuh", "Palwal", "Panchkula", "Panipat", "Rewari", "Rohtak", "Sirsa", "Sonipat", "Yamunanagar"],
    "Himachal Pradesh": ["Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu", "Lahaul and Spiti", "Mandi", "Shimla", "Sirmaur", "Solan", "Una"],
    "Jharkhand": ["Bokaro", "Chatra", "Deoghar", "Dhanbad", "Dumka", "East Singhbhum", "Garhwa", "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamtara", "Khunti", "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu", "Ramgarh", "Ranchi", "Sahebganj", "Saraikela Kharsawan", "Simdega", "West Singhbhum"],
    "Karnataka": ["Bagalkot", "Ballari", "Belagavi", "Bengaluru Rural", "Bengaluru Urban", "Bidar", "Chamarajanagar", "Chikkaballapura", "Chikkamagaluru", "Chitradurga", "Dakshina Kannada", "Davanagere", "Dharwad", "Gadag", "Hassan", "Haveri", "Kalaburagi", "Kodagu", "Kolar", "Koppal", "Mandya", "Mysuru", "Raichur", "Ramanagara", "Shivamogga", "Tumakuru", "Udupi", "Uttara Kannada", "Vijayanagara", "Vijayapura", "Yadgir"],
    "Kerala": ["Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam", "Kottayam", "Kozhikode", "Malappuram", "Palakkad", "Pathanamthitta", "Thiruvananthapuram", "Thrissur", "Wayanad"],
    "Madhya Pradesh": ["Agar Malwa", "Alirajpur", "Anuppur", "Ashoknagar", "Balaghat", "Barwani", "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara", "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda", "Narmadapuram", "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", "Mandla", "Mandsaur", "Morena", "Narsinghpur", "Neemuch", "Niwari", "Panna", "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar", "Satna", "Sehore", "Seoni", "Shahdol", "Shajapur", "Sheopur", "Shivpuri", "Sidhi", "Singrauli", "Tikamgarh", "Ujjain", "Umaria", "Vidisha", "Mauganj"],
    "Maharashtra": ["Ahmednagar", "Akola", "Amravati", "Chhatrapati Sambhaji Nagar", "Bhandara", "Beed", "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli", "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban", "Nagpur", "Nanded", "Nandurbar", "Nashik", "Dharashiv", "Palghar", "Parbhani", "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindhudurg", "Solapur", "Thane", "Wardha", "Washim", "Yavatmal"],
    "Manipur": ["Bishnupur", "Chandel", "Churachandpur", "Imphal East", "Imphal West", "Jiribam", "Kakching", "Kamjong", "Kangpokpi", "Noney", "Pherzawl", "Senapati", "Tamenglong", "Tengnoupal", "Thoubal", "Ukhrul"],
    "Meghalaya": ["East Garo Hills", "East Jaintia Hills", "East Khasi Hills", "Eastern West Khasi Hills", "North Garo Hills", "Ri Bhoi", "South Garo Hills", "South West Garo Hills", "South West Khasi Hills", "West Garo Hills", "West Jaintia Hills", "West Khasi Hills"],
    "Mizoram": ["Aizawl", "Champhai", "Hnahthial", "Khawzawl", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saitual", "Siaha", "Serchhip"],
    "Nagaland": ["Chumoukedima", "Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", "Mon", "Niuland", "Noklak", "Peren", "Phek", "Shamator", "Tseminyu", "Tuensang", "Wokha", "Zunheboto"],
    "Odisha": ["Angul", "Balangir", "Balasore", "Bargarh", "Bhadrak", "Boudh", "Cuttack", "Deogarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghapur", "Jajpur", "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar", "Khordha", "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur", "Nayagarh", "Nuapada", "Puri", "Rayagada", "Sambalpur", "Subarnapur", "Sundargarh"],
    "Punjab": ["Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib", "Fazilka", "Firozpur", "Gurdaspur", "Hoshiarpur", "Jalandhar", "Kapurthala", "Ludhiana", "Malerkotla", "Mansa", "Moga", "Pathankot", "Patiala", "Rupnagar", "Sahibzada Ajit Singh Nagar", "Sangrur", "Shahid Bhagat Singh Nagar", "Sri Muktsar Sahib", "Tarn Taran"],
    "Rajasthan": ["Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara", "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur", "Dungarpur", "Hanumangarh", "Jaipur", "Jaisalmer", "Jalore", "Jhalawar", "Jhunjhunu", "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh", "Rajsamand", "Sawai Madhopur", "Sikar", "Sirohi", "Sri Ganganagar", "Tonk", "Udaipur"],
    "Sikkim": ["Gangtok", "Gyalsing", "Pakyong", "Soreng", "Mangan", "Namchi"],
    "Tamil Nadu": ["Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", "Dindigul", "Erode", "Kallakurichi", "Kanchipuram", "Kanyakumari", "Karur", "Krishnagiri", "Madurai", "Mayiladuthurai", "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai", "Ramanathapuram", "Ranipet", "Salem", "Sivaganga", "Tenkasi", "Thanjavur", "Theni", "Thoothukudi", "Tiruchirappalli", "Tirunelveli", "Tirupathur", "Tiruppur", "Tiruvallur", "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"],
    "Telangana": ["Adilabad", "Bhadradri Kothagudem", "Hanamkonda", "Hyderabad", "Jagtial", "Jangaon", "Jayashankar Bhupalpally", "Jogulamba Gadwal", "Kamareddy", "Karimnagar", "Khammam", "Kumuram Bheem Asifabad", "Mahabubabad", "Mahabubnagar", "Mancherial", "Medak", "Medchal-Malkajgiri", "Mulugu", "Nagarkurnool", "Nalgonda", "Narayanpet", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", "Ranga Reddy", "Sangareddy", "Siddipet", "Suryapet", "Vikarabad", "Wanaparthy", "Warangal", "Yadadri Bhuvanagiri"],
    "Tripura": ["Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala", "South Tripura", "Unakoti", "West Tripura"],
    "Uttar Pradesh": ["Agra", "Aligarh", "Ambedkar Nagar", "Amethi", "Amroha", "Auraiya", "Ayodhya", "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", "Bareilly", "Basti", "Bhadohi", "Bijnor", "Budaun", "Bulandshahr", "Chandauli", "Chitrakoot", "Deoria", "Etah", "Etawah", "Farrukhabad", "Fatehpur", "Firozabad", "Gautam Buddha Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", "Hamirpur", "Hapur", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", "Kanpur Dehat", "Kanpur Nagar", "Kasganj", "Kaushambi", "Kheri", "Kushinagar", "Lalitpur", "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit", "Pratapgarh", "Prayagraj", "Raebareli", "Rampur", "Saharanpur", "Sambhal", "Sant Kabir Nagar", "Shahjahanpur", "Shamli", "Shravasti", "Siddharthnagar", "Sitapur", "Sonbhadra", "Sultanpur", "Unnao", "Varanasi"],
    "Uttarakhand": ["Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar", "Nainital", "Pauri Garhwal", "Pithoragarh", "Rudraprayag", "Tehri Garhwal", "Udham Singh Nagar", "Uttarkashi"],
    "West Bengal": ["Alipurduar", "Bankura", "Birbhum", "Cooch Behar", "Dakshin Dinajpur", "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri", "Jhargram", "Kalimpong", "Kolkata", "Malda", "Murshidabad", "Nadia", "North 24 Parganas", "Paschim Bardhaman", "Paschim Medinipur", "Purba Bardhaman", "Purba Medinipur", "Purulia", "South 24 Parganas", "Uttar Dinajpur"],
    "Andaman and Nicobar Islands": ["Nicobar", "North and Middle Andaman", "South Andaman"],
    "Chandigarh": ["Chandigarh"],
    "Dadra and Nagar Haveli and Daman and Diu": ["Dadra and Nagar Haveli", "Daman", "Diu"],
    "Delhi": ["Central Delhi", "East Delhi", "New Delhi", "North Delhi", "North East Delhi", "North West Delhi", "Shahdara", "South Delhi", "South East Delhi", "South West Delhi", "West Delhi"],
    "Jammu and Kashmir": ["Anantnag", "Bandipora", "Baramulla", "Budgam", "Doda", "Ganderbal", "Jammu", "Kathua", "Kishtwar", "Kulgam", "Kupwara", "Poonch", "Pulwama", "Rajouri", "Ramban", "Reasi", "Samba", "Shopian", "Srinagar", "Udhampur"],
    "Ladakh": ["Kargil", "Leh"],
    "Lakshadweep": ["Lakshadweep"],
    "Puducherry": ["Karaikal", "Mahe", "Puducherry", "Yanam"]
};

document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state_name');
    const districtSelect = document.getElementById('district_name');
    const oldDistrict = "{{ old('district_name') }}";

    function updateDistricts(selectedState, selectedDistrict = '') {
        if (!districtSelect) return;
        districtSelect.innerHTML = '<option value="">— Select District —</option>';
        if (selectedState && stateDistricts[selectedState]) {
            stateDistricts[selectedState].forEach(function(district) {
                const opt = document.createElement('option');
                opt.value = district;
                opt.textContent = district;
                if (district === selectedDistrict) {
                    opt.selected = true;
                }
                districtSelect.appendChild(opt);
            });
            districtSelect.disabled = false;
        } else {
            districtSelect.disabled = true;
            districtSelect.innerHTML = '<option value="">— Select State First —</option>';
        }
    }

    if (stateSelect) {
        stateSelect.addEventListener('change', function() {
            updateDistricts(this.value);
        });

        if (stateSelect.value) {
            updateDistricts(stateSelect.value, oldDistrict);
        }
    }
});
</script>
</body>
</html>
