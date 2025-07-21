<?php

namespace App\Enum;

enum LedgerType: string
{
    case Credit = 'credit';
    case Debit  = 'debit';
}
