<style>
    .public-navbar {
        background-color: #1a4d2e !important;
        padding: 0.75rem 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1050;
    }
    .public-navbar .navbar-brand {
        color: #c5a059 !important;
        font-family: 'Playfair Display', serif;
        font-size: 1.65rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .public-navbar .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        margin-left: 1.2rem;
        font-size: 0.95rem;
        transition: color 0.2s ease;
    }
    .public-navbar .nav-link:hover, 
    .public-navbar .nav-link:focus {
        color: #c5a059 !important;
    }
    .public-navbar .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.3);
    }
    .public-navbar .navbar-toggler-icon {
        filter: invert(1);
    }
</style>
<nav class="navbar navbar-expand-lg sticky-top public-navbar">
    <div class="container-fluid">
        <a href="{{ url('/') }}" class="navbar-brand">
            <i class="fas fa-leaf me-2 text-warning"></i> Ayurveda
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Products</a></li>
                <li class="nav-item"><a href="{{ route('doctors.index') }}" class="nav-link">Doctors</a></li>
                
                @if(Auth::guard('web')->check())
                    <!-- <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">My Dashboard</a></li> -->
                    <li class="nav-item"><a href="{{ route('cart.index') }}" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                    <li class="nav-item"><a href="{{ route('orders.index') }}" class="nav-link">My Orders</a></li>
                    <li class="nav-item"><a href="{{ route('bookings.my') }}" class="nav-link"><i class="fas fa-calendar-check"></i> My Appointments</a></li>
                    <li class="nav-item">
                        <a href="{{ route('profile') }}" class="nav-link">
                            <i class="fas fa-user-circle me-1"></i> My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-decoration-none">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link"><i class="fas fa-user me-1"></i> Login / Register</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
