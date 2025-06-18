@extends('cargo::adminLte.layouts.master')
@section('pageTitle', 'Create Tracking Stage')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Tracking Stage</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('tracking-stages.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="cargo_type">Cargo Type</label>
                            <select class="form-control @error('cargo_type') is-invalid @enderror" id="cargo_type" name="cargo_type" required>
                                <option value="air" {{ old('cargo_type') == 'air' ? 'selected' : '' }}>Air Cargo</option>
                                <option value="sea" {{ old('cargo_type') == 'sea' ? 'selected' : '' }}>Sea Cargo</option>
                            </select>
                            @error('cargo_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="order">Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order') }}" required>
                            @error('order')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Stage</button>
                            <a href="{{ route('tracking-stages.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 