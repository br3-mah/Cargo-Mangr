<div class="w-full">
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row">
        <div id="column3" class="col-md-12 px-6">
            <p class="text-muted text-sm">Mawb Number: {{ $consignment->Mawb_num }}</p>
            @if ($consignment->cargo_type == 'sea')
                <div class="items-center d-flex space-x-2">
                    <p class="text-sm text-gray-500">ETA DAR</p>
                    <p class="font-medium">
                        {{ Carbon::parse($consignment->eta_dar)->format('l, F j, Y') ?? 'Not placed' }}
                    </p>
                </div>
                <div class="items-center d-flex space-x-2">
                    <p class="text-sm text-gray-500">ETA LUN</p>
                    <p class="font-medium">
                        {{ Carbon::parse($consignment->eta_lun)->format('l, F j, Y') ?? 'Not placed' }}
                    </p>
                </div>
                <div class="items-center d-flex space-x-2">
                    <p class="text-sm text-gray-500">Destination Port</p>
                    <p class="font-medium">
                        {{ $consignment->dest_port }}
                    </p>
                </div>
                <div>
                    <img width="80" src="{{ asset('icon/ship.svg') }}" alt="">
                </div>
            @else
                <div class="items-center d-flex space-x-2">
                    <p class="text-sm text-gray-500">Expected time of arrival:</p>
                    <p class="font-medium">
                        {{ Carbon::parse($consignment->eta)->format('l, F j, Y') ?? 'Not placed' }}
                    </p>
                </div>
                <div>
                    <img width="80" src="{{ asset('icon/plane.svg') }}" alt="">
                </div>
            @endif
            <table id="shipmentTable" class="table table-hover">
                <thead class="sticky-top bg-white z-10">
                    <tr class="text-sm">
                        <th><i class="bi bi-upc-scan me-1"></i> Hawb No.</th>
                        <th><i class="bi bi-box me-1"></i> Type</th>
                        <th><i class="bi bi-building me-1"></i> Branch</th>
                        <th><i class="bi bi-person me-1"></i> Client</th>
                        <th><i class="bi bi-file me-1"></i> Package Description</th>
                        <th><i class="bi bi-telephone me-1"></i> Client Phone</th>
                        <th><i class="bi bi-currency-dollar me-1"></i> Cost</th>
                        <th><i class="bi bi-cash-coin me-1"></i> Payment</th>
                        <th><i class="bi bi-clock-history me-1"></i> Created On</th>
                        <th><i class="bi bi-gear me-1"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consignment->shipments as $shipment)
                        <tr id="shipment_row_{{ $shipment->id }}">
                            <td>
                                <span class="badge bg-info rounded-pill">{{ $shipment->code }}</span>
                            </td>
                            <td>{{ $shipment->type }}</td>
                            <td>{{ 'Lusaka' }}</td>
                            <td>{{ $shipment->client->name }}</td>
                            <td>
                                @foreach (Modules\Cargo\Entities\PackageShipment::where('shipment_id', $shipment->id)->get() as $package)
                                    {{ $package->description }}
                                @endforeach
                            </td>
                            <td>{{ $shipment->client_phone ?? 'No phone' }}</td>
                            <td>
                                <span class="text-dark text-md font-weight-bold">
                                    K{{ number_format(convert_currency($shipment->amount_to_be_collected, 'usd', 'zmw'), 2) }}
                                </span>
                                <span class="text-warning text-sm">(${{ $shipment->amount_to_be_collected }})</span>
                            </td>
                            <td>
                                @if ($shipment->paid)
                                    <span class="badge bg-success rounded-pill">PAID</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">UNPAID</span>
                                @endif
                            </td>
                            <td>{{ $shipment->created_at->toFormattedDateString() }}</td>
                            <td class="action-buttons">
                                @can('view-shipment-invoices')
                                <a href="{{ url('admin/shipments/shipments/' . $shipment->id) }}"
                                    class="btn btn-icon btn-light text-info btn-lg rounded me-2"
                                    title="View Shipment Invoice">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                                        <path
                                            d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z" />
                                        <path
                                            d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                    </a>
                                @endcan

                                @can('delete-shipment-invoices')
                                <button class="btn btn-icon btn-light text-danger rounded"
                                    data-shipment-id="{{ $shipment->id }}" data-bs-toggle="tooltip"
                                    title="Remove Shipment">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-folder-minus" viewBox="0 0 16 16">
                                        <path
                                            d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z" />
                                        <path d="M11 11.5a.5.5 0 0 1 .5-.5h4a.5.5 0 1 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                        </svg>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
