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
        if (Schema::hasTable('clients') && !Schema::hasColumn('clients', 'avatar')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->text('avatar')->nullable();
            });
        }

        if (Schema::hasTable('drivers') && !Schema::hasColumn('drivers', 'avatar')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->text('avatar')->nullable();
            });
        }

        if (Schema::hasTable('staffs') && !Schema::hasColumn('staffs', 'avatar')) {
            Schema::table('staffs', function (Blueprint $table) {
                $table->text('avatar')->nullable();
            });
        }

        if (Schema::hasTable('branches') && !Schema::hasColumn('branches', 'avatar')) {
            Schema::table('branches', function (Blueprint $table) {
                $table->text('avatar')->nullable();
            });
        }
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