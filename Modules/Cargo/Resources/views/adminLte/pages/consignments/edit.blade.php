@php

    $user_role = auth()->user()->role;
    $admin  = 1;
    $branch = 3;
    $client = 4;
@endphp

@extends('cargo::adminLte.layouts.master')
@section('pageTitle')
    Edit Consignments
@endsection
@section('content')
    <div class="container">
        <h2>Edit Consignment</h2>
        
        <form action="{{ route('consignment.update', $consignment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Consignment Code</label>
                <input type="text" name="consignment_code" class="form-control" value="{{ $consignment->consignment_code }}" readonly>
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $consignment->name }}" required>
            </div>

            <div class="form-group">
                <label>Source</label>
                <input type="text" name="source" class="form-control" value="{{ $consignment->source }}" required>
            </div>

            <div class="form-group">
                <label>Destination</label>
                <input type="text" name="destination" class="form-control" value="{{ $consignment->destination }}" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $consignment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_transit" {{ $consignment->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="delivered" {{ $consignment->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="canceled" {{ $consignment->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('consignment.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
