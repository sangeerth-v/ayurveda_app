<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration | Ayurveda App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: radial-gradient(#40916c 0.5px, transparent 0.5px), radial-gradient(#40916c 0.5px, #fefae0 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            padding: 20px;
        }

        .login-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 450px;
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
            position: relative;
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
            padding-right: 2.8rem;
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

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 38px;
            background: none;
            border: none;
            color: var(--secondary-green);
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 38px;
            width: 30px;
        }

        button[type="submit"] {
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
            margin-top: 0.5rem;
        }

        button[type="submit"]:hover {
            background: var(--secondary-green);
        }

        .error {
            background-color: #ffe5e5;
            color: #cc0000;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: left;
            font-size: 0.9rem;
            border: 1px solid #ff4d4d;
        }
        
        ul { margin: 0; padding-left: 1.5rem; }

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
        <h2>🌿 Join Ayurveda App</h2>
        
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="user@example.com">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" required placeholder="••••••••">
                <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••">
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <button type="submit">Sign Up</button>
        </form>

        <div class="text-center">
            Already have an account? <a href="{{ route('login') }}">Log In</a>
        </div>
    </div>

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
