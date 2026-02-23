@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Manage Doctors | Ayurveda Admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Doctors List</h1>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-secondary" style="background:var(--white); color:var(--primary-green);">+ Add New Doctor</a>
    </div>

    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>District</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->department->name ?? 'N/A' }}</td>
                    <td>{{ $doctor->district->name ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this doctor?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 2rem;">
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection
