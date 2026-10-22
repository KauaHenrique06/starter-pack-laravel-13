<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    const PERMISSIONS = [
        // place default permissions here
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::PERMISSIONS as $permission) 
        {
            Permission::updateOrCreate(
                [
                    'name' => $permission['name'], 
                    'guard_name' => $permission['guard_name']
                ],
                [
                    'label' => $permission['label']
                ]
            );
        }
    }
}
