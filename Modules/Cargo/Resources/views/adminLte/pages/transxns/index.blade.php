@php
$user_role = auth()->user()->role;
$admin = 1;
$branch = 3;
$client = 4;
@endphp

@extends('cargo::adminLte.layouts.master')
@section('pageTitle', 'Transactions')
@section('content')

<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="flex items-center py-2 px-4 bg-gray-50 rounded-lg shadow-sm text-sm">
        <li class="flex items-center">
            <a href="#" class="text-yellow-400 hover:text-yellow-500 transition-colors">Dashboard</a>
            <svg class="h-4 w-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </li>
        <li class="text-gray-700 font-medium" aria-current="page">Transactions</li>
    </ol>
</nav>
<!-- Transaction Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white border-l-4 border-yellow-400 shadow rounded-lg p-4">
        <div class="text-sm text-gray-500">Total To Date</div>
        <div class="text-xl font-bold text-gray-800">K{{ number_format($totals['todate'], 2) }}</div>
    </div>
    <div class="bg-white border-l-4 border-green-400 shadow rounded-lg p-4">
        <div class="text-sm text-gray-500">Today</div>
        <div class="text-xl font-bold text-gray-800">K{{ number_format($totals['today'], 2) }}</div>
    </div>
    <div class="bg-white border-l-4 border-blue-400 shadow rounded-lg p-4">
        <div class="text-sm text-gray-500">Yesterday</div>
        <div class="text-xl font-bold text-gray-800">K{{ number_format($totals['yesterday'], 2) }}</div>
    </div>
    <div class="bg-white border-l-4 border-purple-400 shadow rounded-lg p-4">
        <div class="text-sm text-gray-500">This Week</div>
        <div class="text-xl font-bold text-gray-800">K{{ number_format($totals['this_week'], 2) }}</div>
    </div>
    <div class="bg-white border-l-4 border-red-400 shadow rounded-lg p-4">
        <div class="text-sm text-gray-500">This Month</div>
        <div class="text-xl font-bold text-gray-800">K{{ number_format($totals['this_month'], 2) }}</div>
    </div>
</div>

<!-- Transactions Table Card -->
<div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-yellow-50 to-gray-50 border-b px-6 py-4 flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-800">Recent Transactions</h2>
    </div>

    <div class="p-4 overflow-x-auto">
        <table id="transactionsTable" class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Transaction ID</th>
                    <th class="px-4 py-2">Receipt No.</th>
                    <th class="px-4 py-2">Shipment Code.</th>
                    <th class="px-4 py-2">Client</th>
                    <th class="px-4 py-2">Client Phone</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($transactions as $index => $txn)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $txn->id }}</td>
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $txn->receipt_number }}</td>
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $txn->shipment?->code }}</td>
                    <td class="px-4 py-2">{{ $txn?->shipment?->client?->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $txn?->shipment?->client_phone ?? 'Not placed' }}</td>
                    <td class="px-4 py-2 text-green-600 font-semibold">K{{ number_format($txn->total, 2) }}</td>
                    <td class="px-4 py-2">
                        <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Completed</span>
                    </td>
                    <td class="px-4 py-2">{{ $txn->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#transactionsTable').DataTable({
            "order": [[0, "desc"]]
        });
    });
</script>

@endsection
