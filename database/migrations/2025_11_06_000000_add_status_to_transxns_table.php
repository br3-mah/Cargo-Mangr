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
        Schema::table('transxns', function (Blueprint $table) {
            $table->string('status')->default('completed')->after('total');
            $table->timestamp('refunded_at')->nullable()->after('status');
            $table->string('refund_reason')->nullable()->after('refunded_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transxns', function (Blueprint $table) {
            $table->dropColumn(['status', 'refunded_at', 'refund_reason']);
        });
    }
};