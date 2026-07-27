<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email OTP | Ayurveda App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #2d6a4f;
            --secondary-green: #40916c;
            --light-green: #d8f3dc;
            --cream-bg: #fefae0;
            --text-dark: #1b4332;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --radius: 12px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream-bg);
            color: var(--text-dark);
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: radial-gradient(#40916c 0.5px, transparent 0.5px), radial-gradient(#40916c 0.5px, #fefae0 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }

        .verify-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 420px;
            border: 1px solid var(--light-green);
            text-align: center;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: #e8f5e9;
            color: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1.2rem;
            border: 2px solid var(--light-green);
        }

        h2 {
            color: var(--primary-green);
            margin-top: 0;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        p {
            color: #4a6f54;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .otp-input-group {
            margin-bottom: 1.5rem;
        }

        .otp-input {
            width: 100%;
            padding: 0.9rem;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 10px;
            text-align: center;
            border: 2px solid var(--light-green);
            border-radius: 8px;
            box-sizing: border-box;
            color: var(--primary-green);
            transition: all 0.3s;
        }

        .otp-input:focus {
            outline: none;
            border-color: var(--secondary-green);
            box-shadow: 0 0 0 3px rgba(64, 145, 108, 0.15);
        }

        button {
            width: 100%;
            padding: 1rem;
            background: var(--primary-green);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            background: var(--secondary-green);
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #ffe5e5;
            color: #cc0000;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            border: 1px solid #ff4d4d;
        }

        ul { margin: 0; padding-left: 1.2rem; text-align: left; }

        .resend-box {
            margin-top: 1.5rem;
            font-size: 0.88rem;
        }

        .resend-btn {
            background: none;
            border: none;
            color: var(--secondary-green);
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            text-decoration: underline;
            width: auto;
            text-transform: none;
            letter-spacing: normal;
        }

        .resend-btn:hover {
            background: none;
            color: var(--primary-green);
        }
    </style>
</head>
<body>

@include('partials.nav-public')

    <div class="verify-card">
        <div class="icon-circle">
            <i class="fas fa-envelope-open-text"></i>
        </div>

        <h2>Verify Email OTP</h2>
        <p>We've sent a 6-digit OTP code to <br><strong>{{ session('pending_registration.email') }}</strong></p>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.verify_otp') }}" method="POST">
            @csrf
            <div class="otp-input-group">
                <input type="text" name="otp" class="otp-input" maxlength="6" pattern="[0-9]{6}" placeholder="------" required autofocus autocomplete="off">
            </div>

            <button type="submit">Verify & Register</button>
        </form>

        <div class="resend-box">
            Didn't receive the OTP? 
            <form action="{{ route('register.resend_otp') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="resend-btn">Resend OTP</button>
            </form>
        </div>
    </div>
</body>
</html>
