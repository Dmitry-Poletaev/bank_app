<?php

namespace App\Http\Repositories\Interfaces;

use App\Models\LedgerEntry;

interface LedgerEntryRepositoryInterface
{
    public function save(array $data): void;
}
