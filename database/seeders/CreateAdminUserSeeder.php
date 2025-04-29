<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'     => 'admin',
            'email'    => 'admin010055@admin.com',
            'password' => bcrypt('admin010055@admin.com010055'),
            'roles_name' => json_encode(['owner']),
            'Status'   => 'Active',
        ]);
        $role = Role::create(['name' => 'owner']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole($role->id);
    }
}
