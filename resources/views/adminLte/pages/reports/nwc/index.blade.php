@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    NWC Reports
@endsection

@section('content')
    @php
        $filters = array_merge([
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'cashier' => null,
            'method' => null,
            'cargo_type' => null,
            'hawb_number' => null,
            'date' => null,
            'bill_order' => null,
        ], $filters ?? []);

        $availableFilters = $availableFilters ?? [
            'methods' => [],
            'cashiers' => [],
            'cargo_types' => [],
            'hawb_numbers' => [],
        ];

        $exportQuery = array_filter([
            'start_date' => $filters['start_date'],
            'end_date' => $filters['end_date'],
            'cashier' => $filters['cashier'],
            'method' => $filters['method'],
            'cargo_type' => $filters['cargo_type'],
            'hawb_number' => $filters['hawb_number'],
            'date' => $filters['date'],
            'bill_order' => $filters['bill_order'],
        ], fn ($value) => $value !== null && $value !== '');
    @endphp
    <div class="container-fluid">
        

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif



        <div class="row g-2 mb-4">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="card border-0 shadow-sm h-100 rounded-2xl" style="border-radius: 1rem; background: linear-gradient(135deg, #f7c600 0%, #f7c600 100%);">
                    <div class="card-body text-white p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 opacity-75 small fw-semibold">Total Transactions</p>
                                <h5 class="fw-bold mb-0">{{ number_format($summary['total_rows'] ?? 0) }}</h5>
                            </div>
                            <div class="opacity-75">
                                <i class="fas fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, #f7c600 0%, #f7c600 100%);">
                    <div class="card-body text-white p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 opacity-75 small fw-semibold">Total Bill (USD)</p>
                                <h5 class="fw-bold mb-0">${{ number_format($summary['total_bill_usd'] ?? 0, 2) }}</h5>
                            </div>
                            <div class="opacity-75">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, #f7c600 0%, #f7c600 100%);">
                    <div class="card-body text-white p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 opacity-75 small fw-semibold">Total Bill (ZMW)</p>
                                <h5 class="fw-bold mb-0">K{{ number_format($summary['total_bill_kwacha'] ?? 0, 2) }}</h5>
                            </div>
                            <div class="opacity-75">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, #f7c600 0%, #f7c600 100%);">
                    <div class="card-body text-white p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 opacity-75 small fw-semibold">Average Rate</p>
                                <h5 class="fw-bold mb-0">{{ number_format($summary['average_rate'] ?? 0, 4) }}</h5>
                            </div>
                            <div class="opacity-75">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, #f7c600 0%, #f7c600 100%);">
                    <div class="card-body text-white p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 opacity-75 small fw-semibold">SEA Receipts</p>
                                <h5 class="fw-bold mb-0">{{ number_format($summary['total_sea_receipts'] ?? 0) }}</h5>
                            </div>
                            <div class="opacity-75">
                                <i class="fas fa-ship"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, #f7c600 0%, #f7c600 100%);">
                    <div class="card-body text-white p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1 opacity-75 small fw-semibold">AIR Receipts</p>
                                <h5 class="fw-bold mb-0">{{ number_format($summary['total_air_receipts'] ?? 0) }}</h5>
                            </div>
                            <div class="opacity-75">
                                <i class="fas fa-plane"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-filter text-primary me-2"></i>
                            <h6 class="card-title mb-0 fw-bold text-dark">Filter Reports</h6>
                        </div>
                        <form class="row g-2 g-md-3 align-items-end" method="GET" action="{{ route('reports.nwc.index') }}">
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <label for="start_date" class="form-label fw-semibold text-muted small">Start Date</label>
                                <input type="date"
                                       id="start_date"
                                       name="start_date"
                                       value="{{ $filters['start_date'] }}"
                                       class="form-control form-control-sm border-0 bg-light">
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <label for="end_date" class="form-label fw-semibold text-muted small">End Date</label>
                                <input type="date"
                                       id="end_date"
                                       name="end_date"
                                       value="{{ $filters['end_date'] }}"
                                       class="form-control form-control-sm border-0 bg-light">
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <label for="date" class="form-label fw-semibold text-muted small">Transaction Date</label>
                                <input type="date"
                                       id="date"
                                       name="date"
                                       value="{{ $filters['date'] }}"
                                       class="form-control form-control-sm border-0 bg-light">
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <label for="bill_order" class="form-label fw-semibold text-muted small">Bill Order</label>
                                <select id="bill_order" name="bill_order" class="form-select form-select-sm border-0 bg-light">
                                    <option value="">Default</option>
                                    <option value="bill_usd_asc" @selected($filters['bill_order'] === 'bill_usd_asc')>USD: Low to High</option>
                                    <option value="bill_usd_desc" @selected($filters['bill_order'] === 'bill_usd_desc')>USD: High to Low</option>
                                    <option value="bill_kwacha_asc" @selected($filters['bill_order'] === 'bill_kwacha_asc')>ZMW: Low to High</option>
                                    <option value="bill_kwacha_desc" @selected($filters['bill_order'] === 'bill_kwacha_desc')>ZMW: High to Low</option>
                                </select>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <label for="cashier" class="form-label fw-semibold text-muted small">Cashier</label>
                                <select id="cashier" name="cashier" class="form-select form-select-sm border-0 bg-light">
                                    <option value="">All Cashiers</option>
                                    @foreach($availableFilters['cashiers'] as $cashier)
                                        <option value="{{ $cashier }}" @selected($filters['cashier'] === $cashier)>{{ $cashier }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <label for="method" class="form-label fw-semibold text-muted small">Payment Method</label>
                                <select id="method" name="method" class="form-select form-select-sm border-0 bg-light">
                                    <option value="">All Methods</option>
                                    @foreach($availableFilters['methods'] as $methodOption)
                                        <option value="{{ $methodOption['value'] }}" @selected($filters['method'] === $methodOption['value'])>
                                            {{ $methodOption['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <label for="cargo_type" class="form-label fw-semibold text-muted small">Cargo Type</label>
                                <select id="cargo_type" name="cargo_type" class="form-select form-select-sm border-0 bg-light">
                                    <option value="">All Types</option>
                                    @foreach($availableFilters['cargo_types'] as $cargoType)
                                        <option value="{{ $cargoType }}" @selected($filters['cargo_type'] === $cargoType)>
                                            {{ ucfirst($cargoType) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <label for="hawb_number" class="form-label fw-semibold text-muted small">HAWB Number</label>
                                <input type="text"
                                       id="hawb_number"
                                       name="hawb_number"
                                       value="{{ $filters['hawb_number'] }}"
                                       class="form-control form-control-sm border-0 bg-light"
                                       list="hawbNumbers"
                                       placeholder="e.g. HAWB12345">
                                <datalist id="hawbNumbers">
                                    @foreach($availableFilters['hawb_numbers'] as $hawbNumber)
                                        <option value="{{ $hawbNumber }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary btn-clicky btn-sm px-3 flex-fill">
                                    <i class="fas fa-filter me-1"></i>Apply Filters
                                </button>
                                @can('export-nwc-reports')
                                    <a href="{{ route('reports.nwc.export', $exportQuery) }}"
                                       class="btn btn-success btn-sm px-3 flex-fill">
                                        <i class="fas fa-file-excel me-1"></i>Export
                                    </a>
                                @endcan
                                <a href="{{ route('reports.nwc.index') }}" class="btn btn-outline-secondary btn-sm px-3 flex-fill">
                                    <i class="fas fa-undo me-1"></i>Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-2 p-md-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
                    <div>
                        <h5 class="card-title mb-1">Report Details</h5>
                        @if($filters['cashier'] || $filters['method'] || $filters['cargo_type'])
                            <div class="small text-muted flex-wrap">
                                @if($filters['cashier'])
                                    <span class="badge bg-info me-1 mb-1">
                                        <i class="fas fa-user me-1"></i>Cashier: {{ $filters['cashier'] }}
                                    </span>
                                @endif
                                @if($filters['method'])
                                    <span class="badge bg-secondary me-1 mb-1">
                                        <i class="fas fa-credit-card me-1"></i>Method: {{ collect($availableFilters['methods'])->firstWhere('value', $filters['method'])['label'] ?? $filters['method'] }}
                                    </span>
                                @endif
                                @if($filters['cargo_type'])
                                    <span class="badge bg-success me-1 mb-1">
                                        <i class="fas fa-{{ $filters['cargo_type'] === 'sea' ? 'ship' : 'plane' }} me-1"></i>Type: {{ ucfirst($filters['cargo_type']) }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        @can('share-nwc-reports-email')
                            <button class="btn btn-outline-primary btn-sm" data-toggle="collapse" data-target="#shareEmailForm">
                                <i class="fas fa-envelope me-1"></i> Email
                            </button>
                        @endcan
                        @can('share-nwc-reports-whatsapp')
                            <button class="btn btn-outline-success btn-sm" data-toggle="collapse" data-target="#shareWhatsappForm">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp
                            </button>
                        @endcan
                    </div>
                </div>

                @can('share-nwc-reports-email')
                    <div id="shareEmailForm" class="collapse mb-3">
                        <form class="row g-2 g-md-3 align-items-end" method="POST" action="{{ route('reports.nwc.share-email') }}">
                            @csrf
                            @foreach(['start_date', 'end_date', 'cashier', 'method', 'cargo_type', 'hawb_number', 'date', 'bill_order'] as $hiddenField)
                                <input type="hidden" name="{{ $hiddenField }}" value="{{ $filters[$hiddenField] }}">
                            @endforeach
                            <div class="col-12 col-md-4">
                                <label for="email" class="form-label">Recipient Email</label>
                                <input type="email" id="email" name="email" class="form-control" required placeholder="example@domain.com">
                            </div>
                            <div class="col-12 col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-1"></i>Send
                                </button>
                            </div>
                        </form>
                    </div>
                @endcan

                @can('share-nwc-reports-whatsapp')
                    <div id="shareWhatsappForm" class="collapse mb-3">
                        <form class="row g-2 g-md-3 align-items-end" method="POST" action="{{ route('reports.nwc.share-whatsapp') }}">
                            @csrf
                            @foreach(['start_date', 'end_date', 'cashier', 'method', 'hawb_number', 'date', 'bill_order'] as $hiddenField)
                                <input type="hidden" name="{{ $hiddenField }}" value="{{ $filters[$hiddenField] }}">
                            @endforeach
                            <div class="col-12 col-md-4">
                                <label for="phone" class="form-label">WhatsApp Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" required placeholder="+2607XXXXXXX">
                            </div>
                            <div class="col-12 col-md-2">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fab fa-whatsapp me-1"></i>Share
                                </button>
                            </div>
                        </form>
                    </div>
                @endcan

                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold"><b>Date</b></th>
                                <th class="fw-bold"><b>HAWB No</b></th>
                                <th class="fw-bold"><b>Receipt #</b></th>
                                <th class="fw-bold"><b>Consignee</b></th>
                                <th class="fw-bold"><b>Client</b></th>
                                <th class="fw-bold"><b>Rate</b></th>
                                <th class="fw-bold"><b>Bill (USD)</b></th>
                                <th class="fw-bold"><b>Bill (ZMW)</b></th>
                                <th class="fw-bold"><b>Method</b></th>
                                <th class="fw-bold"><b>Cashier</b></th>
                                <th class="bg-danger text-dark fw-bold">Airtel</th>
                                <th class="bg-warning text-dark font-lg fw-bold">MTN</th>
                                <th class="bg-success text-dark font-lg fw-bold">Cash Payments</th>
                                <th class="bg-info text-dark font-lg fw-bold">Invoice</th>
                                <th class="bg-primary text-dark font-lg fw-bold">Bank Transfer</th>
                                <th class="bg-secondary text-dark font-lg fw-bold">Card</th>
                                <th class="bg-info text-white font-lg fw-bold" style="background-color: #FF66C4 !important;">Zamtel</th>
                                <th class="bg-dark text-white font-lg fw-bold">Other</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($reportRows as $row)
                            <tr>
                                <td>{{ optional($row['date'])->format('Y-m-d') }}</td>
                                <td>{{ $row['hawb_number'] ?? '—' }}</td>
                                <td>{{ $row['receipt_number'] ?? '—' }}</td>
                                <td>{{ $row['consignee_name'] ?? '—' }}</td>
                                <td>{{ $row['client_name'] ?? '—' }}</td>
                                <td>{{ $row['rate'] !== null ? number_format($row['rate'], 4) : '—' }}</td>
                                <td>{{ $row['bill_usd'] !== null ? number_format($row['bill_usd'], 2) : '—' }}</td>
                                <td>{{ $row['bill_kwacha'] !== null ? number_format($row['bill_kwacha'], 2) : '—' }}</td>
                                <td>{{ $row['method_of_payment'] }}</td>
                                <td>{{ $row['cashier_name'] ?? 'N/A' }}</td>
                                @php
                                    $airtelAmount = $row['airtel'] ?? 0;
                                    $mtnAmount = $row['mtn'] ?? 0;
                                    $cashPaymentsAmount = $row['cash_payments'] ?? 0;
                                    $invoiceAmount = $row['invoice_payment'] ?? 0;
                                    $bankTransferAmount = $row['bank_transfer'] ?? 0;
                                    $cardAmount = $row['card_payment'] ?? 0;
                                    $zamtelAmount = $row['zamtel'] ?? 0;
                                    $otherAmount = $row['other_payment'] ?? 0;
                                @endphp
                                <td class="bg-danger text-dark" style="color:#000 !important;font-weight:bold;">{{ $airtelAmount > 0 ? number_format($airtelAmount, 2) : '-' }}</td>
                                <td class="bg-warning text-dark" style="color:#000 !important;font-weight:bold;">{{ $mtnAmount > 0 ? number_format($mtnAmount, 2) : '-' }}</td>
                                <td class="bg-success text-dark" style="color:#000 !important;font-weight:bold;">{{ $cashPaymentsAmount > 0 ? number_format($cashPaymentsAmount, 2) : '-' }}</td>
                                <td class="bg-info text-dark" style="color:#000 !important;font-weight:bold;">{{ $invoiceAmount > 0 ? number_format($invoiceAmount, 2) : '-' }}</td>
                                <td class="bg-primary text-dark" style="color:#000 !important;font-weight:bold;">{{ $bankTransferAmount > 0 ? number_format($bankTransferAmount, 2) : '-' }}</td>
                                <td class="bg-secondary text-dark" style="color:#000 !important;font-weight:bold;">{{ $cardAmount > 0 ? number_format($cardAmount, 2) : '-' }}</td>
                                <td class="bg-info text-white" style="background-color: #FF66C4 !important;font-weight:bold;">{{ $zamtelAmount > 0 ? number_format($zamtelAmount, 2) : '-' }}</td>
                                <td class="bg-dark text-white" style="font-weight:bold;">{{ $otherAmount > 0 ? number_format($otherAmount, 2) : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="text-center text-muted">
                                    No transactions found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        @if($reportRows->isNotEmpty())
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="5" class="text-end">Totals:</th>
                                    <th><b>{{ number_format($summary['total_rate'] ?? 0, 4) }}</b></th>
                                    <th><b>{{ number_format($summary['total_bill_usd'] ?? 0, 2) }}</b></th>
                                    <th><b>{{ number_format($summary['total_bill_kwacha'] ?? 0, 2) }}</b></th>
                                    <th></th>
                                    <th></th>
                                    <th><b>{{ number_format($summary['total_airtel'] ?? 0, 2) }}</b></th>
                                    <th><b>{{ number_format($summary['total_mtn'] ?? 0, 2) }}</b></th>
                                    <th> <b>{{ number_format($summary['total_cash_payments'] ?? 0, 2) }}</b> </th>
                                    <th><b>{{ number_format($summary['total_invoice_payment'] ?? 0, 2) }}</b></th>
                                    <th><b>{{ number_format($summary['total_bank_transfer'] ?? 0, 2) }}</b></th>
                                    <th><b>{{ number_format($summary['total_card_payment'] ?? 0, 2) }}</b></th>
                                    <th><b>{{ number_format($summary['total_zamtel'] ?? 0, 2) }}</b></th>
                                    <th><b>{{ number_format($summary['total_other_payment'] ?? 0, 2) }}</b></th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Responsive table improvements */
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Make table more readable on mobile */
        @media (max-width: 767.98px) {
            .table th,
            .table td {
                padding: 0.25rem;
                font-size: 0.85rem;
            }
            
            /* Make sure the table header is readable */
            .table th {
                white-space: nowrap;
            }
            
            /* Adjust card body padding on smaller screens */
            .card-body {
                padding: 0.75rem !important;
            }
            
            /* Adjust column widths for better fit */
            .table th:nth-child(1),
            .table td:nth-child(1) { /* Date column */
                min-width: 80px;
            }
            
            .table th:nth-child(2),
            .table td:nth-child(2) { /* HAWB No column */
                min-width: 80px;
            }
            
            .table th:nth-child(4),
            .table td:nth-child(4), /* Consignee column */
            .table th:nth-child(5),
            .table td:nth-child(5) { /* Client column */
                min-width: 100px;
            }
        }
        
        @media (max-width: 575.98px) {
            .table th,
            .table td {
                padding: 0.15rem 0.2rem;
                font-size: 0.75rem;
            }
            
            /* Stack action buttons on very small screens */
            .d-flex.gap-2 {
                flex-direction: column;
                align-items: stretch;
            }
            
            .d-flex.gap-2 .btn {
                margin-bottom: 0.25rem;
            }
            
            /* Reduce padding further on very small screens */
            .card-body {
                padding: 0.5rem !important;
            }
        }
        
        /* Make sure form elements are responsive */
        .form-control,
        .form-select {
            min-height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
        }
        
        @media (max-width: 575.98px) {
            .form-control,
            .form-select {
                font-size: 0.8rem;
                padding: 0.25rem 0.4rem;
            }
        }
        
        /* Ensure buttons are accessible on mobile */
        .btn {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }
    </style>
@endsection



