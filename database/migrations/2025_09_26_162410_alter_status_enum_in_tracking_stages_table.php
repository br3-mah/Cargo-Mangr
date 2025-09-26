<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStatusEnumInTrackingStagesTable extends Migration
{
    public function up()
    {
        Schema::table('tracking_stages', function (Blueprint $table) {
            $table->string('status')->default('PENDING')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tracking_stages', function (Blueprint $table) {
            $table->enum('status', ['PENDING', 'IN_TRANSIT', 'DELIVERED', 'DEFAULTED'])
                  ->default('PENDING')
                  ->change();
        });
    }
    
    
}
