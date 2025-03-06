<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlterClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->text('avatar')->nullable();
        });
        Schema::table('drivers', function (Blueprint $table) {
            $table->text('avatar')->nullable();
        });
        Schema::table('staffs', function (Blueprint $table) {
            $table->text('avatar')->nullable();
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->text('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alter_clients');
    }
}