<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_updates_user_successfully(): void
    {
        $user = User::factory()->create([
            'name'  => 'Old',
            'email' => 'old@mail.com',
            'age'   => 25,
        ]);

        $payload = ['name' => 'NewName', 'age' => 30];
        $this->patchJson("/api/users/{$user->id}", $payload)
            ->assertStatus(200)
            ->assertExactJson(['message' => 'success']);

        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'name' => 'NewName',
            'age'  => 30,
        ]);
    }

    #[Test]
    public function it_fails_when_email_is_taken(): void
    {
        $userA = User::factory()->create(['email' => 'a@mail.com']);
        $userB = User::factory()->create(['email' => 'b@mail.com']);

        $this->patchJson("/api/users/{$userA->id}", ['email' => 'b@mail.com'])
            ->assertStatus(422)
            ->assertJson(['message' => 'Email b@mail.com already taken']);
    }

    #[Test]
    public function it_returns_404_for_unknown_id(): void
    {
        $this->patchJson('/api/users/999', ['name' => 'Ghost'])
            ->assertStatus(404);
    }
}
