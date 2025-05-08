@extends('cargo::adminLte.layouts.master')

@section('pageTitle', 'Consignments')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- Dropzone CSS for file upload styling -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

<div class="">
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
        @include('cargo::adminLte.pages.consignments.editor.table')
    @endif
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

@include('cargo::adminLte.pages.consignments.editor.import-modal')
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
