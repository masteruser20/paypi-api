<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PingTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_should_returns_numeric_string()
    {
        $response = $this->get('/api/ping');
        $this->assertIsNumeric($response->json()['ack']);
    }
}
