<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a href="{{ route('pharma.dashboard') }}" class="navbar-brand">
            <i class="fas fa-pills me-2"></i> Pharma Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a href="{{ route('pharma.dashboard') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('pharma.products.create') }}" class="nav-link">Add Product</a></li>
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
