<x-base-layout>

    <x-slot name="pageTitle">
        @lang('view.system_update')
    </x-slot>

    <!--begin::System Information-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <h3 class="card-title">System Information</h3>
        </div>
        <div class="card-body">
            <div class="row g-5">
                <!-- System Version -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-code-branch text-primary fs-2 me-3"></i>
                                <div>
                                    <h4 class="mb-1">Current Version</h4>
                                    <span class="text-muted">v1.0.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Last Update -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-clock text-success fs-2 me-3"></i>
                                <div>
                                    <h4 class="mb-1">Last Update</h4>
                                    <span class="text-muted">{{ date('Y-m-d H:i:s') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-server text-info fs-2 me-3"></i>
                                <div>
                                    <h4 class="mb-1">System Status</h4>
                                    <span class="badge badge-light-success">Running</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Updates -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-sync text-success fs-2 me-3"></i>
                                <div>
                                    <h4 class="mb-1">Available Updates</h4>
                                    <span class="badge badge-light-success">System is up to date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Information -->
            <div class="mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Company Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-5">
                            <i class="fas fa-building text-primary fs-2 me-3"></i>
                            <div>
                                <h4 class="mb-1">New World Cargo Limited</h4>
                                <p class="mb-0">Your trusted logistics partner</p>
                            </div>
                        </div>
                        <div class="row g-5">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-globe text-info fs-2 me-3"></i>
                                    <div>
                                        <h5 class="mb-1">Website</h5>
                                        <a href="https://www.newworldcargo.com" target="_blank" class="text-decoration-none">www.newworldcargo.com</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-envelope text-warning fs-2 me-3"></i>
                                    <div>
                                        <h5 class="mb-1">Contact</h5>
                                        <a href="https://www.newworldcargo.com/contact" target="_blank" class="text-decoration-none">Contact Us</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Section -->
            <div class="mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">System Update</h3>
                    </div>
                    <div class="card-body">
                        <div class="message message--info mb-5">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle text-info fs-2 me-3"></i>
                                <div>
                                    <h4 class="mb-1">System Status</h4>
                                    <p class="mb-0">Your system is currently running the latest version. No updates are available at this time.</p>
                                </div>
                            </div>
                        </div>

                        <form id="kt_form_1" method="POST" action="{{ route('system.update') }}">
                            @csrf
                            <button type="button" id="confirm" class="btn btn-primary" disabled>
                                <i class="fas fa-sync me-2"></i>Check for Updates
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::System Information-->

    <!-- Update Confirmation Modal -->
    <div class="modal fade" id="mi-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Update</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to proceed with the system update?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="modal-btn-no">Cancel</button>
                    <button type="button" class="btn btn-primary" id="modal-btn-yes">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        var modalConfirm = function(callback){
            $("#confirm").on("click", function(){
                $("#mi-modal").modal('show');
            });

            $("#modal-btn-yes").on("click", function(){
                callback(true);
                $("#mi-modal").modal('hide');
            });

            $("#modal-btn-no").on("click", function(){
                callback(false);
                $("#mi-modal").modal('hide');
            });
        };

        modalConfirm(function(confirm){
            if(confirm){
                $("#confirm").html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');
                $('#confirm').prop('disabled', true);
                $("#kt_form_1").submit();
            }
        });
    </script>
    @endsection
</x-base-layout>
