@extends('layouts.app')

@section('navbar')
    @include('partials.nav-hospital')
@endsection

@section('title', 'Hospital Dashboard | Ayurveda')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-7">
        <h2 class="mb-1">{{ $hospital->name }}</h2>
        <p class="text-muted mb-0">{{ $hospital->district->name ?? 'No district selected' }} | {{ $hospital->phone }}</p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <a href="{{ route('hospital.doctors.create') }}" class="btn btn-primary"><i class="fas fa-user-plus me-2"></i> Add Doctor</a>
        <a href="{{ route('hospital.profile') }}" class="btn btn-outline-success"><i class="fas fa-hospital me-2"></i> Profile</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted">Doctors</div><h2 class="display-6 fw-bold">{{ $hospital->doctors->count() }}</h2></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted">Specialties</div><h2 class="display-6 fw-bold">{{ $hospital->specialtiesList()->count() }}</h2></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted">Treatments</div><h2 class="display-6 fw-bold">{{ $hospital->treatmentsList()->count() }}</h2></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted">Facilities</div><h2 class="display-6 fw-bold">{{ $hospital->facilitiesList()->count() }}</h2></div></div></div>
</div>

<div class="row g-4 mb-4">
    @foreach(['Specialties' => $hospital->specialtiesList(), 'Treatments' => $hospital->treatmentsList(), 'Facilities' => $hospital->facilitiesList()] as $label => $items)
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">{{ $label }}</div>
            <div class="card-body">
                @forelse($items as $item)
                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-3 py-2 mb-2">{{ $item }}</span>
                @empty
                    <p class="text-muted mb-0">Add {{ strtolower($label) }} from Hospital Profile.</p>
                @endforelse
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span>Hospital Doctors</span>
        <a href="{{ route('hospital.doctors.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Add</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Doctor</th>
                        <th class="py-3">Specialization</th>
                        <th class="py-3">Password</th>
                        <th class="py-3">Fee</th>
                        <th class="py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hospital->doctors as $doctor)
                    <tr>
                        <td class="ps-4 py-4"><div class="fw-bold">{{ $doctor->name }}</div><div class="small text-muted">{{ $doctor->email }} | {{ $doctor->phone }}</div></td>
                        <td>{{ $doctor->specialization_category }}<div class="small text-muted">{{ $doctor->specialization_subcategory }}</div></td>
                        <td><code>{{ $doctor->password_plain ?? 'N/A' }}</code></td>
                        <td>{{ $doctor->consultation_fee ? 'Rs. ' . $doctor->consultation_fee : 'N/A' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('hospital.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('hospital.doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Remove this doctor from your hospital?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">No doctors added yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
