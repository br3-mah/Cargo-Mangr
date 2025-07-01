<button id="printBtn" onclick="printReceipt()" class="btnclicky btn btn-sm btn-light text-dark me-2">
    <i class="bi bi-receipt-cutoff"></i>
    <span id="printBtnText">Print Receipt</span>
    <span id="printSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
</button>
<div id="receiptContent" style="display:none;">
    <div style="font-family: monospace; width: 58mm; padding: 10px;">
        <div style="text-align: center;">
            <img src="https://app.newworldcargo.com/assets/lte/cargo-logo.svg" alt="New World Cargo Logo" style="max-width: 100px; margin-bottom: 5px;">
            <h3 style="margin: 0;">Newworld Cargo Limited </h3>
            <p style="font-size: 11px; margin: 2px 0;">TPIN.: 2001344196</p>
            <p style="font-size: 11px; margin: 2px 0;">Shop 62/A, Carousel Shopping Centre</p>
            <p style="font-size: 11px; margin: 2px 0;">Lusaka, Zambia</p>
            <p style="font-size: 11px; margin: 2px 0;">+260 763 297 287 | +260 763 313 193</p>
            <p style="font-size: 11px; margin: 2px 0;">info@newworldcargo.com</p>
        </div>

        <hr />
        <p>Date: {{ now()->format('Y-m-d H:i') }}</p>
        <p>Shipment ID: {{ $shipment->code }}</p>
        <p>Customer: {{ $shipment->client->name ?? '-' }}</p>
        <p>Receipt No.: {{ $shipment?->receipt?->receipt_number ?? '-' }}</p>

        <hr />
        <p><strong>Items:</strong></p>
        @foreach(Modules\Cargo\Entities\PackageShipment::where('shipment_id',$shipment->id)->get() as $package)
            <p>
                {{ $package->description }} x{{ $package->qty }}<br>
                @if(isset($package->package->name))
                    {{ json_decode($package->package->name, true)[app()->getLocale()] ?? '-' }}
                @else
                    -
                @endif
            </p>
        @endforeach

        <hr />
        <p><strong>Shipment Logs:</strong></p>
        @foreach($shipment->logs()->orderBy('id','desc')->get() as $log)
            <p>
                {{ $log->created_at->format('Y-m-d H:i') }}<br>
                {{ __('cargo::view.changed_from') }}:
                "{{ Modules\Cargo\Entities\Shipment::getStatusByStatusId($log->from) }}"
                {{ __('cargo::view.to') }}:
                "{{ Modules\Cargo\Entities\Shipment::getStatusByStatusId($log->to) }}"
            </p>
        @endforeach

        <hr />
        <p>Total: <strong>{{ format_price($shipment?->receipt?->total ) }}</strong></p>
        <p style="text-align:center;">Thank you!</p>
    </div>
</div>

<script>
    function printReceipt() {
        const btn = document.getElementById("printBtn");
        const btnText = document.getElementById("printBtnText");
        const spinner = document.getElementById("printSpinner");

        // Disable the button and show spinner
        btn.disabled = true;
        spinner.classList.remove("d-none");
        btnText.textContent = "Printing...";

        const receipt = document.getElementById("receiptContent").innerHTML;
        const printWindow = window.open('', '', 'width=300,height=600');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Receipt</title>
                    <style>
                        body { font-family: monospace; font-size: 12px; width: 58mm; padding: 0; margin: 0; }
                        h3 { margin: 0; padding: 5px 0; text-align: center; }
                        p { margin: 2px 0; line-height: 1.2em; }
                        hr { border: none; border-top: 1px dashed #000; margin: 5px 0; }
                    </style>
                </head>
                <body onload="window.print(); setTimeout(() => window.close(), 500);">
                    ${receipt}
                </body>
            </html>
        `);
        printWindow.document.close();

        // Re-enable the button after 2 seconds (or longer if needed)
        setTimeout(() => {
            btn.disabled = false;
            spinner.classList.add("d-none");
            btnText.textContent = "Print Receipt";
        }, 2000);
    }
    </script>
