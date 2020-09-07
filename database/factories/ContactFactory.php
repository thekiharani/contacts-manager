<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->name,
        'phone_number' => $faker->unique()->e164PhoneNumber,
    ];
});
