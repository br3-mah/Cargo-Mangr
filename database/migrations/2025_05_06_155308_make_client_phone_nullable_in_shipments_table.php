<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeClientPhoneNullableInShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('client_phone')->nullable()->change(); // use string, not unsignedBigInteger
            $table->unsignedBigInteger('from_country_id')->nullable()->change();
            $table->unsignedBigInteger('from_state_id')->nullable()->change();
            $table->unsignedBigInteger('to_country_id')->nullable()->change();
            $table->unsignedBigInteger('to_state_id')->nullable()->change();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            //
        });
    }
}