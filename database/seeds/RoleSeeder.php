<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_roles = [
            ['Admin','admin'],
            ['Employee','employee'],
            ['Manager','manager'],
        ];
        foreach ($default_roles as $ele) {
            DB::table('role')->insert([
                'title' => $ele[0],
                'slug' => $ele[1]
            ]);
        }
    }
}
