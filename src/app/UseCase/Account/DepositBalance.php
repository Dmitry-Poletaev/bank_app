<?php

declare(strict_types=1);

namespace App\UseCase\Account;

use App\Http\Repositories\Interfaces\AccountRepositoryInterface;
use App\Http\Repositories\Interfaces\LedgerEntryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Enum\LedgerType;

class DepositBalance
{
    public function __construct(
        private readonly AccountRepositoryInterface     $accountRepository,
        private readonly LedgerEntryRepositoryInterface $ledgerEntryRepository,
    ) {}

    public function handle(int $id, float $amount): void
    {

        DB::transaction(function () use ($id, $amount) {

            $account = $this->accountRepository->one($id)
                ?? throw new ModelNotFoundException("Account #$id not found");

            $this->accountRepository->incrementBalance(
                account: $account,
                amount:  (string)$amount,
                lock:    true
            );

            $this->ledgerEntryRepository->save([
                'account_id'     => $account->id,
                'type'           => LedgerType::Debit,
                'amount'         => $amount,
                'correlation_id' => Str::uuid(),
                'description'    => 'Deposit',
            ]);
        });
    }
}
