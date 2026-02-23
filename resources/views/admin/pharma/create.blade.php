@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Add Pharma Company | Ayurveda Admin')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h1>Add New Pharma Company</h1>
        <a href="{{ route('admin.pharmas.index') }}" class="btn btn-secondary" style="background:rgba(255,255,255,0.2); color:white; text-decoration:none; padding:0.5rem 1rem; border-radius:4px;">&larr; Back</a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.pharmas.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" name="company_name" placeholder="ABC Pharmaceuticals" value="{{ old('company_name') }}" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="contact@abcpharma.com" value="{{ old('email') }}" required>
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
                <label>Address</label>
                <textarea name="address" rows="3" placeholder="Full Address">{{ old('address') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Add Company</button>
        </form>
    </div>
</div>
@endsection
