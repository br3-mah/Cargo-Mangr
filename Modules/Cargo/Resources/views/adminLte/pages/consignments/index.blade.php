@extends('cargo::adminLte.layouts.master')

@section('pageTitle', 'Consignments')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- Dropzone CSS for file upload styling -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .card-header {
        background-color: #fff;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 2px;
        border-radius: 4px;
    }

    .badge {
        padding: 6px 10px;
        font-weight: 500;
    }

    .badge-delivered {
        background-color: #10B981;
    }

    .badge-in_transit {
        background-color: #3B82F6;
    }

    .badge-pending {
        background-color: #F59E0B;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group-actions {
        white-space: nowrap;
    }

    .tooltip-inner {
        max-width: 200px;
        padding: 4px 8px;
        color: #fff;
        text-align: center;
        background-color: #000;
        border-radius: 4px;
    }
</style>
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="m-0">Consignments</h2>
                <div>
                    <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#importModal">
                        <i class="fas fa-file-excel"></i> Import Consignments
                    </button>
                    <a href="{{ route('consignment.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Consignment
                    </a>
                </div>
            </div>

            @include('cargo::adminLte.components.flashes.success')
            @include('cargo::adminLte.components.flashes.error')
            @include('cargo::adminLte.components.flashes.warning')

            @if (!empty($consignments))
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>CODE</th>
                            <th>JOB NO.</th>
                            <th>MAWB NO.</th>
                            <th>CONSIGNEE</th>
                            <th>SOURCE</th>
                            <th>DESTINATION</th>
                            <th>UPDATED</th>
                            <th>STATUS</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consignments as $consignment)
                        <tr>
                            <td>{{ $consignment->consignment_code }}</td>
                            <td>{{ $consignment->Job_num }}</td>
                            <td>{{ $consignment->Mawb_num ?? 'Unspecified' }}</td>
                            <td>{{ $consignment->name }}</td>
                            <td>{{ $consignment->source ?? 'China' }}</td>
                            <td>{{ $consignment->destination ?? 'Zambia' }}</td>
                            <td>{{ $consignment->updated_at->toFormattedDateString() }}</td>
                            <td>
                                <span
                                    class="badge badge-{{ $consignment->status == 'delivered' ? 'success' : ($consignment->status == 'in_transit' ? 'info' : 'warning') }}">
                                    {{ ucfirst($consignment->status) }}
                                </span>
                            </td>
                            <td class="text-center btn-group-actions">
                                <a href="{{ route('consignment.edit', $consignment->id) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('consignment.destroy', $consignment->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a class="btn btn-sm btn-light"
                                    href="{{ route('consignment.show', $consignment->id) }}">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-primary update-tracker-btn"
                                    data-id="{{ $consignment->id }}" data-checkpoint="{{ $consignment->checkpoint }}"
                                    data-toggle="modal" data-target="#updateTrackerModal">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Update Tracker Modal -->
<div class="modal fade" id="updateTrackerModal" tabindex="-1" role="dialog" aria-labelledby="updateTrackerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="updateTrackerModalLabel">Update Consignment Tracker</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateTrackerForm" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <!-- Laravel requires PATCH for updates -->

                    <!-- Hidden field for consignment_id -->
                    <input type="hidden" name="consignment_id" id="consignmentId">

                    <div class="form-group">
                        <label for="trackerStatus">Status</label>
                        <select class="form-control" name="status" id="trackerStatus" required>
                            <option value="1">Parcel received and is being processed</option>
                            <option value="2">Parcel dispatched from China</option>
                            <option value="3">Parcel has arrived at the transit Airport</option>
                            <option value="4">Parcel has departed from the Transit Airport to Lusaka Airport</option>
                            <option value="5">Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress
                            </option>
                            <option value="6">Parcel is now ready for collection in Lusaka at the Main Branch</option>
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


<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-excel mr-2"></i>Import Consignments
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-cloud-upload-alt fa-3x text-success"></i>
                    </div>
                    <h6>Upload your Excel file containing consignment data</h6>
                    <p class="text-muted small">Supported formats: .xlsx, .xls, .csv</p>
                </div>

                <form id="importForm2" action="{{ route('consignment.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="fallback">
                        <input name="excel_file" type="file" />
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload & Process
                    </button>
                </form>

                <div id="importStatus" class="mt-3 d-none">
                    <div class="progress">
                        <div id="importProgressBar"
                            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                            role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted" id="importProgressText">Processing...</small>
                </div>

                <div class="mt-3">
                    <p class="text-muted mb-1"><small><i class="fas fa-info-circle"></i> Need a template?</small></p>
                    <a href="#" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-download"></i> Download Template
                    </a>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="uploadBtn" class="btn btn-success">
                    <i class="fas fa-upload"></i> Upload & Process
                </button>
            </div> --}}
        </div>
    </div>
</div>

@include('cargo::adminLte.pages.consignments.editor.index')

@endsection

<!-- Scripts -->
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
    $(document).ready(function () {
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

        // Initialize Dropzone
        Dropzone.autoDiscover = false;

        let myDropzone = new Dropzone("#importForm", {
            url: "{{ route('consignment.import') }}",
            maxFilesize: 10, // MB
            maxFiles: 1,
            acceptedFiles: ".xlsx,.xls,.csv",
            autoProcessQueue: false,
            dictDefaultMessage: `<div class="text-center p-4">
                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-muted"></i>
                <h6>Drag and drop your Excel file here</h6>
                <span class="btn btn-sm btn-light mt-2">or click to browse</span>
            </div>`,
            dictFileTooBig: "File is too big). Max filesize: 1500MB.",
            dictInvalidFileType: "Invalid file type. Please upload Excel or CSV files only.",
            addRemoveLinks: true,
            dictRemoveFile: "Remove file",
        });

        // Upload button click handler
        $("#uploadBtn").click(function() {
            if (myDropzone.getQueuedFiles().length > 0) {
                // Show progress bar and start processing
                $("#importStatus").removeClass("d-none");
                simulateProgress();
                myDropzone.processQueue();

            } else {
                alert("Please select a file to upload");
            }
        });

        // File added handler
        myDropzone.on("addedfile", function(file) {
            console.log("File added: " + file.name);
        });

        // Success handler
        myDropzone.on("success", function(file, response) {
            console.log("Upload successful");
            $("#importProgressBar").css("width", "100%").attr("aria-valuenow", 100);
            $("#importProgressText").text("Upload complete! Refreshing...");

            setTimeout(function() {
                window.location.reload();
            }, 1500);
        });

        // Error handler
        myDropzone.on("error", function(file, errorMessage) {
            console.error("Upload error:", errorMessage);
            $("#importProgressBar").addClass("bg-danger").removeClass("bg-success");
            $("#importProgressText").text("Error: " + errorMessage);
        });

        // Function to simulate progress while processing
        function simulateProgress() {
            let progress = 0;
            const interval = setInterval(function() {
                progress += Math.floor(Math.random() * 15);
                if (progress > 90) {
                    clearInterval(interval);
                    return;
                }
                $("#importProgressBar").css("width", progress + "%").attr("aria-valuenow", progress);
                $("#importProgressText").text("Processing... " + progress + "%");
            }, 600);
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".update-tracker-btn").forEach(button => {
        button.addEventListener("click", function () {
            let consignmentId = this.dataset.id; // Get the consignment ID
            let checkpoint = this.dataset.checkpoint; // Get the current checkpoint

            // Set the correct form action dynamically
            let form = document.getElementById("updateTrackerForm");
            form.action = `/consignment/tracker/update/${consignmentId}`;

            // Set the tracker status in the dropdown
            document.getElementById("trackerStatus").value = checkpoint;

            // Add hidden input field for consignmentId if needed
            let consignmentInput = document.getElementById("consignmentId");
            if (!consignmentInput) {
                consignmentInput = document.createElement("input");
                consignmentInput.type = "hidden";
                consignmentInput.name = "consignment_id";
                consignmentInput.id = "consignmentId";
                form.appendChild(consignmentInput);
            }
            consignmentInput.value = consignmentId;
        });
    });
});


</script>
@endsection