@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Pharma Profile | Ayurveda Admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.pharmas.index') }}" class="text-success text-decoration-none">Pharma Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $pharma->company_name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="card-body text-center p-5" style="background: linear-gradient(135deg, var(--accent-gold), #b38b4d);">
                <div class="rounded-3 d-inline-flex align-items-center justify-content-center mb-3 bg-white shadow-lg overflow-hidden" style="width: 100px; height: 100px;">
                    @if($pharma->logo)
                        <img src="{{ asset('storage/' . $pharma->logo) }}" style="width: 100%; height: 100%; object-fit: contain;">
                    @else
                        <i class="fas fa-capsules fa-3x" style="color: var(--accent-gold);"></i>
                    @endif
                </div>
                <h3 class="text-white mb-1">{{ $pharma->company_name }}</h3>
                <span class="badge bg-white text-dark rounded-pill px-3 py-2 mt-2 opacity-90">Official Partner</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">Company ID</span>
                        <span class="fw-bold">#PHR-{{ str_pad($pharma->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </li>
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">Products Listed</span>
                        <span class="badge bg-primary rounded-pill">0</span>
                    </li>
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small text-uppercase fw-bold">Partner Since</span>
                        <span class="fw-bold text-muted small">{{ $pharma->created_at->format('M Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Contact & Address -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-warning"></i> Business Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Admin Email</label>
                    <div class="text-dark">{{ $pharma->email }}</div>
                </div>
                <div class="mb-3">
                    <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Contact Support</label>
                    <div class="text-dark">{{ $pharma->phone ?? 'Not provided' }}</div>
                </div>
                <div>
                    <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Registered Address</label>
                    <div class="text-dark small">{{ $pharma->address ?? 'Address details not available' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Stats Overview -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                    <div class="card-body p-4 text-center">
                        <h2 class="display-6 fw-bold text-primary mb-1">0</h2>
                        <span class="text-uppercase small fw-bold text-primary opacity-75">Active Orders</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                    <div class="card-body p-4 text-center">
                        <h2 class="display-6 fw-bold text-success mb-1">₹0</h2>
                        <span class="text-uppercase small fw-bold text-success opacity-75">Total Revenue</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Management Placeholder -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-box-open me-2 text-warning"></i> Catalog Inventory</h5>
                <button class="btn btn-sm btn-outline-warning text-dark disabled">View Catalog</button>
            </div>
            <div class="card-body text-center py-5">
                <div class="opacity-25 mb-3">
                    <i class="fas fa-boxes fa-4x text-muted"></i>
                </div>
                <h6 class="text-muted">No products have been uploaded by this company yet.</h6>
            </div>
        </div>

        <!-- Actions -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 d-flex gap-3">
                <form action="{{ route('admin.pharmas.destroy', $pharma->id) }}" method="POST" onsubmit="return confirm('Delete this pharma company and all associated data?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i> Terminate Partnership
                    </button>
                </form>
                <a href="{{ route('admin.pharmas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Return to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
