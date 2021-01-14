<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanStoreUsers()
    {
        $data = User::factory()->make()->makeVisible('password')->toArray();

        $response = $this->postJson(
            'api/users',
            $data
        );

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
                "credit"   => $data['credit'],
                "document" => $data['document'],
                "email"    => $data['email'],
                "name"     => $data['name'],
                "type"     => $data['type'],
                "id"       => $response->json('id'),
        ]);
    }
}
