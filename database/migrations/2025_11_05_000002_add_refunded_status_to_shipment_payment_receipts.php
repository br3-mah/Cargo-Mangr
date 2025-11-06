<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundedStatusToShipmentPaymentReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipment_payment_receipts', function (Blueprint $table) {
            $table->boolean('refunded')->default(false)->after('amount');
            $table->timestamp('refunded_at')->nullable()->after('refunded');
            $table->string('refund_reason')->nullable()->after('refunded_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment_payment_receipts', function (Blueprint $table) {
            $table->dropColumn(['refunded', 'refunded_at', 'refund_reason']);
        });
    }
}