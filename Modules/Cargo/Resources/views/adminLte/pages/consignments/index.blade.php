@php
    $user_role = auth()->user()->role;
    $admin  = 1;
    $branch = 3;
    $client = 4;
@endphp

@extends('cargo::adminLte.layouts.master')

@section('pageTitle', 'Consignments')

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="container-fluid">
                <h2 class="mb-3">Consignments</h2>
                <a href="{{ route('consignment.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Add New Consignment
                </a>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Source</th>
                                <th>Destination</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consignments as $consignment)
                                <tr>
                                    <td>{{ $consignment->id }}</td>
                                    <td>{{ $consignment->consignment_code }}</td>
                                    <td>{{ $consignment->name }}</td>
                                    <td>{{ $consignment->source }}</td>
                                    <td>{{ $consignment->destination }}</td>
                                    <td>
                                        <span class="badge badge-{{ $consignment->status == 'delivered' ? 'success' : ($consignment->status == 'in_transit' ? 'info' : 'warning') }}">
                                            {{ ucfirst($consignment->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('consignment.edit', $consignment->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('consignment.destroy', $consignment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        <!-- New Modal Trigger Button -->
                                        <a class="btn btn-sm btn-info" href="{{ route('consignment.show', $consignment->id) }}">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('cargo::adminLte.pages.consignments.editor.index')

    <!-- Ensure the hidden input is set up to receive a JSON array -->
@endsection
