<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionsToRolesSeeder extends Seeder
{
    
    public function run(): void
    {
        $adminRole = Role::findByName('ADMIN', 'web');
        $permissions = Permission::whereIn('name', ['VER', 'ACTUALIZAR', 'ELIMINAR', 'ENVIAR'])->get();
        $adminRole->givePermissionTo($permissions);

        $userRole = Role::findByName('PACIENTE', 'web');
        $userPermissions = Permission::whereIn('name', ['VER'])->get();
        $userRole->givePermissionTo($userPermissions);

        $markRole = Role::findByName('MARKETING', 'web');
        $markPermissions = Permission::whereIn('name', ['VER', 'ACTUALIZAR'])->get();
        $markRole->givePermissionTo($markPermissions);
    }
}
