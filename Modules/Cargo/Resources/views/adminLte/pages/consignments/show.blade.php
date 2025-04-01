@php
    $user_role = auth()->user()->role;
    $admin  = 1;
    $branch = 3;
    $client = 4;
@endphp

@extends('cargo::adminLte.layouts.master')

@section('pageTitle', 'Consignments')

@section('content')

<div class="col-lg-12" id="consignmentModal">
    <div class="col-12">
        <div class="content">
            <div class="modal-header">
                <h5 class="modal-title" id="consignmentModalLabel">
                    <span class="fw-bold font-bold"><b>Consignment Code: {{ $consignment->consignment_code }}</b></span>
                    <span id="formConsignmentCode" class="text-white ms-2"></span>
                </h5>
                <div style="margin-left: -20px;" class="items-center flex d-flex">
                    <img src="http://localhost:8000/assets/lte/cargo-logo.svg" width="60" alt="">
                </div>
                <div class="modal-header-actions">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShipmentModal">
                        Add Shipment
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="column3" class="col-md-12">
                        <p class="text-muted text-sm">Current Saved Shipments</p>
                        {{-- integrate js datatable here --}}
                        <table id="shipmentTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Branch ID</th>
                                    <th>Shipping Date</th>
                                    <th>Client Status</th>
                                    <th>Client ID</th>
                                    <th>Client Phone</th>
                                    <th>Receiver Phone</th>
                                    <th>Receiver Name</th>
                                    <th>Receiver Address</th>
                                    <th>Created On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($consignment->shipments as $shipment)
                                <tr id="shipment_row_{{ $shipment->id }}">
                                    <td>{{ $shipment->code }}</td>
                                    <td>{{ $shipment->type }}</td>
                                    <td>{{ $shipment->branch_id }}</td>
                                    <td>{{ $shipment->shipping_date }}</td>
                                    <td>{{ $shipment->client_status }}</td>
                                    <td>{{ $shipment->client_id }}</td>
                                    <td>{{ $shipment->client_phone }}</td>
                                    <td>{{ $shipment->reciver_phone }}</td>
                                    <td>{{ $shipment->reciver_name }}</td>
                                    <td>{{ $shipment->reciver_address }}</td>
                                    <td>{{ $shipment->created_at->toFormattedDateString() }}</td>
                                    <td>
                                        <a href="{{ url('admin/shipments/shipments/'.$shipment->id) }}" class="btn btn-info btn-sm">View</a>
                                        {{-- This button will now remove this shipment from the consignment --}}
                                        <button class="btn btn-danger btn-sm" data-shipment-id="{{ $shipment->id }}">Remove</button>
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
</div>

<!-- Add Shipment Modal -->
<div class="modal fade" id="addShipmentModal" tabindex="-1" aria-labelledby="addShipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addShipmentModalLabel">Add Shipments to Consignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="consignmentId" value="{{ $consignment->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <h6 class="text-muted"><b>Search Shipments:</b></h6>
                            <input type="text" id="searchShipment" class="form-control"
                                placeholder="Search shipment by code..."
                                onkeyup="searchShipment()">
                        </div>

                        <div id="shipmentResults" class="search-results mt-3">
                            <p class="text-muted">Type at least 2 characters to search for shipments...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="addSelectedShipmentsToConsignment({{ $consignment->id }})">
                    Add Selected Shipments
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function searchShipment() {
        let query = document.getElementById('searchShipment').value;

        if (query.length < 2) {
            document.getElementById('shipmentResults').innerHTML = "<p class='text-muted'>Type at least 2 characters to search for shipments...</p>";
            return;
        }

        // Show loading indicator
        document.getElementById('shipmentResults').innerHTML = "<p class='text-center'><i class='fas fa-spinner fa-spin'></i> Searching...</p>";

        // This is a working query route for live searching through shipments
        fetch("{{ route('search.shipments') }}?query=" + query)
    .then(response => response.json())
    .then(data => {
        if (data.length === 0) {
            document.getElementById('shipmentResults').innerHTML = "<p class='text-center'>No shipments found matching your search.</p>";
            return;
        }

        // Custom styled results container
        let resultsHtml = `
            <div class="shipment-results-wrapper" style="max-height: 350px; overflow-y: auto; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <div class="list-group list-group-flush">
        `;

        data.forEach(shipment => {
            resultsHtml += `
                <div class="list-group-item list-group-item-action p-2 d-flex align-items-center shipment-item" style="border-left: 3px solid #3490dc; transition: all 0.2s ease;">
                    <div class="form-check me-2" style="min-width: 24px;">
                        <input class="form-check-input"
                            style="cursor: pointer; border-width: 2px;"
                            type="checkbox"
                            name="shipment_id[]"
                            value="${shipment.id}"
                            id="shipment_${shipment.id}"
                            onclick="event.stopPropagation(); toggleShipment(${shipment.id}, '${shipment.code}')">
                    </div>
                    <div class="ms-1 flex-grow-1 overflow-hidden" onclick="document.getElementById('shipment_${shipment.id}').click();" style="cursor: pointer;">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-truncate" style="max-width: 120px;">${shipment.code}</span>
                            <small class="text-muted ms-2">${shipment.reciver_phone || 'No phone'}</small>
                        </div>
                        <div class="text-truncate small" style="opacity: 0.8;">${shipment.reciver_name || 'Unknown'}</div>
                    </div>
                </div>
            `;
        });

        resultsHtml += `</div></div>`;
        resultsHtml += `<div class="text-muted small mt-2 d-flex justify-content-between">
                            <span>Found ${data.length} shipment(s)</span>
                            <span id="selected-count">0 selected</span>
                        </div>`;

        document.getElementById('shipmentResults').innerHTML = resultsHtml;

        // Add hover effect for list items
        document.querySelectorAll('.shipment-item').forEach(item => {
            item.addEventListener('mouseover', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            item.addEventListener('mouseout', function() {
                this.style.backgroundColor = '';
            });
        });
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('shipmentResults').innerHTML = "<p class='text-danger'>Error searching for shipments. Please try again.</p>";
    });

    }


// Update the toggleShipment function to count selected items
function toggleShipment(shipmentId, shipmentCode) {
    const checkbox = document.getElementById(`shipment_${shipmentId}`);
    console.log(`Shipment ${shipmentCode} (${shipmentId}) is now ${checkbox.checked ? 'selected' : 'unselected'}`);

    // Highlight the selected item
    const item = checkbox.closest('.shipment-item');
    if (checkbox.checked) {
        item.style.backgroundColor = '#e8f4ff';
    } else {
        item.style.backgroundColor = '';
    }

    // Update the selected count
    const selectedCount = document.querySelectorAll('input[name="shipment_id[]"]:checked').length;
    document.getElementById('selected-count').textContent = `${selectedCount} selected`;
}

    function addSelectedShipmentsToConsignment(consignmentId) {
        const selectedShipments = document.querySelectorAll('input[name="shipment_id[]"]:checked');
        const shipmentIds = Array.from(selectedShipments).map(checkbox => checkbox.value);

        if (shipmentIds.length === 0) {
            alert('Please select at least one shipment to add');
            return;
        }

        // Send AJAX request to add shipments to consignment
        fetch(`../api/submit-shipments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ shipment_ids: shipmentIds, consignment_id: consignmentId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Failed to add shipments: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Function to remove a shipment from the consignment
    function removeShipmentFromConsignment(shipmentId, consignmentId) {
        if (!confirm('Are you sure you want to remove this shipment from the consignment?')) {
            return;
        }

        // Send AJAX request to remove shipment from consignment
        fetch(`../api/consignments/${consignmentId}/remove-shipment/${shipmentId}`, {
            method: 'POST',
            headers: {
                // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row from the table
                const row = document.querySelector(`#shipment_row_${shipmentId}`);
                if (row) {
                    row.remove();
                } else {
                    // If we can't find the row, just reload the page
                    window.location.reload();
                }
            } else {
                alert('Failed to remove shipment: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the shipment');
        });
    }

    // Initialize when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable for better table presentation
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#shipmentTable').DataTable({
                responsive: true,
                "pageLength": 10
            });
        }

        // Add event listeners to all Remove buttons
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function() {
                const shipmentId = this.getAttribute('data-shipment-id');
                const consignmentId = {{ $consignment->id }};

                removeShipmentFromConsignment(shipmentId, consignmentId);
            });
        });
    });
</script>
@endsection