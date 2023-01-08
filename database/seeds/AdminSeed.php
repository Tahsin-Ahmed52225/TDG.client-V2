<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                    'name' => 'Admin',
                    'email' => 'admin@tdg.com',
                    'phone' => '1111111',
                    'image' => null,
                    'position_id' => 1,
                    'role_id' => 1,
                    'email_verified' => 1,
                    'verification_code' => null,
                    'stage' => 1,
                    'password' => Hash::make('11223344'),
                ]);
        $user = User::where('role_id', 1)->first();

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();



        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);


    }
}
