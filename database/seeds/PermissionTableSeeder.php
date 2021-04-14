<?php

use Illuminate\Database\Seeder;
use App\Permissions\HasPermissionsTrait;
use App\Role;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dev_role = Role::where('slug', 'developer')->first();
        $manager_role = Role::where('slug', 'manager')->first();
        $admin_role = Role::where('slug',  'administrator')->first();
        $staff_role = Role::where('slug',  'staff')->first();

        $createUsers = new Permission();
        $createUsers->slug = 'create';
        $createUsers->name = 'Create';
        $createUsers->save();
        $createUsers->roles()->attach($dev_role);

        $editUsers = new Permission();
        $editUsers->slug = 'edit';
        $editUsers->name = 'Edit';
        $editUsers->save();
        $editUsers->roles()->attach($manager_role);

        $deleteUsers = new Permission();
        $deleteUsers->slug = 'delete';
        $deleteUsers->name = 'Delete';
        $deleteUsers->save();
        $deleteUsers->roles()->attach($admin_role);

        $create = new Permission();
        $create->slug = 'create';
        $create->name = 'Create';
        $create->save();
        $create->roles()->attach($staff_role);

    }
}
