<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrateExistingPaymentsForMultiplePaymentSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This migration script would be run after the main changes are deployed
        // It creates shipment_payment_receipt records for existing nwc_receipt entries
        // to maintain data compatibility
        
        // First, make sure the shipment_payment_receipts table exists (this should be run after the first migration)
        $tableExists = DB::getSchemaBuilder()->hasTable('shipment_payment_receipts');
        
        if (!$tableExists) {
            return; // Skip if table doesn't exist yet
        }
        
        // Process existing nwc_receipts that don't have corresponding shipment_payment_receipts
        $nwcReceipts = DB::table('nwc_receipts')
            ->join('transxns', 'nwc_receipts.shipment_id', '=', 'transxns.shipment_id')
            ->select('nwc_receipts.*', 'transxns.total as transxn_total')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('shipment_payment_receipts')
                      ->whereColumn('shipment_payment_receipts.shipment_id', 'nwc_receipts.shipment_id');
            })
            ->get();
            
        foreach ($nwcReceipts as $receipt) {
            // Create a payment record based on the existing receipt
            // For backward compatibility, we'll use the total from the transxn record
            DB::table('shipment_payment_receipts')->insert([
                'shipment_id' => $receipt->shipment_id,
                'method_of_payment' => $receipt->method_of_payment,
                'amount' => $receipt->transxn_total,
                'receipt_number' => $receipt->receipt_number . '-1',
                'cashier_name' => $receipt->cashier_name,
                'user_id' => $receipt->user_id,
                'created_at' => $receipt->created_at,
                'updated_at' => $receipt->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This is a one-way migration for data compatibility
        // We don't reverse it to avoid losing data
    }
}