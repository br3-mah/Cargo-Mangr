<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('consignment_code')->unique();
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('source')->nullable();
            $table->string('destination')->nullable();
            $table->string('released_by')->nullable();
            $table->enum('status', ['pending','dispatched', 'in_transit', 'delivered', 'canceled'])->default('pending');
            $table->string('tracker')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignments');
    }
}