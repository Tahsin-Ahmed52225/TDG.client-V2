<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissonSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_employee_permisson = ['CEO', 'Web Developer' , 'Graphices Designer' , 'Manager'];
        foreach ($default_postions as $ele) {
            DB::table('position')->insert([
                'title' => $ele,
            ]);
        }
    }
}
