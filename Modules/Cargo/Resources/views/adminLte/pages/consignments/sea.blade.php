@extends('cargo::adminLte.layouts.master')
@section('pageTitle', 'Sea Consignments')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Sea Consignments Overview</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
            <div class="text-gray-500">Total Sea Consignments</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['delivered'] }}</div>
            <div class="text-gray-500">Delivered</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['in_transit'] }}</div>
            <div class="text-gray-500">In Transit</div>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Sea Consignment List</h2>
        <!-- Only sea consignments are listed below -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Consignee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($consignments as $consignment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $consignment->consignment_code ?? 'Unspecified' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $consignment->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $consignment->source ?? 'China' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $consignment->destination ?? 'Zambia' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $consignment->updated_at->toFormattedDateString() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($consignment->status == 'delivered')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">DELIVERED</span>
                                @elseif($consignment->status == 'in_transit')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">IN TRANSIT</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ strtoupper($consignment->current_status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No sea consignments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 