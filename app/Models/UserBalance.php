<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    use HasFactory;

    protected $table = 'user_balances';
    protected $fillable = [
        'user_id',
        'balance'
    ];


    public function getUpdatedDateAttribute(): string
    {
        return Carbon::parse($this->updated_at)->toDateString();
    }
}
