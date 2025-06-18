@extends('cargo::adminLte.layouts.master')
@section('pageTitle', 'Tracking Stages')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Air Cargo Tracking Stages</h3>
                    <div class="card-tools">
                        <a href="{{ route('tracking-stages.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Stage
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($airStages as $stage)
                            <tr>
                                <td>{{ $stage->order }}</td>
                                <td>{{ $stage->name }}</td>
                                <td>{{ $stage->description }}</td>
                                <td>
                                    <span class="badge badge-{{ $stage->is_active ? 'success' : 'danger' }}">
                                        {{ $stage->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('tracking-stages.edit', $stage) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tracking-stages.destroy', $stage) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this stage?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sea Cargo Tracking Stages</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seaStages as $stage)
                            <tr>
                                <td>{{ $stage->order }}</td>
                                <td>{{ $stage->name }}</td>
                                <td>{{ $stage->description }}</td>
                                <td>
                                    <span class="badge badge-{{ $stage->is_active ? 'success' : 'danger' }}">
                                        {{ $stage->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('tracking-stages.edit', $stage) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tracking-stages.destroy', $stage) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this stage?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 