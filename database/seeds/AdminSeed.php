<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

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
            'password' => Hash::make('1122334455'),
        ]);
    }
}
