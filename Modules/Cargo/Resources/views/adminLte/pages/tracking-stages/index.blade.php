@extends('cargo::adminLte.layouts.master')
@section('pageTitle', 'Tracking Stages')
@section('content')

<!-- Add Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<div class="container-fluid">
    {{-- Sea Table section 1 --}}
    <div class="row" id="seaTableSection">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sea Cargo Tracking Stages</h3>
                    <div class="card-tools">
                        <a href="{{ route('tracking-stages.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Stage
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Table View -->
                    <div id="seaTableView" class="view-container">
                        <table class="table table-hover">
                            <thead class="sticky-top bg-white z-10">
                                <tr class="text-sm">
                                    <th><i class="bi bi-sort-numeric-down me-1"></i> Order</th>
                                    <th><i class="bi bi-tag me-1"></i> Name</th>
                                    <th><i class="bi bi-info-circle me-1"></i> Description</th>
                                    <th><i class="bi bi-check-circle me-1"></i> Status</th>
                                    <th><i class="bi bi-box me-1"></i> Cargo Type</th>
                                    <th><i class="bi bi-clock me-1"></i> Created</th>
                                    <th><i class="bi bi-gear me-1"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($seaStages as $stage)
                                <tr class="stage-row" data-search-text="{{ strtolower($stage->name . ' ' . $stage->description . ' ' . $stage->cargo_type) }}">
                                    <td>{{ $stage->order }}</td>
                                    <td>{{ $stage->name }}</td>
                                    <td>{{ $stage->description }}</td>
                                    <td>
                                        <span class="badge badge-{{ $stage->is_active ? 'success' : 'danger' }}">
                                            {{ $stage->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img width="24" src="{{ asset('icon/ship.svg') }}" alt="Sea Cargo" class="me-2">
                                            {{ $stage->cargo_type }}
                                        </div>
                                    </td>
                                    <td>{{ $stage->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('tracking-stages.edit', $stage) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tracking-stages.destroy', $stage) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this stage?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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

    {{-- Air Table section 2 --}}
    <div class="row mt-4" id="airTableSection">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Air Cargo Tracking Stages</h3>
                </div>
                <div class="card-body">
                    <!-- Table View -->
                    <div id="airTableView" class="view-container">
                        <table class="table table-hover">
                            <thead class="sticky-top bg-white z-10">
                                <tr class="text-sm">
                                    <th><i class="bi bi-sort-numeric-down me-1"></i> Order</th>
                                    <th><i class="bi bi-tag me-1"></i> Name</th>
                                    <th><i class="bi bi-info-circle me-1"></i> Description</th>
                                    <th><i class="bi bi-check-circle me-1"></i> Status</th>
                                    <th><i class="bi bi-box me-1"></i> Cargo Type</th>
                                    <th><i class="bi bi-clock me-1"></i> Created</th>
                                    <th><i class="bi bi-gear me-1"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($airStages as $stage)
                                <tr class="stage-row" data-search-text="{{ strtolower($stage->name . ' ' . $stage->description . ' ' . $stage->cargo_type) }}">
                                    <td>{{ $stage->order }}</td>
                                    <td>{{ $stage->name }}</td>
                                    <td>{{ $stage->description }}</td>
                                    <td>
                                        <span class="badge badge-{{ $stage->is_active ? 'success' : 'danger' }}">
                                            {{ $stage->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img width="24" src="{{ asset('icon/plane.svg') }}" alt="Air Cargo" class="me-2">
                                            {{ $stage->cargo_type }}
                                        </div>
                                    </td>
                                    <td>{{ $stage->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('tracking-stages.edit', $stage) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tracking-stages.destroy', $stage) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this stage?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize table toggles
    const seaTableToggle = document.getElementById('seaTableToggle');
    const airTableToggle = document.getElementById('airTableToggle');
    const seaTableSection = document.getElementById('seaTableSection');
    const airTableSection = document.getElementById('airTableSection');

    // Function to update table visibility
    function updateTableVisibility() {
        if (seaTableSection) {
            seaTableSection.style.display = seaTableToggle.checked ? 'flex' : 'none';
        }
        if (airTableSection) {
            airTableSection.style.display = airTableToggle.checked ? 'flex' : 'none';
        }
    }

    // Add event listeners for toggles if they exist
    if (seaTableToggle) {
        seaTableToggle.addEventListener('change', updateTableVisibility);
    }
    if (airTableToggle) {
        airTableToggle.addEventListener('change', updateTableVisibility);
    }
});

function switchView(type, viewType) {
    // Get all view containers for the type
    const tableView = document.getElementById(type + 'TableView');
    const listView = document.getElementById(type + 'ListView');
    const gridView = document.getElementById(type + 'GridView');

    // Get all view buttons for the type
    const tableBtn = document.getElementById(type + 'TableViewBtn');
    const listBtn = document.getElementById(type + 'ListViewBtn');
    const gridBtn = document.getElementById(type + 'GridViewBtn');

    // Check if elements exist before proceeding
    if (!tableView || !listView || !gridView || !tableBtn || !listBtn || !gridBtn) {
        console.warn(`Some elements for ${type} ${viewType} view are missing`);
        return;
    }

    // Hide all views
    tableView.style.display = 'none';
    listView.style.display = 'none';
    gridView.style.display = 'none';

    // Remove active class from all buttons
    tableBtn.classList.remove('active');
    listBtn.classList.remove('active');
    gridBtn.classList.remove('active');

    // Show selected view and activate button
    switch(viewType) {
        case 'table':
            tableView.style.display = 'block';
            tableBtn.classList.add('active');
            break;
        case 'list':
            listView.style.display = 'block';
            listBtn.classList.add('active');
            break;
        case 'grid':
            gridView.style.display = 'block';
            gridBtn.classList.add('active');
            break;
    }

    // Apply current search filter if search input exists
    const searchInput = document.getElementById(type + 'Search');
    if (searchInput && searchInput.value.trim() !== '') {
        filterStages(type);
    }
}

function filterStages(type) {
    const searchInput = document.getElementById(type + 'Search');
    if (!searchInput) return;

    const searchTerm = searchInput.value.toLowerCase();
    
    // Get all elements to filter
    const elements = {
        table: document.querySelectorAll('#' + type + 'TableView .stage-row'),
        list: document.querySelectorAll('#' + type + 'ListView .stage-item'),
        grid: document.querySelectorAll('#' + type + 'GridView .stage-card')
    };

    // Filter each type of element
    Object.keys(elements).forEach(viewType => {
        elements[viewType].forEach(element => {
            const searchText = element.getAttribute('data-search-text');
            if (searchText && searchText.includes(searchTerm)) {
                element.style.display = '';
            } else {
                element.style.display = 'none';
            }
        });
    });

    // Update no results message
    updateNoResultsMessage(type);
}

function clearSearch(type) {
    const searchInput = document.getElementById(type + 'Search');
    if (searchInput) {
        searchInput.value = '';
        filterStages(type);
    }
}

function updateNoResultsMessage(type) {
    const searchInput = document.getElementById(type + 'Search');
    if (!searchInput) return;

    const searchTerm = searchInput.value.toLowerCase();
    if (searchTerm.trim() === '') {
        // Remove existing no results messages
        const existingMessages = document.querySelectorAll('#' + type + 'TableView .no-results-message, #' + type + 'ListView .no-results-message, #' + type + 'GridView .no-results-message');
        existingMessages.forEach(msg => msg.remove());
        return;
    }

    // Get visible elements
    const visibleElements = {
        table: document.querySelectorAll('#' + type + 'TableView .stage-row:not([style*="display: none"])'),
        list: document.querySelectorAll('#' + type + 'ListView .stage-item:not([style*="display: none"])'),
        grid: document.querySelectorAll('#' + type + 'GridView .stage-card:not([style*="display: none"])')
    };

    // Check if any elements are visible
    const hasVisibleResults = Object.values(visibleElements).some(elements => elements.length > 0);

    // Remove existing no results messages
    const existingMessages = document.querySelectorAll('#' + type + 'TableView .no-results-message, #' + type + 'ListView .no-results-message, #' + type + 'GridView .no-results-message');
    existingMessages.forEach(msg => msg.remove());

    if (!hasVisibleResults) {
        // Get active view
        const activeView = document.querySelector('#' + type + 'TableView:not([style*="display: none"]), #' + type + 'ListView:not([style*="display: none"]), #' + type + 'GridView:not([style*="display: none"])');
        
        if (activeView) {
            const noResultsDiv = document.createElement('div');
            noResultsDiv.className = 'no-results-message text-center py-5';
            noResultsDiv.innerHTML = `
                <div class="text-muted">
                    <i class="bi bi-search fs-1 mb-3"></i>
                    <h5>No stages found</h5>
                    <p>Try adjusting your search terms or clear the search to see all stages.</p>
                </div>
            `;
            activeView.appendChild(noResultsDiv);
        }
    }
}
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

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-input:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
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
@endpush

@endsection 