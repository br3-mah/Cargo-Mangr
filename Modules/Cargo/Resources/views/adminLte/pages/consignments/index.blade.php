@extends('cargo::adminLte.layouts.master')

@section('pageTitle', 'Consignments')

@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Dropzone CSS for file upload styling -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

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

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-responsive table-bordered">
                        <thead class="thead-muted">
                            <tr>
                                <th>Code</th>
                                <th>Job No.</th>
                                <th>Mawb No.</th>
                                <th>Name</th>
                                <th>Source</th>
                                <th>Destination</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consignments as $consignment)
                                <tr>
                                    <td>{{ $consignment->consignment_code }}</td>                                  
                                    <td>{{ $consignment->Job_num }}</td>
                                    <td>{{ $consignment->Mawb_num }}</td>
                                    <td>{{ $consignment->name }}</td>
                                    <td>{{ $consignment->source }}</td>
                                    <td>{{ $consignment->destination }}</td>
                                    <td>
                                        <span class="badge badge-{{ $consignment->status == 'delivered' ? 'success' : ($consignment->status == 'in_transit' ? 'info' : 'warning') }}">
                                            {{ ucfirst($consignment->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('consignment.edit', $consignment->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('consignment.destroy', $consignment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        <a class="btn btn-sm btn-info" href="{{ route('consignment.show', $consignment->id) }}">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
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
                    
                    <form id="importForm" action="{{ route('consignment.import') }}" method="POST" enctype="multipart/form-data" class="dropzone">
                        @csrf
                        <div class="fallback">
                            <input name="excel_file" type="file" />
                        </div>
                    </form>
                    
                    <div id="importStatus" class="mt-3 d-none">
                        <div class="progress">
                            <div id="importProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="uploadBtn" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload & Process
                    </button>
                </div>
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
                { "orderable": false, "targets": 7 }
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
</script>
@endsection