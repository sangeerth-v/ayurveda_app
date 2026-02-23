<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ayurveda App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #2d6a4f;
            --secondary-green: #40916c;
            --light-green: #d8f3dc;
            --accent-gold: #d4a373;
            --cream-bg: #fefae0;
            --text-dark: #1b4332;
            --text-light: #52b788;
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

        .login-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 400px;
            border: 1px solid var(--light-green);
        }

        h2 {
            text-align: center;
            color: var(--primary-green);
            margin-top: 0;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-green);
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid var(--light-green);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--secondary-green);
            box-shadow: 0 0 0 3px rgba(64, 145, 108, 0.1);
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

        .error {
            background-color: #ffe5e5;
            color: #cc0000;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            border: 1px solid #ff4d4d;
        }
        
        ul { margin: 0; padding-left: 1.5rem; text-align: left; }

        .text-center {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        a {
            color: var(--secondary-green);
            text-decoration: none;
            font-weight: 500;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>🌿 Welcome Back</h2>
        
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="user@example.com">
            </div>

            <div class="form-group" style="position: relative;">
                <label>Password</label>
                <input type="password" name="password" id="password" required placeholder="••••••••">
                <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 38px; cursor: pointer;">
                    👁️
                </span>
            </div>

            <button type="submit">Log In</button>
        </form>

        <div class="text-center">
            Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>
</html>
