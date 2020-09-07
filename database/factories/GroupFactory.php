<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->company,
        'description' => $faker->text,
    ];
});
