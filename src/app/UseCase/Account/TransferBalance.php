<?php

declare(strict_types=1);

namespace App\UseCase\Account;

use App\Dto\TransferBalanceDto;
use App\Http\Repositories\Interfaces\AccountRepositoryInterface;
use App\Http\Repositories\Interfaces\LedgerEntryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use App\Enum\LedgerType;

class TransferBalance
{
    public function __construct(
        private readonly AccountRepositoryInterface     $accountRepository,
        private readonly LedgerEntryRepositoryInterface $ledgerEntryRepository,
    ) {}
    public function handle(TransferBalanceDto $dto): void
    {
        DB::transaction(function () use ($dto) {
            $from = $this->accountRepository->one($dto->getFromAccountId())
                ?? throw new ModelNotFoundException("Account #{$dto->getFromAccountId()} not found");

            $to = $this->accountRepository->one($dto->getToAccountId())
                ?? throw new ModelNotFoundException("Account #{$dto->getToAccountId()} not found");

            // фиксированный порядок, чтобы не словить deadlock
            if ($from->id > $to->id) {
                [$from, $to] = [$to, $from];
            }

            if (bccomp($from->balance, $dto->getAmount(), 2) < 0) {
                throw new InvalidArgumentException('Insufficient funds');
            }

            $this->accountRepository->decrementBalance($from, $dto->getAmount(), lock: true);
            $this->accountRepository->incrementBalance($to, $dto->getAmount(), lock: true);


            $corr = Str::uuid();

            $this->ledgerEntryRepository->save([
                'account_id' => $from->id,
                'type' => LedgerType::Debit,
                'amount' => $dto->getAmount(),
                'correlation_id' => $corr,
                'description' => "Transfer to #{$to}"
            ]);

            $this->ledgerEntryRepository->save([
                'account_id' => $to->id,
                'type' => LedgerType::Credit,
                'amount' => $dto->getAmount(),
                'correlation_id' => $corr,
                'description' => "Transfer from #{$from}",
            ]);
        });
    }
}
