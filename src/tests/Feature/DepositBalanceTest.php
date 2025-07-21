<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DepositBalanceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_adds_money_via_route(): void
    {
        $account = Account::factory()->create(['balance' => 100]);

        $this->postJson("/api/accounts/{$account->id}/deposit-balance", [
            'amount' => 50.00,
        ])
            ->assertOk();

        $this->assertDatabaseHas('accounts', [
            'id'      => $account->id,
            'balance' => '150.00',
        ]);
    }
}
