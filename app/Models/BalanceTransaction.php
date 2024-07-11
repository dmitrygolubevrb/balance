<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceTransaction extends Model
{
    use HasFactory;

    const TYPE_CREDIT = 'credit';
    const TYPE_DEBIT = 'debit';
    const ALLOWABLE_TYPES = [self::TYPE_DEBIT, self::TYPE_CREDIT];

    protected $table = 'balance_transactions';
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'balance_after',
        'description'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCreateDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->toDateString();
    }
}
