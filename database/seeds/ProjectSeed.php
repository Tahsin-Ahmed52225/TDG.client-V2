<?php

use Illuminate\Database\Seeder;

use App\Models\Project;

class ProjectSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating a global project instance
        $project = Project::create([
            'title' => 'Global',
        ]);
    }
}
