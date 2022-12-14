<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissonSeed::class);
        $this->call(RoleSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(AdminSeed::class);
        $this->call(UserSeeder::class);
        $this->call(ProjectSeed::class);

    }
}
