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
        Schema::table('nwc_receipts', function (Blueprint $table) {
            $table->string('cashier_name')->nullable()->after('discount_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nwc_receipts', function (Blueprint $table) {
            $table->dropColumn('cashier_name');
        });
    }
};
