<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\AccountRepositoryInterface;
use App\Models\Account;

class AccountRepository implements AccountRepositoryInterface
{
    public function one(int $id): ?Account
    {
        return Account::find($id);
    }

    public function incrementBalance(Account $account, string $amount, bool $lock = false): void
    {
        if ($lock) {
            $account = Account::whereKey($account->id)
                ->lockForUpdate()
                ->firstOrFail();
        }

        $account->increment('balance', $amount);
    }

    public function decrementBalance(Account $account, string $amount, bool $lock = false): void
    {
        if ($lock) {
            $account = Account::whereKey($account->id)
                ->lockForUpdate()
                ->firstOrFail();
        }

        $account->decrement('balance', $amount);
    }
}
