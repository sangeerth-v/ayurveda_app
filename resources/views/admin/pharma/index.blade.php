@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Manage Pharma Companies | Ayurveda Admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Pharma Companies List</h1>
        <a href="{{ route('admin.pharmas.create') }}" class="btn btn-secondary" style="background:var(--white); color:var(--primary-green);">+ Add New Company</a>
    </div>

    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pharmas as $pharma)
                <tr>
                    <td>{{ $pharma->company_name }}</td>
                    <td>{{ $pharma->email }}</td>
                    <td>{{ $pharma->phone }}</td>
                    <td>
                        <form action="{{ route('admin.pharmas.destroy', $pharma->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company?');" style="display:inline;">
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
            {{ $pharmas->links() }}
        </div>
    </div>
</div>
@endsection
