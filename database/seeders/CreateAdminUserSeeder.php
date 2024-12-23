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
            'name' => 'FikriDev',
            'username' => 'admin',
            'password' => bcrypt('admin123')
        ]);

        $role = Role::firstOrCreate(['name' => 'Admin']);

        // syncronize permission using tinker
        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole($role->id);
    }
}
