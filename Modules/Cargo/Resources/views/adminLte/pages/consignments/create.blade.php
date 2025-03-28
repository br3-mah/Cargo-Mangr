@php

    $user_role = auth()->user()->role;
    $admin  = 1;
    $branch = 3;
    $client = 4;
@endphp

{{-- @dd('here'); --}}
@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    Add New Consignments
@endsection

@section('content')
    <div class="container">
        <h2>Create Consignment</h2>
        
        <form action="{{ route('consignment.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Consignment Code</label>
                <input type="text" name="consignment_code" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Source</label>
                <input type="text" name="source" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Destination</label>
                <input type="text" name="destination" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
