@extends('cargo::adminLte.layouts.blank')

@php
    $pageTitle = __('cargo::view.tracking_shipment') . ' #' . (isset($model) ? $model->code : __('cargo::view.error'));
    // $allStages = [ ... ]; // Get all stages from DB or config
    $completedCount = 0;
    foreach ($track_map as $log) {
        if ($log[1] !== null) $completedCount++;
    }
    $stages = \App\Models\TrackingStage::where('cargo_type', $model->cargo_type)
        ->orderBy('order')
        ->get();
@endphp

@section('page-title', $pageTitle)
@section('page-type', 'page')

@section('styles')
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#012642',
                            300: '#012642',
                            400: '#f7c600',
                            500: '#012642',
                            600: '#f7c600',
                            700: '#f7c600',
                            800: '#075985',
                            900: '#012642',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .content-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .progress-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #012642 0%, #f7c600 100%);
            transition: width 0.3s ease;
        }
        .stage-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #e5e7eb;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e5e7eb;
            position: relative;
        }
        .stage-dot.completed {
            background: #f7c600;
            box-shadow: 0 0 0 2px #f7c600;
        }
        .stage-dot.completed::after {
            content: '✓';
            position: absolute;
            top: -8px;
            left: -8px;
            right: -8px;
            bottom: -8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
        }
        .stage-dot.active {
            background: #012642;
            box-shadow: 0 0 0 2px #012642;
        }
    </style>
@endsection

@section('page-content')
@if(isset($error))
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-16">
            <div class="max-w-md mx-auto">
                <div class="content-card rounded-lg shadow-md overflow-hidden">
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-600 rounded-lg mb-6">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">Track Your Shipment</h1>
                            <p class="text-gray-600">Enter your tracking number to get started</p>
                        </div>

                        @if($error)
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-red-700 font-medium">{{ $error }}</p>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('shipments.tracking') }}" method="GET" class="space-y-6">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    name="code"
                                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-400 transition-all text-gray-800 bg-white"
                                    placeholder="{{ __('cargo::view.example_SH00001') }}"
                                >
                            </div>

                            <button
                                type="submit"
                                class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-6 rounded-lg font-semibold transition-all focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                            >
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ __('cargo::view.search') }}
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Tracking Information</h1>
                <p class="text-xl text-gray-600">#{{ $model->code ?? 'Unknown' }}</p>
                
                @if($model)
                    <div class="inline-flex items-center space-x-2 bg-green-50/90 backdrop-blur-sm px-4 py-2 rounded-full border border-green-200 mt-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-green-700 font-medium">Tracking Active</span>
                    </div>
                @endif
            </div>

            <!-- Tracking Information -->
            @if($model && isset($track_map))
                <div class="max-w-4xl mx-auto">
                    <div class="content-card rounded-lg p-8 mb-8">
                        <!-- Progress Bar -->
                        <div class="mb-8">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Delivery Progress</span>
                                <span class="text-sm font-medium text-primary-600">{{ count(array_filter($track_map, function($item) { return $item[1] !== null; })) }}/6 Stages</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-bar-fill" style="width: {{ (count(array_filter($track_map, function($item) { return $item[1] !== null; })) / 6) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Tracking Timeline -->
                        <div class="space-y-6">
                            @foreach($track_map as $index => $log)
                                @php
                                    $isCompleted = $log[1] !== null;
                                    $date = $log[1];
                                    $formattedDate = $date instanceof \Carbon\Carbon ? $date->format('M j, Y g:i A') : ($date ? \Carbon\Carbon::parse($date)->format('M j, Y g:i A') : null);
                                    $timeAgo = $date instanceof \Carbon\Carbon ? $date->diffForHumans() : ($date ? \Carbon\Carbon::parse($date)->diffForHumans() : null);
                                @endphp
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $isCompleted ? 'bg-primary-50' : 'bg-gray-100' }} flex items-center justify-center mr-4">
                                        <svg class="w-4 h-4 {{ $isCompleted ? 'text-primary-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <p class="font-medium text-gray-800 mb-1">{{ $log[0] }}</p>
                                            @if($isCompleted)
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $formattedDate }}
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $timeAgo }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipment Details -->
                    @if(isset($client) && isset($PackageShipment))
                        <div class="content-card rounded-lg p-8 mb-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Shipment Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Client Information</h3>
                                    <p class="text-gray-600">Name: {{ $client->name ?? 'N/A' }}</p>
                                    <p class="text-gray-600">Phone: {{ $client->phone ?? 'N/A' }}</p>
                                    @if(isset($ClientAddress))
                                        <p class="text-gray-600">Address: {{ $ClientAddress->address ?? 'N/A' }}</p>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Package Information</h3>
                                    @foreach($PackageShipment as $package)
                                        <div class="mb-2">
                                            <p class="text-gray-600">Type: {{ $package->package_type ?? 'N/A' }}</p>
                                            <p class="text-gray-600">Weight: {{ $package->weight ?? 'N/A' }} kg</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Search Another Shipment -->
                    <div class="content-card rounded-lg p-8">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Track Another Shipment</h3>
                            <p class="text-gray-600">Enter a different tracking code to search</p>
                        </div>
                        
                        <form action="{{ route('shipments.tracking') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    name="code"
                                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-400 transition-all text-gray-700 bg-white"
                                    placeholder="{{ __('cargo::view.example_SH00001') }}"
                                >
                            </div>
                            <button
                                type="submit"
                                class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-primary-500 whitespace-nowrap"
                            >
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ __('cargo::view.search') }}
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="max-w-2xl mx-auto">
                    <div class="content-card rounded-lg p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-lg mb-6">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">No Tracking Data Available</h3>
                        <p class="text-gray-600">We couldn't find any tracking information for this shipment</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
@endsection