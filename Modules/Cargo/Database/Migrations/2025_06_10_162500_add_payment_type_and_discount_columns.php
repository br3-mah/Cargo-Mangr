<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentTypeAndDiscountColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('type')->default('payment')->after('payment_date');
            $table->string('discount_type')->nullable()->after('type');
            $table->decimal('discount_value', 10, 2)->default(0)->after('discount_type');
            $table->text('notes')->nullable()->after('discount_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['type', 'discount_type', 'discount_value', 'notes']);
        });
    }
} 