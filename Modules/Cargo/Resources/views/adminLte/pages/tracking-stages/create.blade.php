@extends('cargo::adminLte.layouts.master')
@section('pageTitle', 'Add Tracking Stage')
@section('content')
<div class="container-fluid">
    <!-- Breadcrumb navigation with modern styling -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="flex items-center py-2 px-4 bg-gray-50 rounded-lg shadow-sm text-sm">
            <li class="flex items-center">
                <a href="#" class="text-yellow-400 hover:text-yellow-500 transition-colors">
                    <i class="fas fa-home mr-1"></i> Dashboard
                </a>
                <svg class="h-4 w-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="flex items-center">
                <a href="{{ fr_route('tracking-stages.index') }}" class="text-yellow-400 hover:text-yellow-500 transition-colors">
                    <i class="fas fa-list mr-1"></i> Tracking Stages
                </a>
                <svg class="h-4 w-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-700 font-medium" aria-current="page">
                <i class="fas fa-plus mr-1"></i> Add Stage
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Tracking Stage</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('tracking-stages.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-tag text-warning me-2"></i>Name
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-warning text-white">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                            id="name" name="name" value="{{ old('name') }}" required
                                            placeholder="Enter stage name">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order">
                                        <i class="fas fa-sort-numeric-down text-warning me-2"></i>Order
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-warning text-white">
                                            <i class="fas fa-sort-numeric-down"></i>
                                        </span>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                            id="order" name="order" value="{{ old('order', $nextOrder ?? 1) }}" required readonly>
                                        @error('order')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="description">
                                <i class="fas fa-info-circle text-warning me-2"></i>Description
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning text-white">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="3" 
                                    placeholder="Enter stage description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="cargo_type">
                                <i class="fas fa-box text-warning me-2"></i>Cargo Type
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning text-white">
                                    <i class="fas fa-box"></i>
                                </span>
                                <select class="form-control @error('cargo_type') is-invalid @enderror" 
                                    id="cargo_type" name="cargo_type" required>
                                    <option value="">Select cargo type</option>
                                    <option value="air" {{ old('cargo_type') == 'air' ? 'selected' : '' }}>
                                        <i class="fas fa-plane"></i> Air Cargo
                                    </option>
                                    <option value="sea" {{ old('cargo_type') == 'sea' ? 'selected' : '' }}>
                                        <i class="fas fa-ship"></i> Sea Cargo
                                    </option>
                                </select>
                                @error('cargo_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" 
                                    name="is_active" value="1" checked>
                                <label class="custom-control-label" for="is_active">
                                    <i class="fas fa-toggle-on text-warning me-2"></i>Active
                                </label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Save Stage
                            </button>
                            <a href="{{ route('tracking-stages.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.input-group-text {
    border: none;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-warning {
    color: #000;
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-warning:hover {
    color: #000;
    background-color: #e0a800;
    border-color: #d39e00;
}

.form-group label {
    font-weight: 500;
    color: #495057;
}

.input-group .form-control {
    border-left: none;
}

.input-group .input-group-text {
    border-right: none;
}

textarea.form-control {
    min-height: 100px;
}

select.form-control {
    cursor: pointer;
}

.custom-switch .custom-control-label::before {
    height: 1.5rem;
    width: 3rem;
}

.custom-switch .custom-control-label::after {
    height: calc(1.5rem - 4px);
    width: calc(1.5rem - 4px);
}

/* Remove old breadcrumb styles since we're using Tailwind now */
.breadcrumb,
.breadcrumb-item,
.breadcrumb-item + .breadcrumb-item::before,
.breadcrumb-item a,
.breadcrumb-item.active,
.breadcrumb-item i {
    /* Remove these styles as they're no longer needed */
}
</style>
@endsection 