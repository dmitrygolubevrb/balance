<?php


namespace App\Repositories;


use App\Http\Resources\UserBalanceResource;
use App\Models\UserBalance;
use App\Repositories\Interfaces\UserBalanceRepositoryInterface;

class UserBalanceRepository implements UserBalanceRepositoryInterface
{

    public function getByUserIdWithLock(int $userId): UserBalance
    {
        return UserBalance::where('user_id', $userId)->lockForUpdate()->first();
    }

    public function getByUserId(int $userId): UserBalance
    {
        return UserBalance::where('user_id', $userId)->first();
    }
}
