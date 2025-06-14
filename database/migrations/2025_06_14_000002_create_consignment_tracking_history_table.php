<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignment_tracking_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consignment_id')->constrained()->onDelete('cascade');
            $table->integer('stage_id');
            $table->string('status')->default('completed'); // completed, in_progress, pending
            $table->text('notes')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Add index for faster queries
            $table->index(['consignment_id', 'stage_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignment_tracking_history');
    }
}; 