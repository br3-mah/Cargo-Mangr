<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nwc_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->onDelete('cascade');
            $table->string('receipt_number')->unique();
            $table->decimal('rate', 15, 6)->nullable();
            $table->decimal('bill_usd', 15, 2)->nullable();
            $table->decimal('bill_kwacha', 15, 2)->nullable();
            $table->string('method_of_payment')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 15, 2)->default(0);
            $table->timestamps();

            $table->unique('shipment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nwc_receipts');
    }
};
