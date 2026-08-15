<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <i class="fas fa-user-shield me-2"></i> Admin Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-1">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-chart-line me-1"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.bookings.index') }}" class="nav-link"><i class="fas fa-calendar-check me-1"></i> Appointments</a></li>
                <li class="nav-item"><a href="{{ route('admin.orders.index') }}" class="nav-link"><i class="fas fa-shopping-bag me-1"></i> Orders</a></li>
                <li class="nav-item"><a href="{{ route('admin.products.index') }}" class="nav-link"><i class="fas fa-cubes me-1"></i> Products</a></li>
                <li class="nav-item"><a href="{{ route('admin.doctors.index') }}" class="nav-link"><i class="fas fa-user-md me-1"></i> Doctors</a></li>
                <li class="nav-item"><a href="{{ route('admin.astrology.edit') }}" class="nav-link"><i class="fas fa-star-of-life me-1"></i> Astrology Settings</a></li>
                <li class="nav-item"><a href="{{ route('admin.pharmas.index') }}" class="nav-link"><i class="fas fa-building me-1"></i> Pharmacies</a></li>
                <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link"><i class="fas fa-users me-1"></i> Users</a></li>
                <li class="nav-item"><a href="{{ route('admin.advertisements.index') }}" class="nav-link"><i class="fas fa-bullhorn me-1"></i> Ads</a></li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-decoration-none"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
