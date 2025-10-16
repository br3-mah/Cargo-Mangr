@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    NWC Reports
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form class="row g-3 align-items-end" method="GET" action="{{ route('reports.nwc.index') }}">
                            <div class="col-md-3">
                                <label for="start_date" class="form-label fw-semibold text-muted">Start Date</label>
                                <input type="date"
                                       id="start_date"
                                       name="start_date"
                                       value="{{ $filters['start_date'] ?? now()->toDateString() }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label fw-semibold text-muted">End Date</label>
                                <input type="date"
                                       id="end_date"
                                       name="end_date"
                                       value="{{ $filters['end_date'] ?? now()->toDateString() }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-6 d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Apply Filters
                                </button>
                                @can('export-nwc-reports')
                                    <a href="{{ route('reports.nwc.export', ['start_date' => $filters['start_date'], 'end_date' => $filters['end_date']]) }}"
                                       class="btn btn-success">
                                        <i class="fas fa-file-excel me-1"></i>Export Excel
                                    </a>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total Transactions</p>
                        <h4 class="fw-bold mb-0">{{ number_format($summary['total_rows'] ?? 0) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total Bill (USD)</p>
                        <h4 class="fw-bold mb-0">${{ number_format($summary['total_bill_usd'] ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total Bill (ZMW)</p>
                        <h4 class="fw-bold mb-0">K{{ number_format($summary['total_bill_kwacha'] ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1">Average Rate</p>
                        <h4 class="fw-bold mb-0">{{ number_format($summary['average_rate'] ?? 0, 4) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Report Details</h5>
                    <div class="d-flex gap-2">
                        @can('share-nwc-reports-email')
                            <button class="btn btn-outline-primary" data-toggle="collapse" data-target="#shareEmailForm">
                                <i class="fas fa-envelope me-1"></i>Email Report
                            </button>
                        @endcan
                        @can('share-nwc-reports-whatsapp')
                            <button class="btn btn-outline-success" data-toggle="collapse" data-target="#shareWhatsappForm">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp Report
                            </button>
                        @endcan
                    </div>
                </div>

                @can('share-nwc-reports-email')
                    <div id="shareEmailForm" class="collapse mb-3">
                        <form class="row g-2 align-items-end" method="POST" action="{{ route('reports.nwc.share-email') }}">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ $filters['start_date'] }}">
                            <input type="hidden" name="end_date" value="{{ $filters['end_date'] }}">
                            <div class="col-md-4">
                                <label for="email" class="form-label">Recipient Email</label>
                                <input type="email" id="email" name="email" class="form-control" required placeholder="example@domain.com">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-1"></i>Send
                                </button>
                            </div>
                        </form>
                    </div>
                @endcan

                @can('share-nwc-reports-whatsapp')
                    <div id="shareWhatsappForm" class="collapse mb-3">
                        <form class="row g-2 align-items-end" method="POST" action="{{ route('reports.nwc.share-whatsapp') }}">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ $filters['start_date'] }}">
                            <input type="hidden" name="end_date" value="{{ $filters['end_date'] }}">
                            <div class="col-md-4">
                                <label for="phone" class="form-label">WhatsApp Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" required placeholder="+2607XXXXXXX">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fab fa-whatsapp me-1"></i>Share
                                </button>
                            </div>
                        </form>
                    </div>
                @endcan

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>HAWB No</th>
                                <th>Receipt #</th>
                                <th>Consignee</th>
                                <th>Client</th>
                                <th>Rate</th>
                                <th>Bill (USD)</th>
                                <th>Bill (ZMW)</th>
                                <th>Method</th>
                                <th class="bg-danger text-white">Airtel</th>
                                <th class="bg-warning text-dark">MTN</th>
                                <th class="bg-success text-white">Cash Payments</th>
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
                                @php
                                    $airtelAmount = $row['airtel'] ?? 0;
                                    $mtnAmount = $row['mtn'] ?? 0;
                                    $cashPaymentsAmount = $row['cash_payments'] ?? 0;
                                @endphp
                                <td class="bg-danger text-dark">{{ $airtelAmount > 0 ? number_format($airtelAmount, 2) : '-' }}</td>
                                <td class="bg-warning text-dark">{{ $mtnAmount > 0 ? number_format($mtnAmount, 2) : '-' }}</td>
                                <td class="bg-success text-dark">{{ $cashPaymentsAmount > 0 ? number_format($cashPaymentsAmount, 2) : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">
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
                                    <th><b>{{ number_format($summary['total_airtel'] ?? 0, 2) }}</b></th>
                                    <th><b>{{ number_format($summary['total_mtn'] ?? 0, 2) }}</b></th>
                                    <th> <b>{{ number_format($summary['total_cash_payments'] ?? ($summary['total_zamtel'] ?? 0), 2) }}</b> </th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection



