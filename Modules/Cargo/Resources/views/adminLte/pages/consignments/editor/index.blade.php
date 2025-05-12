
<style>
    .modal-xl {
        max-width: 1400px;
    }

    .shipments-grid {
        max-height: 500px;
        overflow-y: auto;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }

    .current-shipment-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .current-shipment-item:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .current-shipment-badge {
        background-color: #28a745;
        color: white;
        padding: 3px 8px;
        border-radius: 3px;
        margin-left: 10px;
        font-size: 0.75rem;
    }

    .shipment-details {
        display: flex;
        flex-direction: column;
    }

    .shipment-info {
        margin-top: 5px;
        color: #6c757d;
    }

    .column-toggle-btn {
        margin-left: 10px;
        background-color: transparent;
        border: none;
        color: #010212;
    }

    .column-toggle-btn:hover {
        color: #6c757d;
    }

    .search-results {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 10px;
        margin-top: 15px;
    }

    .selected-shipments {
        max-height: 300px;
        overflow-y: auto;
    }

    #searchShipment {
        border-radius: 20px;
        padding: 10px 15px;
    }

    .custom-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        user-select: none;
    }

    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 4px;
    }

    .custom-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    .custom-checkbox input:checked ~ .checkmark {
        background-color: #010212;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .custom-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    .custom-checkbox .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }
    .modal-header{
        background-color: #ff9900;
        border-radius: 2%;
    }
</style>
<div class="modal fade" id="consignmentModal" tabindex="-1" aria-labelledby="consignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consignmentModalLabel">
                    <span class="fw-bold font-bold"><b>Consignment Code: </b></span>
                    <span id="formConsignmentCode" class="text-white ms-2"></span>
                </h5>
                <div style="margin-left: -20px;" class="items-center flex d-flex">
                    <img src="http://localhost:8000/assets/lte/cargo-logo.svg" width="60" alt="">
                </div>
                <div class="modal-header-actions">
                    <button type="button" class="column-toggle-btn" data-toggle="column1" title="Toggle Search">
                        <i class="fas fa-search"></i>
                    </button>
                    <button type="button" class="column-toggle-btn" data-toggle="column2" title="Toggle Selected Shipments">
                        <i class="fas fa-list-alt"></i>
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="column1" class="col-md-4" style="display: none;">
                        <div class="form-group">
                            {{-- <label>Consignment ID</label> --}}
                            <input type="hidden" disabled id="modalConsignmentId" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <h6 class="text-muted"><b>Search Shipments:</b></h6>
                            <input type="text" id="searchShipment" class="form-control"
                                placeholder="Search shipment by code..."
                                onkeyup="searchShipment()">
                        </div>

                        <div id="shipmentResults" class="search-results mt-3"></div>
                    </div>
                    <div id="column2" class="col-md-4" style="display: none;">
                        <h6 class="text-muted"><b>Selected Shipments:</b></h6>
                        <ul id="selectedShipments" class="list-group selected-shipments"></ul>
                    </div>
                    <div id="column3" class="col-md-12">
                        <h6 class="text-muted"><b>Current Saved Shipments</b></h6>
                        <div id="currentShipmentsList" class="shipments-grid"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="submitShipmentsForm" method="POST" action="{{ route('submit.shipments') }}">
                    @csrf
                    <input type="hidden" id="formConsignmentId" name="consignment_id">
                    <input type="hidden" id="selectedShipmentIds" name="shipment_id[]" value="[]">
                    <button type="submit" class="btnclicky btn btn-primary" style="background-color: #010212">Save Changes</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Previous JavaScript remains the same, with minor modifications to accommodate the new UI

    // Column toggle functionality
    document.querySelectorAll('.column-toggle-btn').forEach(button => {
        button.addEventListener('click', function() {
            const columnId = this.getAttribute('data-toggle');
            const column = document.getElementById(columnId);
            const column3 = document.getElementById('column3');

            if (column.style.display === 'none') {
                column.style.display = 'block';
                column3.classList.remove('col-md-12');
                column3.classList.add('col-md-8');
                this.classList.add('active');
            } else {
                column.style.display = 'none';
                column3.classList.remove('col-md-8');
                column3.classList.add('col-md-12');
                this.classList.remove('active');
            }
        });
    });
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
    removeCurrentShipment(shipmentId);$consignment
    // if (confirm("Are you sure you want to remove this shipment?")) {
    // }
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
