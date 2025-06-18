<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tracking_stages', function (Blueprint $table) {
            $table->string('cargo_type')->default('air')->after('description');
        });

        // Update existing records to have cargo_type
        DB::table('tracking_stages')
            ->where('order', '<=', 6)
            ->update(['cargo_type' => 'air']);

        DB::table('tracking_stages')
            ->where('order', '>', 6)
            ->update(['cargo_type' => 'sea']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking_stages', function (Blueprint $table) {
            $table->dropColumn('cargo_type');
        });
    }
}; 