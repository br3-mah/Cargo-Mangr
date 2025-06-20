@extends('cargo::adminLte.layouts.master')
@section('pageTitle', 'Shipments Overview')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Shipments Overview</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Air Consignments Stats -->
        <div>
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Air Consignments</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $airStats['total'] }}</div>
                    <div class="text-gray-500">Total Air Consignments</div>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $airStats['delivered'] }}</div>
                    <div class="text-gray-500">Delivered</div>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $airStats['in_transit'] }}</div>
                    <div class="text-gray-500">In Transit</div>
                </div>
            </div>
        </div>
        <!-- Sea Consignments Stats -->
        <div>
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Sea Consignments</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $seaStats['total'] }}</div>
                    <div class="text-gray-500">Total Sea Consignments</div>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $seaStats['delivered'] }}</div>
                    <div class="text-gray-500">Delivered</div>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $seaStats['in_transit'] }}</div>
                    <div class="text-gray-500">In Transit</div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Shipment List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($shipments as $shipment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $shipment->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ optional($shipment->client)->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($shipment->status_id == \Modules\Cargo\Entities\Shipment::DELIVERED_STATUS)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Delivered</span>
                                @elseif($shipment->status_id == \Modules\Cargo\Entities\Shipment::PENDING_STATUS)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In Transit</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Other</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $shipment->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $shipment->created_at ? $shipment->created_at->toFormattedDateString() : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No shipments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 