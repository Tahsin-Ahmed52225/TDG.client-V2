<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProjectAssigns;
use Faker\Generator as Faker;

# Custom model
use App\Models\User;
use App\Models\Project;

$factory->define(ProjectAssigns::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'project_id' => Project::all()->random()->id,
    ];
});
