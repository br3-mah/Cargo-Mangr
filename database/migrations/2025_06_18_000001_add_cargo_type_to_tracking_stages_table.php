<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCargoTypeToTrackingStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracking_stages', function (Blueprint $table) {
            $table->enum('status', ['PENDING', 'IN_TRANSIT', 'DELIVERED', 'DEFAULTED'])->default('PENDING')->after('cargo_type');
        });

        // Update existing records with appropriate statuses
        DB::table('tracking_stages')->where('order', 1)->update(['status' => 'PENDING']);
        DB::table('tracking_stages')->whereIn('order', [2, 3, 4, 5])->update(['status' => 'IN_TRANSIT']);
        DB::table('tracking_stages')->where('order', 6)->update(['status' => 'DELIVERED']);
        
        // For sea cargo
        DB::table('tracking_stages')->where('order', 7)->update(['status' => 'PENDING']);
        DB::table('tracking_stages')->whereIn('order', [8, 9, 10, 11, 12, 13, 14])->update(['status' => 'IN_TRANSIT']);
        DB::table('tracking_stages')->where('order', 15)->update(['status' => 'DELIVERED']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracking_stages', function (Blueprint $table) {
            $table->dropColumn('cargo_type');
            $table->dropColumn('status');
        });
    }
} 