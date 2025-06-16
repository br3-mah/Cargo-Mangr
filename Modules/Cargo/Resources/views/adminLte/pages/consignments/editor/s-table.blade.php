<div class="w-full">
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row">
        <div id="column3" class="col-md-12 px-6">
            @if ($consignment->Mawb_num )
            <p class="text-muted text-sm">Mawb Number: {{ $consignment->Mawb_num }}</p>
            @endif
            @if ($consignment->voyage_no )
            <p class="text-muted text-sm">Vessel / Voyage No : {{ $consignment->voyage_no }}</p>
            @endif
            @if ($consignment->container_no )
            <p class="text-muted text-sm">Container No: {{ $consignment->container_no }}</p>
            @endif
            @if ($consignment->cargo_type == 'sea')
                <div class="items-center d-flex space-x-2">
                    <p class="text-sm text-gray-500">ETA DAR</p>
                    <p class="font-medium">
                        {{ $consignment->eta_dar ?? 'Not placed' }}
                    </p>
                </div>
                <div class="items-center d-flex space-x-2">
                    <p class="text-sm text-gray-500">ETA LUN</p>
                    <p class="font-medium">
                        {{ $consignment->eta_lun ?? 'Not placed' }}
                    </p>
                </div>
                @if ($consignment->destination)
                <div class="items-center d-flex space-x-2">
                    <p class="text-sm text-gray-500">Destination Port</p>
                    <p class="font-medium">
                        {{ $consignment->destination }}
                    </p>
                </div>  
                @endif
                <div>
                    <img width="80" src="{{ asset('icon/ship.svg') }}" alt="">
                </div>
            @else
                <div class="items-center d-flex space-x-2">
                    <p class="text-sm text-gray-500">Expected time of arrival:</p>
                    <p class="font-medium">
                        {{ Carbon::parse($consignment->eta)->format('l, F j, Y') ?? 'Not placed' }}
                    </p>
                </div>
                <div>
                    <img width="80" src="{{ asset('icon/plane.svg') }}" alt="">
                </div>
            @endif

            <!-- View Toggle Toolbar and Search -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="flex-grow-1 me-3">
                    <div class="input-group" style="max-width: 400px;">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="shipmentSearch" placeholder="Search shipments..." onkeyup="filterShipments()">
                        <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
                <div class="btn-group" role="group" aria-label="View Toggle">
                    <button type="button" class="btn btn-outline-primary active" id="tableViewBtn" onclick="switchView('table')">
                        <i class="bi bi-table me-1"></i>Table
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="listViewBtn" onclick="switchView('list')">
                        <i class="bi bi-list-ul me-1"></i>List
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="gridViewBtn" onclick="switchView('grid')">
                        <i class="bi bi-grid-3x3-gap me-1"></i>Grid
                    </button>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="view-container">
                <table id="shipmentTable" class="table table-hover">
                    <thead class="sticky-top bg-white z-10">
                        <tr class="text-sm">
                            <th><i class="bi bi-upc-scan me-1"></i> Hawb No.</th>
                            <th><i class="bi bi-box me-1"></i>Salesman</th>
                            <th><i class="bi bi-cube me-1"></i>Volume</th>
                            <th><i class="bi bi-person me-1"></i> Client</th>
                            <th><i class="bi bi-file me-1"></i> Package Description</th>
                            <th><i class="bi bi-telephone me-1"></i> Client Phone</th>
                            <th><i class="bi bi-currency-dollar me-1"></i> Cost</th>
                            <th><i class="bi bi-cash-coin me-1"></i> Payment</th>
                            <th><i class="bi bi-clock-history me-1"></i> Created On</th>
                            <th><i class="bi bi-gear me-1"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consignment->shipments as $shipment)
                            <tr id="shipment_row_{{ $shipment->id }}" class="shipment-row" data-search-text="{{ strtolower($shipment->code . ' ' . $shipment->client->name . ' ' . $shipment->salesman . ' ' . ($shipment->client_phone ?? '')) }}">
                                <td>
                                    <span class="badge bg-info rounded-pill">{{ $shipment->code }}</span>
                                </td>
                                <td>{{ $shipment->salesman ?? 'No Salesman' }}</td>
                                <td>{{ $shipment->volume ?? 'No Volume' }}</td>
                                <td>{{ $shipment->client->name  }}</td>
                                <td>
                                    @foreach (Modules\Cargo\Entities\PackageShipment::where('shipment_id', $shipment->id)->get() as $package)
                                        {{ $package->description }}
                                    @endforeach
                                </td>
                                <td>{{ $shipment->client_phone ?? 'No phone' }}</td>
                                <td>
                                    <span class="text-dark text-md font-weight-bold">
                                        K{{ number_format(convert_currency($shipment->amount_to_be_collected, 'usd', 'zmw'), 2) }}
                                    </span>
                                    <span class="text-warning text-sm">(${{ $shipment->amount_to_be_collected }})</span>
                                </td>
                                <td>
                                    @if ($shipment->paid)
                                        <span class="badge bg-success rounded-pill">PAID</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">UNPAID</span>
                                    @endif
                                </td>
                                <td>{{ $shipment->created_at->toFormattedDateString() }}</td>
                                <td class="action-buttons">
                                    @can('view-shipment-invoices')
                                    <a href="{{ url('admin/shipments/shipments/' . $shipment->id) }}"
                                        class="btn btn-icon btn-light text-info btn-lg rounded me-2"
                                        title="View Shipment Invoice">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                                            <path
                                                d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z" />
                                            <path
                                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5" />
                                        </svg>
                                    </a>
                                    @endcan

                                    @can('delete-shipment-invoices')
                                    <button class="btn btn-icon btn-light text-danger rounded"
                                        data-shipment-id="{{ $shipment->id }}" data-bs-toggle="tooltip"
                                        title="Remove Shipment">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-folder-minus" viewBox="0 0 16 16">
                                            <path
                                                d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z" />
                                            <path d="M11 11.5a.5.5 0 0 1 .5-.5h4a.5.5 0 1 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                        </svg>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- List View -->
            <div id="listView" class="view-container" style="display: none;">
                <div class="list-group">
                    @foreach ($consignment->shipments as $shipment)
                        <div class="list-group-item list-group-item-action p-3 mb-2 border rounded shipment-item" 
                             id="shipment_list_{{ $shipment->id }}"
                             data-search-text="{{ strtolower($shipment->code . ' ' . $shipment->client->name . ' ' . $shipment->salesman . ' ' . ($shipment->client_phone ?? '')) }}">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mb-1">
                                                <span class="badge bg-info rounded-pill me-2">{{ $shipment->code }}</span>
                                                {{ $shipment->client->name }}
                                            </h6>
                                            <p class="mb-1 text-muted small">
                                                <i class="bi bi-person me-1"></i>{{ $shipment->salesman }} | 
                                                <i class="bi bi-building me-1"></i>Lusaka
                                            </p>
                                            <p class="mb-1 text-muted small">
                                                <i class="bi bi-telephone me-1"></i>{{ $shipment->client_phone ?? 'No phone' }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-end">
                                                <div class="mb-2">
                                                    <span class="text-dark fw-bold">
                                                        K{{ number_format(convert_currency($shipment->amount_to_be_collected, 'usd', 'zmw'), 2) }}
                                                    </span>
                                                    <span class="text-warning small">(${{ $shipment->amount_to_be_collected }})</span>
                                                </div>
                                                <div class="mb-2">
                                                    @if ($shipment->paid)
                                                        <span class="badge bg-success rounded-pill">PAID</span>
                                                    @else
                                                        <span class="badge bg-secondary rounded-pill">UNPAID</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $shipment->created_at->toFormattedDateString() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="bi bi-file me-1"></i>
                                            @foreach (Modules\Cargo\Entities\PackageShipment::where('shipment_id', $shipment->id)->get() as $package)
                                                {{ $package->description }}
                                            @endforeach
                                        </small>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="d-flex flex-column gap-2">
                                        @can('view-shipment-invoices')
                                        <a href="{{ url('admin/shipments/shipments/' . $shipment->id) }}"
                                            class="btn btn-light text-info btn-sm"
                                            title="View Shipment Invoice">
                                            <i class="bi bi-receipt"></i>
                                        </a>
                                        @endcan
                                        @can('delete-shipment-invoices')
                                        <button class="btn btn-light text-danger btn-sm"
                                            data-shipment-id="{{ $shipment->id }}" data-bs-toggle="tooltip"
                                            title="Remove Shipment">
                                            <i class="bi bi-folder-minus"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Grid View -->
            <div id="gridView" class="view-container" style="display: none;">
                <div class="row">
                    @foreach ($consignment->shipments as $shipment)
                        <div class="col-lg-4 col-md-6 mb-4 shipment-card" 
                             id="shipment_grid_{{ $shipment->id }}"
                             data-search-text="{{ strtolower($shipment->code . ' ' . $shipment->client->name . ' ' . $shipment->salesman . ' ' . ($shipment->client_phone ?? '')) }}">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info rounded-pill">{{ $shipment->code }}</span>
                                    @if ($shipment->paid)
                                        <span class="badge bg-success rounded-pill">PAID</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">UNPAID</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">{{ $shipment->client->name }}</h6>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i>{{ $shipment->salesman }}
                                        </small>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="bi bi-building me-1"></i>Lusaka
                                        </small>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="bi bi-telephone me-1"></i>{{ $shipment->client_phone ?? 'No phone' }}
                                        </small>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="bi bi-file me-1"></i>
                                            @foreach (Modules\Cargo\Entities\PackageShipment::where('shipment_id', $shipment->id)->get() as $package)
                                                {{ $package->description }}
                                            @endforeach
                                        </small>
                                    </div>
                                    <div class="text-center mb-3">
                                        <div class="fw-bold text-dark">
                                            K{{ number_format(convert_currency($shipment->amount_to_be_collected, 'usd', 'zmw'), 2) }}
                                        </div>
                                        <small class="text-warning">(${{ $shipment->amount_to_be_collected }})</small>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $shipment->created_at->toFormattedDateString() }}</small>
                                        <div class="btn-group btn-group-sm">
                                            @can('view-shipment-invoices')
                                            <a href="{{ url('admin/shipments/shipments/' . $shipment->id) }}"
                                                class="btn btn-outline-info"
                                                title="View Shipment Invoice">
                                                <i class="bi bi-receipt"></i>
                                            </a>
                                            @endcan
                                            @can('delete-shipment-invoices')
                                            <button class="btn btn-outline-danger"
                                                data-shipment-id="{{ $shipment->id }}" data-bs-toggle="tooltip"
                                                title="Remove Shipment">
                                                <i class="bi bi-folder-minus"></i>
                                            </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchView(viewType) {
            // Hide all views
            document.getElementById('tableView').style.display = 'none';
            document.getElementById('listView').style.display = 'none';
            document.getElementById('gridView').style.display = 'none';
            
            // Remove active class from all buttons
            document.getElementById('tableViewBtn').classList.remove('active');
            document.getElementById('listViewBtn').classList.remove('active');
            document.getElementById('gridViewBtn').classList.remove('active');
            
            // Show selected view and activate button
            switch(viewType) {
                case 'table':
                    document.getElementById('tableView').style.display = 'block';
                    document.getElementById('tableViewBtn').classList.add('active');
                    break;
                case 'list':
                    document.getElementById('listView').style.display = 'block';
                    document.getElementById('listViewBtn').classList.add('active');
                    break;
                case 'grid':
                    document.getElementById('gridView').style.display = 'block';
                    document.getElementById('gridViewBtn').classList.add('active');
                    break;
            }
            
            // Apply current search filter to new view
            const searchTerm = document.getElementById('shipmentSearch').value;
            if (searchTerm.trim() !== '') {
                filterShipments();
            }
        }

        function filterShipments() {
            const searchTerm = document.getElementById('shipmentSearch').value.toLowerCase();
            
            // Filter table rows
            const tableRows = document.querySelectorAll('.shipment-row');
            tableRows.forEach(row => {
                const searchText = row.getAttribute('data-search-text');
                if (searchText.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Filter list items
            const listItems = document.querySelectorAll('.shipment-item');
            listItems.forEach(item => {
                const searchText = item.getAttribute('data-search-text');
                if (searchText.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Filter grid cards
            const gridCards = document.querySelectorAll('.shipment-card');
            gridCards.forEach(card => {
                const searchText = card.getAttribute('data-search-text');
                if (searchText.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            updateNoResultsMessage();
        }

        function clearSearch() {
            document.getElementById('shipmentSearch').value = '';
            filterShipments();
        }

        function updateNoResultsMessage() {
            const searchTerm = document.getElementById('shipmentSearch').value.toLowerCase();
            if (searchTerm.trim() === '') {
                // Remove any existing no results messages
                const existingMessages = document.querySelectorAll('.no-results-message');
                existingMessages.forEach(msg => msg.remove());
                return;
            }

            // Check if any items are visible
            const visibleRows = document.querySelectorAll('.shipment-row:not([style*="display: none"])');
            const visibleItems = document.querySelectorAll('.shipment-item:not([style*="display: none"])');
            const visibleCards = document.querySelectorAll('.shipment-card:not([style*="display: none"])');
            
            const hasVisibleResults = visibleRows.length > 0 || visibleItems.length > 0 || visibleCards.length > 0;
            
            // Remove existing no results messages
            const existingMessages = document.querySelectorAll('.no-results-message');
            existingMessages.forEach(msg => msg.remove());
            
            if (!hasVisibleResults) {
                // Add no results message to the active view
                const activeView = document.querySelector('.view-container:not([style*="display: none"])');
                if (activeView) {
                    const noResultsDiv = document.createElement('div');
                    noResultsDiv.className = 'no-results-message text-center py-5';
                    noResultsDiv.innerHTML = `
                        <div class="text-muted">
                            <i class="bi bi-search fs-1 mb-3"></i>
                            <h5>No shipments found</h5>
                            <p>Try adjusting your search terms or clear the search to see all shipments.</p>
                        </div>
                    `;
                    activeView.appendChild(noResultsDiv);
                }
            }
        }

        // Initialize search functionality when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('shipmentSearch');
            searchInput.addEventListener('input', filterShipments);
        });
    </script>

    <style>
        .view-container {
            transition: all 0.3s ease-in-out;
        }
        
        .btn-group .btn {
            transition: all 0.2s ease;
        }
        
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        }
        
        .list-group-item {
            transition: all 0.2s ease;
        }
        
        .list-group-item:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn-group {
                width: 100%;
            }
            
            .btn-group .btn {
                flex: 1;
            }
            
            .input-group {
                max-width: 100% !important;
            }
        }
    </style>
</div>