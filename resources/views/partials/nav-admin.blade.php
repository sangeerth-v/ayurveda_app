<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <i class="fas fa-shield-alt me-2"></i> Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Overview</a></li>
                <li class="nav-item"><a href="{{ route('admin.doctors.index') }}" class="nav-link">Doctors</a></li>
                <li class="nav-item"><a href="{{ route('admin.pharmas.index') }}" class="nav-link">Pharmacies</a></li>
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link"><i class="fas fa-external-link-alt me-1"></i> Visit Website</a></li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-decoration-none">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
