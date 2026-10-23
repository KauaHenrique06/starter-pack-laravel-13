<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    const PERMISSIONS = [
        ['name' => 'user.create', 'guard_name' => 'api', 'label' => 'Create user'],
        ['name' => 'user.view', 'guard_name' => 'api', 'label' => 'View user'],
        ['name' => 'user.update', 'guard_name' => 'api', 'label' => 'Update user'],
        ['name' => 'user.delete', 'guard_name' => 'api', 'label' => 'Delete user'],
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
