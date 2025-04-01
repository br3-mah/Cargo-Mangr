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
                    <div id="column1" class="col-md-4">
                        <div class="form-group">
                            <label>Consignment ID</label>
                            <input type="text" disabled id="modalConsignmentId" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Search Shipments</label>
                            <input type="text" id="searchShipment" class="form-control"
                                placeholder="Search shipment by code..."
                                onkeyup="searchShipment()">
                        </div>

                        <div id="shipmentResults" class="shipment-results mt-3"></div>
                    </div>
                    <div id="column2" class="col-md-4">
                        <h6>Selected Shipments:</h6>
                        <ul id="selectedShipments" class="list-group selected-shipments"></ul>
                    </div>
                    <div id="column2" class="col-md-4">
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
                <button class="btn btn-danger btn-sm" onclick="confirmRemoveShipment(${shipment.id})">
                    Remove
                </button>
            </div>
        `).join('');

        currentShipmentsList.innerHTML = html;
    }

    function confirmRemoveShipment(shipmentId) {
        if (confirm("Are you sure you want to remove this shipment?")) {
            removeCurrentShipment(shipmentId);
        }
    }

    function removeCurrentShipment(shipmentId) {
        fetch(`/api/shipments/${shipmentId}/remove`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove shipment from UI and update the list
                currentShipments = currentShipments.filter(s => s.id !== shipmentId);
                renderCurrentShipments();
            } else {
                alert("Failed to remove shipment.");
            }
        })
        .catch(error => console.error('Error:', error));
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