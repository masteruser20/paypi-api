<?php

use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "gender" => $faker->randomElement(['M', 'F']),
        "email" => $faker->unique()->email,
        "address" => $faker->address,
        "city" => $faker->city,
        "zip" => $faker->postcode,
        "country_code" => $faker->countryCode,
        "birthday" => $faker->date()
    ];
});
