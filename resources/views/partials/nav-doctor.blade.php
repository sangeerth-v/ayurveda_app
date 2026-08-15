<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        @php
            $isAstrologer = \Illuminate\Support\Facades\Auth::guard('doctor')->user()?->is_admin_astrologer;
        @endphp
        <a href="{{ route('doctor.dashboard') }}" class="navbar-brand">
            @if($isAstrologer)
                <i class="fas fa-star-of-life me-2"></i> Astrologer Dashboard
            @else
                <i class="fas fa-user-md me-2"></i> Doctor Dashboard
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a href="{{ route('doctor.dashboard') }}" class="nav-link">Home</a></li>
                @if(!$isAstrologer)
                    <li class="nav-item"><a href="{{ route('doctor.products.index') }}" class="nav-link"><i class="fas fa-boxes me-1"></i> My Products</a></li>
                    <li class="nav-item"><a href="{{ route('doctor.orders.index') }}" class="nav-link"><i class="fas fa-truck me-1"></i> Product Orders</a></li>
                @endif
                <li class="nav-item"><a href="{{ route('doctor.profile') }}" class="nav-link">My Profile</a></li>
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
