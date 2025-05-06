<div class="w-full">
    <div class="row">
        <div id="column3" class="col-md-12 px-6">
            <p class="text-muted text-sm">Mawb Number: {{ $consignment->Mawb_num }}</p>

            <table id="shipmentTable" class="table table-striped table-bordered">
                <thead>
                    <tr class="text-sm">
                        <th><i class="bi bi-upc-scan me-1"></i> Hawb No.</th>
                        <th><i class="bi bi-box me-1"></i> Type</th>
                        <th><i class="bi bi-building me-1"></i> Branch</th>
                        <th><i class="bi bi-person me-1"></i> Client</th>
                        <th><i class="bi bi-file me-1"></i> Package Description</th>
                        <th><i class="bi bi-telephone me-1"></i> Client Phone</th>
                        <th><i class="bi bi-currency-dollar me-1"></i> Cost</th>
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
                            @foreach(Modules\Cargo\Entities\PackageShipment::where('shipment_id',$shipment->id)->get() as $package)
                                {{$package->description}}
                            @endforeach
                        </td>
                        <td>{{ $shipment->client_phone ?? 'No phone' }}</td>
                        <td>{{ $shipment->shipping_cost }}</td>
                        <td>{{ $shipment->created_at->toFormattedDateString() }}</td>
                        <td class="action-buttons">
                            <a href="{{ url('admin/shipments/shipments/'.$shipment->id) }}"
                               class="btn btn-icon btn-light text-info btn-lg rounded me-2"

                               title="View Shipment">
                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                              </svg>
                            </a>

                            <button class="btn btn-icon btn-light text-danger rounded"
                                    data-shipment-id="{{ $shipment->id }}"
                                    data-bs-toggle="tooltip"
                                    title="Remove Shipment">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-minus" viewBox="0 0 16 16">
                                        <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z"/>
                                        <path d="M11 11.5a.5.5 0 0 1 .5-.5h4a.5.5 0 1 1 0 1h-4a.5.5 0 0 1-.5-.5"/>
                                      </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
