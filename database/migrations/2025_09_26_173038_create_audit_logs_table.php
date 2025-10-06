<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('auditable_id'); // Model ID
            $table->unsignedBigInteger('user_id')->nullable(); // who did the action
            $table->unsignedBigInteger('shipment_id')->nullable(); // who did the action
            $table->unsignedBigInteger('consignment_id')->nullable(); // who did the action
            $table->string('event')->nullable(); // e.g., created, updated, deleted
            $table->string('auditable_type'); // Model class name (e.g., Shipment)
            $table->text('description')->nullable(); // details about the action
            $table->json('old_values')->nullable(); // before changes
            $table->json('new_values')->nullable(); // after changes
            $table->ipAddress('ip_address')->nullable(); // user IP
            $table->string('user_agent')->nullable(); // browser/device
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
        Schema::dropIfExists('audit_logs');
    }
}
