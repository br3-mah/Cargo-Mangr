<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTrackingStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->integer('order')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default tracking stages
        DB::table('tracking_stages')->insert([
            [
                'name' => 'Processing',
                'description' => 'Parcel received and is being processed',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dispatched',
                'description' => 'Parcel dispatched from China',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'In Transit',
                'description' => 'Parcel has arrived at the transit Airport',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Departing',
                'description' => 'Parcel has departed from the Transit Airport to Lusaka Airport',
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Arrived',
                'description' => 'Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress',
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ready',
                'description' => 'Parcel is now ready for collection in Lusaka at the Main Branch',
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_stages');
    }
} 