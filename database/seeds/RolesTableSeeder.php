<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Role;
use App\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dev_permission = Permission::where('slug','create')->first();
        $manager_permission = Permission::where('slug', 'edit')->first();
        $admin_permission = Permission::where('slug', 'delete')->first();
        $staff_permission = Permission::where('slug', 'create')->first();


        $dev_role = new Role();
        $dev_role->slug = 'developer';
        $dev_role->name = 'Developer';
        $dev_role->save();
        $dev_role->permissions()->attach($dev_permission);

        $manager_role = new Role();
        $manager_role->slug = 'manager';
        $manager_role->name = 'Manager';
        $manager_role->save();
		$manager_role->permissions()->attach($manager_permission);

        $admin_role=new Role();
    	$admin_role->slug = 'administrator';
    	$admin_role->name = 'Administrator';
    	$admin_role->save();
		$admin_role->permissions()->attach($admin_permission);

		$staff_role=new Role();
    	$staff_role->slug = 'staff';
    	$staff_role->name = 'Staff';
    	$staff_role->save();
		$staff_role->permissions()->attach($staff_permission);

    }
}
