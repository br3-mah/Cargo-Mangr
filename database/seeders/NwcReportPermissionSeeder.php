<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class NwcReportPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = DB::table('permission_groups')
            ->where('name', 'nwc_reports')
            ->first();

        $groupId = $group?->id ?? DB::table('permission_groups')->insertGetId([
            'name' => 'nwc_reports',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $permissions = [
            'view-nwc-reports',
            'export-nwc-reports',
            'share-nwc-reports-email',
            'share-nwc-reports-whatsapp',
        ];

        $createdPermissionNames = [];

        foreach ($permissions as $permission) {
            $permissionModel = Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['permission_group_id' => $groupId]
            );

            $createdPermissionNames[] = $permissionModel->name;
        }

        $adminUsers = User::where('role', 1)->get();

        foreach ($adminUsers as $admin) {
            $admin->givePermissionTo($createdPermissionNames);
        }
    }
}
