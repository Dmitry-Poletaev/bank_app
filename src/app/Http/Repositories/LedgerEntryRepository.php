<?php

namespace App\Http\Repositories;

use App\Models\LedgerEntry;

class LedgerEntryRepository implements Interfaces\LedgerEntryRepositoryInterface
{

    public function save(array $data): void
    {
        LedgerEntry::create($data);
    }
}
