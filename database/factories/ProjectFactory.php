<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return[
        'title' => $faker->name,
        'created_by' => User::all()->random()->id,
        'due_date' => $faker->unixTime(new DateTime('+3 weeks')),
        'status' =>  $faker->randomElement(["todo","running","complete","stopped"]),
        'priority' => $faker->randomElement(["high","medium","low"]),
        'description' => $faker->text('200'),
        'type' => $faker->randomElement(["rnd","inhouse"]),
    ];
});
