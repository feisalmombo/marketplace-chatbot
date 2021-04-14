<?php

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Role;
use App\Permission;

class UsersTableSeeder extends Seeder
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


        $dev_permission = Permission::where('slug','create')->first();
        $manager_permission = Permission::where('slug', 'edit')->first();
        $admin_permission = Permission::where('slug', 'delete')->first();
        $staff_permission = Permission::where('slug', 'create')->first();


        $developer = new User();
        $developer->first_name = 'Feisal';
        $developer->last_name = 'Mombo';
        $developer->email = 'feisal.mombo@getpesa.co.tz';
        $developer->phone_number = '255684456287';
        $developer->password = bcrypt('developer');
        $developer->created_at = Carbon::now();
        $developer->updated_at = Carbon::now();
        $developer->save();
        $developer->roles()->attach($dev_role);
        $developer->permissions()->attach($dev_permission);


    }
}

