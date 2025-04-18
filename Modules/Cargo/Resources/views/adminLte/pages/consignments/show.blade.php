@php
$user_role = auth()->user()->role;
$admin = 1;
$branch = 3;
$client = 4;
@endphp

@extends('cargo::adminLte.layouts.master')

@section('pageTitle', 'Consignments')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addShipmentModal">
                        Add Shipment
                    </button>
                </div>
            </div>
            <form method="POST" action="{{ route('consignment.export') }}"> @csrf <div class="row"> <div class="col-md-4"> <label for="from_date">From Date</label> <input type="date" name="from_date" class="form-control" required> </div> <div class="col-md-4"> <label for="to_date">To Date</label> <input type="date" name="to_date" class="form-control" required> </div> <div class="col-md-4 d-flex align-items-end"> <button type="submit" class="btn btn-success">Export Shipments</button> </div> </div> </form>

            <div class="modal-body">
                <div class="row">
                    <div id="column3" class="col-md-12">
                        <p class="text-muted text-sm">Mawb Number: {{ $consignment->Mawb_num }}</p>

                        <table id="shipmentTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Hawb No.</th>
                                    <th>Type</th>
                                    <th>Branch</th>
                                    <th>Shipping Date</th>
                                    {{-- <th>Client Status</th> --}}
                                    <th>Client</th>
                                    <th>Client Phone</th>
                                    <th>Shipment Cost</th>
                                    <!-- <th>Receiver Phone</th> -->
                                    <!-- <th>Receiver Name</th> -->
                                    <!-- <th>Receiver Address</th> -->
                                    <th>Created On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($consignment->shipments as $shipment)
                                <tr id="shipment_row_{{ $shipment->id }}">
                                    <td>{{ $shipment->code }}</td>
                                    <td>{{ $shipment->type }}</td>
                                    <td>{{ 'Lusaka' }}</td>
                                    <td>{{ $shipment->shipping_date }}</td>
                                    {{-- <td>{{ $shipment->client_status }}</td> --}}
                                    <td>{{ $shipment->client->name }}</td>
                                    <td>{{ $shipment->client_phone }}</td>
                                    <td>{{ $shipment->shipping_cost }}</td>
                                    <!-- <td>{{ $shipment->reciver_phone }}</td> -->
                                    <!-- <td>{{ $shipment->reciver_name }}</td> -->
                                    <!-- <td>{{ $shipment->reciver_address }}</td> -->
                                    <td>{{ $shipment->created_at->toFormattedDateString() }}</td>
                                    <td class="action-buttons">
                                        <a href="{{ url('admin/shipments/shipments/'.$shipment->id) }}"
                                           class="btn btn-icon btn-info btn-sm rounded-circle me-2"
                                           data-bs-toggle="tooltip"
                                           title="View Shipment">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <button class="btn btn-icon btn-danger btn-sm rounded-circle"
                                                data-shipment-id="{{ $shipment->id }}"
                                                data-bs-toggle="tooltip"
                                                title="Remove Shipment">
                                            <i class="fas fa-trash-alt"></i>
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
    </div>
</div>


<div class="modal fade" id="updateTrackerModal{{ $consignment->id }}" tabindex="-1" role="dialog"
    aria-labelledby="updateTrackerModalLabel{{ $consignment->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="updateTrackerModalLabel{{ $consignment->id }}">Update Consignment Tracker</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('consignment.tracker.update', $consignment->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="tracker_status">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="Parcel received and is being processed" {{ $consignment->checkpoint == 1 ? 'selected' : '' }}>Parcel received and is being processed</option>
                            <option value="Parcel dispatched from China" {{ $consignment->checkpoint == 2 ? 'selected' : '' }}>Parcel dispatched from China</option>
                            <option value="Parcel has arrived at the transit Airport" {{ $consignment->checkpoint == 3 ? 'selected' : '' }}>Parcel has arrived at the transit Airport</option>
                            <option value="Parcel has departed from the Transit Airport to Lusaka Airport" {{ $consignment->checkpoint == 4 ? 'selected' : '' }}>Parcel has departed from the Transit Airport to Lusaka Airport</option>
                            <option value="Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress" {{ $consignment->checkpoint == 5 ? 'selected' : '' }}>Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress</option>
                            <option value="Parcel is now ready for collection in Lusaka at the Main Branch" {{ $consignment->checkpoint == 6 ? 'selected' : '' }}>Parcel is now ready for collection in Lusaka at the Main Branch</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Tracker</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Initialize DataTable
        $('.table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 100],
            "columnDefs": [
                { "orderable": false, "targets": 7 }
            ]
        });

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
            let resultsHtml = `...`; // Same content as previous for search results.
            document.getElementById('shipmentResults').innerHTML = resultsHtml;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('shipmentResults').innerHTML = "<p class='text-danger'>Error searching for shipments. Please try again.</p>";
        });
    }

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