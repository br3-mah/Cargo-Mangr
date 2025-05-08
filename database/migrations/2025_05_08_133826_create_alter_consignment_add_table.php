<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlterConsignmentAddTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->date('eta')->nullable();
            $table->date('cargo_date')->nullable();
            $table->enum('cargo_type', ['sea', 'air', 'land', 'virtual', 'other'])->nullable();
            $table->date('eta_dar')->nullable();
            $table->date('eta_nak')->nullable();
            $table->date('eta_lun')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alter_consignment_add');
    }
}