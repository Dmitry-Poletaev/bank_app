<?php

namespace App\Http\Repositories\Interfaces;

use App\Models\Account;

interface AccountRepositoryInterface
{
    public function one(int $id): ?Account;

    public function incrementBalance(Account $account, string $amount, bool $lock = false): void;
    public function decrementBalance(Account $account, string $amount, bool $lock = false): void;
}
