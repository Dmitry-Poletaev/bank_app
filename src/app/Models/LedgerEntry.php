<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class LedgerEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'correlation_id',
        'description',
    ];

    /** Каждая запись относится к одному счёту */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /** Автогенерация correlation_id, если не передали */
    protected static function booted(): void
    {
        static::creating(function (self $entry) {
            if (empty($entry->correlation_id)) {
                $entry->correlation_id = Str::uuid();
            }
        });
    }

    protected $casts = [
        'amount' => 'decimal:2',
        'correlation_id' => 'string',
    ];
}
