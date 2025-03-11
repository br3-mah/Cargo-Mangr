@php
    $user_role = auth()->user()->role;
    $admin  = 1;
    $branch = 3;
    $client = 4;
@endphp

@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    Customer Support
@endsection

@section('content')
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <!-- Left Column: Support Information -->
        <div class="col-xl-4">
            <!-- Company Info Card -->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Newworld Cargo - Global Network</h3>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        At Newworld Cargo, we take pride in our extensive global reach, ensuring your goods are delivered seamlessly across borders. Whether it's by air or sea, our reliable and professional shipping services make the world feel smaller for you.
                    </p>

                    <h5 class="font-weight-bold mt-5">Our Key Shipping Hubs</h5>

                    <div class="mt-4">
                        <h6 class="font-weight-bold">China</h6>
                        <p><strong>Cities Served:</strong> Guangzhou, Shenzhen, Yiwu, Shanghai</p>
                        <p><strong>Services:</strong> Air and sea freight, supplier payments, sourcing and verifying goods, warehousing, and full container loads.</p>
                    </div>

                    <div class="mt-4">
                        <h6 class="font-weight-bold">Dubai</h6>
                        <p><strong>Services:</strong> Air freight, product sourcing, goods verification, warehousing, and collection of goods from hotels for shipment.</p>
                    </div>

                    <div class="mt-4">
                        <h6 class="font-weight-bold">Zambia (Head Office)</h6>
                        <p><strong>Locations:</strong> Lusaka, Kitwe</p>
                        <p><strong>Services:</strong> Full logistics management, warehousing, local delivery, and distribution services.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Contact Information</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="symbol symbol-40 symbol-light-primary mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-placeholder text-primary"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="font-weight-bold">Lusaka Office</h5>
                            <span class="text-muted">Plot 12500, Carousel Shopping Center Shop 62/a</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40 symbol-light-primary mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-placeholder text-primary"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="font-weight-bold">Kitwe Office</h5>
                            <span class="text-muted">Plot 50 F.G.P PLaza, Shop 23 Kabengele Avenue</span>
                        </div>
                    </div>

                    <div class="separator separator-dashed my-7"></div>

                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40 symbol-light-info mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-phone text-info"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="tel:+260763313173" class="text-dark text-hover-primary font-weight-bold">+260 763 313 173</a>
                            <span class="text-muted">Call us for immediate assistance</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Support Tickets -->
        <div class="col-xl-8">
            <!-- Tickets Overview Card -->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Support Tickets</h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTicketModal">
                            <i class="flaticon2-plus"></i> Create New Ticket
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($user_role == $admin || $user_role == $branch)
                    <!-- Admin/Branch View - All Tickets -->
                    <div class="table-responsive">
                        <table class="table table-head-custom table-vertical-center" id="kt_support_tickets_table">
                            <thead>
                                <tr class="text-left">
                                    <th>ID</th>
                                    <th>Subject</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Demo Data - This would be dynamic in production -->
                                <tr>
                                    <td><span class="text-dark-75 font-weight-bold">#SUP-12345</span></td>
                                    <td>Delayed Shipment from China</td>
                                    <td>John Doe</td>
                                    <td><span class="label label-lg label-light-warning label-inline">In Progress</span></td>
                                    <td>2025-03-05</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light-primary btn-icon" title="View">
                                            <i class="flaticon-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="text-dark-75 font-weight-bold">#SUP-12344</span></td>
                                    <td>Missing Package Documentation</td>
                                    <td>Jane Smith</td>
                                    <td><span class="label label-lg label-light-success label-inline">Resolved</span></td>
                                    <td>2025-03-01</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light-primary btn-icon" title="View">
                                            <i class="flaticon-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="text-dark-75 font-weight-bold">#SUP-12343</span></td>
                                    <td>Customs Clearance Issue</td>
                                    <td>Robert Johnson</td>
                                    <td><span class="label label-lg label-light-danger label-inline">New</span></td>
                                    <td>2025-03-07</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light-primary btn-icon" title="View">
                                            <i class="flaticon-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                    <!-- Client View - Only Their Tickets -->
                        <div class="table-responsive">
                            <table class="table table-head-custom table-vertical-center" id="kt_my_support_tickets_table">
                                <thead>
                                    <tr class="text-left">
                                        <th>ID</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                    <tr>
                                        <td><span class="text-dark-75 font-weight-bold">#SUP-{{ $ticket->id }}</span></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>
                                            @if ($ticket?->status == 'open')
                                                <span class="label label-lg label-light-primary label-inline">Open</span>
                                            @elseif ($ticket?->status == 'in_progress')
                                                <span class="label label-lg label-light-warning label-inline">In Progress</span>
                                            @elseif ($ticket?->status == 'resolved')
                                                <span class="label label-lg label-light-success label-inline">Resolved</span>
                                            @else
                                                <span class="label label-lg label-light-danger label-inline">Closed</span>
                                            @endif
                                        </td>
                                        <td>{{ $ticket->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $ticket->updated_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-light-primary btn-icon" title="View">
                                                <i class="flaticon-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- FAQ Section Card -->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Frequently Asked Questions</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="accordion accordion-light accordion-toggle-arrow" id="faqAccordion">
                        <div class="card">
                            <div class="card-header" id="faqHeading1">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#faqCollapse1">
                                    What types of goods can Newworld Cargo ship?
                                </div>
                            </div>
                            <div id="faqCollapse1" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    We ship a wide variety of goods, including general goods, electronic items, furniture, clothing, and more. Please reach out for specific inquiries on any restricted items..
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="faqHeading2">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#faqCollapse2">
                                    How long does it take to ship goods by air?
                                </div>
                            </div>
                            <div id="faqCollapse2" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    For air cargo, the lead time for general goods is 7 to 14 days, while electronic goods take 14 to 21 days.                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="faqHeading3">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#faqCollapse3">
                                    How long does shipping take from Dubai to Zambia?
                                </div>
                            </div>
                            <div id="faqCollapse3" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    Shipping time from Dubai to Zambia typically takes 7-14 days for air freight, depending on customs clearance and local delivery requirements. Expedited services are available for urgent shipments at an additional cost.
                                </div>
                            </div>
                        </div>
                        <a target="_blank" class="link" href="{{ route('faq') }}">View More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating New Ticket -->
<div class="modal fade" id="createTicketModal" tabindex="-1" role="dialog" aria-labelledby="createTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="ticketSubmissionForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTicketModalLabel">Submit a Support Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ticketSubject" class="font-weight-bold">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ticketSubject" name="subject" required placeholder="Brief description of your issue">
                    </div>

                    <div class="form-group">
                        <label for="ticketCategory" class="font-weight-bold">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="ticketCategory" name="category" required>
                            <option value="">Select a category</option>
                            <option value="shipping">Shipping Issue</option>
                            <option value="tracking">Tracking Inquiry</option>
                            <option value="billing">Billing Question</option>
                            <option value="customs">Customs Clearance</option>
                            <option value="damage">Damaged Goods</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ticketPriority" class="font-weight-bold">Priority</label>
                        <select class="form-control" id="ticketPriority" name="priority">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="shipmentNumber" class="font-weight-bold">Related Shipment (if applicable)</label>
                        <input type="text" class="form-control" id="shipmentNumber" name="shipment_number" placeholder="Enter shipment tracking number">
                    </div>

                    <div class="form-group">
                        <label for="ticketMessage" class="font-weight-bold">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="ticketMessage" name="message" rows="5" required placeholder="Please describe your issue in detail"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="ticketAttachments" class="font-weight-bold">Attachments (Max 3 files)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="ticketAttachments" name="attachments[]" multiple>
                            <label class="custom-file-label" for="ticketAttachments">Choose files</label>
                            <span class="form-text text-muted">Supported formats: JPG, PNG, PDF. Max file size: 5MB each.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <span class="indicator-label">Submit Ticket</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("ticketSubmissionForm");

    form.addEventListener("submit", async function(event) {
        event.preventDefault();

        const submitButton = form.querySelector("button[type='submit']");
        const indicatorLabel = submitButton.querySelector(".indicator-label");
        const indicatorProgress = submitButton.querySelector(".indicator-progress");

        // Show loading state
        indicatorLabel.style.display = "none";
        indicatorProgress.style.display = "inline-block";

        let formData = new FormData(form);

        try {
            let response = await axios.post("{{ route('support.ticket.submit') }}", formData, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    "Content-Type": "multipart/form-data",
                },
            });

            if (response.status === 200) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Your support ticket has been submitted.",
                    confirmButtonText: "OK",
                });

                form.reset();
                $('#createTicketModal').modal('hide'); // Close modal
            }
        } catch (error) {
            console.error("Error submitting ticket:", error);

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Failed to submit the ticket. Please try again.",
            });
        } finally {
            indicatorLabel.style.display = "inline-block";
            indicatorProgress.style.display = "none";
        }
    });
});
</script>

@push('styles')
<style>
    .card-custom {
        box-shadow: 0px 0px 30px 0px rgba(82, 63, 105, 0.05);
        border: 0;
    }

    .card-custom .card-header {
        border-bottom: 1px solid #EBEDF3;
        min-height: 60px;
        padding: 0;
        background-color: transparent;
    }

    .card-custom .card-title {
        display: flex;
        align-items: center;
        margin: 0.75rem;
        margin-left: 2rem;
    }

    .label-light-warning {
        background-color: rgba(255, 184, 34, 0.1);
        color: #FFA800;
    }

    .label-light-success {
        background-color: rgba(27, 197, 189, 0.1);
        color: #1BC5BD;
    }

    .label-light-danger {
        background-color: rgba(246, 78, 96, 0.1);
        color: #F64E60;
    }

    .table th, .table td {
        vertical-align: middle;
        padding: 0.75rem;
    }

    .separator.separator-dashed {
        border-bottom: 1px dashed #EBEDF3;
    }
</style>
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize DataTables
        $('#kt_support_tickets_table, #kt_my_support_tickets_table').DataTable({
            responsive: true,
            order: [[4, 'desc']]
        });

        // Handle file input display
        $('.custom-file-input').on('change', function() {
            var fileCount = this.files.length;
            var label = fileCount > 0 ? fileCount + ' files selected' : 'Choose files';
            $(this).next('.custom-file-label').html(label);
        });

        // Form submission with loading indicator
        $('#ticketSubmissionForm').on('submit', function() {
            var btn = $(this).find('[type="submit"]');
            btn.attr('disabled', true);
            btn.find('.indicator-label').addClass('d-none');
            btn.find('.indicator-progress').removeClass('d-none');
            // Form will be submitted normally
        });
    });
</script>
@endpush
@endsection
