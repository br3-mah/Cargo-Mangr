<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update all existing transactions to have 'completed' status since they were all completed before
        DB::table('transxns')
            ->whereNull('status')
            ->update(['status' => 'completed']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No need to revert since we're just setting default values
    }
};