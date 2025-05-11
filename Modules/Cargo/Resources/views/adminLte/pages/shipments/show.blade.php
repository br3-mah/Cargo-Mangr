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

        <!-- Invoice Header -->
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
                        <p class="text-sm font-medium"><span class="opacity-80">{{ __('cargo::view.from') }}:</span> {{$shipment->consignment->source}}</p>
                        <p class="text-sm font-medium"><span class="opacity-80">{{ __('cargo::view.to') }}:</span> {{$shipment->consignment->destination}}</p>
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
                            {{-- + $shipment->tax + $shipment->shipping_cost + $shipment->insurance --}}
                            {{format_price($shipment->amount_to_be_collected) }}
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
                        <button id="printBtn2" onclick="printInvoice()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-print mr-1"></i>
                            <span id="printBtnText2">Print Invoice</span>
                            <span id="printSpinner2" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>

                        @include('cargo::adminLte.pages.shipments._partials.print-invoice')
                        @if ($shipment->paid)
                            @include('cargo::adminLte.pages.shipments._partials.print-receipt')
                        @else
                            <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-700 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400" onclick="openMarkPaidModal({{ $shipment->id }})">
                                <i class="fas fa-check-circle mr-1"></i> Mark as Paid
                            </button>
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
            $totalAmount = $shipment->amount_to_be_collected;
        @endphp
        <div class="modal fade" id="markPaidModal" tabindex="-1" role="dialog" aria-labelledby="markPaidLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden">
                <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3">
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
        @include('cargo::adminLte.pages.shipments._partials.cargo-payment-modal')
    </div>
</div>
@endsection
@include('cargo::adminLte.pages.shipments._partials.bottom-assets')
