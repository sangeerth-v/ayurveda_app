@extends('layouts.app')

@section('navbar')
    @include('partials.nav-public')
@endsection

@section('content')
<div class="container py-5">
    <div class="mb-4 text-center">
        <h1 class="display-6 fw-bold">Find Ayurveda Hospitals</h1>
        <p class="text-muted">Browse verified Ayurveda hospitals, wellness centres, and certified care providers.</p>
    </div>

    <div class="row g-4">
        @forelse($hospitals as $hospital)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm rounded-4 border-0 overflow-hidden">
                    <div class="ratio ratio-16x9 bg-light">
                        @if($hospital->logo)
                            <img src="{{ asset('storage/' . $hospital->logo) }}" alt="{{ $hospital->name }}" class="card-img-top object-cover">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">No image available</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $hospital->name }}</h5>
                        <p class="text-muted mb-2">{{ $hospital->district?->name ?? 'Location not available' }}</p>
                        <p class="text-sm text-muted mb-3">{{ Str::limit($hospital->description, 110) }}</p>
                        <div class="mb-3">
                            @foreach($hospital->specialtiesList() as $specialty)
                                <span class="badge bg-success bg-opacity-15 text-success me-1 mb-1">{{ $specialty }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('login', ['role' => 'hospital']) }}" class="btn btn-success btn-sm">Hospital Login</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No hospitals are available at the moment.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
