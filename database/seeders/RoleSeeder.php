<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    const ROLES = [
        ['name' => 'admin', 'guard_name' => 'api', 'label' => 'Administrator'],
        ['name' => 'client', 'guard_name' => 'api', 'label' => 'Client'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(self::ROLES as $role) 
        {
            Role::updateOrCreate(
                [
                    'name' => $role['name'],
                    'guard_name' => $role['guard_name'],
                ],
                [
                    'label' => $role['label']
                ]
            );
        }

        // Sync all permissions to admin
        Role::findByName('admin', 'api')
            ->syncPermissions(Permission::where('guard_name', 'api'));
    }
}
