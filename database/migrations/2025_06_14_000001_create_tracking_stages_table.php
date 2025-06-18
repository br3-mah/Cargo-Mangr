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
            $table->string('cargo_type')->default('air'); // 'air' or 'sea'
            $table->enum('status', ['PENDING', 'IN_TRANSIT', 'DELIVERED', 'DEFAULTED'])->default('PENDING');
            $table->integer('order')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default tracking stages for air cargo
        DB::table('tracking_stages')->insert([
            [
                'name' => 'Processing',
                'description' => 'Parcel received and is being processed',
                'cargo_type' => 'air',
                'status' => 'PENDING',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dispatched',
                'description' => 'Parcel dispatched from China',
                'cargo_type' => 'air',
                'status' => 'IN_TRANSIT',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'In Transit',
                'description' => 'Parcel has arrived at the transit Airport',
                'cargo_type' => 'air',
                'status' => 'IN_TRANSIT',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Departing',
                'description' => 'Parcel has departed from the Transit Airport to Lusaka Airport',
                'cargo_type' => 'air',
                'status' => 'IN_TRANSIT',
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Arrived',
                'description' => 'Parcel has arrived at the Airport in Lusaka, Customs Clearance in progress',
                'cargo_type' => 'air',
                'status' => 'IN_TRANSIT',
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ready',
                'description' => 'Parcel is now ready for collection in Lusaka at the Main Branch',
                'cargo_type' => 'air',
                'status' => 'DELIVERED',
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Insert default tracking stages for sea cargo
        DB::table('tracking_stages')->insert([
            [
                'name' => 'Processing',
                'description' => 'Parcel received and is being processed',
                'cargo_type' => 'sea',
                'status' => 'PENDING',
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dispatched',
                'description' => 'Parcel dispatched from China',
                'cargo_type' => 'sea',
                'status' => 'IN_TRANSIT',
                'order' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'In Transit',
                'description' => 'The Parcel has arrived at the transit Sea port',
                'cargo_type' => 'sea',
                'status' => 'IN_TRANSIT',
                'order' => 9,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Departing',
                'description' => 'The parcel has departed from the transit Sea port headed for Dar Es Salaam',
                'cargo_type' => 'sea',
                'status' => 'IN_TRANSIT',
                'order' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Arrived Port',
                'description' => 'The parcel has arrived at the port in Dar es Salaam',
                'cargo_type' => 'sea',
                'status' => 'IN_TRANSIT',
                'order' => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Border Transit',
                'description' => 'The parcel has left the port headed for the Nakonde Border',
                'cargo_type' => 'sea',
                'status' => 'IN_TRANSIT',
                'order' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Border Clearance',
                'description' => 'The Parcel has arrived at the Nakonde Border, waiting for clearance',
                'cargo_type' => 'sea',
                'status' => 'IN_TRANSIT',
                'order' => 13,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'In Transit to Lusaka',
                'description' => 'The Parcel has been cleared from Nakonde and is headed for Lusaka',
                'cargo_type' => 'sea',
                'status' => 'IN_TRANSIT',
                'order' => 14,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ready for Collection',
                'description' => 'The Parcel is now ready for collection in Lusaka at our warehouse',
                'cargo_type' => 'sea',
                'status' => 'DELIVERED',
                'order' => 15,
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