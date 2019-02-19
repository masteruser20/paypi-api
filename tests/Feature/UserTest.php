<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     *
     * @return void
     * @test
     */
    public function it_should_returns_exact_user_structure()
    {
        $user = factory(User::class)->create();
        $response = $this->get('/api/users/' . $user->id);

        $response->assertJsonStructure([
            "first_name",
            "last_name",
            "gender",
            "email",
            "address",
            "city",
            "state",
            "zip",
            "country_code",
            "birthday",
        ])->assertStatus(200);
    }
}
