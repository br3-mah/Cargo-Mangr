<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlterShipmentsTable extends Migration
{
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dateTime('received_at')->nullable()->after('updated_at');
            $table->string('condition')->nullable()->after('received_at');
        });
    }

    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['received_at', 'condition']);
        });
    }
}
