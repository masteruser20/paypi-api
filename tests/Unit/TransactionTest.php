<?php

namespace Tests\Unit;

use App\PaymentProvider;
use App\Transaction;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Artisan::call('db:seed');
    }

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

    /**
     * @return void
     * @test
     */
    public function it_should_test_paginated_results()
    {
        $this->generateTransactions(20, ['success', 'failed']);

        $status = 'success';
        $page = 2;
        $limit = 1;
        $orderId = 'asc';
        $response = $this->get("/api/transactions?filters[status]=$status&page=$page&limit=$limit&order[id]=$orderId");
        $responseContent = $response->json();
        $pagination = $responseContent['pagination'];

        $transactionsCount = Transaction::where('status', $status)
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get()
            ->count();

        $this->assertCount($transactionsCount, $responseContent['data']);
        if (!isset($responseContent['data'][0])) {
            dd(Transaction::where('status', $status)->get());
        }
        $this->assertEquals($status, $responseContent['data'][0]['status']);
        $this->assertEquals($page, $pagination['page']);
        $this->assertEquals($limit, $pagination['limit']);
        $this->assertEquals($orderId, $pagination['order']['id']);

    }

    private function generateTransactions(int $count, $statuses = Transaction::STATUSES)
    {
        $faker = Factory::create();
        foreach (range(1, $count) as $index) {
            $transaction = new Transaction([
                "provider_id" => $faker->randomElement(\App\PaymentProvider::select('id')->get()->pluck('id')),
                "type" => $faker->randomElement(['deposit', 'withdraw']),
                "amount" => $faker->randomFloat(2, -1000000, 1000000),
                "currency" => $faker->currencyCode,
                "user_id" => factory(User::class)->create()->id,
                "status" => $faker->randomElement($statuses)
            ]);;
            $transaction->save();
        }
    }
}
