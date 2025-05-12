
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
                    <button type="submit" class="btn btn-success btnclicky">
                        <i class="fas fa-upload"></i> Upload
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
