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
            /* Royal Forest & Sage Mint Clinical Theme */
            --primary-green: #0c3b2e;       /* Deep Royal Forest Green */
            --primary-green-dark: #06231b;  /* Dark Forest Accent */
            --secondary-green: #6d9773;     /* Healing Sage Mint */
            --accent-gold: #ffba08;         /* Warm Honey Amber Accent */
            --light-bg: #f4f7f4;            /* Refreshing Soft Mint Cream */
            --card-bg: #ffffff;
            --text-dark: #072a21;
            --text-muted: #577568;
            --border-color: rgba(109, 151, 115, 0.22);
            
            --shadow-sm: 0 4px 15px rgba(12, 59, 46, 0.05);
            --shadow-md: 0 10px 30px rgba(12, 59, 46, 0.10);
            --shadow-lg: 0 18px 45px rgba(12, 59, 46, 0.16);
            --radius-md: 16px;
            --radius-lg: 24px;
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

        .navbar-nav .dropdown:hover .dropdown-menu {
            display: block;
        }

        .navbar-nav .dropdown-menu {
            margin-top: 0.2rem;
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

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    @if(Auth::guard('web')->check())
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Request Native OS / Device Push Notification Permission
        if ("Notification" in window && Notification.permission !== "granted" && Notification.permission !== "denied") {
            Notification.requestPermission();
        }

        function checkNativeNotifications() {
            fetch("{{ route('notifications.unread_latest') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.has_notification) {
                        // 1. Trigger Native OS / Mobile Push Notification
                        if ("Notification" in window && Notification.permission === "granted") {
                            const nativeNotif = new Notification(data.title, {
                                body: data.message,
                                icon: "{{ asset('favicon.ico') }}",
                                vibrate: [200, 100, 200]
                            });
                            nativeNotif.onclick = function() {
                                window.focus();
                                if (data.link) window.location.href = data.link;
                            };
                        }

                        // 2. Trigger Floating Web Banner Toast Alert
                        showNativeToastAlert(data.title, data.message, data.link);
                    }
                })
                .catch(err => console.log('Notification check:', err));
        }

        function showNativeToastAlert(title, message, link) {
            const toast = document.createElement('div');
            toast.className = 'position-fixed top-0 end-0 m-4 p-4 rounded-4 shadow-lg text-white bg-success border-0 fade show';
            toast.style.zIndex = '999999';
            toast.style.maxWidth = '380px';
            toast.innerHTML = `
                <div class="d-flex align-items-start gap-3">
                    <i class="fas fa-check-circle fa-2x text-warning flex-shrink-0 mt-1"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">${title}</h6>
                        <p class="mb-2 small opacity-90" style="line-height:1.4;">${message}</p>
                        <a href="${link || '#'}" class="btn btn-sm btn-light text-success fw-bold rounded-pill px-3">View Details</a>
                    </div>
                    <button type="button" class="btn-close btn-close-white" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
            document.body.appendChild(toast);
        }

        // Check every 6 seconds
        setInterval(checkNativeNotifications, 6000);
    });
    </script>
    @endif

    @yield('scripts')
</body>
</html>
