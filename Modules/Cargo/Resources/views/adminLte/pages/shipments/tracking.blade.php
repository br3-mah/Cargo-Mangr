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
                    }
                }
            }
        }
    </script>
@endsection

@section('page-content')

@if(isset($error))
    <div class="flex flex-col justify-center items-center">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-gray-100 transition-all hover:shadow-xl">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-50 rounded-full mb-4">
                    <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">{{ __('cargo::view.tracking_shipment') }}</h1>
                <p class="text-gray-500">{{ __('cargo::view.enter_your_tracking_code') }}</p>

                @if($error)
                <div class="mt-4 p-3 bg-red-50 text-red-600 rounded-lg">
                    <p class="font-medium">{{ $error }}</p>
                </div>
                @endif
            </div>

            <form action="{{ route('shipments.tracking') }}" method="GET" class="space-y-5">
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1 ml-1">{{ __('cargo::view.enter_your_tracking_code') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="code"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all text-gray-800"
                            placeholder="{{ __('cargo::view.example_SH00001') }}"
                        >
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-lg font-medium transition-all transform hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                    {{ __('cargo::view.search') }}
                </button>
            </form>
        </div>
    </div>
@else
    <section class="min-h-screen py-10">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <!-- Header card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6 transition-all hover:shadow-xl border border-gray-100">
                    <div class="px-6 py-5 bg-gradient-to-r from-primary-600 to-primary-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-white/20 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-white">
                                    {{ __('cargo::view.tracking_shipment') }}
                                    <span class="block text-sm font-normal text-white/90 mt-0.5">
                                        #{{ $model->code ?? 'Unknown' }}
                                    </span>
                                </h2>
                            </div>

                            <!-- Status indicator -->
                            @if($track_map)
                                <div class="bg-white/10 px-3 py-2 rounded-full flex items-center space-x-2">
                                    <div class="relative">
                                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                        <div class="w-3 h-3 bg-green-400 rounded-full absolute top-0 left-0 animate-ping-slow opacity-75"></div>
                                    </div>
                                    <span class="text-white font-medium text-sm">In Transit</span>
                                </div>
                            @else
                                <div class="bg-white/10 px-3 py-2 rounded-full flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <span class="text-white font-medium text-sm">{{ __('cargo::view.consignment_not_found') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 transition-all hover:shadow-xl border border-gray-100">
                    <div class="flex items-center space-x-2 mb-6">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-800">Cargo Tracking Details</h3>
                    </div>

                    <!-- Timeline -->
                    @if($track_map)
                        <div class="ml-3 space-y-0">
                            @foreach($track_map as $index => $log)
                                <div class="relative pl-6 pb-6 {{ $index === count($track_map) - 1 ? '' : 'border-l-2 border-primary-100' }}">
                                    <div class="absolute {{ $loop->last ? 'pulse':'' }} left-[-5px] mt-1.5 w-3.5 h-3.5 rounded-full bg-primary-400"></div>
                                    <div class="pl-2">
                                        <p class="text-xs text-gray-500 mb-1">
                                            {{ \Carbon\Carbon::parse($log[1])->format('F j, Y g:i A') }}
                                            <span class="ml-1 px-2 py-0.5 bg-gray-100 rounded-full text-gray-600">
                                                {{ \Carbon\Carbon::parse($log[1])->diffForHumans() }}
                                            </span>
                                        </p>
                                        <p class="font-medium text-gray-800">{{ $log[0] }}</p>
                                        <div class="my-2 bg-gray-50 rounded-lg p-3 text-sm text-gray-600">
                                            <div class="flex items-center mb-1">
                                                <svg class="w-4 h-4 text-primary-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>Shipment location updated</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-800 mb-1">No tracking information available</h4>
                            <p class="text-gray-500">The shipment tracking details could not be found</p>
                        </div>
                    @endif

                    <!-- Search another shipment -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <form action="{{ route('shipments.tracking') }}" method="GET" class="flex space-x-3">
                            <input
                                type="text"
                                name="code"
                                class="flex-1 block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all text-gray-700 text-sm"
                                placeholder="{{ __('cargo::view.example_SH00001') }}"
                            >
                            <button
                                type="submit"
                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-all"
                            >
                                {{ __('cargo::view.search') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

@endsection
