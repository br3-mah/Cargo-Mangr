@php
    use \Milon\Barcode\DNS1D;
    use Carbon\Carbon;
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
<!-- Add Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<style>
    .breadcrumb a {
      color: #ffc507;
      text-decoration: none;
    }

    .breadcrumb a:hover {
      text-decoration: underline;
    }
</style>

<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2 mb-0" style="font-size: 0.9rem; border-radius: 0.25rem;">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('consignment.index') }}">Consignments</a></li>
            <li class="breadcrumb-item"><a href="{{ route('consignment.show', $shipment->consignment_id) }}">Consignment Shipments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shipment - Invoice Details</li>
        </ol>
    </nav>
</div>
<div class="card shadow-lg rounded-lg overflow-hidden">
    <div class="p-0 card-body">
        @include('cargo::adminLte.pages.shipments._partials.payment-modal-message')
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-300 text-white px-8 py-6">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold">{{ __('cargo::view.shipment') }}: {{$shipment->code}}</h1>
                        @if($shipment->order_id != null)
                            <p class="mt-1 opacity-80">{{ __('cargo::view.order_id') }}: {{$shipment->order_id}}</p>
                        @endif
                    </div>
                    <div class="mt-4 md:mt-0 text-right">
                        @if($shipment->barcode != null)
                            <div class="mb-2 bg-white py-2 px-4 rounded-md inline-block"><?=$d->getBarcodeHTML($shipment->code, "C128");?></div>
                        @endif
                        <p class="text-sm font-medium"><span class="opacity-80">{{ __('cargo::view.from') }}:</span> {{$shipment->consignment?->source}}</p>
                        <p class="text-sm font-medium"><span class="opacity-80">{{ __('cargo::view.to') }}:</span> {{$shipment->consignment?->destination}}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-6 py-8">


            @include('cargo::adminLte.pages.shipments._partials.shipment-client-details')
            @include('cargo::adminLte.pages.shipments._partials.shipment-details')
            @include('cargo::adminLte.pages.shipments._partials.shipment-packages')
            <!-- Total Cost -->
            <div class="mt-8 bg-gradient-to-r from-yellow-50 rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">{{ __('cargo::view.total_cost') }}</h2>
                        {{-- <p class="text-sm text-gray-500">{{ __('cargo::view.included_tax_insurance') }}</p> --}}
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-bold text-blue-600">
                            K{{ number_format(convert_currency($shipment->amount_to_be_collected, 'usd', 'zmw'), 2) }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Bottom Toolbar -->
        <div class="fixed-bottom bg-white border-t border-gray-200 shadow-lg px-6 py-4" style="z-index: 1050;">
            <div class="container mx-auto">
                <div class="flex flex-wrap justify-between items-center">
                    <div>
                        @php
                            $INVOICE_PAYMENT = 'invoice_payment';
                            $cash_payment = 'cash_payment';
                        @endphp

                        @if ($user_role != $admin )
                            @if($shipment->paid == 0 && $shipment->payment_method_id != $cash_payment && $shipment->payment_method_id != $INVOICE_PAYMENT )
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" onclick="openCheckoutModal()">
                                    {{ __('cargo::view.pay_now') }} <i class="ml-1 fas fa-credit-card"></i>
                                </button>Packing (CTN)
                            @endif
                        @endif
                    </div>

                    <div class="flex items-center space-x-3">
                        @can('print-shipment-invoice')
                        <button id="printBtn2" onclick="printInvoice()" class="btnclicky inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-dark bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <i class="fas fa-print mr-1"></i>
                            <span id="printBtnText2">Print Invoice</span>
                            <span id="printSpinner2" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                        @endcan
                        @include('cargo::adminLte.pages.shipments._partials.print-invoice')


                        @if ($shipment->paid)
                            @can('print-shipment-receipt')
                                @include('cargo::adminLte.pages.shipments._partials.print-receipt')
                            @endcan
                            {{-- @can('refund-shipment-payment') --}}
                                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="openRefundModal({{ $shipment->id }})">
                                    <i class="fas fa-undo mr-1"></i> Refund Payment
                                </button>
                            {{-- @endcan --}}
                        @else
                            @can('confirm-shipment-payment')
                                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-700 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400" onclick="openMarkPaidModal({{ $shipment->id }})">
                                <i class="fas fa-check-circle mr-1"></i> Mark as Paid
                            </button>
                            @endcan
                        @endif

                        @if($user_role == $admin || auth()->user()->can('edit-shipments'))
                            <a href="{{ route('shipments.edit', $shipment->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-pen mr-1"></i> {{ __('cargo::view.edit_shipment') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Confirm Payment -->
@php
    $totalAmount = convert_currency($shipment->amount_to_be_collected, 'usd', 'zmw');
@endphp
<div class="modal fade" id="markPaidModal" tabindex="-1" role="dialog" aria-labelledby="markPaidLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden" style="background-color: #f8f9fa;">
            <!-- Header with dark blue gradient -->
            <div class="modal-header py-4" style="background: linear-gradient(45deg, #0a2463 0%, #1e3a8a 100%); border: none;">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FFD700" class="bi bi-credit-card-fill me-3" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1"/>
                    </svg>
                    <h5 class="modal-title fw-bold mb-0 text-white" id="markPaidLabel">Confirm Payment</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <form id="markPaidForm">
                    <!-- Alert with yellow accent -->
                    <div class="alert mb-4 border-0 shadow-sm" style="background-color: #fffbeb; border-left: 4px solid #FFD700;">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFD700" class="bi bi-info-circle-fill me-3" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                            </svg>
                            <p class="mb-0 fw-medium">Are you sure you want to mark this shipment as paid?</p>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4" style="background-color: white;">
                        <h6 class="mb-3 text-uppercase" style="color: #0a2463; font-size: 0.85rem; letter-spacing: 0.5px;">Discount Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discountType" class="form-label fw-medium mb-2" style="color: #475569; font-size: 0.9rem;">
                                        Discount Type
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0" style="background-color: #f8fafc; border-radius: 8px 0 0 8px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" viewBox="0 0 16 16">
                                                <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2h6.5a.5.5 0 0 1 0 1H18v6.5a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 0 1H17v6.5a.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5V16H.5a.5.5 0 0 1 0-1H1v-6.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 0-1H1V.5a.5.5 0 0 1 .5-.5H8v.5a.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5z"/>
                                            </svg>
                                        </span>
                                        <select class="form-select form-control-lg border-0" id="discountType" style="background-color: #f8fafc; border-radius: 0 8px 8px 0; height: 48px; font-size: 0.95rem;">
                                            <option value="">None</option>
                                            <option value="fixed">Fixed Amount</option>
                                            <option value="percent">Percentage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discountValue" class="form-label fw-medium mb-2" style="color: #475569; font-size: 0.9rem;">
                                        Discount Value
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0" style="background-color: #f8fafc; border-radius: 8px 0 0 8px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" viewBox="0 0 16 16">
                                                <path d="M1.5 2.5A1.5 1.5 0 0 1 3 1h10a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 13 5h-1a1.5 1.5 0 0 1 0 3h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 13 12H3a1.5 1.5 0 0 1-1.5-1.5v-1A1.5 1.5 0 0 1 3 8h1a1.5 1.5 0 0 1 0-3H3a1.5 1.5 0 0 1-1.5-1.5z"/>
                                            </svg>
                                        </span>
                                        <input type="number" class="form-control form-control-lg border-0" id="discountValue" value="0" min="0" style="background-color: #f8fafc; border-radius: 0 8px 8px 0; height: 48px; font-size: 0.95rem;">
                                        <span class="input-group-text border-0 d-none" id="percentSymbol" style="background-color: #f8fafc; border-radius: 0 8px 8px 0;">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary card with yellow accent -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 mt-4" style="background-color: white;">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Original Total:</span>
                            <span id="originalTotal" class="fw-medium">{{ number_format($totalAmount, 2) }}</span>
                        </div>
                        <hr style="opacity: 0.1;">
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold" style="color: #0a2463;">Final Total:</span>
                            <span id="finalTotal" class="fw-bold fs-5" style="color: #0a2463;">{{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer py-4" style="background-color: #f8f9fa; border-top: 1px solid rgba(0,0,0,0.05);">
                <button type="button" class="btn px-4 py-2" data-dismiss="modal" style="background-color: #e2e8f0; color: #64748b; border: none; border-radius: 8px; font-weight: 600;">
                    Cancel
                </button>
                <button type="button" class="btn px-4 py-2 d-flex align-items-center btnclicky" id="confirmMarkPaidBtn" style="background-color: #FFD700; color: #0a2463; border: none; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 5px rgba(255, 215, 0, 0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    <span>Confirm Payment</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden" style="background-color: #f8f9fa;">
            <!-- Header with red gradient -->
            <div class="modal-header py-4" style="background: linear-gradient(45deg, #dc2626 0%, #b91c1c 100%); border: none;">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" class="bi bi-arrow-counterclockwise me-3" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                    </svg>
                    <h5 class="modal-title fw-bold mb-0 text-white" id="refundLabel">Confirm Refund</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <form id="refundForm">
                    <!-- Alert with red accent -->
                    <div class="alert mb-4 border-0 shadow-sm" style="background-color: #fef2f2; border-left: 4px solid #dc2626;">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#dc2626" class="bi bi-exclamation-triangle-fill me-3" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            <p class="mb-0 fw-medium">Are you sure you want to refund this payment? This action cannot be undone.</p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4" style="background-color: white;">
                        <h6 class="mb-3 text-uppercase" style="color: #dc2626; font-size: 0.85rem; letter-spacing: 0.5px;">Refund Details</h6>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="refundReason" class="form-label fw-medium mb-2" style="color: #475569; font-size: 0.9rem;">
                                        Reason for Refund
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0" style="background-color: #f8fafc; border-radius: 8px 0 0 8px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#dc2626" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                            </svg>
                                        </span>
                                        <textarea class="form-control form-control-lg border-0" id="refundReason" rows="3" style="background-color: #f8fafc; border-radius: 0 8px 8px 0; font-size: 0.95rem;" placeholder="Enter reason for refund..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary card with red accent -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 mt-4" style="background-color: white;">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Original Payment Amount:</span>
                            <span class="fw-medium">{{ number_format($totalAmount, 2) }}</span>
                        </div>
                        <hr style="opacity: 0.1;">
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold" style="color: #dc2626;">Refund Amount:</span>
                            <span class="fw-bold fs-5" style="color: #dc2626;">{{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer py-4" style="background-color: #f8f9fa; border-top: 1px solid rgba(0,0,0,0.05);">
                <button type="button" class="btn px-4 py-2" data-dismiss="modal" style="background-color: #e2e8f0; color: #64748b; border: none; border-radius: 8px; font-weight: 600;">
                    Cancel
                </button>
                <button type="button" class="btn px-4 py-2 d-flex align-items-center btnclicky" id="confirmRefundBtn" style="background-color: #dc2626; color: white; border: none; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 5px rgba(220, 38, 38, 0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                    </svg>
                    <span>Confirm Refund</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add this script at the end of your document -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const discountTypeEl = document.getElementById('discountType');
        const discountValueEl = document.getElementById('discountValue');
        const originalTotalEl = document.getElementById('originalTotal');
        const finalTotalEl = document.getElementById('finalTotal');

        // Original total amount from PHP
        const originalTotal = {{ $totalAmount }};

        // Function to update final total based on discount
        function updateFinalTotal() {
            const discountType = discountTypeEl.value;
            const discountValue = parseFloat(discountValueEl.value) || 0;
            let finalTotal = originalTotal;

            if (discountType === 'fixed') {
                finalTotal = Math.max(0, originalTotal - discountValue);
            } else if (discountType === 'percent') {
                finalTotal = originalTotal * (1 - (discountValue / 100));
            }

            finalTotalEl.textContent = finalTotal.toFixed(2);
        }

        // Add event listeners
        discountTypeEl.addEventListener('change', updateFinalTotal);
        discountValueEl.addEventListener('input', updateFinalTotal);

        // Initialize
        updateFinalTotal();
    });
</script>
        @include('cargo::adminLte.pages.shipments._partials.cargo-payment-modal')
    </div>
</div>
@endsection
@include('cargo::adminLte.pages.shipments._partials.bottom-assets')
