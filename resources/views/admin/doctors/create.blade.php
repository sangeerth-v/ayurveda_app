@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Add Doctor | Ayurveda Admin')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h1>Add New Practitioner</h1>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary" style="background:rgba(255,255,255,0.2); color:white; text-decoration:none; padding:0.5rem 1rem; border-radius:4px;">&larr; Back</a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.doctors.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Doctor Name</label>
                    <input type="text" name="name" placeholder="Dr. Full Name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="email@example.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="+91 98765 43210" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department" placeholder="e.g. Panchakarma" value="{{ old('department') }}" required>
                </div>

                <div class="form-group">
                    <label>District</label>
                    <input type="text" name="district" placeholder="e.g. Wayanad" value="{{ old('district') }}" required>
                </div>

                <div class="form-group">
                    <label>Qualification</label>
                    <input type="text" name="qualification" placeholder="e.g. BAMS, MD (Ay)" value="{{ old('qualification') }}">
                </div>

                <div class="form-group">
                    <label>Experience (Years)</label>
                    <input type="number" name="experience" placeholder="e.g. 5" value="{{ old('experience') }}">
                </div>

                <div class="form-group">
                    <label>Consultation Fee (₹)</label>
                    <input type="number" step="0.01" name="consultation_fee" placeholder="0.00" value="{{ old('consultation_fee') }}">
                </div>

                <div class="form-group">
                    <label>Available Time</label>
                    <input type="text" name="available_time" placeholder="e.g. 9:00 AM - 5:00 PM" value="{{ old('available_time') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Register Doctor</button>
        </form>
    </div>
</div>
@endsection
