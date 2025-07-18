<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlterShipsTable extends Migration
{
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->tinyInteger('is_flagged')->default(0)->after('dispatched_by');
            $table->string('flag_reason')->nullable()->after('is_flagged');
            $table->text('flag_notes')->nullable()->after('flag_reason');
        });
    }

    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['is_flagged', 'flag_reason', 'flag_notes']);
        });
    }
}
