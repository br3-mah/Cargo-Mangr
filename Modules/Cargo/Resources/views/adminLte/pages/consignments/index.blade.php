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
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#consignmentModal"
                                            onclick="openModal({{ $consignment->id }}, '{{ (string)$consignment->consignment_code }}')   ">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
<style>
    /* Existing custom checkbox styles remain the same */
    .modal-dialog.modal-xl {
        max-width: 1200px;
    }

    .shipments-grid {
        max-height: 400px;
        overflow-y: auto;
    }

    .current-shipment-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #e9ecef;
        border-radius: 4px;
    }

    .current-shipment-badge {
        background-color: #28a745;
        color: white;
        padding: 3px 8px;
        border-radius: 3px;
        margin-left: 10px;
    }

    .shipment-details {
        display: flex;
        align-items: center;
    }

    .shipment-info {
        margin-left: 15px;
    }
</style>

<div class="modal fade" id="consignmentModal" tabindex="-1" aria-labelledby="consignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consignmentModalLabel">Consignment Shipment Management 
                    <span id="formConsignmentCode"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Consignment ID</label>
                            <input type="text" id="modalConsignmentId" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Search Shipments</label>
                            <input type="text" id="searchShipment" class="form-control" 
                                   placeholder="Search shipment by code..." 
                                   onkeyup="searchShipment()">
                        </div>
                        
                        <div id="shipmentResults" class="shipment-results mt-3"></div>
                    </div>
                    <div class="col-md-4">
                        <h6>Selected Shipments:</h6>
                        <ul id="selectedShipments" class="list-group selected-shipments"></ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Current Saved Shipments</h6>
                        <div id="currentShipmentsList" class="shipments-grid"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Submit Selected Shipments -->
                <form id="submitShipmentsForm" method="POST" action="{{ route('submit.shipments') }}">
                    @csrf
                    <input type="hidden" id="formConsignmentId" name="consignment_id">
                    <input type="hidden" id="selectedShipmentIds" name="shipment_id[]" value="[]">
                    <button type="submit" class="btn btn-primary">Submit Selected</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedShipments = [];
    let currentShipments = [];

    function openModal(consignmentId, consCode) {
        // Set consignment ID in modal and hidden input
        document.getElementById('modalConsignmentId').value = consignmentId;
        document.getElementById('formConsignmentId').value = consignmentId;
        document.getElementById('formConsignmentId').style.visibility = 'hidden';
        document.getElementById('formConsignmentCode').innerHTML = consCode;
        
        // Reset all selection-related elements
        selectedShipments = [];
        document.getElementById('selectedShipments').innerHTML = "";
        document.getElementById('selectedShipmentIds').value = JSON.stringify([]);
        document.getElementById('searchShipment').value = "";
        document.getElementById('shipmentResults').innerHTML = "";

        // Fetch current shipments for this consignment
        fetchCurrentShipments(consignmentId);
    }

    function fetchCurrentShipments(consignmentId) {
        fetch(`/api/consignments/${consignmentId}/shipments`)
            .then(response => response.json())
            .then(shipments => {
                currentShipments = shipments;
                renderCurrentShipments();
            })
            .catch(error => {
                console.error('Error fetching shipments:', error);
                document.getElementById('currentShipmentsList').innerHTML = 
                    '<div class="alert alert-danger">Unable to load shipments</div>';
            });
    }

    function renderCurrentShipments() {
        let currentShipmentsList = document.getElementById('currentShipmentsList');
        
        if (currentShipments.length === 0) {
            currentShipmentsList.innerHTML = 
                '<div class="alert alert-info">No current shipments</div>';
            return;
        }

        let html = currentShipments.map(shipment => `
            <div class="current-shipment-item" data-shipment-id="${shipment.id}">
                <div class="shipment-details">
                    <div>
                        <strong>${shipment.code}</strong>
                        <span class="current-shipment-badge">Verified</span>
                    </div>
                    <div class="shipment-info">
                        <small>Receiver Name: ${shipment.reciver_name}</small><br>
                        <small>Receiver Address: ${shipment.reciver_address} (${shipment.type})</small><br>
                        <small>Weight: ${shipment.total_weight} Kg</small>
                    </div>
                </div>
            </div>
        `).join('');
        
        currentShipmentsList.innerHTML = html;
    }
    
        function searchShipment() {
            let query = document.getElementById('searchShipment').value;
            
            if (query.length < 2) {
                document.getElementById('shipmentResults').innerHTML = "";
                return;
            }
    
            fetch("{{ route('search.shipments') }}?query=" + query)
                .then(response => response.json())
                .then(data => {
                    let resultsHtml = "";
                    data.forEach(shipment => {
                        resultsHtml += `
                            <label class="custom-checkbox">
                                ${shipment.code}
                                <input type="checkbox" 
                                       name="shipment_id[]" 
                                       value="${shipment.id}" 
                                       id="shipment_${shipment.id}" 
                                       onclick="toggleShipment(${shipment.id}, '${shipment.code}')">
                                <span class="checkmark"></span>
                            </label>
                        `;
                    });
                    document.getElementById('shipmentResults').innerHTML = resultsHtml;
                });
        }
    
        function toggleShipment(id, code) {
            let checkbox = document.getElementById(`shipment_${id}`);
            let index = selectedShipments.findIndex(s => s.id === id);
            
            if (checkbox.checked) {
                if (index === -1) {
                    selectedShipments.push({ id, code });
                }
            } else {
                if (index !== -1) {
                    selectedShipments.splice(index, 1);
                }
            }
    
            // Update selected shipments list in the UI
            let listHtml = "";
            selectedShipments.forEach(s => {
                listHtml += `
                    <li class="list-group-item">
                        ${s.code}
                        <span class="remove-shipment" onclick="removeShipment(${s.id})">
                            <i class="fa fa-times"></i>
                        </span>
                    </li>
                `;
            });
            document.getElementById('selectedShipments').innerHTML = listHtml;
    
            // Update hidden input with JSON stringified array of shipment IDs
            document.getElementById('selectedShipmentIds').value = JSON.stringify(selectedShipments.map(s => s.id));
        }
    
        function removeShipment(id) {
            // Remove from selected shipments
            selectedShipments = selectedShipments.filter(s => s.id !== id);
            
            // Uncheck the corresponding checkbox
            let checkbox = document.getElementById(`shipment_${id}`);
            if (checkbox) checkbox.checked = false;
    
            // Update UI and hidden input
            let listHtml = "";
            selectedShipments.forEach(s => {
                listHtml += `
                    <li class="list-group-item">
                        ${s.code}
                        <span class="remove-shipment" onclick="removeShipment(${s.id})">
                            <i class="fa fa-times"></i>
                        </span>
                    </li>
                `;
            });
            document.getElementById('selectedShipments').innerHTML = listHtml;
            
            // Update hidden input with JSON stringified array of shipment IDs
            document.getElementById('selectedShipmentIds').value = JSON.stringify(selectedShipments.map(s => s.id));
        }
    </script>
    
    <!-- Ensure the hidden input is set up to receive a JSON array -->
@endsection
