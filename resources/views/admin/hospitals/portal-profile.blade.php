@extends('layouts.app')

@section('navbar')
    @include('partials.nav-hospital')
@endsection

@section('title', 'Hospital Profile | Ayurveda')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Hospital Profile</h2>
                <p class="text-muted mb-0">Update center details, specialties, treatments, and facilities.</p>
            </div>
            <a href="{{ route('hospital.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Back</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('hospital.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.hospitals.form')
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4"><i class="fas fa-save me-2"></i> Save Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
