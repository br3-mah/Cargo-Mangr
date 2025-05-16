<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Cargo\Entities\Shipment;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ShipmentExport implements FromCollection
{
    protected $data;
    public function __construct($request)
    {
        $this->data = $request;
    }

    public function collection()
    {
        return Shipment::with('consignment', 'client')
            ->where('id', $this->data->consignment_id)
            ->get()
            ->map(function ($shipment) {
                return [
                    // Consignment headers
                    optional($shipment->consignment)->consignment_code,
                    optional($shipment->consignment)->name,
                    optional($shipment->consignment)->desc,
                    optional($shipment->consignment)->source,
                    optional($shipment->consignment)->destination,
                    optional($shipment->consignment)->status,
                    optional($shipment->consignment)->tracker,
                    optional($shipment->consignment)->consignee,
                    optional($shipment->consignment)->job_num,
                    optional($shipment->consignment)->mawb_num,
                    optional($shipment->consignment)->handler,

                    // Shipment row
                    $shipment->code,
                    $shipment->client_id,
                    $shipment->branch_id,
                    $shipment->type,
                    $shipment->status_id,
                    $shipment->client_status,
                    $shipment->from_country_id,
                    $shipment->from_state_id,
                    $shipment->to_country_id,
                    $shipment->to_state_id,
                    $shipment->shipping_date,
                    $shipment->total_weight,
                    $shipment->amount_to_be_collected,
                    $shipment->client_address,
                    $shipment->client_phone,
                ];
            });
    }

    public function headings(): array
    {
        return [
            // Consignment
            'Consignment Code', 'Name', 'Description', 'Source', 'Destination', 'Status', 'Tracker',
            'Consignee', 'Job Number', 'MAWB Number', 'Handler',

            // Shipment
            'Code', 'Client ID', 'Branch ID', 'Type', 'Status ID', 'Client Status',
            'From Country', 'From State', 'To Country', 'To State',
            'Shipping Date', 'Total Weight', 'Total Cost', 'Client Address', 'Client Phone'
        ];
    }

}
