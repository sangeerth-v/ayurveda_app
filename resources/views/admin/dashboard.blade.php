@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Admin Dashboard | Ayurveda')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="mb-3">Admin Overview</h2>
        <p class="text-muted">Welcome back, Admin. Here is what's happening today.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Doctors Stat Card -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm" style="border-left: 5px solid var(--primary-green) !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="rounded-circle p-3" style="background-color: var(--light-bg); color: var(--primary-green);">
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                </div>
                <h5 class="card-title text-muted mb-0">Total Doctors</h5>
                <h2 class="display-6 fw-bold my-2" style="color: var(--primary-green);">{{ \App\Models\Doctor::count() }}</h2>
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-sm btn-outline-success stretched-link mt-2">Manage Doctors <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Pharmas Stat Card -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm" style="border-left: 5px solid var(--accent-gold) !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="rounded-circle p-3" style="background-color: #fff8e1; color: var(--accent-gold);">
                        <i class="fas fa-capsules fa-2x"></i>
                    </div>
                    <span class="badge bg-warning bg-opacity-10 text-warning">Partners</span>
                </div>
                <h5 class="card-title text-muted mb-0">Pharma Companies</h5>
                <h2 class="display-6 fw-bold my-2" style="color: var(--text-dark);">{{ \App\Models\PharmaCompany::count() }}</h2>
                <a href="{{ route('admin.pharmas.index') }}" class="btn btn-sm btn-outline-warning stretched-link mt-2 text-dark">Manage Pharmas <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Users Stat Card -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm" style="border-left: 5px solid #4a90e2 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="rounded-circle p-3" style="background-color: #e3f2fd; color: #4a90e2;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <span class="badge bg-info bg-opacity-10 text-info">Registered</span>
                </div>
                <h5 class="card-title text-muted mb-0">Total Users</h5>
                <h2 class="display-6 fw-bold my-2" style="color: var(--text-dark);">{{ \App\Models\User::count() }}</h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-info stretched-link mt-2">View Users <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold" style="color: var(--primary-green);">Quick Actions</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex gap-3">
                    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle"></i> Add New Doctor
                    </a>
                    <a href="{{ route('admin.pharmas.create') }}" class="btn btn-outline-dark d-flex align-items-center gap-2">
                        <i class="fas fa-building"></i> Register Pharma
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
