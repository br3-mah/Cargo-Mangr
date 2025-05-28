@extends('cargo::adminLte.layouts.blank')

@php
    $pageTitle = __('cargo::view.tracking_shipment') . ' #' . (isset($model) ? $model->code : __('cargo::view.error'));
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
                    },
                    animation: {
                        'ping-slow': 'ping 2s cubic-bezier(0, 0, 0.2, 1) infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite alternate',
                        'float': 'float 3s ease-in-out infinite',
                        'slide-in': 'slide-in 0.8s ease-out',
                        'fade-in': 'fade-in 0.6s ease-out',
                        'bounce-soft': 'bounce-soft 2s ease-in-out infinite',
                    },
                    keyframes: {
                        'pulse-glow': {
                            '0%': { boxShadow: '0 0 0 0 rgba(247, 198, 0, 0.4)' },
                            '100%': { boxShadow: '0 0 0 20px rgba(247, 198, 0, 0)' }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        'slide-in': {
                            '0%': { transform: 'translateX(-50px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        'fade-in': {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        'bounce-soft': {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-5px)' }
                        }
                    },
                    backdropBlur: {
                        'xs': '2px',
                    }
                }
            }
        }
    </script>
    <style>
        .map-bg {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="%23e5e7eb" stroke-width="1" opacity="0.3"/></pattern></defs><rect width="100%" height="100%" fill="%23f8fafc"/><rect width="100%" height="100%" fill="url(%23grid)"/><path d="M100,200 Q200,150 300,180 T500,160 T700,140 T900,120" stroke="%23f7c600" stroke-width="3" fill="none" opacity="0.6"/><circle cx="150" cy="190" r="8" fill="%23012642" opacity="0.4"/><circle cx="350" cy="170" r="6" fill="%23f7c600" opacity="0.5"/><circle cx="550" cy="155" r="7" fill="%23012642" opacity="0.4"/><circle cx="750" cy="135" r="5" fill="%23f7c600" opacity="0.6"/></svg>');
            background-size: cover;
            background-position: center;
        }
    </style>
@endsection

@section('page-content')

@if(isset($error))
    <div class="min-h-screen map-bg relative">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/80 via-primary-800/70 to-primary-700/80"></div>
        <div class="relative z-10 flex flex-col justify-center items-center min-h-screen px-4">
            <div class="bg-white/95 backdrop-blur-xl p-8 rounded-3xl shadow-2xl w-full max-w-md border border-white/20 transition-all hover:shadow-3xl animate-fade-in">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl mb-6 animate-float">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent mb-2">
                        {{ __('cargo::view.tracking_shipment') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('cargo::view.enter_your_tracking_code') }}</p>

                    @if($error)
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-medium">{{ $error }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <form action="{{ route('shipments.tracking') }}" method="GET" class="space-y-6">
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('cargo::view.enter_your_tracking_code') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="code"
                                class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-400 focus:border-primary-400 transition-all text-gray-800 bg-gray-50 focus:bg-white"
                                placeholder="{{ __('cargo::view.example_SH00001') }}"
                            >
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white py-4 px-6 rounded-xl font-semibold transition-all transform hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 animate-pulse-glow"
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
@else
    <div class="min-h-screen map-bg relative">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/60 via-primary-800/40 to-primary-700/60"></div>
        <div class="relative z-10 min-h-screen py-8">
            <div class="container mx-auto px-4">
                <!-- Header Section -->
                <div class="text-center mb-12 animate-fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl mb-4 animate-bounce-soft">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-white mb-2">
                        {{ __('cargo::view.tracking_shipment') }}
                    </h1>
                    <p class="text-xl text-white/80 mb-1">#{{ $model->code ?? 'Unknown' }}</p>
                    
                    <!-- Live Status Indicator -->
                    @if($track_map)
                        <div class="inline-flex items-center space-x-2 bg-green-500/20 backdrop-blur-sm px-4 py-2 rounded-full border border-green-400/30">
                            <div class="relative">
                                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-400 rounded-full absolute top-0 left-0 animate-ping opacity-75"></div>
                            </div>
                            <span class="text-green-300 font-medium">Live Tracking Active</span>
                        </div>
                    @else
                        <div class="inline-flex items-center space-x-2 bg-red-500/20 backdrop-blur-sm px-4 py-2 rounded-full border border-red-400/30">
                            <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                            <span class="text-red-300 font-medium">{{ __('cargo::view.consignment_not_found') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Horizontal Timeline -->
                @if($track_map)
                    <div class="max-w-7xl mx-auto mb-12">
                        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/20 animate-slide-in">
                            <div class="flex items-center space-x-3 mb-8">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary-400 to-primary-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">Shipment Journey</h2>
                                <div class="flex-1 flex justify-end">
                                    <span class="bg-primary-100 text-primary-800 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ count($track_map) }} Updates
                                    </span>
                                </div>
                            </div>

                            <!-- Horizontal Timeline Container -->
                            <div class="relative">
                                <!-- Timeline Line -->
                                <div class="absolute top-12 left-8 right-8 h-1 bg-gradient-to-r from-primary-200 via-primary-400 to-primary-600 rounded-full"></div>
                                
                                <!-- Timeline Items -->
                                <div class="flex justify-between items-start relative">
                                    @foreach($track_map as $index => $log)
                                        <div class="flex flex-col items-center max-w-xs {{ $loop->first ? 'animate-pulse-glow' : '' }}" style="animation-delay: {{ $index * 0.2 }}s">
                                            <!-- Timeline Node -->
                                            <div class="relative z-10 mb-4">
                                                <div class="w-6 h-6 rounded-full {{ $loop->first ? 'bg-gradient-to-r from-green-400 to-green-600 animate-ping-slow' : ($loop->last ? 'bg-gradient-to-r from-primary-400 to-primary-600' : 'bg-gradient-to-r from-gray-300 to-gray-400') }} flex items-center justify-center border-4 border-white shadow-lg">
                                                    @if($loop->first)
                                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                                    @endif
                                                </div>
                                                
                                                <!-- Connecting Line for Mobile -->
                                                @if(!$loop->last)
                                                    <div class="hidden max-md:block absolute top-6 left-3 w-0.5 h-20 bg-gradient-to-b from-primary-400 to-primary-200"></div>
                                                @endif
                                            </div>

                                            <!-- Content Card -->
                                            <div class="bg-white rounded-2xl shadow-lg p-4 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 max-w-xs">
                                                <div class="text-center">
                                                    <p class="text-xs font-semibold text-primary-600 mb-2">
                                                        {{ \Carbon\Carbon::parse($log[1])->format('M j, Y') }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 mb-2">
                                                        {{ \Carbon\Carbon::parse($log[1])->format('g:i A') }}
                                                    </p>
                                                    <p class="font-semibold text-gray-800 text-sm mb-2 leading-tight">{{ $log[0] }}</p>
                                                    
                                                    <div class="bg-gradient-to-r from-primary-50 to-primary-100 rounded-lg p-2 text-xs">
                                                        <div class="flex items-center justify-center text-primary-700">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            <span class="font-medium">{{ \Carbon\Carbon::parse($log[1])->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($loop->first)
                                                        <div class="mt-2 flex justify-center">
                                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></div>
                                                                Current
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="max-w-2xl mx-auto mb-12">
                        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-12 text-center border border-white/20">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-2xl mb-6">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">No Tracking Data Available</h3>
                            <p class="text-gray-600 text-lg">We couldn't find any tracking information for this shipment</p>
                        </div>
                    </div>
                @endif

                <!-- Search Another Shipment -->
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/20">
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
                                    class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-400 focus:border-primary-400 transition-all text-gray-700 bg-gray-50 focus:bg-white"
                                    placeholder="{{ __('cargo::view.example_SH00001') }}"
                                >
                            </div>
                            <button
                                type="submit"
                                class="px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl transition-all transform hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary-500 whitespace-nowrap"
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
            </div>
        </div>
    </div>
@endif
@endsection