<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlterShipments2Table extends Migration
{
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dateTime('dispatch_time')->nullable()->after('condition');
            $table->string('next_destination')->nullable()->after('dispatch_time');
            $table->string('dispatched_by')->nullable()->after('next_destination');
        });
    }

    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['dispatch_time', 'next_destination', 'dispatched_by']);
        });
    }
}
