<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ayurveda App')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Premium Ayurvedic Palette */
            --primary-green: #1a4d2e;  /* Deep Forest Green */
            --secondary-green: #4f772d; /* Herbal Green */
            --accent-gold: #c5a059;    /* Muted Gold */
            --light-bg: #fcfdfa;       /* Off-White/Mist */
            --card-bg: #ffffff;
            --text-dark: #2b2b2b;
            --text-muted: #6c757d;
            --border-color: #e0e5d5;
            
            --shadow-sm: 0 2px 8px rgba(26, 77, 46, 0.08);
            --shadow-md: 0 8px 24px rgba(26, 77, 46, 0.12);
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        h2 {
            color: var(--primary-green);
            font-weight: 700;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-green) !important;
            padding: 1rem 2rem;
            box-shadow: var(--shadow-sm);
        }
        
        .navbar-brand {
            color: var(--accent-gold) !important;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 400;
            margin-left: 1rem;
            transition: color 0.3s ease;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .nav-link:hover, .nav-link:focus {
            color: var(--accent-gold) !important;
        }

        /* Buttons */
        .btn {
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            box-shadow: 0 4px 12px rgba(26, 77, 46, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--secondary-green);
            border-color: var(--secondary-green);
            transform: translateY(-1px);
        }
        
        .btn-outline-success {
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-outline-success:hover {
            background-color: var(--primary-green);
            color: white;
        }

        /* Cards */
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background-color: white;
            border-bottom: 2px solid var(--light-bg);
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.2rem;
            padding: 1.25rem 1.5rem;
            font-family: 'Playfair Display', serif;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 3rem 0;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: var(--radius-md);
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #1b5e20;
        }

        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
        }
    </style>
</head>
<body>
    @yield('navbar')


    <div class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
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
    @yield('scripts')
</body>
</html>
