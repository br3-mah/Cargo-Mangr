<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->string('voyage_no')->nullable();
            $table->date('date')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('shipping_line')->nullable();
            $table->date('arrival_date')->nullable();
        });
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('dest_port')->nullable();
            $table->string('salesman')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consignments', function (Blueprint $table) {
            //
        });
    }
}