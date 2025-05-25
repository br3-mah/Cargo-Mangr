<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert into permission_groups table
        $permissionGroupId = DB::table('permission_groups')->insertGetId([
            'name' => 'finances',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Permissions to insert
        $permissions = [
            'access-finance-transactions',
            'view-total-to-date-transactions',
            'view-total-today-transactions',
            'view-total-yesterday-transactions',
            'view-total-this-week-transactions',
            'view-total-this-month-transactions',
            'view-total-this-year-transactions',
        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroupId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
