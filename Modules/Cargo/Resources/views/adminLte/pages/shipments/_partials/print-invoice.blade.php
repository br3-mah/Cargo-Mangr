
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#0f4c81',
                        'primary-light': '#dbeafe',
                    }
                },
                fontFamily: {
                    'sans': ['Roboto', 'sans-serif'],
                }
            }
        }
    </script>
    <div id="printable-invoice" class="hidden print:block max-w-4xl mx-auto my-5 bg-white shadow-md rounded-lg p-8 relative">
        <!-- Watermark -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 -rotate-45 text-8xl text-gray-900/[0.03] pointer-events-none z-0 whitespace-nowrap">
            NEWWORLD CARGO LIMITED
        </div>

        <!-- Header -->
        <div class="flex justify-between items-center pb-5 border-b-2 border-primary mb-6 relative z-10">
            <div class="flex items-center">
                <div class="w-20 h-20 bg-primary rounded-full flex justify-center items-center text-white font-bold text-2xl mr-4">
                    NC
                </div>
                <div class="leading-relaxed">
                    <div class="text-xl font-bold text-primary">NEWWORLD CARGO</div>
                    <div>Global Logistics Solutions</div>
                    <div>+1 (555) 123-4567 | info@newworldcargo.com</div>
                    <div>123 Shipping Lane, Port City, PC 12345</div>
                </div>
            </div>

            <div class="text-right">
                <div class="text-2xl font-bold text-primary mb-1">SHIPMENT INVOICE</div>
                <div class="inline-block px-3 py-1 bg-gray-200 rounded text-gray-600 font-medium">
                    {{ $shipment->code }}
                </div>
            </div>
        </div>

        <!-- Info Container -->
        <div class="flex justify-between gap-4 mb-6">
            <!-- Sender Box -->
            <div class="w-1/2 p-5 bg-gray-50 rounded-md border-l-4 border-primary">
                <div class="text-base font-semibold mb-2 text-primary uppercase tracking-wider">Sender Information</div>
                <div class="leading-8">
                    <div><span class="font-semibold inline-block w-24">Name:</span> {{ $shipment->client->name ?? 'N/A' }}</div>
                    <div><span class="font-semibold inline-block w-24">Phone:</span> {{ $shipment->client_phone }}</div>
                    <div><span class="font-semibold inline-block w-24">Address:</span> {{ $shipment->from_address->address ?? 'N/A' }}</div>
                </div>
            </div>

            <!-- Receiver Box -->
            <div class="w-1/2 p-5 bg-gray-50 rounded-md border-l-4 border-primary">
                <div class="text-base font-semibold mb-2 text-primary uppercase tracking-wider">Receiver Information</div>
                <div class="leading-8">
                    <div><span class="font-semibold inline-block w-24">Destination:</span> {{ $shipment->consignment->destination }}</div>
                    <div><span class="font-semibold inline-block w-24">Status:</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium uppercase bg-blue-100 text-blue-800">
                            {{ $shipment->getStatus() }}
                        </span>
                    </div>
                    <div><span class="font-semibold inline-block w-24">Date:</span> {{ $shipment->created_at->format('F j, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Shipment Summary -->
        <div class="bg-gray-50 p-5 rounded-md mb-6">
            <div class="text-base font-semibold mb-4 text-primary uppercase tracking-wider border-b border-gray-300 pb-2">
                Shipment Summary
            </div>
            <div class="flex flex-wrap">
                <div class="w-1/3 mb-3">
                    <div><span class="font-semibold inline-block w-24">Type:</span> {{ $shipment->type }}</div>
                    <div><span class="font-semibold inline-block w-24">Cargo:</span> {{ $shipment->consignment->cargo_type ?? 'Sea' }} Freight</div>
                    <div><span class="font-semibold inline-block w-24">Branch:</span> {{ $shipment->branch->name ?? 'N/A' }}</div>
                    <div><span class="font-semibold inline-block w-24">Ship Date:</span>
                        @if(strpos($shipment->shipping_date, '/'))
                            {{ Carbon\Carbon::createFromFormat('d/m/Y', $shipment->shipping_date)->format('F j, Y') }}
                        @else
                            {{ \Carbon\Carbon::parse($shipment->shipping_date)->format('F j, Y') }}
                        @endif
                    </div>
                </div>

                <div class="w-1/3 mb-3">
                    @if ($shipment->prev_branch)
                        <div><span class="font-semibold inline-block w-24">Prev Branch:</span> {{ Modules\Cargo\Entities\Branch::find($shipment->prev_branch)->name ?? 'N/A' }}</div>
                    @endif
                    <div><span class="font-semibold inline-block w-24">Weight:</span> {{ $shipment->total_weight }} KG</div>
                    <div><span class="font-semibold inline-block w-24">Tax:</span> {{ format_price($shipment->tax) }}</div>
                    <div><span class="font-semibold inline-block w-24">Collection:</span> {{ format_price($shipment->amount_to_be_collected ?? 0) }}</div>
                </div>

                <div class="w-1/3 mb-3">
                    <div><span class="font-semibold inline-block w-24">Cargo Date:</span> {{ optional($shipment->consignment->cargo_date)->format('F j, Y') ?? 'N/A' }}</div>
                    <div><span class="font-semibold inline-block w-24">ETA:</span> {{ optional($shipment->consignment->eta)->format('F j, Y') ?? 'N/A' }}</div>
                    @if ($shipment->consignment->cargo_type == 'sea')
                        <div><span class="font-semibold inline-block w-24">ETA DAR:</span> {{ optional($shipment->consignment->eta_dar)->format('F j, Y') ?? 'N/A' }}</div>
                        <div><span class="font-semibold inline-block w-24">ETA LUN:</span> {{ optional($shipment->consignment->eta_lun)->format('F j, Y') ?? 'N/A' }}</div>
                    @endif
                </div>
            </div>

            <div class="flex items-center mt-4">
                @if ($shipment->consignment->cargo_type == 'air')
                    <div class="text-4xl text-primary">✈️</div>
                    <span class="ml-2 font-medium">Air Freight</span>
                @else
                    <div class="text-4xl text-primary">🚢</div>
                    <span class="ml-2 font-medium">Sea Freight</span>
                @endif
            </div>
        </div>

        <!-- Package Items -->
        <div class="text-base font-semibold mb-4 text-primary uppercase tracking-wider">Package Items</div>
        <div class="overflow-x-auto mb-6">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="bg-primary text-white font-medium text-left py-3 px-4 rounded-tl-md">Description</th>
                        <th class="bg-primary text-white font-medium text-center py-3 px-4">Packing (CTN)</th>
                        <th class="bg-primary text-white font-medium text-right py-3 px-4 rounded-tr-md">Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(Modules\Cargo\Entities\PackageShipment::where('shipment_id',$shipment->id)->get() as $package)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                            <td class="py-3 px-4 border-b border-gray-200">{{ $package->description }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 text-center">{{ $package->qty }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 text-right">
                                @if(isset($package->package->name))
                                    {{ json_decode($package->package->name, true)[app()->getLocale()] ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="w-80 ml-auto border border-gray-200 rounded-md overflow-hidden mb-6">
            <div class="flex justify-between px-4 py-2 border-b border-gray-200">
                <div>Subtotal:</div>
                <div>${{ number_format(($shipment->amount_to_be_collected ?? 0) - ($shipment->tax ?? 0), 2) }}</div>
            </div>
            <div class="flex justify-between px-4 py-2 border-b border-gray-200">
                <div>Tax:</div>
                <div>{{ format_price($shipment->tax) }}</div>
            </div>
            <div class="flex justify-between px-4 py-2 bg-primary text-white font-semibold">
                <div>TOTAL:</div>
                <div>{{ format_price($shipment->amount_to_be_collected ?? 0) }}</div>
            </div>
        </div>

        <!-- Barcode -->
        <div class="text-center mb-5">
            <div class="w-20 h-20 bg-gray-100 mx-auto flex justify-center items-center text-gray-400 text-xs text-center">
                QR Code<br/>{{ $shipment->code }}
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-5 pt-5 border-t border-gray-200 text-sm text-gray-500">
            <p>This is an official document issued by Newworld Cargo Ltd.</p>
            <p>For inquiries, please contact customer service at +1 (555) 123-4567 or support@newworldcargo.com</p>
            <p class="font-semibold">Generated on: {{ now()->format('F j, Y, g:i a') }}</p>
        </div>
    </div>

<script>
    function printInvoice() {
        let printContent = document.getElementById('printable-invoice').innerHTML;
        let originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload(); // reload the page to restore JS functionality
    }
</script>
    <style>
        @media print {
            body {
                background-color: white;
            }
            #printable-invoice {
                box-shadow: none;
                margin: 0;
                padding: 20px;
                max-width: 100%;
            }
        }
    </style>
