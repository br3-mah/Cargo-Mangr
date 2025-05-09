<!-- Shipment Details -->
<div class="mt-8 bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-bold text-gray-700 mb-4">{{ __('cargo::view.shipment_details') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div>
            <p class="text-sm text-gray-500">Cargo</p>
            <p class="font-medium">{{$shipment->consignment->cargo_type ?? 'Sea'}} Freight</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('cargo::view.shipment_type') }}</p>
            <p class="font-medium">{{$shipment->type}}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('cargo::view.current_branch') }}</p>
            @if($user_role == $admin || auth()->user()->can('show-branches') )
                <a class="font-medium text-blue-600 hover:underline" href="{{route('branches.show', $shipment->branch_id ?? 1)}}">{{$shipment->branch->name ?? 'Null'}}</a>
            @else
                <p class="font-medium">{{$shipment->branch->name ?? 'Null'}}</p>
            @endif
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('cargo::view.created_date') }}</p>
            <p class="font-medium">{{$shipment->created_at->toFormattedDateString()}}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('cargo::view.shipping_date') }}</p>
            <p class="font-medium">
                @if(strpos($shipment->shipping_date, '/' ))
                    {{ Carbon\Carbon::createFromFormat('d/m/Y', $shipment->shipping_date)->format('F j, Y') }}
                @else
                    {{ \Carbon\Carbon::parse($shipment->shipping_date)->format('F j, Y') }}
                @endif
            </p>
        </div>

        @if ($shipment->prev_branch)
        <div>
            <p class="text-sm text-gray-500">{{ __('cargo::view.previous_branch') }}</p>
            <p class="font-medium">{{Modules\Cargo\Entities\Branch::find($shipment->prev_branch)->name ?? 'Null'}}</p>
        </div>
        @endif

        <div>
            <p class="text-sm text-gray-500">{{ __('cargo::view.total_weight') }}</p>
            <p class="font-medium">{{$shipment->total_weight}} {{ __('cargo::view.KG') }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ __('cargo::view.tax_duty') }}</p>
            <p class="font-medium">{{format_price($shipment->tax)}}</p>
        </div>

        <!-- New Consignment Fields -->

        <div>
            <p class="text-sm text-gray-500">Cargo Date</p>
            <p class="font-medium">
                {{ optional($shipment->consignment->cargo_date)->format('F j, Y') ?? 'N/A' }}
            </p>
        </div>

        <div>
            <p class="text-sm text-gray-500">ETA</p>
            <p class="font-medium">
                {{ optional($shipment->consignment->eta)->format('F j, Y') ?? 'N/A' }}
            </p>
        </div>

        <div>
            <p class="text-sm text-gray-500">ETA DAR</p>
            <p class="font-medium">
                {{ optional($shipment->consignment->eta_dar)->format('F j, Y') ?? 'N/A' }}
            </p>
        </div>

        <div>
            <p class="text-sm text-gray-500">ETA LUN</p>
            <p class="font-medium">
                {{ optional($shipment->consignment->eta_lun)->format('F j, Y') ?? 'N/A' }}
            </p>
        </div>

        <div>
            
        </div>
    </div>
</div>