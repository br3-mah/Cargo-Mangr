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

    <div class="">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-2 mb-0" style="font-size: 0.9rem; border-radius: 0.25rem;">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('consignment.index') }}">Consignments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Consignment - Shipments</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 rounded-lg mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            
                <h5 class="card-title mb-0 text-primary fw-bold" id="consignmentModalLabel">
                    Consignment Code: <span class="text-dark">{{ $consignment->consignment_code }}</span>
                    <span id="formConsignmentCode" class="badge bg-primary ms-2"></span>
                </h5>
            
            <div class="d-flex">
                {{-- <form method="POST" action="{{ route('consignment.export') }}" class="me-2">
                    @csrf
                    <button type="submit" class="btnclicky btn-sm text-sm btn btn-info px-3 d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet me-2" viewBox="0 0 16 16">
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z"/>
                        </svg>
                        <span>Export Shipments</span>
                    </button>
                </form> --}}
                <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-excel"></i> Import Consignment
                </button>
                
            </div>
        </div>
        <div class="card-body p-0">
            @include('cargo::adminLte.pages.consignments.editor.s-table')
        </div>
    </div>
<style>
.card {
    transition: all 0.2s ease;
    border-radius: 8px !important;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.btn {
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #4e73df, #224abe);
    border-color: #224abe;
}

.btn-success {
    background: linear-gradient(135deg, #1cc88a, #169a6f);
    border-color: #169a6f;
}

.badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
}
</style>

@include('cargo::adminLte.pages.consignments.editor.import-modal')

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
                { "orderable": false, "targets": 8 }
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
