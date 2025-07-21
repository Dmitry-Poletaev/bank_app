<?php

namespace App\Dto;

class TransferBalanceDto
{
    public function __construct(
        private readonly int    $fromAccountId,
        private readonly int    $toAccountId,
        private readonly string $amount
    ) {}

    public function getFromAccountId(): int
    {
        return $this->fromAccountId;
    }

    public function getToAccountId(): int
    {
        return $this->toAccountId;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }
}
