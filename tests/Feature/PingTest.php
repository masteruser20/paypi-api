<?php

namespace Tests\Feature;

use Tests\TestCase;

class PingTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_will_returns_json_with_current_timestamp()
    {
        $response = $this->get('/api/ping');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'ack'
            ]);
    }
}
