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

        unset($data['password']);

        $this->assertDatabaseHas('users', $data);
    }

    public function testItCanUpdateUsers()
    {
        $user = User::factory()->create();

        $data = User::factory()->make()->makeVisible('password')->toArray();

        $response = $this->putJson(
            route('users.update', $user->id),
            $data
        );

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        unset($data['password']);

        $this->assertDatabaseHas('users', $data);
    }

    public function testItCanDeleteUsers()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('users.destroy', $user->id)
        );

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', $user->toArray());
    }
}
