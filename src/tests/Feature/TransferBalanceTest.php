<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TransferBalanceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_transfers_money_between_two_accounts(): void
    {
        $from = Account::factory()->create(['balance' => 200]);
        $to   = Account::factory()->create(['balance' => 50]);

        $this->postJson('/api/transfer-balance', [
            'from_account_id' => $from->id,
            'to_account_id'   => $to->id,
            'amount'          => 75.00,
        ])
            ->assertOk();

        $this->assertDatabaseHas('accounts', [
            'id'      => $from->id,
            'balance' => '125.00',
        ]);

        $this->assertDatabaseHas('accounts', [
            'id'      => $to->id,
            'balance' => '125.00',
        ]);
    }
}
