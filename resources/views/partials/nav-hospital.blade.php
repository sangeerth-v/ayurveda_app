<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a href="{{ route('hospital.dashboard') }}" class="navbar-brand">
            <i class="fas fa-hospital me-2"></i> Hospital Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a href="{{ route('hospital.dashboard') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('hospital.doctors.create') }}" class="nav-link">Add Doctor</a></li>
                <li class="nav-item"><a href="{{ route('hospital.profile') }}" class="nav-link">Hospital Profile</a></li>
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
