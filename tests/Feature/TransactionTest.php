<?php

namespace Tests\Feature;

use App\Transaction;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_validate_the_transaction()
    {
        $transaction = factory(Transaction::class)->states('invalid')->make();

        $response = $this->post('/api/transactions', $transaction->toArray());
        $response->assertStatus(422)
            ->assertJsonStructure([
                'provider',
                'amount',
                'user.email'
            ]);
    }

    /**
     * @return void
     * @test
     */
    public function it_should_create_the_transaction()
    {
        $transaction = factory(Transaction::class)->make();

        $response = $this->post('/api/transactions', $transaction->toArray());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'provider',
                'type',
                'amount',
                'currency',
                'user',
            ]);
    }
}
