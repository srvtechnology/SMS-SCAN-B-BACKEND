<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProjectSetup extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['Manage Roles', 'Manage Users', 'Manage Permissions'];
        $pids = [];
        foreach ($permissions as $key => $permission) {
            $per = new Permission();
            $per->name = $permission;
            $per->save();
            $pids[] = $per->id;
        }

        $role = new Role();
        $role->name = 'SuperAdmin';
        $role->save();


        foreach ($pids as $key => $id) {
            $pr = new PermissionRole();
            $pr->role_id = $role->id;
            $pr->permission_id = $id;
            $pr->save();
        }

        $role = new Role();
        $role->name = 'School Admin';
        $role->save();


        foreach ($pids as $key => $id) {
            $pr = new PermissionRole();
            $pr->role_id = $role->id;
            $pr->permission_id = $id;
            $pr->save();
        }


        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('12345678');
        $user->role_id = 1;
        $user->save();
    }
}
