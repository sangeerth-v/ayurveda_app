<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a href="{{ url('/') }}" class="navbar-brand">
            <i class="fas fa-leaf me-2"></i> Ayurveda
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
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-decoration-none">Logout</button>
                        </form>
                    </li>
                @elseif(Auth::guard('admin')->check() || Auth::guard('doctor')->check() || Auth::guard('pharma')->check())
                    {{-- Professional logged in viewing public pages --}}
                    @if(Auth::guard('admin')->check())
                        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Dashboard</a></li>
                    @elseif(Auth::guard('doctor')->check())
                        <li class="nav-item"><a href="{{ route('doctor.dashboard') }}" class="nav-link">Doctor Dashboard</a></li>
                    @elseif(Auth::guard('pharma')->check())
                        <li class="nav-item"><a href="{{ route('pharma.dashboard') }}" class="nav-link">Pharma Dashboard</a></li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-decoration-none">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
