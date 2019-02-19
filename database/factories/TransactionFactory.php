<?php

use Faker\Generator as Faker;

$factory->define(\App\Transaction::class, function (Faker $faker) {
    return [
        "provider_id" => $faker->randomElement(\App\PaymentProvider::select('id')->get()->pluck('id')),
        "type" => $faker->randomElement(['deposit', 'withdraw']),
        "amount" => $faker->randomFloat(2, -1000000,1000000),
        "currency" => $faker->currencyCode,
        "user" => [
            "first_name" => $faker->firstName,
            "last_name" => $faker->lastName,
            "gender" => $faker->randomElement(['M', 'F']),
            "email" => $faker->email,
            "address" => $faker->address,
            "city" => $faker->city,
            "zip" => $faker->postcode,
            "country_code" => $faker->countryCode,
            "birthday" => $faker->date()
        ]
    ];
});

$factory->state(\App\Transaction::class, 'invalid', function (Faker $faker) {
    return [
        "provider_id" => null,
        "provider" => null,
        "type" => "deposit",
        "amount" => "tewt",
        "currency" => "EUR",
        "user" => [
            "first_name" => "Bob",
            "last_name" => "Hoskins",
            "gender" => "M",
            "email" => null,
            "address" => "Black 12/4",
            "city" => "London",
            "zip" => 12890,
            "country_code" => "GB",
            "birthday" => "1985-05-01"
        ]
    ];
});
