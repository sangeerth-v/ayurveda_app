@extends('layouts.app')

@section('navbar')
    @include('partials.nav-hospital')
@endsection

@section('title', 'Add Doctor | Hospital')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Add Doctor</h2>
                <p class="text-muted mb-0">Register a doctor under your hospital or center.</p>
            </div>
            <a href="{{ route('hospital.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Back</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('hospital.doctors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.hospitals.portal-doctor-form')
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4"><i class="fas fa-check-circle me-2"></i> Register Doctor</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
