<?php

use Faker\Generator as Faker;

$factory->define(\App\Transaction::class, function (Faker $faker) {
    return [
        "provider" => 'paypal',
        "type" => "deposit",
        "amount" => 150,
        "currency" => "EUR",
        "user" => [
            "first_name" => "Bob",
            "last_name" => "Hoskins",
            "gender" => "M",
            "email" => 'mail@mail.test',
            "address" => "Black 12/4",
            "city" => "London",
            "zip" => 12890,
            "country_code" => "GB",
            "birthday" => "1985-05-01"
        ]
    ];
});

$factory->state(\App\Transaction::class, 'invalid', function (Faker $faker) {
    return [
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