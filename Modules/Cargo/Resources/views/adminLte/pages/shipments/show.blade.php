@php
    use \Milon\Barcode\DNS1D;
    $d = new DNS1D();
    $user_role = auth()->user()->role;
    $admin  = 1;

@endphp

@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    {{ __('cargo::view.shipment').'-'. $shipment->code }}
@endsection

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="p-0 card-body">
         <!-- begin: Invoice -->
            @if(session('message'))
            <!-- Modal -->
            <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="messageModalLabel">Notification</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ session('message') }}
                            <img width="100" src="https://img.freepik.com/premium-vector/vector-drawing-hand-with-mobile-phone-phone-contains-numbers-entering-pin-code-owner-data-confirmation_531064-125.jpg?w=360">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Script to open modal -->
            <script>
                // Open the modal when the page loads
                window.onload = function() {
                    $('#messageModal').modal('show');
                };
            </script>
            @endif


            <!-- begin: Invoice header-->
            <div class="px-8 py-8 row justify-content-center pt-md-27 px-md-0">
                <div class="col-md-10">
                    <div class="pb-10 d-flex justify-content-between pb-md-20 flex-column flex-md-row">
                        <div class="px-0 d-flex flex-column align-items-md-start">
                            <span class="d-flex flex-column align-items-md-start">
                                <h1 class="mb-10 display-4 font-weight-boldest">{{ __('cargo::view.shipment') }}: {{$shipment->code}}</h1>
                                @if($shipment->order_id != null)
                                    <span><span class="font-weight-bolder opacity-70">{{ __('cargo::view.order_id') }}:</span> {{$shipment->order_id}}</span>
                                @endif
                            </span>
                        </div>
                        <div class="px-0 d-flex flex-column align-items-md-end">
                            <span class="d-flex flex-column align-items-md-end opacity-70">
                                @if($shipment->barcode != null)
                                    <span class="mb-5 font-weight-bolder"><?=$d->getBarcodeHTML($shipment->code, "C128");?></span>
                                @endif
                                <span><span class="font-weight-bolder">{{ __('cargo::view.from') }}:</span> {{$shipment->consignment->source}}</span>
                                <span><span class="font-weight-bolder">{{ __('cargo::view.to') }}:</span> {{$shipment->consignment->destination}}</span>
                            </span>
                        </div>
                    </div>

                    <div class="pb-6 d-flex justify-content-between">
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.client_sender') }}</span>
                            @if($user_role == $admin || auth()->user()->can('show-clients') )
                                <a class="text-danger font-weight-boldest font-size-lg" href="{{route('clients.show',$shipment->client_id)}}">{{$shipment->client->name ?? 'Null'}}</a>
                            @else
                                <span class="text-danger font-weight-boldest font-size-lg">{{$shipment->client->name ?? 'Null'}}</span>
                            @endif
                            <span class="text-muted font-size-md">{{$shipment->client_phone}}</span>
                            <span class="text-muted font-size-md">{{$shipment->from_address ? $shipment->from_address->address : ''}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.status') }}</span>
                            <span class="opacity-70 d-block">{{$shipment->getStatus()}}</span>
                        </div>

                        @if (isset($shipment->amount_to_be_collected))
                            <div class="d-flex flex-column flex-root">
                                <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.amount_to_be_collected') }}</span>
                                <span class="text-muted font-weight-bolder font-size-lg">{{format_price($shipment->amount_to_be_collected)}}</span>
                            </div>
                        @endif
                    </div>
                    <div class="border-bottom w-100"></div>
                    <div class="pt-6 d-flex justify-content-between">
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-2 font-weight-bolder">{{ __('cargo::view.shipment_type') }}</span>
                            <span class="opacity-70">{{$shipment->type}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-2 font-weight-bolder">{{ __('cargo::view.current_branch') }}</span>
                            @if($user_role == $admin || auth()->user()->can('show-branches') )
                                <a class="opacity-70" href="{{route('branches.show', $shipment->branch_id ?? 1)}}">{{$shipment->branch->name ?? 'Null'}}</a>
                            @else
                                <span class="text-danger font-weight-boldest font-size-lg">{{$shipment->branch->name ?? 'Null'}}</span>
                            @endif
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-2 font-weight-bolder">{{ __('cargo::view.created_date') }}</span>
                            <span class="opacity-70">{{$shipment->created_at->toFormattedDateString()}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-2 font-weight-bolder">{{ __('cargo::view.shipping_date') }}</span>
                            <span class="opacity-70">
                                @if(strpos($shipment->shipping_date, '/' ))
                                    {{ Carbon\Carbon::createFromFormat('d/m/Y', $shipment->shipping_date)->format('F j, Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($shipment->shipping_date)->format('F j, Y') }}
                                @endif
                            </span>
                        </div>
                    </div>


                    <div class="pt-6 d-flex justify-content-between">
                        @if ($shipment->prev_branch)
                            <div class="d-flex flex-column flex-root">
                                <span class="mb-2 font-weight-bolder">{{ __('cargo::view.previous_branch') }}</span>
                                <span class="opacity-70">{{Modules\Cargo\Entities\Branch::find($shipment->prev_branch)->name ?? 'Null'}}</span>
                            </div>
                        @endif
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.total_weight') }}</span>
                            <span class="text-muted font-weight-bolder font-size-lg">{{$shipment->total_weight}} {{ __('cargo::view.KG') }}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.amount_to_be_collected') }}</span>
                            <span class="text-muted font-weight-bolder font-size-lg">{{format_price($shipment->amount_to_be_collected)}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.tax_duty') }}</span>
                            <span class="text-muted font-weight-bolder font-size-lg">{{format_price($shipment->tax)}}</span>
                        </div>
                    </div>

                    @if(count($shipment->getMedia('attachments')) > 0)
                        <div class="pt-6 d-flex justify-content-between">
                            <div class="d-flex flex-column flex-root">
                                <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.attachments') }} <span class="text-muted font-size-xs">({{ __('cargo::view.ADDED_WHEN_SHIPMENT_CREATED') }} )</span></span>
                                <div class="pt-6 d-flex justify-content-between">
                                    @foreach($shipment->getMedia('attachments') as $img)
                                        <div class="d-flex flex-column flex-root ml-1">
                                            <span class="text-muted font-weight-bolder font-size-lg">
                                                <a href="{{$img->getUrl()}}" target="_blank"><img src="{{$img->getUrl()}}" alt="image" style="max-width:100px;max-height:60px" /></a>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="px-8 py-8 row justify-content-center py-md-10 px-md-0">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pl-0 font-weight-bold text-muted text-uppercase">{{ __('cargo::view.package_items') }}</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Packing (CTN)</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">{{ __('cargo::view.type') }}</th>
                                    {{-- <th class="pr-0 text-right font-weight-bold text-muted text-uppercase">{{ __('cargo::view.weigh_length_width_height') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                                @foreach(Modules\Cargo\Entities\PackageShipment::where('shipment_id',$shipment->id)->get() as $package)

                                    <tr class="font-weight-boldest">
                                        <td class="pl-0 border-0 pt-7 d-flex align-items-center">{{$package->description}}</td>
                                        <td class="text-right align-middle pt-7">{{$package->qty}}</td>
                                        <td class="text-right align-middle pt-7">@if(isset($package->package->name)){{json_decode($package->package->name, true)[app()->getLocale()]}} @else - @endif</td>
                                        {{-- <td class="pr-0 text-right align-middle text-primary pt-7">{{$package->weight." ". __('cargo::view.KG')." x ".$package->length." ". __('cargo::view.CM') ." x ".$package->width." ".__('cargo::view.CM')." x ".$package->height." ".__('cargo::view.CM')}}</td> --}}
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="px-8 py-8 mx-0 bg-gray-100 row justify-content-center py-md-10 px-md-0">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">{{ __('cargo::view.total_cost') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="font-weight-bolder">
                                    <td class="text-right text-primary font-size-h2 text-2xl font-weight-boldest">
                                        {{-- {{format_price($shipment->tax + $shipment->shipping_cost + $shipment->insurance) }} --}}
                                        {{format_price($shipment->amount_to_be_collected + $shipment->tax + $shipment->shipping_cost + $shipment->insurance) }}
                                        <br />
                                        <span class="text-muted font-weight-bolder font-size-lg">
                                            {{ __('cargo::view.included_tax_insurance') }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Toolbar -->
            <div class="fixed-bottom bg-primary rounded-top rounded text-white shadow-xl px-4 py-3" style="z-index: 1050;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @php
                            $INVOICE_PAYMENT = 'invoice_payment';
                            $cash_payment = 'cash_payment';
                        @endphp

                        @if ($user_role != $admin )
                            @if($shipment->paid == 0 && $shipment->payment_method_id != $cash_payment && $shipment->payment_method_id != $INVOICE_PAYMENT )
                                <button type="button" class="btn btn-warning font-weight-bold mr-2" onclick="openCheckoutModal()">
                                    {{ __('cargo::view.pay_now') }} <i class="ml-1 fas fa-credit-card"></i>
                                </button>
                            @endif
                        @endif
                    </div>

                    <div class="ml-auto d-flex align-items-center">
                        <button id="printBtn2" onclick="printCardContent()" class="btn btn-primary font-weight-bold mr-2">
                            <i class="fas fa-print mr-1"></i>
                            <span id="printBtnText2">Print Invoice</span>
                            <span id="printSpinner2" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>

                        @if ($shipment->paid)
                            @include('cargo::adminLte.pages.shipments._partials.print-receipt')
                        @else
                            <button class="btn btn-warning font-weight-bold text-dark mr-2" onclick="openMarkPaidModal({{ $shipment->id }})">
                                <i class="fas fa-check-circle mr-1"></i> Mark as Paid
                            </button>
                        @endif

                        @if($user_role == $admin || auth()->user()->can('edit-shipments'))
                            <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn btn-info font-weight-bold">
                                <i class="fas fa-pen"></i> {{ __('cargo::view.edit_shipment') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal for Confirm Payment -->
            @php
                $totalAmount = $shipment->amount_to_be_collected;
            @endphp

            <div class="modal fade" id="markPaidModal" tabindex="-1" role="dialog" aria-labelledby="markPaidLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden">
                    <div class="modal-header bg-gradient-primary text-white py-3">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-credit-card-fill me-2" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1"/>
                            </svg>
                            <h5 class="modal-title fw-bold mb-0" id="markPaidLabel">Confirm Payment</h5>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <form id="markPaidForm">
                            <div class="alert alert-info d-flex align-items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-info-circle-fill me-2" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                                </svg>
                                <p class="mb-0">Are you sure you want to mark this shipment as paid?</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="discountType" class="form-label fw-medium">Discount Type</label>
                                        <select class="form-select form-control-lg shadow-sm border" id="discountType">
                                            <option value="">None</option>
                                            <option value="fixed">Fixed</option>
                                            <option value="percent">Percentage</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="discountValue" class="form-label fw-medium">Discount Value</label>
                                        <input type="number" class="form-control form-control-lg shadow-sm border" id="discountValue" value="0" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="card bg-light border-0 shadow-sm rounded-3 p-3 mt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Original Total:</span>
                                    <span id="originalTotal" class="fw-medium">{{ number_format($totalAmount, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Final Total:</span>
                                    <span id="finalTotal" class="fw-bold text-primary fs-5">{{ number_format($totalAmount, 2) }}</span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer bg-light py-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">
                            <span>Cancel</span>
                        </button>
                        <button type="button" class="btn btn-success px-4 d-flex align-items-center" id="confirmMarkPaidBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <span>Confirm Payment</span>
                        </button>
                    </div>
                </div>
            </div>
            </div>

            <style>
                .bg-gradient-primary {
                    background: linear-gradient(135deg, #4e73df, #224abe);
                }
                .modal-content {
                    border-radius: 12px;
                }

                .form-control, .form-select {
                    border-radius: 8px;
                    padding: 0.6rem 1rem;
                }

                .form-control:focus, .form-select:focus {
                    border-color: #4e73df;
                    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
                }
                .btn {
                    border-radius: 8px;
                    padding: 0.6rem 1.25rem;
                    font-weight: 500;
                    transition: all 0.2s ease;
                }
                .btn:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                }
                .btn-success {
                    background: linear-gradient(135deg, #1cc88a, #169a6f);
                    border-color: #169a6f;
                }
                .alert {
                    border-radius: 8px;
                }
            </style>
            @include('cargo::adminLte.pages.shipments._partials.cargo-payment-modal')

        </div>
    </div>

    @if(!empty($shipment->shipmentReasons->toArray()))
        <div class="card card-custom card-stretch-half gutter-b">
            <!--begin::List Widget 19-->

            <!--begin::Header-->
            <div class="pt-6 mb-2 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-3 card-label font-weight-bold font-size-h4 text-dark-75">{{ __('cargo::view.shipment_return_reasons_log') }}</span>

                </h3>
                <div class="card-toolbar">

                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="pt-2 card-body" style="overflow:hidden">
                <div class="mt-3 timeline timeline-6 scroll scroll-pull" style="overflow:hidden" data-scroll="true" data-wheel-propagation="true">

                @forelse($shipment->shipmentReasons as $key => $shipmentReason)
                    <!--begin::Item-->
                    <div class="timeline-item align-items-start">
                        <!--begin::Label-->
                        <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">{{$shipmentReason->created_at->diffForHumans()}}</div>
                        <!--end::Label-->

                        <!--begin::Badge-->
                        <div class="timeline-badge">
                            <i class="fa fa-genderless text-warning icon-xl" style="margin-right: 4px;"></i>
                        </div>
                        <!--end::Badge-->

                        <!--begin::Text-->
                        <div class="pl-3 font-weight-mormal font-size-lg timeline-content text-muted">
                            {{ __('cargo::view.reason').' '.($key+1) }}: "{{$shipmentReason->reason->name}}"
                        </div>
                        <!--end::Text-->

                    </div>
                    <!--end::Item-->
                @empty

                @endforelse


                </div>
            </div>
        </div>
    @endif

    <!--end::List Widget 19-->
    @if(($user_role == $admin || auth()->user()->can('shipments-log')) && !empty($shipment->logs->toArray()))
        <div class="card card-custom card-stretch-half gutter-b">
            <!--begin::List Widget 19-->

            <!--begin::Header-->
            <div class="pt-6 mb-2 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-3 card-label font-weight-bold font-size-h4 text-dark-75">{{ __('cargo::view.shipment_status_log') }}</span>

                </h3>
                <div class="card-toolbar">

                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="pt-2 card-body" style="overflow:hidden">
                <div class="mt-3 timeline timeline-6 scroll scroll-pull" style="overflow:hidden" data-scroll="true" data-wheel-propagation="true">

                @foreach($shipment->logs()->orderBy('id','desc')->get() as $log)
                    <!--begin::Item-->
                    <div class="timeline-item align-items-start">
                        <!--begin::Label-->
                        <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">{{$log->created_at->diffForHumans()}}</div>
                        <!--end::Label-->

                        <!--begin::Badge-->
                        <div class="timeline-badge">
                            <i class="fa fa-genderless text-warning icon-xl" style="margin-right: 4px;"></i>
                        </div>
                        <!--end::Badge-->

                        <!--begin::Text-->
                        <div class="pl-3 font-weight-mormal font-size-lg timeline-content text-muted">
                            {{ __('cargo::view.changed_from') }}: "{{Modules\Cargo\Entities\Shipment::getStatusByStatusId($log->from)}}" {{ __('cargo::view.to') }}: "{{Modules\Cargo\Entities\Shipment::getStatusByStatusId($log->to)}}"
                        </div>
                        <!--end::Text-->

                    </div>
                    <!--end::Item-->

                @endforeach


                </div>
            </div>
        </div>
    @endif

@endsection

{{-- Inject styles --}}
@section('styles')
    <style>
        .timeline .timeline-content {
            width: auto;
        }
        .timeline-label{
            margin-right: 6px;
            padding-right: 6px;
            border-right: solid 3px #eff2f5;
        }
        .timeline-label:before{
            width: unset;
        }
    </style>
@endsection

{{-- Inject Scripts --}}
@section('scripts')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            AIZ.plugins.notify('success', "{{ __('cargo::view.payment_link_copied') }}");
        }
    </script>
    <script>
        function printCardContent() {
            const card = document.querySelector('.card.card-custom.gutter-b');
            if (!card) return;

            // Clone the card to avoid modifying the original
            const clone = card.cloneNode(true);

            // Remove buttons inside elements with class 'd-flex justify-content-between'
            const buttonContainers = clone.querySelectorAll('.d-flex.justify-content-between');
            buttonContainers.forEach(container => {
                const buttons = container.querySelectorAll('button');
                const anchors = container.querySelectorAll('a');
                buttons.forEach(btn => btn.remove());
                anchors.forEach(a => a.remove());
            });

            // Open a new window for printing
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print</title>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                            }
                            img {
                                max-width: 100%;
                            }
                            .footer {
                                margin-top: 30px;
                                padding-top: 20px;
                                border-top: 1px solid #ddd;
                                text-align: center;
                                font-size: 14px;
                                color: #555;
                            }
                            .footer-title {
                                font-weight: bold;
                                margin-bottom: 10px;
                                color: #333;
                            }
                            .contact-item {
                                margin-bottom: 8px;
                            }
                            .contact-value {
                                font-weight: bold;
                                color: #222;
                            }
                        </style>
                    </head>
                    <body>
                        ${clone.innerHTML}

                        <div class="footer">
                            <div class="footer-title">New World Cargo</div>
                            <div class="contact-item">
                                Phone: <span class="contact-value">+260 763 297 287</span>
                            </div>
                            <div class="contact-item">
                                Address: <span class="contact-value">Shop 62/A Carousel Shopping Centre, Lusaka, Zambia</span>
                            </div>
                            <div class="contact-item">
                                Email: <span class="contact-value">info@newworldcargo.com</span>
                            </div>
                        </div>
                    </body>
                </html>
            `);
            printWindow.document.close();

            // Wait for content to load before printing
            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            };
        }
    </script>
<script>
    let selectedShipmentId = null;
    const originalTotal = parseFloat({{ $totalAmount }});
    const discountTypeEl = document.getElementById('discountType');
    const discountValueEl = document.getElementById('discountValue');
    const finalTotalEl = document.getElementById('finalTotal');

    function openMarkPaidModal(shipmentId) {
        selectedShipmentId = shipmentId;
        document.getElementById('discountType').value = '';
        document.getElementById('discountValue').value = 0;
        finalTotalEl.textContent = originalTotal.toFixed(2);
        $('#markPaidModal').modal('show');
    }

    function computeFinalTotal() {
        const type = discountTypeEl.value;
        const discountVal = parseFloat(discountValueEl.value) || 0;
        let finalTotal = originalTotal;

        if (type === 'fixed') {
            finalTotal = originalTotal - discountVal;
        } else if (type === 'percent') {
            finalTotal = originalTotal - (originalTotal * (discountVal / 100));
        }

        if (finalTotal < 0) finalTotal = 0;

        finalTotalEl.textContent = finalTotal.toFixed(2);
    }

    discountTypeEl.addEventListener('change', computeFinalTotal);
    discountValueEl.addEventListener('input', computeFinalTotal);

    document.getElementById('confirmMarkPaidBtn').addEventListener('click', function () {
        const url = `/api/mark-as-paid`;

        const discountType = discountTypeEl.value;
        const discountValue = parseFloat(discountValueEl.value) || 0;
        const finalTotal = parseFloat(finalTotalEl.textContent);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                shipment_id: selectedShipmentId,
                discount_type: discountType,
                discount_value: discountValue,
                final_total: finalTotal,
            }),
        })
        .then(response => response.json())
        .then(data => {
            $('#markPaidModal').modal('hide');
            alert('Marked as Paid successfully!');
            window.location.reload();
        })
        .catch(error => {
            console.error(error);
            alert('Failed to mark as paid.');
        });
    });
</script>

@endsection
