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
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.shipping_cost') }}</span>
                            <span class="text-muted font-weight-bolder font-size-lg">{{format_price($shipment->shipping_cost)}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.tax_duty') }}</span>
                            <span class="text-muted font-weight-bolder font-size-lg">{{format_price($shipment->tax)}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.insurance') }}</span>
                            <span class="text-muted font-weight-bolder font-size-lg">{{format_price($shipment->insurance)}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="mb-4 text-dark font-weight-bold">{{ __('cargo::view.return_cost') }}</span>
                            <span class="text-muted font-weight-bolder font-size-lg">{{format_price($shipment->return_cost)}}</span>
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
                                    <td class="text-right text-primary font-size-h3 font-weight-boldest">{{format_price($shipment->tax + $shipment->shipping_cost + $shipment->insurance) }}<br /><span class="text-muted font-weight-bolder font-size-lg">{{ __('cargo::view.included_tax_insurance') }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Toolbar -->
            <div class="fixed-bottom bg-dark text-white shadow-lg px-4 py-3" style="z-index: 1050;">
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
                        <button id="printBtn" onclick="printCardContent()" class="btn btn-primary font-weight-bold mr-2">
                            <span id="printBtnText">Print Invoice</span>
                            <span id="printSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>

                        <button class="btn btn-warning font-weight-bold text-dark mr-2" onclick="openMarkPaidModal({{ $shipment->id }})">
                            <i class="fas fa-check-circle mr-1"></i> Mark as Paid
                        </button>

                        @if($user_role == $admin || auth()->user()->can('edit-shipments'))
                            <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn btn-info font-weight-bold">
                                <i class="fas fa-pen"></i> {{ __('cargo::view.edit_shipment') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal for Confirm Payment -->
            <div class="modal fade" id="markPaidModal" tabindex="-1" role="dialog" aria-labelledby="markPaidLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="markPaidLabel">Confirm Payment</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this shipment as paid?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning font-weight-bold text-dark" id="confirmMarkPaidBtn">Yes, Mark as Paid</button>
                </div>
                </div>
            </div>
            </div>

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
    

    let selectedShipmentId = null;

    function openMarkPaidModal(shipmentId) {
        selectedShipmentId = shipmentId;
        $('#markPaidModal').modal('show');
    }

    document.getElementById('confirmMarkPaidBtn').addEventListener('click', function () {
        const url = `/api/mark-as-paid`; // Your API route

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ shipment_id: selectedShipmentId }),
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
