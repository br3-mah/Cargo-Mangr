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
                <div class="modal-header-actions row">
                    <form method="POST" action="{{ route('consignment.export') }}">
                        @csrf
                            {{-- <div class="col-md-4">
                                <label for="from_date">From Date</label>
                                <input type="date" name="from_date" class="form-control" required>
                            </div> <div class="col-md-4">
                                <label for="to_date">To Date</label>
                                <input type="date" name="to_date" class="form-control" required>
                            </div> --}}
                        <button type="submit" class="btn btn-success me-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z"/>
                              </svg>
                            Export Shipments
                        </button>
                    </form>
                    <button type="button" class="btn btn-primary text-sm" data-bs-toggle="modal"
                        data-bs-target="#updateTrackerModal" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411"/>
                          </svg>
                        Update Tracker
                    </button>
                </div>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div id="column3" class="col-md-12">
                        <p class="text-muted text-sm">Mawb Number: {{ $consignment->Mawb_num }}</p>

                        <table id="shipmentTable" class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-sm">
                                    <th><i class="bi bi-upc-scan me-1"></i> Hawb No.</th>
                                    <th><i class="bi bi-box me-1"></i> Type</th>
                                    <th><i class="bi bi-building me-1"></i> Branch</th>
                                    <th><i class="bi bi-calendar-date me-1"></i> Shipping Date</th>
                                    <th><i class="bi bi-person me-1"></i> Client</th>
                                    <th><i class="bi bi-telephone me-1"></i> Client Phone</th>
                                    <th><i class="bi bi-currency-dollar me-1"></i> Cost</th>
                                    <th><i class="bi bi-clock-history me-1"></i> Created On</th>
                                    <th><i class="bi bi-gear me-1"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($consignment->shipments as $shipment)
                                <tr id="shipment_row_{{ $shipment->id }}">
                                    <td>
                                        <span class="badge bg-info rounded-pill">{{ $shipment->code }}</span>
                                    </td>
                                    <td>{{ $shipment->type }}</td>
                                    <td>{{ 'Lusaka' }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($shipment->shipping_date)->format('M d, Y') }}
                                    </td>
                                    <td>{{ $shipment->client->name }}</td>
                                    <td>{{ $shipment->client_phone ?? 'No phone' }}</td>
                                    <td>{{ $shipment->shipping_cost }}</td>
                                    <td>{{ $shipment->created_at->toFormattedDateString() }}</td>
                                    <td class="action-buttons">
                                        <a href="{{ url('admin/shipments/shipments/'.$shipment->id) }}"
                                           class="btn btn-icon btn-light text-info btn-lg rounded me-2"
                                           data-bs-toggle="tooltip"
                                           title="View Shipment">
                                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                          </svg>
                                        </a>

                                        <button class="btn btn-icon btn-light text-danger rounded"
                                                data-shipment-id="{{ $shipment->id }}"
                                                data-bs-toggle="tooltip"
                                                title="Remove Shipment">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-minus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z"/>
                                                    <path d="M11 11.5a.5.5 0 0 1 .5-.5h4a.5.5 0 1 1 0 1h-4a.5.5 0 0 1-.5-.5"/>
                                                  </svg>
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


<div class="modal fade" id="updateTrackerModal" tabindex="-1" role="dialog"
    aria-labelledby="updateTrackerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="updateTrackerModalLabel">Update Consignment Tracker</h5>
                {{-- <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
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