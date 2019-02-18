<?php

namespace Tests\Unit;

use App\Transaction;
use App\User;
use Faker\Factory;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_should_create_transaction_with_updated_associated_user()
    {
        $transactionData = factory(Transaction::class)->make()->toArray();
        $faker = Factory::create();
        $email = $faker->email;
        $userData = [
            'first_name' => $transactionData['user']['first_name'],
            'last_name' => $transactionData['user']['last_name'],
            'gender' => $transactionData['user']['gender'],
            'email' => $email,
            'address' => $transactionData['user']['address'],
            'city' => $transactionData['user']['city'],
            'zip' => $transactionData['user']['zip'],
            'country_code' => $transactionData['user']['country_code'],
            'birthday' => $transactionData['user']['birthday'],
        ];

        $user = User::insert($userData);

        $this->assertTrue($user);

        $user = User::updateOrCreate(
            ['email' => $email],
            $userData
        );

        $this->assertFalse($user->wasRecentlyCreated);

        $transaction = $user->addTransaction($transactionData);
        $transaction->load('user');

        $this->assertEquals($transaction->user->id, $user->id);
    }
}
