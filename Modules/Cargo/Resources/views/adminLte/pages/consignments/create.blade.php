@php
    $user_role = auth()->user()->role;
    $admin  = 1;
    $branch = 3;
    $client = 4;
@endphp

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
                <label>Consignee</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" value="NWC" name="consignee" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Job Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                    </div>
                    <input type="text" name="job_num" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>MAWB Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-plane"></i></span>
                    </div>
                    <input type="text" name="mawb_num" class="form-control" required>
                </div>
            </div>

            {{-- <div class="form-group">
                <label>HAWB Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                    </div>
                    <input type="text" name="hawb_num" class="form-control" required>
                </div>
            </div> --}}

            <div class="form-group">
                <label>Consignment Code</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                    </div>
                    <input type="text" name="consignment_code" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                    </div>
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Source</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" name="source" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Destination</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                    </div>
                    <input type="text" name="destination" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered to Main Branch</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
