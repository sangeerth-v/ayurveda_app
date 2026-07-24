@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Add Hospital | Ayurveda Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Register Hospital / Center</h2>
                <p class="text-muted mb-0">Create credentials and service details for a hospital account.</p>
            </div>
            <a href="{{ route('admin.hospitals.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Back</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.hospitals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.hospitals.form')
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4"><i class="fas fa-check-circle me-2"></i> Register Hospital</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
