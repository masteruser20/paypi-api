<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentProviderTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_should_returns_providers_collection()
    {
        $response = $this->get('/api/methods');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'label',
                    'types',
                    'additionalData'
                ]
            ]);

    }
}
