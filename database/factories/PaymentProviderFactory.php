<?php

use Faker\Generator as Faker;

$factory->define(App\PaymentProvider::class,  function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'label' => $faker->name,
        'types' => [
            'deposit',
            'withdraw'
        ],
        'additional_data' => [
            [
                'name' => 'username',
                'label' => 'User name',
                'type' => 'text',
                'required' => true
            ],
            [
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
                'required' => true
            ]
        ]
    ];
});
