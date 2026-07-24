@extends('layouts.app')

@section('navbar')
    @include('partials.nav-admin')
@endsection

@section('title', 'Add Advertisement | Ayurveda Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-gray-800">Add New Advertisement</h2>
            <a href="{{ route('admin.advertisements.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Advertisement Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required accept="image/*">
                        <div class="form-text text-muted">Recommended aspect ratio is 16:9 or 21:9 for wide slides. Max 5MB.</div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="title" class="form-label fw-bold">Title (Optional)</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="link" class="form-label fw-bold">Link URL (Optional)</label>
                            <input type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link') }}">
                            @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="order_index" class="form-label fw-bold">Display Order</label>
                            <input type="number" class="form-control @error('order_index') is-invalid @enderror" id="order_index" name="order_index" value="{{ old('order_index', 0) }}">
                            <div class="form-text">Lower numbers appear first. 0 is default.</div>
                            @error('order_index')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div> -->
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check form-switch mt-md-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2 fw-semibold text-secondary" for="is_active">Publish Immediately</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary py-2 fw-bold text-uppercase shadow-sm">
                            <i class="fas fa-save me-2"></i> Save Advertisement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
